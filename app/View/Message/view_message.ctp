<div class="row d-flex justify-content-center mt-5 mb-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header d-flex">
                    <h2 class="flex-grow-1">View Message</h2>
                    <button class="btn btn-outline-success mr-2" id="add"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Message</button>
                    <button class="btn btn-outline-danger delete-all" id="delete-all"><i class="fa fa-trash" aria-hidden="true"></i> Delete All Message</button>
            </div> 
            <div class="card-body" id="pagination">
                <?php foreach($messages as $message):?>
                    <?php if($currentUser['id'] != $message['Message']['sender_id']):?>
                        <div class="row recipient-box d-flex flex-row mb-2">
                            <div class="media" id="recipient-box">
                                <?php 
                                    $img = isset($message['User']['img']) ? $message['User']['img'] : 'avatar-1.jpg';
                                    echo $this->Html->image($img, array('alt' => 'Default Avatar',
                                        'class' => 'ml-2 mr-2 rounded-circle',
                                        'width' => '64',
                                        'height' => '64'
                                    ));
                                ?>
                                <div class="media-body border border-dark mr-2">
                                    <p class="ml-1 mt-1 mb-1 mr-1 text-justify"><?php echo $message['Message']['message'];?></p>
                                    <hr class="text-dark">
                                    <p class="text-right text-black-50 mx-2" style="font-size: 8px"><?php echo date('Y/m/d h:i',strtotime($message['Message']['create_date']));?></p>
                                </div>
                            </div>
                        </div>
                    <?php else:?>
                        <div class="row sender-box d-flex flex-row-reverse mb-2">
                            <div class="media" id="sender-box">
                                <div class="btn-group dropdown dropleft">
                                    <button class="btn btn-light" type="button" data-toggle="dropdown" aria-expanded="false" style="padding-right: 10px;">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu p-0 text-center" style="max-height: 150px; overflow-y: auto;">
                                        <button class="dropdown-item text-dark delete-message" data-message-id="<?php echo $message['Message']['id'];?>">
                                            Delete <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="media-body border border-dark ml-2">
                                    <p class="ml-1 mt-1 mb-1 mr-1"><?php echo $message['Message']['message'];?></p>
                                    <hr class="text-dark">
                                    <p class="text-right text-black-50 mx-2" style="font-size: 8px"><?php echo date('Y/m/d h:i',strtotime($message['Message']['create_date']));?></p>
                                </div>
                                <?php 
                                    $img = isset($message['User']['img']) ? $message['User']['img'] : 'avatar-1.jpg';
                                    echo $this->Html->image($img, array('alt' => 'Default Avatar',
                                        'class' => 'ml-2 mr-2 rounded-circle',
                                        'width' => '64',
                                        'height' => '64'
                                    ));
                                ?>
                            </div>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
                <div id="message-container">

                </div>
            </div>
                <div class="row d-flex justify-content-center">
                        <div class="col-12 text-center mb-2">
                            <button id="show-more" class="btn btn-link">Show More</button>
                        </div>
                    </div>
                <div class="card-footer" id="messageInput" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                        <?php echo $this->Form->create('Message', array('class' => 'form-inline', 'id' => 'messageAdd', 'url' => array('controller' => 'Message', 'action' => 'addMessageJson')));?>
                            <div class="form-group">
                                <?php 
                                    echo $this->Form->input('message', array(
                                        'type' => 'text',
                                        'label' => false,
                                        'class' => 'form-control',
                                        'autocomplete' => 'off',
                                        'id' => 'message',
                                    ));
                                ?>
                                <?php 
                                    echo $this->Form->end(array(
                                        'class' => 'btn btn-outline-primary br rounded-right',
                                        'type' => 'submit',
                                        'label' => 'Send',
                                        'id' => 'send-message'
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>


<script>
    $(document).ready(function(){

        $('#add').on('click',function(){
            $('#messageInput').show();
        })

        var page = 2; // Initial page (the second page, as the first page is already loaded)
        var loading = false; // To prevent multiple simultaneous requests

        function loadMoreMessages() {
            if (loading) {
                return;
            }

            loading = true;

            $.ajax({
                url: '<?php echo $this->Html->url(['controller' => 'Message', 'action' => 'loadMoreMessages']); ?>',
                type: 'post',
                dataType: 'json',
                data: {
                    page: page, // Send the current page
                    conversationId: '<?php echo $convoId; ?>'
                },
                success: function (data) {

                    if (data.length > 0) {

                        var messageContainer = $('#pagination');
                        var userId = '<?php echo $message['User']['id']; ?>';
                        var baseUrl = '<?php echo $this->Html->url(array('controller' => 'img'), true); ?>';
                        
                        data.forEach(function (message) {

                                if (message.Message.sender_id != userId) {
                                var messageHtml = `
                                    <div class="row recipient-box d-flex flex-row mb-2">
                                        <div class="media">
                                            <img src=" `+ baseUrl +`/`+ message.User.img +`" alt="Default Avatar" class="ml-2 mr-2 rounded-circle" width="64" height="64">
                                            <div class="media-body border border-dark mr-2">
                                                <p class="ml-1 mt-1 mb-1 mr-1 text-justify">`+ message.Message.message +`</p>
                                                <hr class="text-dark">
                                                <p class="text-right text-black-50 mx-2" style="font-size: 8px">
                                                    `+ moment(message.Message.create_date).format("YYYY/MM/DD H:mm") +` 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                messageContainer.append(messageHtml);
                            } else {
                                var messageHtml = `
                                    <div class="row sender-box d-flex flex-row-reverse mb-2">
                                        <div class="media">
                                            <div class="btn-group dropdown dropleft">
                                                <button class="btn btn-light" type="button" data-toggle="dropdown" aria-expanded="false" style="padding-right: 10px;">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <div class="dropdown-menu p-0 text-center" style="max-height: 150px; overflow-y: auto;">
                                                    <button class="dropdown-item text-dark delete-message" data-message-id="`+ message.Message.id +`">
                                                        Delete <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="media-body border border-dark ml-2">
                                                <p class="ml-1 mt-1 mb-1 mr-1 text-justify">`+ message.Message.message +`</p>
                                                <hr class="text-dark">
                                                <p class="text-right text-black-50 mx-2" style="font-size: 8px">
                                                    `+ moment(message.Message.create_date).format("YYYY/MM/DD H:mm") +`
                                                </p>
                                            </div>
                                            <img src=" `+ baseUrl +`/`+ message.User.img +`" alt="Default Avatar" class="ml-2 mr-2 rounded-circle" width="64" height="64">
                                        </div>
                                    </div>
                                `;
                                messageContainer.append(messageHtml);
                            }
                        });

                        page++; // Increment the page for the next request
                    }

                    loading = false;
                }
            });
        }

        // Load more messages when the "Show More" button is clicked
        $('#show-more').on('click', function () {
            loadMoreMessages();
        });

        // Load more messages when the user scrolls to the bottom of the message container
        $('#pagination').scroll(function () {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                loadMoreMessages();
            }
        });
        
        $('#messageAdd').on('submit',function(e){

            e.preventDefault(); // Prevent the default form submission

            // Get the form data
            var conversationId = '<?php echo $message['Conversation']['id'];?>';

            var requestData = {
                id: conversationId,  
                formData: $('#message').val()
            };

            // Send the Added Message
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'Message', 'action' => 'addMessage', 'id' => $message['Conversation']['id'])); ?>',
                type: 'post',
                dataType: 'json',
                data: requestData,
                success: function (data)
                {
                    // Use for Date Format
                    let dateFormatted = moment(data.Message.create_date).format("YYYY/MM/DD H:mm");
                    var baseUrl = '<?php echo $this->Html->url(array('controller' => 'img'), true); ?>';
                    var newMessageHtml = `
                        <div class="row sender-box d-flex flex-row-reverse mb-2">
                            <div class="media" id="sender-box">
                                <div class="btn-group dropdown dropleft">
                                    <button class="btn btn-light" type="button" data-toggle="dropdown" aria-expanded="false" style="padding-right: 10px;">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu p-0 text-center" style="max-height: 150px; overflow-y: auto;">
                                        <button class="dropdown-item text-dark delete-message" data-message-id="`+ data.Message.id +`">
                                            Delete <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="media-body border border-dark ml-2">
                                    <p class="ml-1 mt-1 mb-1 mr-1 text-justify">`+ data.Message.message +`</p>
                                    <hr class="text-dark">
                                    <p class="text-right text-black-50 mx-2" style="font-size: 8px">`+ dateFormatted +`</p>
                                </div>
                                <img src=" `+ baseUrl +`/`+data.User.img +`" alt="Default Avatar" class="ml-2 mr-2 rounded-circle" width="64" height="64">
                            </div>
                        </div>
                    `;

                    // Append the new message HTML to a container with id "message-container"
                    $("#message-container").append(newMessageHtml);
                    $('#message').val('');
                }
            });
        });

        // Delete Single Message
        $(document).on('click', '.delete-message', function() {
            var messageId = $(this).data('message-id');
            var baseUrl = '<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'deleteMessage'), true); ?>';
            
            $.ajax({
                url: baseUrl + '/' + messageId, // Replace with the actual URL
                type: 'post',
                dataType: 'json',
                data: { id: messageId },
                success: function(data) {
                    if (data.status == 'success')
                    {
                        $(this).closest('.sender-box').hide(500, function(){
                            $(this).closest('.sender-box').remove();
                        });
                    }
                }.bind(this)
            });
        });

        // Delete All Message 
        $(document).on('click', '.delete-all', function() {
            var conversationId = '<?php echo $message['Conversation']['id'];?>';
            var baseUrl = '<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'deleteMessageinConversation'), true); ?>';

            $.ajax({
                url: baseUrl + '/' + conversationId, // Replace with the actual URL
                type: 'post',
                dataType: 'json',
                data: { id: conversationId },
                success: function(data) {
                    if (data.status == 'success')
                    {
                        $('.sender-box').each(function(){
                            var senderBox = $(this);
                            senderBox.hide(500, function(){
                                senderBox.remove();
                            });
                        });
                    }
                }
            });
        });
    });
</script>