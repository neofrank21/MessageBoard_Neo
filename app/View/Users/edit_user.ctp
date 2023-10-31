<div class="row d-flex justify-content-center mt-5">
    <div class="col-6">
            <?php echo $this->Form->create('User');?> 
        <div class="card">
            <div class="card-header">
                <h2>Edit User Settings</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <?php
                            echo $this->Form->input('email', array(
                                'class' => 'form-control mb-2',
                                'type' => 'email',
                                'default' => $userData['User']['email']
                            ));
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php 
                            echo $this->Form->input('password', array(
                                'class'=> 'form-control mb-2',
                                'type'=> 'password',
                                'placeholder' => 'New Password',
                                'default'=> $userData['User']['password']
                            ));
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php 
                            echo $this->Form->input('confirm_password', array(
                                'class'=> 'form-control',
                                'type'=> 'password',
                                'placeholder'=> 'Confirm New Password',
                                'default'=> $userData['User']['password']
                            ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <?php 
                    // Cancel Button
                    echo $this->Html->link('Cancel','profile',array(
                        'class'=> 'btn btn-danger mr-2',
                        'type' => 'cancel'
                    ));

                    // Submit Button
                    echo $this->Form->end(array(
                    'class' => 'btn btn-success',
                    'label' => 'Update',
                    'type' => 'submit'
                    ));
                ?>

            </div>
        </div>
    </div>
</div>