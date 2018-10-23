<div class='admin-box portlet box purple'>
    <div class='portlet-title'>
        <div class='caption'>
            <i class='fa fa-cogs'></i> Email Settings
        </div>
    </div>
    <div class='portlet-body form'>

	<?php echo form_open(SITE_AREA .'/settings/emailer', 'class="form-horizontal"'); ?>

	<fieldset>
		<legend>General Settings</legend>

		<div class="control-group <?php echo form_error('sender_email') ? 'has-error' : '' ?>">
			<label class="control-label col-md-3" for="sender_email"><?php echo lang('em_system_email'); ?></label>
			<div class="controls">
				<input type="email" name="sender_email" id="sender_email" class="form-control input-large " value="<?php echo set_value('sender_email', $sender_email)  ?>" />
				<?php if (form_error('sender_email')) echo '<span class="help-inline">'. form_error('sender_email') .'</span>'; ?>
				<p class="help-block"><?php echo lang('em_system_email_note'); ?></p>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label col-md-3" for="mailtype"><?php echo lang('em_email_type'); ?></label>
			<div class="controls">
				<select name="mailtype" class="form-control input-small" id="mailtype">
					<option value="text" <?php echo set_select('mailtype', 'text', $mailtype == 'text'); ?>>Text</option>
					<option value="html" <?php echo set_select('mailtype', 'html', $mailtype == 'html'); ?>>HTML</option>
				</select>
			</div>
		</div>

		<div class="control-group <?php echo form_error('protocol') ? 'has-error' : ''; ?>">
			<label class="control-label col-md-3" for="server_type"><?php echo lang('em_email_server'); ?></label>
			<div class="controls">
				<select name="protocol" class="form-control input-small" id="server_type">
					<option <?php echo set_select('protocol', 'mail', $protocol == 'mail'); ?>>mail</option>
					<option <?php echo set_select('protocol', 'sendmail', $protocol == 'sendmail'); ?>>sendmail</option>
					<option value="smtp" <?php echo set_select('protocol', 'smtp', $protocol == 'smtp'); ?>>SMTP</option>
				</select>
	    	    <span class="help-inline"><?php echo form_error('protocol'); ?></span>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?php echo lang('em_settings'); ?></legend>
		<!-- PHP Mail -->
		<div id="mail" class="control-group">
			<p class="intro"><?php echo lang('em_settings_note'); ?></p>
		</div>

		<!-- Sendmail -->
		<div id="sendmail" class="control-group <?php echo form_error('mailpath') ? 'has-error' : ''; ?>" style="padding-top: 27px">
			<label  class="control-label col-md-3" for="mailpath">Sendmail <?php echo lang('em_location'); ?></label>
			<div class="controls">
				<input type="text" name="mailpath" id="mailpath" class="form-control input-large" value="<?php echo set_value('mailpath', $mailpath) ?>" />
				<span class="help-inline"><?php echo form_error('mailpath'); ?></span>
			</div>
		</div>

		<!-- SMTP -->
		<div id="smtp" style="padding-top: 27px">

			<div class="control-group <?php echo form_error('smtp_host') ? 'has-error' : ''; ?>">
				<label class="control-label col-md-3" for="smtp_host">SMTP <?php echo lang('em_server_address'); ?></label>
				<div class="controls">
					<input type="text" name="smtp_host" id="smtp_host" class="form-control input-large" value="<?php echo set_value('smtp_host', $smtp_host) ?>" />
		    	    <span class="help-inline"><?php echo form_error('smtp_host'); ?></span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label col-md-3" for="smtp_user">SMTP <?php echo lang('bf_username'); ?></label>
				<div class="controls">
					<input type="text" name="smtp_user" id="smtp_user" class="form-control input-large" value="<?php echo set_value('smtp_user', $smtp_user) ?>" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label col-md-3" for="smtp_pass">SMTP <?php echo lang('bf_password'); ?></label>
				<div class="controls">
					<input type="password" name="smtp_pass" id="smtp_pass" class="form-control input-large" value="<?php echo set_value('smtp_pass', $smtp_pass) ?>" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label col-md-3" for="smtp_port">SMTP <?php echo lang('em_port'); ?></label>
				<div class="controls">
					<input type="text" name="smtp_port" id="smtp_port" class="form-control input-large" value="<?php echo set_value('smtp_port', $smtp_port) ?>" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label col-md-3" for="smtp_timeout">SMTP <?php echo lang('em_timeout_secs'); ?></label>
				<div class="controls">
					<input type="text" name="smtp_timeout" id="smtp_timeout" class="form-control input-large" value="<?php echo set_value('smtp_timeout', $smtp_timeout) ?>" />
				</div>
			</div>
		</div>
	</fieldset>

	<div class="form-actions">
		<input type="submit" name="save" class="btn purple" value="<?php e(lang('em_save_settings')); ?>" />
	</div>

	<?php echo form_close(); ?>
        </div>
</div>

<!-- Test Settings -->
<div class='admin-box portlet box purple'>
    <div class='portlet-title'>
        <div class='caption'>
            <i class='fa fa-cogs'></i><?php echo lang('em_test_settings') ?>
        </div>
    </div>
    <div class='portlet-body form'>
        <h2><p class="intro"><?php echo lang('em_test_header'); ?></p></h2>

	<?php echo form_open(SITE_AREA .'/settings/emailer/test', array('class' => 'form-horizontal', 'id'=>'test-form')); ?>
		<fieldset>
<!--			<legend>--><?php //echo lang('em_test_settings') ?><!--</legend>-->
			<br/>
			<p class="intro"><?php echo lang('em_test_intro'); ?></p>

			<br/>
			<div class="control-group">
				<label class="control-label col-md-3" for="test-email"><?php echo lang('bf_email'); ?></label>
				<div class="controls">
					<input type="email" name="email" class="form-control input-medium" id="test-email" value="<?php echo set_value('test_email', settings_item('site.system_email')) ?>" />
					</br><input type="submit" name="test" class="btn purple" value="<?php echo lang('em_test_button'); ?>" />
				</div>
			</div>
		</fieldset>

		<div id="test-ajax"></div>

	<?php echo form_close(); ?>
        </div>
</div>
