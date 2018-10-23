<div class="masthead">
    <ul class="nav nav-pills pull-right">
        <li <?php echo check_class('home'); ?>><a href="http://dove.network"><?php e(lang('bf_home')); ?></a></li>
        <?php if ($this->session->userdata('user_id')=='') : ?>
        <li><a href="<?php echo site_url(LOGIN_URL); ?>">Sign In</a></li>
        <?php else : ?>
        <li <?php echo check_method('profile'); ?>><a href="<?php echo site_url('users/profile'); ?>"><?php e(lang('bf_user_settings')); ?></a></li>
        <li <?php echo check_method('kyc'); ?>><a href="<?php echo site_url('users/kyc'); ?>"><?php e(lang('bf_kyc')); ?></a></li>
        <!--<li><a href="<?php /*echo site_url('users/my_buy_token'); */?>"><?php /*e(lang('bf_buy_token')); */?></a></li>-->
        <li><a href="<?php echo site_url('logout'); ?>"><?php e(lang('bf_action_logout')); ?></a></li>
        <?php endif; ?>
    </ul>
    <!--<h3 class="muted"><?php /*e(class_exists('Settings_lib') ? settings_item('site.title') : 'Bonfire'); */?></h3>-->
    <h3 class="muted"><a href="https://dove.network/"><img src="<?=base_url();?>assets/images/_logo_3.png"></a></h3>
</div>
<hr />