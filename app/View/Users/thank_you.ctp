<div class="row d-flex justify-content-center mt-5">
    <div class="col-7 align-content-center">
    <div class="card">
        <div class="card-body justify-content-center">
          <div class="row">
            <div class="col-12 text-center">
                Thank You for Register!
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-center mt-2">
                <?php 
                    echo $this->Html->link('<i class="fa fa-home" aria-hidden="true"></i> Go to Home', array(
                        'controller'=> 'users',
                        'action'=> 'home',
                    ), array(
                        'class'=> 'btn btn-success mr-2',
                        'full_base' => true,
                        'escape' => false,
                        'label' => false,
                    ));
                ;?>
            </div>
          </div>
        </div>
    </div>
    </div>
</div>