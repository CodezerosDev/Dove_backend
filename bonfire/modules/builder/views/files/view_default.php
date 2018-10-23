<?php

//------------------------------------------------------------------------------
// Setup the fields to be displayed in the view
//------------------------------------------------------------------------------
$field_prefix = '';
if ($db_required == 'new' && $table_as_field_prefix === true) {
    $field_prefix = "{$module_name_lower}_";
}

$viewFields = '';
for ($counter = 1; $field_total >= $counter; $counter++) {
    // Only build on fields that have data entered.
    if (set_value("view_field_label$counter") == null) {
        continue;
    }


    $maxlength = null;
    $validation_rules = $this->input->post("validation_rules{$counter}");
    $field_label = set_value("view_field_label$counter");
    $field_name  = set_value("view_field_name$counter");
    $form_name   = "{$field_prefix}{$field_name}";
    $field_type  = set_value("view_field_type$counter");

    $required = '';
    $required_attribute = false;

    // Validation rules for this fieldset
    if (is_array($validation_rules)) {
        foreach ($validation_rules as $key => $value) {
            if ($value == 'required') {
                $required = ". lang('bf_form_label_required')";
                $required_attribute = true;
            }
        }
    }

    // Type of field
    switch ($field_type) {
        case 'textarea':
            $viewFields .= PHP_EOL . "
			<div class=\"control-group<?php echo form_error('{$field_name}') ? ' has-error' : ''; ?>\">
				<?php echo form_label('{$field_label}'{$required}, '{$form_name}', array('class' => 'control-label col-md-3')); ?>
				<div class='controls'>
					<?php echo form_textarea(array('name' => '{$form_name}', 'id' => '{$form_name}', 'class' => 'form-control input-medium', 'rows' => '5', 'cols' => '80', 'value' => set_value('$form_name', isset(\${$module_name_lower}->{$field_name}) ? \${$module_name_lower}->{$field_name} : '')" . ($required_attribute ? ", 'required' => 'required'" : "") . ")); ?>
					<label id='{$field_name}-error' class='error' for='{$field_name}'></label>
					<span class='help-inline'><?php echo form_error('{$field_name}'); ?></span>
				</div>
			</div>";
            break;

        case 'radio':
            $viewFields .= PHP_EOL . "
			<div class=\"control-group<?php echo form_error('{$field_name}') ? ' has-error' : ''; ?>\">
				<?php echo form_label('{$field_label}'{$required}, '', array('class' => 'control-label col-md-3', 'id' => '{$form_name}_label')); ?>
				<div class='controls' aria-labelled-by='{$form_name}_label'>
					<label class='radio' for='{$form_name}_option1'>
						<input id='{$form_name}_option1' name='{$form_name}' type='radio' " . ($required_attribute ? "required='required' " : "") . "value='option1' <?php echo set_radio('{$form_name}', 'option1', isset(\${$module_name_lower}->{$field_name}) && \${$module_name_lower}->{$field_name} == 'option1'); ?> />
						Radio option 1
					</label>
					<label class='radio' for='{$form_name}_option2'>
						<input id='{$form_name}_option2' name='{$form_name}' type='radio' " . ($required_attribute ? "required='required' " : "") . "value='option2' <?php echo set_radio('{$form_name}', 'option2', isset(\${$module_name_lower}->{$field_name}) && \${$module_name_lower}->{$field_name} == 'option2'); ?> />
						Radio option 2
					</label>
					<label id='{$field_name}-error' class='error' for='{$field_name}'></label>
					<span class='help-inline'><?php echo form_error('{$field_name}'); ?></span>
				</div>
			</div>";
            break;

        case 'select':
            // Use CI form helper here as it makes selects/dropdowns easier
            $select_options = array();
            if (set_value("db_field_length_value$counter") != null) {
                $select_options = explode(',', set_value("db_field_length_value$counter"));
            }
            $viewFields .= PHP_EOL . '
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(';
            foreach ($select_options as $key => $option) {
                $viewFields .= '
					' . strip_slashes($option) . ' => ' . strip_slashes($option) . ',';
            }
            $viewFields .= "
				);
				echo form_dropdown(array('name' => '{$form_name}' ,'class'=>'form-control input-medium'" . ($required_attribute ? ", 'required' => 'required'" : "") . "), \$options, set_value('{$form_name}', isset(\${$module_name_lower}->{$field_name}) ? \${$module_name_lower}->{$field_name} : ''), '{$field_label}'{$required});
			?>";
            /*<label id='{$field_name}-error' class='error' for='{$field_name}'></label>*/
            break;

        case 'checkbox':
            $viewFields .= PHP_EOL . "
			<div class=\"control-group<?php echo form_error('{$field_name}') ? 'has-error' : ''; ?>\">
			<?php echo form_label('{$field_label}'{$required}, '', array('class' => 'control-label col-md-3', 'id' => '{$form_name}_label')); ?>
				<div class='controls'>
					<label class='checkbox' for='{$form_name}'>
						<input type='checkbox' id='{$form_name}' name='{$form_name}' " . ($required_attribute ? "required='required' " : "") . " value='1' <?php echo set_checkbox('{$form_name}', 1, isset(\${$module_name_lower}->{$field_name}) && \${$module_name_lower}->{$field_name} == 1); ?> />testcheckbox
					</label>
					<!--for more checkbox copy code from <label>to</label> ,change id and value for it-->
					<label id='{$field_name}-error' class='error' for='{$field_name}'></label>
                    <span class='help-inline'><?php echo form_error('{$field_name}'); ?></span>
				</div>
			</div>";
            break;

        case 'input':
            // no break;
        case('password'):
            // no break;
        default:
            $type = $field_type == 'input' ? 'text' : 'password';
            $db_field_type = set_value("db_field_type$counter");
            $max = set_value("db_field_length_value$counter");
            if ($max != null) {
                if (in_array($db_field_type, $realNumberTypes)) {
                    // Constraints for real number types are expected to be in
                    // the format of 'precision,scale', but the standard allows
                    // 'precision', where a scale of 0 is implied (therefore
                    // no decimal point is used)
                    $len = explode(',', $max);
                    $max = $len[0];
                    if ( ! empty($len[1])) {
                        $max++; // Add 1 to allow for the decimal point
                    }
                }
                $maxlength = "maxlength='{$max}'";
            }

            $viewFields .= PHP_EOL . "
			<div class=\"control-group<?php echo form_error('{$field_name}') ? ' has-error' : ''; ?>\">
				<?php echo form_label('{$field_label}'{$required}, '{$form_name}', array('class' => 'control-label col-md-6')); ?>
				<div class='controls'>
					<input id='{$form_name}' class='form-control input-medium' type='{$type}' " . ($required_attribute ? "required='required' " : "") . "name='{$form_name}' {$maxlength} value=\"<?php echo set_value('{$form_name}', isset(\${$module_name_lower}->{$field_name}) ? \${$module_name_lower}->{$field_name} : ''); ?>\" />
					<label id='{$field_name}-error' class='error' for='{$field_name}'></label>
					<span class='help-inline'><?php echo form_error('{$field_name}'); ?></span>
				</div>
			</div>";
            break;
    }
}

//Grid Area
if ($this->input->post('use_status') == 'true') {
    $tmp_status_field = $this->input->post("status_field");
    $viewFields .= "
        <?php
        \$options = array(
                1 => 'Active',
                0 => 'Inactive'
        ); ?>
        <?php echo form_dropdown('{$tmp_status_field}', \$options, set_value('{$tmp_status_field}', isset(\${$module_name_lower}->{$tmp_status_field}) ? \${$module_name_lower}->{$tmp_status_field} : ''), 'Status'. lang('bf_form_label_required'),'class=\"form-control input-medium\"')?>
        <span class=\"help-inline\"><?php echo form_error('{$tmp_status_field}'); ?></span>
        ";
}
//Grid Area Ends



//------------------------------------------------------------------------------
// Setup the delete button, if this is not a create view
//------------------------------------------------------------------------------
$delete = '';
if ($action_name != 'create') {
    $delete_permission = preg_replace("/[ -]/", "_", ucfirst($module_name)) . '.' . ucfirst($controller_name) . '.Delete';
    $delete = "
			<?php if (\$this->auth->has_permission('{$delete_permission}')) : ?>
				<?php echo lang('bf_or'); ?>
				<button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick=\"return confirm('<?php e(js_escape(lang('{$module_name_lower}_delete_confirm'))); ?>');\">
					<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('{$module_name_lower}_delete_record'); ?>
				</button>
			<?php endif; ?>";
}

//------------------------------------------------------------------------------
// Output the view
//------------------------------------------------------------------------------
$module_label = ucwords($module_name);
echo "<?php

\$validation_errors = validation_errors();

if (\$validation_errors) :
?>
<div class='alert alert-block alert-error fade in'>
	<a class='close' data-dismiss='alert'>&times;</a>
	<h4 class='alert-heading'>
		<?php echo lang('{$module_name_lower}_errors_message'); ?>
	</h4>
	<?php echo \$validation_errors; ?>
</div>
<?php
endif;

\$id = isset(\${$module_name_lower}->{$primary_key_field}) ? \${$module_name_lower}->{$primary_key_field} : '';
?>
<div class='admin-box portlet box green'>
 <div class='portlet-title'>
        <div class='caption'>
            <i class='fa fa-pencil'></i> ".($action_name == 'create' ? 'Create ': 'Edit ')."{$module_label}
        </div>
    </div>
    <div class='portlet-body form'>
	<?php echo form_open(\$this->uri->uri_string(), 'class=\"form-horizontal\"'); ?>
		<fieldset>
            {$viewFields}
        </fieldset>
		<fieldset class='form-actions'>
			<input type='submit' name='save' class='btn green' value=\"<?php echo lang('{$module_name_lower}_action_{$action_name}'); ?>\" />
			<?php echo lang('bf_or'); ?>
			<?php echo anchor(SITE_AREA . '/{$controller_name}/{$module_name_lower}', lang('{$module_name_lower}_cancel'), 'class=\"btn default\"'); ?>
			{$delete}
		</fieldset>
    <?php echo form_close(); ?>
</div>";