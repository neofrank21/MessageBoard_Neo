<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->fetch('title');?></title>
    <?php 
    
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('jquery-ui.min');
    echo $this->Html->css('select2.min');
    echo $this->Html->css('dropify.min');
    echo $this->Html->css('font-awesome.min');
    echo $this->Html->script('jquery');
    echo $this->Html->script('angular.min');
    echo $this->Html->script('bootstrap.bundle.min');
    echo $this->Html->script('bootstrap.min');
    echo $this->Html->script('jquery-ui.min');
    echo $this->Html->script('dropify.min');
    echo $this->Html->script('moment.min');
    echo $this->Html->script('select2.min');
    echo $this->Html->meta('preconnect', 'https://fonts.googleapis.com');
    echo $this->Html->meta('preconnect', 'https://fonts.gstatic.com', array('crossorigin' => 'anonymous'));
    echo $this->Html->css('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap', array('rel' => 'stylesheet'));
    echo $this->Html->css('font');

    echo $this->Js->writeBuffer(array('cache' => true));
    ?>
</head>
    <body style="background-color: #FED7BF;">
        <div class="container-xl">
            <!-- Header Start -->
            <nav class="navbar navbar-expand-xl navbar-light shadow-sm" style="background-color: #E4AFB0;">
                <?php echo $this->Html->link('Message Board', array(
                                'controller' => 'users',
                                'action' => 'home'
                            ), array(
                                'class' => 'navbar-brand font-weight-bold',
                                'full_base' => true
                            ));?> 
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <?php echo $this->Html->link('Home', array(
                                'controller' => 'users',
                                'action' => 'home'
                            ), array(
                                'class' => 'nav-link',
                                'full_base' => true
                            ));?> 
                        </li>
                        <li class="nav-item active">
                            <?php echo $this->Html->link('Profile', array(
                                'controller' => 'users',
                                'action'=> 'profile'
                            ), array(
                                'class' => 'nav-link',
                                'full_base' => true
                            ));?> 
                        </li>
                        <li class="nav-item active">
                            <?php
                                echo $this->Html->link('Message', array(
                                    'controller' => 'message',
                                    'action' => 'index',
                                ), array(
                                    'class' => 'nav-link',
                                    'full-base' => true
                                ));
                            ?>
                        </li>
                    </ul>
                    <strong class="mr-4">
                        <?php if($currentUser):?>
                            <?php echo $currentUser['name'];?>
                        <?php else:?>
                            Bad
                        <?php endif;?>
                    </strong>
                    <?php 
                        /* Logout Button */
                        echo $this->Html->link('Logout',array(
                            'controller' => 'users',
                            'action' => 'logout'
                        ),array(
                            'class' => 'btn btn-outline-dark my-2 my-sm-0',
                            'full_base' => true
                        ));
                    ?> 
                </div>
            </nav>
            <!-- Header End -->
        </div>

        <div class="container-fluid">
            <!-- Content Start -->
                <?= $this->fetch('content'); ?>
            <!-- Content End -->
        </div>
    </body>
</html>