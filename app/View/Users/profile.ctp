<?php echo $this->Flash->render('error');?>
<?php echo $this->Flash->render('positive');?>
<div class="row mt-4 ml-4 mr-4 mb-4">
    <?php if(!empty($userData)):?>
        <div class="col-5">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Profile Details</h2>
                    <?php echo $this->Html->link('Edit User', array(
                        'controller'=> 'users',
                        'action'=> 'editUser',
                        '?' => array('id' => $userData['User']['id'])
                    ), array(
                        'class'=> 'btn btn-outline-success',
                        'full_base'=> true
                    ));?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php 
                            $img = isset($userData['User']['img']) ? $userData['User']['img'] : 'avatar-1.jpg';
                            echo $this->Html->image($img, array('alt' => 'Default Avatar',
                                'class' => 'border border-dark rounded-circle mx-auto d-block',
                                'width' => '180',
                                'height' => '180'
                            ));
                        ?>
                    </div>
                    <hr class="hr"/>
                    <div class="row">
                        <div class="col-6">
                            <h5>Name: <?php echo isset($userData['User']['name']) ? $userData['User']['name']:'';?></h5>
                        </div>
                        <div class="col-6">
                            <h5>Email: <?php echo isset($userData['User']['email']) ? $userData['User']['email']:'';?></h5>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <h5>Birthdate: <?php  
                                $date = isset($userData['User']['birthdate']) ? $userData['User']['birthdate']:'';
                                echo date("F j, Y",strtotime($date));
                            ?>
                            </h5>
                        </div>
                        <div class="col-6">
                            <h5>Gender: <?php echo isset($userData['User']['gender']) ? $userData['User']['gender'] : '';?></h5>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <h5>Joined: <?php 
                                $joined = isset($userData['User']['create_date']) ? $userData['User']['create_date']:'';
                                echo gmdate('F j, Y gA',strtotime($joined));
                            ?>
                            </h5>
                        </div>
                        <div class="col-6">
                            <h5>Last Login: <?php 
                                $last_login = isset($userData['User']['last_login']) ? $userData['User']['last_login']:'';
                                echo date('F j, Y gA',strtotime($last_login));
                            ?>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?php
                        echo $this->Html->link('Edit Profile',array(
                            'controller' => 'users',
                            'action' => 'editProfile',
                            '?' => array('id' => $userData['User']['id'])
                        ), array(
                            'class' => 'btn btn-outline-success float-right my-2 my-sm-0',
                            'full_base' => true,
                        ));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card shadow">
                <div class="card-header">
                    <h2>Description</h2>
                </div>
                <div class="card-body">
                        <h3><?php echo isset($userData['User']['hobby']) ? nl2br($userData['User']['hobby']):'';?></h3>
                </div>
            </div>
        </div>
    <?php endif;?>
</div>