<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->fetch('title');?></title>
    <?php
    
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->script('jquery');
    echo $this->Html->script('bootstrap');
    echo $this->Html->css('font-awesome.min');
    echo $this->Html->meta('preconnect', 'https://fonts.googleapis.com');
    echo $this->Html->meta('preconnect', 'https://fonts.gstatic.com', array('crossorigin' => 'anonymous'));
    echo $this->Html->css('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap', array('rel' => 'stylesheet'));
    echo $this->Html->css('font');

    ?>
</head>
<body>
    <div class="container">
        <?php echo $this->fetch('content'); ?>
    </div>
</body>
</html>