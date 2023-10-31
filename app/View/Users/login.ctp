<?php echo $this->Flash->render('positive');?>
<?php echo $this->Flash->render('error');?>
<div class="card mt-5">
    <div class="card-header">
        <h2>Login</h2>
    </div>
    <div class="card-body">
        <?php echo $this->Form->create('User');?>
        <div class="row">
            <div class="col-12 mb-2">
                <?php 
                    echo $this->Form->input('email', array(
                        'class' => 'form-control',
                        'type' => 'email',
                    ));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-2">
                <?php 
                    echo $this->Form->input('password', array(
                        'class' => 'form-control',
                        'type' => 'password',
                    ));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-2">
                <?php echo $this->Html->link('Create Account',array(
                    'controller' => 'users/register',
                    'full_base' => true
                ))?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php echo $this->Form->end(array(
                    'type' => 'submit',
                    'label' => 'Login',
                    'class' => 'btn btn-primary float-right'
                ))?>
            </div>
        </div>
    </div>
</div>