<?php

$validation_errors = validation_errors();
$errorClass = ' error';
$controlClass = 'span6';
$fieldData = array(
    'errorClass'    => $errorClass,
    'controlClass'  => $controlClass,
);

?>
<section id="kyc">
	<h3 class="page-header"><?php echo lang('us_kyc_doc'); ?></h3>
    <?php if ($validation_errors) : ?>
    <div class="alert alert-error">
        <?php echo $validation_errors; ?>
    </div>
    <?php endif; ?>
    <?php if (isset($user) && $user->role_name == 'Banned') : ?>
    <div data-dismiss="alert" class="alert alert-error">
        <?php echo lang('us_banned_admin_note'); ?>
    </div>
    <?php endif; ?>

    <div class="row-fluid">
    	<div class="span12">
            <?php echo form_open_multipart($this->uri->uri_string(), array('class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
                <input type="hidden" name="from" value="kyc">
                <!-- Start User Meta -->

            <!--<div class="control-group<?php /*echo form_error('name') ? $errorClass : ''; */?>">
                <label class="control-label col-md-3" for="name"><?php /*echo lang('bf_name'); */?></label>
                <div class="controls">
                    <input class="<?php /*echo $controlClass; */?> form-control input-medium" type="text" id="name" name="name" value="<?php /*echo set_value('name', isset($user) ? $user->name : ''); */?>" />
                    <span class="help-inline"><?php /*echo form_error('name'); */?></span>
                </div>
            </div>

            <div class="control-group<?php /*echo form_error('address') ? $errorClass : ''; */?>">
                <label class="control-label col-md-3" for="address"><?php /*echo lang('bf_address'); */?></label>
                <div class="controls">
                    <textarea name="address" class="<?php /*echo $controlClass; */?> form-control input-medium" id="address"><?php /*echo set_value('address', isset($user) ? $user->address : ''); */?></textarea>
                    <span class="help-inline"><?php /*echo form_error('address'); */?></span>
                </div>
            </div>-->

                <div class="control-group<?php echo form_error('referral_code') ? $errorClass : ''; ?>">
                    <label class="control-label col-md-3" for="referral_code"><?php echo lang('bf_referral_code'); ?></label>
                    <div class="controls">
                        <input class="<?php echo $controlClass; ?> form-control input-medium" type="text" id="referral_code" name="referral_code" value="<?php echo set_value('referral_code', isset($user) ? $user->referral_code : ''); ?>" />
                        <span class="help-inline"><?php echo form_error('referral_code'); ?></span>
                    </div>
                </div>


                <?php $this->load->view('users/user_meta', array('frontend_only' => false));?>
                <!-- End of User Meta -->
                <div class="form-actions">
                    <input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bf_action_save') . ' ' . lang('bf_user'); ?>" />
                    <?php echo lang('bf_or') . ' ' . anchor('/', lang('bf_action_cancel')); ?>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
<script>
    $(document).ready(function(e){
       $("#name").addClass("span6");
       $("#address").addClass("span6");
    });
</script>
