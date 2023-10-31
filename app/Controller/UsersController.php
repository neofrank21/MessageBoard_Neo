<?php
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
    class UsersController extends AppController {   
        public $helpers = array('Js');
	    public $components = array('RequestHandler');

        public function beforeFilter()
        {
            parent::beforeFilter();
            $this->Auth->allow('login','register');
        }

        public function index()
        {
            $this->set('title_for_layout', 'Welcome');
            $this->layout = 'indexLayout';
        }

        public function login()
        {
            $this->layout = 'indexLayout';

            if ($this->request->is('post')) {

                $email = $this->request->data['User']['email'];
                $password = $this->request->data['User']['password'];

                // Retrieve the user data from the database based on the username
                $user = $this->User->find('first', array('conditions' => array('User.email' => $email)));

                if (!empty($user) && (new BlowfishPasswordHasher)->check($password, $user['User']['password'])) {

                    // Update the Last Login
                    $this->User->id = $user['User']['id'];
                    $this->User->saveField('last_login', gmdate('Y-m-d H:i:s'));

                    // Login successful
                    $this->Auth->login($user['User']);
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error('Username/Password invalid or incorrect', array(
                        'key' => 'error',
                    ));
                }
            }
        }

        // Logout Function
        public function logout()
        {
            $this->Auth->logout();
            $this->Flash->success('You have successfully logged out!', array(
                'key' => 'positive',
            ));
            return $this->redirect($this->Auth->redirectUrl());
        }

        // Register or Add users functionality 
        public function register()
        {

            $this->layout = 'indexLayout';

            // Get the data from the view
            if($this->request->is('post'))
            {
                $this->User->create();
                // Set the data into the database
                $this->User->set($this->request->data);

                // Validates the data before transacting into the database 
                if ($this->User->validates()) {
                    // Insert the data and Insert a date for create_date
                   if($this->User->save($this->request->data) && $this->User->saveField('create_date', gmdate('Y-m-d H:i:s'))) {

                        // Retrieve the user's email and password from the registration form
                        $email = $this->request->data['User']['email'];
                        $password = $this->request->data['User']['password'];

                        // Find the user's data
                        $user = $this->User->find('first', array('conditions' => array('User.email' => $email)));

                        if (!empty($user) && (new BlowfishPasswordHasher)->check($password, $user['User']['password'])) {
                            // Log the user in
                            $this->Auth->login($user['User']);
                            $this->User->saveField('last_login', gmdate('Y-m-d H:i:s'));
                        }

                        // Success Notification
                        $this->Flash->success('User Created', array(
                            'key' => 'positive',
                        ));

                        // Redirect to the "Thank You" method
                        return $this->redirect(array('action' => 'thankYou'));
                    } else {
                        // Error Notification
                        $this->Flash->error('Something Went Wrong', array(
                            'key' => 'error',
                        ));
                        $this->redirect('register');
                    }
                }
            }
        }

        // Thank You Page 
        public function thankYou()
        {
            $this->set('title_for_layout', 'Thank You');
            $this->layout = 'homeLayout';
            
        }

        // Home Page
        public function home()
        {
            $this->set('title_for_layout', 'Home');
            $this->layout = 'homeLayout';
        }

        // Profile Page
        public function profile()
        {
            $this->set('title_for_layout', 'Profile');
            $this->layout = 'homeLayout';
            
            $userId = $this->Session->read('Auth.User.id');
            $user = $this->User->findById($userId);
            
            $this->set('userData', $user);
        }

        // Edit user's settings (email, password)
        public function editUser($id = null)
        {
            $id = $this->request->query('id');

            $this->set('title_for_layout', 'Edit User');
            $this->layout = 'homeLayout';

            // Check if there is an Id
            if (!$id) {
                $this->Flash->error('Something Went Wrong', array(
                    'key' => 'error',
                ));
                $this->redirect('profile');
            }

            $user = $this->User->findById($id);
            $this->set('userData', $user);

            // Check if there is a User
            if (!$user) {
                $this->Flash->error('User not found', array(
                    'key' => 'error',
                ));
                $this->redirect('profile');
            }

            // Update the Data into the Database
            if ($this->request->is('post')) {
                $this->User->id = $id; // Set the User Id for the update
                
                $formData = $this->request->data; // Get all data from the view

                $email = $formData['User']['email'];
                $password = $formData['User']['password'];
                if (empty($password)) {
                    if ($this->User->saveField('email', $email)) {
                        // Success Notification
                        $this->Flash->success('Profile Successfuly Updated', array(
                            'key' => 'positive',
                        ));
                        $this->redirect('profile');
                    } else {
                        // Error Notification
                        $this->Flash->error('Something Went Wrong', array(
                            'key' => 'error',
                        ));
                        $this->redirect('profile');
                    }
                } else if (empty($email)) {
                    if ($this->User->saveField('password', $password)) {
                        // Success Notification
                        $this->Flash->success('Profile Successfuly Updated', array(
                            'key' => 'positive',
                        ));
                        $this->redirect('profile');
                    } else {
                        // Error Notification
                        $this->Flash->error('Something Went Wrong', array(
                            'key' => 'error',
                        ));
                        $this->redirect('profile');
                    }
                } else if (!empty($password) && !empty($email)) { 
                    if ($this->User->save($formData)) {
                        // Success Notification
                        $this->Flash->success('Profile Successfuly Updated', array(
                            'key' => 'positive',
                        ));
                        $this->redirect('profile');
                    } else {
                        // Error Notification
                        $this->Flash->error('Something Went Wrong', array(
                            'key' => 'error',
                        ));
                        $this->redirect('profile');
                    }
                } else {
                    // Error Notification
                    $this->Flash->error('Something Went Wrong', array(
                        'key' => 'error',
                    ));
                    $this->redirect('profile');
                }
                
            }
        }

        // Edit Profile User Function 
        public function editProfile($id = null)
        {
            $id = $this->request->query('id');

            $this->set('title_for_layout', 'Edit Profile');
            $this->layout = 'homeLayout';

            // Check if there is an ID
            if (!$id) {
                $this->Flash->error('Something Went Wrong', array(
                    'key' => 'error',
                ));
                $this->redirect('profile');
            }

            $user = $this->User->findById($id); 
            $this->set('userData', $user);

            // Check if there is a User 
            if (!$user) {
                $this->Flash->error('User not found', array(
                    'key' => 'error',
                ));
                $this->redirect('profile');
            } 
            
            // Update the Data into the Database 
            if ($this->request->is('post')) {
                $this->User->id = $id; // Set the User Id for the Update

                $uploadedFile = $this->request->data['User']['img'];
                
                // File path
                $filePath = WWW_ROOT .'img'. DS;

                // Check if there is file directory
                if (!file_exists($filePath)) {
                    mkdir($filePath,0777,true);
                }

                if (!empty($uploadedFile['name'])) {

                    $fileName  = uniqid() .'-'. $uploadedFile['name'];

                    $targetPath = $filePath . $fileName;

                    if(move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
                        // Update the img data into pathname 
                        $this->request->data['User']['img'] = $fileName;
                        
                    } else {
                        $this->Flash->error('Something Went Wrong', array(
                            'key' => 'error',
                        ));
                        $this->redirect('profile');

                    }

                } else {
                    // Use this if the user has a profile pic and doesn't want to change the profile pic
                    unset($this->request->data['User']['img']);
                } 
                
                // Remove the img
                if (isset($this->request->data['User']['remove_img']) && $this->request->data['User']['remove_img'] == 1) {
                    // if the img remove 
                    $this->request->data['User']['img'] = null;
                }

                // Transacting the User data into the database
                if ($this->User->save($this->request->data)) {
                    // Success Notification
                    $this->Flash->success('Profile Successfuly Updated', array(
                        'key' => 'positive',
                    ));
                    $this->redirect('profile');
                } else {
                    // Error Notification
                    $this->Flash->error('Something Went Wrong', array(
                        'key' => 'error',
                    ));
                    $this->redirect('profile');
                }
            }
        }
    }

?>