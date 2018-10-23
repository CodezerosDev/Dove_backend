<?php

$num_columns	= 4;
$can_delete	= $this->auth->has_permission('My_Tokens.Content.Delete');
$can_edit		= $this->auth->has_permission('My_Tokens.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>

<?php if (!isset($ajax)) : ?>
    <div class='admin-box'>
    <?php
    $attributes = array(
        'name' => 'admin_listing_form',
        'id' => 'admin_listing_form',
        'class'=>'form-inline'
    );
    ?>
    <?php echo form_open($this->uri->uri_string().'/index', $attributes); ?>
    <div id='ajax_loader'>
    </div>
    <div class='grid-filters'>
        <input type="hidden" value="" name="sortby" id="sortby" class="reset-input">
        <input type="hidden" value="" name="order" id="order" class="reset-input">
        <input type="hidden" value="" name="action" id="action" class="reset-input">
        <table>
            <tr>
                <td></td>
                <td><td><input type='text' class='search-field reset-input form-control' rel_id='serach_filed1' name='search[user_id]' />&nbsp;</td><td><select class='search-field-dropdown reset-dropdown form-control input-small ' rel='serach_filed1' ><option value='user_id'>User ID</option><option value='token'>token</option><option value='token_transaction_id'>Transaction ID</option></select>&nbsp;</td></td>
                <td></td>
                <td><button type='button' class='btn submit-filters' title='Find' data-original-title=''>Find</button>&nbsp;</td>
                <td><button type='button' class='btn reset-filters' title='Reset' data-original-title=''>Reset</button>&nbsp;</td>
                <td>
                    <?php if ($can_delete) : ?>
                        <button type='button' class='btn delete-selected btn-danger' title='Delete Selected' data-original-title=''>Delete Selected</button>&nbsp;
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
            <?php if ($can_delete && $has_records) : ?>
                <th class='column-check'><input class='check-all' type='checkbox' /></th>
            <?php endif;?>

            <th><?php echo lang('my_tokens_field_user_id'); ?>                        <i class="icon-arrow-up sort" rel="asc" for="user_id" title="Asc" effect="tooltip"></i>
                <i class="icon-arrow-down sort" rel="desc" for="user_id" title="Desc" effect="tooltip"></i></th>
            <th><?php echo lang('my_tokens_field_token'); ?>                        <i class="icon-arrow-up sort" rel="asc" for="token" title="Asc" effect="tooltip"></i>
                <i class="icon-arrow-down sort" rel="desc" for="token" title="Desc" effect="tooltip"></i></th>
            <th><?php echo lang('my_tokens_field_token_transaction_id'); ?>                        <i class="icon-arrow-up sort" rel="asc" for="token_transaction_id" title="Asc" effect="tooltip"></i>
                <i class="icon-arrow-down sort" rel="desc" for="token_transaction_id" title="Desc" effect="tooltip"></i></th>
        </tr>
        </thead>
        <?php if ($has_records) : ?>
            <tfoot>
            <?php if ($can_delete) : ?>
                <tr>
                    <td colspan='<?php echo $num_columns; ?>'>
                        <?php
                        if (isset($pagination)) {
                            echo $pagination;
                        }
                        ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tfoot>
        <?php endif; ?>
        <tbody>
        <?php
        if ($has_records) :
            foreach ($records as $record) :
                ?>
                <tr>
                    <?php if ($can_delete) : ?>
                        <td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
                    <?php endif;?>

                    <td><?php e($record->user_id); ?></td>
                    <td><?php e($record->token); ?></td>
                    <td><?php e($record->token_transaction_id); ?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan='<?php echo $num_columns; ?>'><?php echo lang('my_tokens_records_empty'); ?></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
<?php if (!isset($ajax)) : ?>
    <?php echo form_close(); ?>
    </div>
    </div>
<?php endif; ?>