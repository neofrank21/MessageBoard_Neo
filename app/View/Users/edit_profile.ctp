<div class="row mt-5">
    <div class="col-12 d-flex justify-content-center">
        <div class="card">
            <?php echo $this->Form->create('User', ['type' => 'file']);?>
                <div class="card-header">
                    <h2>Edit Profile</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <?php
                                $img = isset($userData['User']['img']) ? '../img/'.$userData['User']['img'] : '';
                                echo $this->Form->input('img', array(
                                    'label'=> false,
                                    'class'=> 'dropify',
                                    'type'=> 'file',
                                    'data-max-file-size'=> '2M',
                                    'data-allowed-file-extensions'=> array('jpg','png','gif'),
                                    'data-max-file-size-preview' => '2M',
                                    'data-default-file' => $img,
                                ));
                            ?>
                        </div>
                    </div>
                    <hr class="hr"/>
                    <div class="row">
                        <div class="col-12">
                            <h4>User Information</h4>
                        </div>
                        <div class="col-6">
                            <?php
                                echo $this->Form->input('name', array(
                                    'class' => 'form-control',
                                    'type' => 'text',
                                    'default' => isset($userData['User']['name']) ? $userData['User']['name'] : ''
                                ));
                            ?>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="form-label mb-2">Gender</div>
                            <?php
                                echo $this->Form->input('gender', array(
                                    'class' => 'form-control select2',
                                    'options' => array('Male' => 'Male', 'Female' => 'Female'),
                                    'empty' => 'Choose One',
                                    'label' => false,
                                    'style' => array('width' => '100%'),
                                    'default' => isset($userData['User']['gender']) ? $userData['User']['gender'] : '',
                                ));
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <?php
                                $birthdate = isset($userData['User']['birthdate']) ? $userData['User']['birthdate'] : '';
                                echo $this->Form->input('birthdate', array(
                                    'class' => 'form-control',
                                    'id' => 'birth-date',
                                    'autocomplete' => 'off',
                                    'default' => date("Y-m-d",strtotime($birthdate))
                                ));
                            ?>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <h6>Description</h6>
                            <?php
                                echo $this->Form->textarea('hobby', array(
                                    'class' => 'form-control',
                                    'default' => isset($userData['User']['hobby']) ? $userData['User']['hobby'] : ''
                                ));

                                echo $this->Form->input('remove_img', array(
                                    'type' => 'hidden',
                                    'id' => 'remove-img',
                                    'value' => 0
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

<script>
    $(document).ready(function(){
        $('#birth-date').datepicker({
            dateFormat: "yy-mm-dd"
        });

       $('.dropify').dropify();

        $('.dropify-clear').click(function(e){
            e.preventDefault();
            $('#remove-img').val(1);
        });
    });
</script>