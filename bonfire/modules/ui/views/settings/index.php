<?php if ($validationErrors = validation_errors()) : ?>
<div class="alert alert-danger fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<p><?php echo $validationErrors; ?></p>
</div>
<?php endif; ?>
<p class='intro'><?php echo lang('ui_keyboard_shortcuts'); ?></p>
<div class=' portlet box blue'>
    <div class='portlet-title'>
        <div class='caption'>
            <i class='fa fa-keyboard-o'></i> Shortcut Keys
        </div>
    </div>
    <div class='portlet-body form'>
	<?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'id' => 'shortcut_form')); ?>
		<table class="table table-condensed">
			<thead>
				<tr>
					<th><?php echo lang('ui_action'); ?></th>
					<th colspan="2"><?php echo lang('ui_shortcut'); ?> <span class="help-inline"><?php echo lang('ui_shortcut_help'); ?></span></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>
						<select name="new_action" class="form-control input-large">
    						<?php
                            foreach ($current as $name => $detail) :
                                if ( ! array_key_exists($name, $settings)) :
                            ?>
							<option value="<?php echo $name; ?>" <?php echo set_select('new_action', $name); ?>><?php echo $detail['description']; ?></option>
							<?php
                                endif;
                            endforeach;
                            ?>
						</select>
					</th>
					<td><input type="text" name="new_shortcut" class="form-control input-medium" value="<?php echo set_value('new_shortcut'); ?>" /></td>
					<td><input type="submit" name="add_shortcut" class="btn default" value="<?php echo lang('ui_add_shortcut'); ?>" /></td>
				</tr>
				<?php foreach ($settings as $action => $shortcut) : ?>
                <tr>
                    <th class="col-md-3"><?php echo $current[$action]['description']; ?></th>
                    <td><input type="text" class='form-control input-medium'name="shortcut_<?php echo $action;?>" value="<?php echo set_value("shortcut_$action", $shortcut); ?>" /></td>
                    <td><input type="submit" name="remove_shortcut[<?php echo $action; ?>]" value="<?php echo lang('ui_remove_shortcut'); ?>" class="btn btn-danger" /></td>
                </tr>
				<?php endforeach; ?>
			</tbody>
		</table>
        <div class='form-actions'>
            <input type="submit" name="save" class="btn blue" value="<?php echo lang('ui_update_shortcuts'); ?>" />
        </div>
    <?php echo form_close(); ?>
</div>