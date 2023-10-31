<div class="row d-flex justify-content-center mt-5">
    <div class="col-7">
        <div class="card">
            <?php echo $this->Form->create('Message')?>
            <div class="card-header">
                <h2>Send Message</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <?php
                                echo $this->Form->input('recipient_id',array(
                                    'type'=> 'select',
                                    'class' => 'form-control select2',
                                ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row mt-1" style="display:none;" id="message-form">
                    <div class="col-12">
                        <?php
                            echo $this->Form->input('message',array(
                                'type'=> 'textarea',
                                'class' => 'form-control',
                            ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <?php
                    // Cancel Button
                    echo $this->Html->link('Cancel', 'index', array(
                        'class'=> 'btn btn-danger mr-2',
                        'type' => 'cancel'
                    ));        
                
                    // Submit Button
                    echo $this->Form->end(array(
                        'class' => 'btn btn-success',
                        'type' => 'submit',
                        'label' => 'Send',
                        'id' => 'send-form',
                        'disabled' => 'disabled'
                    ));
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.select2').select2({
            ajax: {
                url: 'contactList',
                type: 'post',
                dataType: 'json',
                delay: '250',
                data: function (term) {
                    return { searchTerm: term };
                },
                processResults: function(data) {
                    var results = [];

                    $.each(data, function(key, value) {
                        results.push({
                            id: key,
                            text: value
                        });
                    });

                    return {
                        results: results
                    };
                }
            }
        });

        $('.select2').on('change', function () {
            if ($(this).val() != null) {
                $('#message-form').show();
                $('#send-form').prop("disabled",false);
            } else {
                $('#message-form').hide();
            }
        });
    });
</script>