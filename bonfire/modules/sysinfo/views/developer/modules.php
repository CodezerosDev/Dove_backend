<div class="admin-box">
	<h3><?php echo lang('sysinfo_installed_mods'); ?></h3>
    <?php if ( ! empty($modules) && is_array($modules)) : ?>
    <table class="table table-striped table-bordered table-hover dataTable no-footer">
        <thead>
            <tr>
                <th><?php echo lang('sysinfo_mod_name'); ?></th>
                <th><?php echo lang('sysinfo_mod_ver'); ?></th>
                <th><?php echo lang('sysinfo_mod_desc'); ?></th>
                <th><?php echo lang('sysinfo_mod_author'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modules as $module => $config) : ?>
            <tr>
                <td><?php echo $config['name']; ?></td>
                <td><?php echo isset($config['version']) ? $config['version'] : '---'; ?></td>
                <td><?php echo isset($config['description']) ? $config['description'] : '---'; ?></td>
                <td><?php echo isset($config['author']) ? $config['author'] : '---'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>