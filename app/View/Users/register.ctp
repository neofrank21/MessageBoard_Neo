<?php echo $this->Flash->render('error');?>
<div class="card mt-5">
    <div class="card-header">
        <h2>Register</h2>
    </div>
        <div class="card-body">
            <?php 
                echo $this->Form->create('User');
            ?>
            <div class="row">
                <div class="col-12">
                    <?php 
                        echo $this->Form->input('email',array(
                            'placeholder' => 'Email',
                            'class' => 'form-control mb-2',
                            'type' => 'email'
                        ));
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php
                        echo $this->Form->input('name', array(
                            'placeholder' => 'Name',
                            'class' => 'form-control mb-2',
                            'type' => 'text'
                        ));
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php
                        echo $this->Form->input('password', array(
                            'placeholder' => 'Password',
                            'class' => 'form-control mb-2',
                            'type' => 'password'
                        ));
                    ?>
                </div>
                <div class="col-12">
                    <?php
                        echo $this->Form->input('confirm_password', array(
                            'placeholder' => 'Confirm Password',
                            'class' => 'form-control mb-2',
                            'type' => 'password'
                        ));
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php 
                        echo $this->Form->end(array(
                            'class' => 'btn btn-primary float-right',
                            'type' => 'submit',
                            'label' => 'Register'
                        ));
                    ?>
                </div>
            </div>
    </div>
</div>