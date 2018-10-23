<p class="intro"><?php echo lang('em_template_note'); ?></p>

<div class='admin-box portlet box purple'>
    <div class='portlet-title'>
        <div class='caption'>
            <i class='glyphicon glyphicon-wrench'></i> Email Template
        </div>
    </div>
    <div class='portlet-body form'>
		<?php echo form_open(SITE_AREA .'/settings/emailer/template'); ?>

		<fieldset>
			<legend><?php echo lang('em_header'); ?></legend>
			<div class="clearfix">
				<div class="input">
					<textarea name="header" class="form-control input-lg" rows="15" style="width: 99%"><?php echo htmlspecialchars_decode($this->load->view('email/_header', null, true)) ;?></textarea>
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend><?php echo lang('em_footer'); ?></legend>

			<div class="clearfix">
				<div class="input">
					<textarea name="footer" class="form-control input-lg" rows="15" style="width: 99%"><?php echo htmlspecialchars_decode($this->load->view('email/_footer', null, true)) ;?></textarea>
				</div>
			</div>
		</fieldset>

		<div class="form-actions">
			<input type="submit" name="save" id="submit" class="btn purple" value="<?php e(lang('em_save_template')); ?>" /> or <?php echo anchor(SITE_AREA .'/settings/emailer', lang('bf_action_cancel'),'class="btn default"'); ?>
		</div>

	<?php echo form_close(); ?>

</div>
