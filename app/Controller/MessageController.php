<?php

    class MessageController extends AppController {
        public $helpers = array('Js');
	    public $components = array('RequestHandler');

        public function index() {

            $this->loadModel('Conversation');
            $this->set('title_for_layout', 'Message');
            $this->layout = 'homeLayout';

            $userId = $this->Session->read('Auth.User.id');

            $conversations = $this->Conversation->find('all', array(
                'conditions' => array(
                    'OR' => array(
                        'Conversation.sender_user_id' => $userId,
                        'Conversation.recipient_user_id' => $userId
                    )
                ),
                'contain' => array(
                    'sender_user_id', 'recipient_user_id','create_date'
                ),
                'limit' => 10,
            ));

            $this->set('conversations', $conversations);
        }

        public function loadMore($page = 1) {

            $this->autoRender = false; // Disable view rendering for this action
            $this->loadModel('Conversation');

            if ($this->request->is('ajax')) {
                $page = $this->request->query('page');
                $userId = $this->Session->read('Auth.User.id');
                $perPage = 10; // Number of records per page
            
                // Calculate the offset based on the page number
                $offset = ($page - 1) * $perPage;
            
                // Query for the next set of records
                $conversations = $this->Conversation->find('all', array(
                    'conditions' => array(
                        'OR' => array(
                            'Conversation.sender_user_id' => $userId,
                            'Conversation.recipient_user_id' => $userId
                        )
                    ),
                    'contain' => array(
                        'Sender', 'Recipient', 'Conversation'
                    ),
                    'limit' => $perPage,
                    'offset' => $offset
                ));
        
                // Return data as JSON
                echo json_encode($conversations);
            }
        } 

        public function viewMessage($id) {

            $convoId = $id;
            $this->loadModel('Conversation');
            $this->set('title_for_layout', 'View Message');
            $this->layout = 'homeLayout';  

            // Find messages for the specified conversation ID
            $messages = $this->Message->find('all', array(
                'conditions' => array(
                    'Message.convo_id' => $convoId
                ),
                'order' => array('Message.create_date ASC'),
                'contain' => 'message', // Load associated user data (if needed)
                'limit' => 10,

            ));

            $this->set('messages', $messages);
            $this->set('convoId', $convoId);
        }
        
        // Load Messages for the pagination fucntionality
        public function loadMoreMessages() {
            $this->autoRender = false;
            if ($this->request->is('ajax')) {
                $page = $this->request->data('page');
                $convoId = $this->request->data('conversationId');
                $offset = ($page - 1) * 10; // Adjust the offset based on the current page
        
                // Find more messages using the same logic as in your 'viewMessage' action
                $messages = $this->Message->find('all', array(
                    'conditions' => array(
                        'Message.convo_id' => $convoId
                    ),
                    'order' => array('Message.create_date ASC'),
                    'limit' => 10,
                    'offset' => $offset
                ));
        
                echo json_encode($messages);
            }
        }

        // Delete Convo all message of sender and recipient
        public function deleteConversation ($id) {
            
            $convoId = $id;
            $this->loadModel('Conversation');

            $messages = $this->Message->deleteAll(array('Message.convo_id' => $convoId), false);

            if ($messages) {
                if ($this->Conversation->delete($convoId)) {
                    $this->Flash->success('Successfully Deleted', array(
                        'key' => 'positive',
                    ));
                    $this->redirect(array('controller'=> 'message', 'action' => 'index'));
                } else {
                    $this->Flash->success('Delete Error', array(
                        'key' => 'error',
                    ));
                    $this->redirect(array('controller'=> 'message', 'action' => 'index'));
                }
            }
        }

        // Delete Single Message
        public function deleteMessage() {
        
          $this->autoRender = false;
          $messageId = isset($this->request->data['id']) ? $this->request->data['id'] : null ;
          
          if (!empty($messageId) && $messageId != null) {
                    
                if ($this->Message->delete($messageId)) {
                    $response = array('status' => 'success');
                    echo json_encode($response);
                }
                else
                {
                    $response = array('status' => 'unsuccess');
                    echo json_encode($response);
                }
            }

        }
        
        // Delete all message
        public function deleteMessageinConversation() {

            $this->autoRender = false;
            $conversationId = isset($this->request->data['id']) ? $this->request->data['id'] : null ;
            $userId = $this->Session->read('Auth.User.id');

            if (!empty($conversationId) && $conversationId != null) {
                if ($this->Message->deleteAll(array('Message.convo_id' => $conversationId, 'Message.sender_id' => $userId), false)) {
                    $response = array('status'=> 'success');
                    echo json_encode($response);
                } else {
                    $response = array('status'=> 'failed');
                    echo json_encode($response);
                }
            }
        }
        
        public function addMessage() {

            $conversationId = isset($this->request->data['id']) ? $this->request->data['id'] : null ; // Convo ID use for the add message in message view

            $this->loadModel('Conversation');
            $this->set('title_for_layout', 'Add Message');
            $this->layout = 'homeLayout';  

            $userId = $this->Session->read('Auth.User.id');
            if (empty($conversationId) && $conversationId == null)
            {
                // Add Message for non existing convo
                if ($this->request->is('post')) {
                
                    // Create a Conversation 
                    $this->Conversation->create();
                    $conversationData = array(
                        'sender_user_id' => $userId,
                        'recipient_user_id' => $this->request->data['Message']['recipient_id'],
                        'create_date' => date('Y-m-d H:i:s')
                    );

                    if ($this->Conversation->save($conversationData)) {

                        $conversationId = $this->Conversation->id;
                        
                        $this->Message->create();
        
                        $messageData = array(
                            'sender_id' => $userId,
                            'message' => $this->request->data['Message']['message'],
                            'create_date' => date('Y-m-d H:i:s'),
                            'convo_id' => $conversationId
                        );
                        
                        // Save the created message 
                        if ($this->Message->save($messageData)) {
                                $this->Flash->success('Message Send', array(
                                    'key' => 'positive',
                                ));
                                $this->redirect(array('controller'=> 'message', 'action' => 'index'));
                        } else {
                            $this->Flash->success('Message Error', array(
                                'key' => 'error',
                            ));
                            $this->redirect(array('controller'=> 'message', 'action' => 'index'));
                        }

                    } else {
                        $this->Flash->success('Something went wrong!', array(
                            'key' => 'error',
                        ));
                        $this->redirect(array('controller'=> 'message', 'action' => 'index'));
                    }
                }
            } else {
                if ($this->request->is('post')) {
                    
                    $this->autoRender = false;

                    $this->Message->create();

                    $messageData = array(
                        'sender_id' => $userId,
                        'message' => $this->request->data['formData'],
                        'create_date' => date('Y-m-d H:i:s'),
                        'convo_id' => $conversationId
                    );

                    if ($this->Message->save($messageData)) {

                        $lastInsertedId = $this->Message->getLastInsertId();
                        
                        $response = $this->Message->find('first', array(
                            'conditions' => array('Message.id' => $lastInsertedId),
                        ));
                        
                        echo json_encode($response);

                    } else {
    
                    }
                } else {
                    
                }
            }
           

        }

        public function contactList() {

            $this->loadModel('User');
            $this->autoRender = false;
            
            // Set the data first and check if there is a value if not goes to empty. if there is going to codition to search a user
            $searchTerm = isset($this->request->data['searchTerm']['term']) ? $this->request->data['searchTerm']['term'] : '';

            // finding the data in the table user
            $users = $this->User->find('list', [
                'conditions'=> ['User.name LIKE' => '%'. $searchTerm .'%'],
                'fields' => ['User.id', 'User.name']
            ]);

            // return the data into the view by using the json_encode so it can be use by the select2 api
            $this->response->type('json');
            echo json_encode($users);

        }
    }

?>