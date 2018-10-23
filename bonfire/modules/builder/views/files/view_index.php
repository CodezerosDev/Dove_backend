<?php

//Grid Area
$tmp_module_name_lower = "";
if (!$table_as_field_prefix) {
    $tmp_module_name_lower = '';
} else {
    $tmp_module_name_lower = $module_name_lower . '_';
}

$category = array();
$search = array();
$sort = array();
$pagination = "";
$hidden_fields = "";
$btn_find = "";
$btn_delete_selected = "";
$btn_reset = "";
$between = array();
$grid_category = "";
$grid_search = "";
$grid_between = "";

//status
if ($this->input->post('use_status') == 'true') {
    $category['active'] = "Active";
    $category['inactive'] = "Inactive";
}

//created
if ($this->input->post('use_created') == 'true') {
    $category['newest'] = "Newest";
    $category['oldest'] = "Oldest";
}

//category
if (!empty($category)) {
    $grid_category = $this->grid->print_category($category);
}

//search
$tmp_search_array = $this->input->post('grid_search');
if (isset($tmp_search_array) && !empty($tmp_search_array)) {
    foreach ($tmp_search_array as $value) {
        $search_v = $this->input->post($value);
        $search_v = $tmp_module_name_lower . "{$search_v}";

        $label_v = $this->input->post(str_replace("name", "label", $value));
        $search[$search_v] = $label_v;
    }
}

if (!empty($search)) {
    $grid_search = $this->grid->print_search_field_with_filter(array($search));
}

//between
$tmp_between = $this->input->post('grid_between');
if (isset($tmp_between) && !empty($tmp_between)) {
    foreach ($tmp_between as $value) {
        $between_v = $this->input->post($value);
        $between_v = $tmp_module_name_lower . "{$between_v}";
        $label_v = $this->input->post(str_replace("name", "label", $value));
        $between[$between_v] = $label_v;
    }
}

if (!empty($between)) {
    $grid_between = $this->grid->print_between($between);
}

//sort
$tmp_sort = $this->input->post('grid_sort');
if (isset($tmp_sort) && !empty($tmp_sort)) {
    foreach ($tmp_sort as $value) {
        $sort_v = $sort_v_pre = $this->input->post($value);
        $sort_v_pre = $tmp_module_name_lower . "{$sort_v}";
        $sort[$sort_v] = $sort_v_pre;
    }
}

//hidden fields
$hidden_fields = $this->grid->print_hidden_fields();

if (!empty($category) || !empty($search) || !empty($between)) {
    $btn_find = $this->grid->print_submit_button();
    $btn_reset = $this->grid->print_reset_button();
}
$btn_delete_selected = $this->grid->print_delete_button();
//Grid Area Ends


//------------------------------------------------------------------------------
// Setup the fields to be displayed in the view
//------------------------------------------------------------------------------
$field_prefix = '';
$headers = '';
$editColumnAdded = false;
$pager = '';
$pencil_icon = "'<span class=\"glyphicon glyphicon-edit\"></span> ' . ";
$table_records = '';
$pencil_icon = "<i class=\"glyphicon glyphicon-edit\" title=\"Edit\" effect=\"tooltip\" >&nbsp;</i>";
$delete_icon = "<i class=\"glyphicon glyphicon-trash\" title=\"Delete\" effect=\"tooltip\" >&nbsp;</i>";

if ($usePagination) {
    $pager = "
    echo \$this->pagination->create_links();";
}

if ($db_required == 'new' && $table_as_field_prefix === true) {
    $field_prefix = "{$module_name_lower}_";
}

for ($counter = 1; $field_total >= $counter; $counter++) {
    // Only build on fields that have data entered.
    if (set_value("view_field_label$counter") == null
        || set_value("view_field_name$counter") == $primary_key_field
    ) {
        continue; // move onto next iteration of the loop
    }

    $label = set_value("view_field_label$counter");
    $name = set_value("view_field_name$counter");
    $field_name = "{$field_prefix}{$name}";

    $headers .= "
					<th><?php echo lang('{$module_name_lower}_field_{$name}'); ?>";
    if (!empty($sort)) {
        $tmp_f = $this->input->post("view_field_name$counter");
        if (array_key_exists($tmp_f, $sort)) {
            $field = $sort[$tmp_f];
            $headers .= <<<EOT
                        <i class="icon-arrow-up sort" rel="asc" for="{$field}" title="Asc" effect="tooltip"></i>
                        <i class="icon-arrow-down sort" rel="desc" for="{$field}" title="Desc" effect="tooltip"></i>
EOT;
        }
    }
    $headers .= "</th>";

    // Instead of checking a specific $counter value, which may be skipped,
    // track whether the edit column has been added
    // When building from existing table, modify output of the 'deleted' maintenance column
    if ($db_required == 'existing' && $field_name == $soft_delete_field) {
        $table_records .= "
					<td><?php echo \$record->{$field_name} > 0 ? lang('{$module_name_lower}_true') : lang('{$module_name_lower}_false'); ?></td>";
    } else {
        $table_records .= "
					<td><?php e(\$record->{$field_name}); ?></td>";
    }
}

if ($use_position == 'true') {
    $headers .= "<th>Position</th>";
    $tmp_position_field = $this->input->post('position_field');
    $table_records .= <<<EOT
                 <td class="position">
                            <?php if(isset(\$max_position) && !empty(\$max_position)) {?>
                                <?php if(\$record->{$tmp_position_field} < \$max_position) { ?>
                                        &nbsp;<i rel_id="<?php echo \$record->{$primary_key_field} ?>" position="<?php echo \$record->{$tmp_position_field}  ?>" state="up" class="icon-chevron-down"></i>
                                <?php } ?>
                            <?php }?>
                            <?php if(isset(\$min_position) && !empty(\$min_position)) {?>
                                <?php if(\$record->{$tmp_position_field} > \$min_position) { ?>
                                        &nbsp;<i rel_id="<?php echo \$record->{$primary_key_field} ?>" position="<?php echo \$record->{$tmp_position_field}  ?>" state="down" class="icon-chevron-up"></i>
                                <?php } ?>
                            <?php }?>
                </td>
EOT;
    $field_total++;
}

// Only add maintenance columns to the view when module is creating a new db table
// (columns should already be present and handled above when existing table is used)
if ($db_required == 'new') {
    if ($useSoftDeletes) {
        $headers .= "
					<th><?php echo lang('{$module_name_lower}_column_deleted'); ?></th>";
        $table_records .= "
					<td><?php echo \$record->{$soft_delete_field} > 0 ? lang('{$module_name_lower}_true') : lang('{$module_name_lower}_false'); ?></td>";
        $field_total++;
    }
    if ($useCreated) {
        $headers .= "
					<th><?php echo lang('{$module_name_lower}_column_created'); ?></th>";
        $table_records .= "
					<td><?php echo show_formatted_date(\$record->{$created_field}); ?></td>";
        $field_total++;
    }
    if ($useModified) {
        $headers .= "
					<th><?php echo lang('{$module_name_lower}_column_modified'); ?></th>";
        $table_records .= "
					<td><?php echo show_formatted_date(\$record->{$modified_field}); ?></td>";
        $field_total++;
    }
}

if ($use_status == 'true') {
    $headers .= "<th>Status</th>";
    $tmp_status_field = $this->input->post('status_field');
    $table_records .= <<<EOT
                <?php
                            if (\$record->{$tmp_status_field} == 1) {
                                \$status = "Active";
                                \$btn_status = "Inactive";
                                \$class = "success";
                            } else {
                                \$status = "Inactive";
                                \$btn_status = "Active";
                                \$class = "warning";
                            }
                            ?>
                            <td><span style="cursor: pointer;" class="badge badge-<?php echo \$class; ?> toggle_status" rel_id="<?php echo \$record->{$primary_key_field}; ?>" ><?php echo \$status ?></span></td>
EOT;
    $field_total++;
}

$headers .= "<th>Action</th>";
$table_records .= <<<EOT
            <td>
            <?php if (\$can_edit) : ?>
                <?php echo anchor(SITE_AREA .'/$controller_name/$module_name_lower/edit/'.\$record->$primary_key_field, '{$pencil_icon}') ?>&nbsp;&nbsp;
            <?php endif;?>
            <?php if ((\$can_delete) && isset(\$records) && is_array(\$records) && count(\$records)) : ?>
                <span style="cursor: pointer;" class="delete" data-original-title="" title="" rel="<?php echo \$record->{$primary_key_field};  ?>">{$delete_icon}</span>&nbsp;&nbsp;
            <?php endif;?>
            </td>
EOT;
$field_total++;

$permissionName = preg_replace("/[ -]/", "_", ucfirst($module_name)) . '.' . ucfirst($controller_name);

//------------------------------------------------------------------------------
// Output the view
//------------------------------------------------------------------------------
echo "<?php

\$num_columns	= {$field_total};
\$can_delete	= \$this->auth->has_permission('{$permissionName}.Delete');
\$can_edit		= \$this->auth->has_permission('{$permissionName}.Edit');
\$has_records	= isset(\$records) && is_array(\$records) && count(\$records);

if (\$can_delete) {
    \$num_columns++;
}
?>

<?php if (!isset(\$ajax)) : ?>
<div class='admin-box'>
	<?php
        \$attributes = array(
            'name' => 'admin_listing_form',
            'id' => 'admin_listing_form',
            'class'=>'form-inline'
        );
        ?>
	<?php echo form_open(\$this->uri->uri_string().'/index', \$attributes); ?>
	<div id='ajax_loader'>
	</div>
	<div class='grid-filters'>
        {$hidden_fields}
        <table>
        <tr>
        <td>{$grid_category}</td>
        <td>{$grid_search}</td>
        <td>{$grid_between}</td>
        <td>{$btn_find}</td>
        <td>{$btn_reset}</td>
        <td>
            <?php if (\$can_delete) : ?>
                {$btn_delete_selected}
            <?php endif; ?>
        </td>
        </tr>
        </table>
        </div>

        <div id='table_content'>
        <?php endif; ?>
		<table class='table table-striped table-bordered table-hover dataTable no-footer'>
			<thead>
				<tr>
					<?php if (\$can_delete && \$has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					{$headers}
				</tr>
			</thead>
			<?php if (\$has_records) : ?>
			<tfoot>
				<?php if (\$can_delete) : ?>
				<tr>
					<td colspan='<?php echo \$num_columns; ?>'>
						<?php
                        if (isset(\$pagination)) {
                            echo \$pagination;
                        }
                        ?>
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if (\$has_records) :
					foreach (\$records as \$record) :
				?>
				<tr>
					<?php if (\$can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo \$record->{$primary_key_field}; ?>' /></td>
					<?php endif;?>
					{$table_records}
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo \$num_columns; ?>'><?php echo lang('{$module_name_lower}_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		<?php if (!isset(\$ajax)) : ?>
		<?php echo form_close(); ?>
    </div>
</div>
<?php endif; ?>";