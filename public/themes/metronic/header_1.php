<!doctype html>
<html lang="en" class="ie8 no-js">
<html lang="en" class="ie9 no-js">
<html lang="en">
<head>
<meta charset="utf-8"/>
<title><?php
    echo isset($toolbar_title) ? "{$toolbar_title} : " : '';
    e($this->settings_lib->item('site.title'));
    ?></title>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex"/>
<meta content="" name="description"/>
<meta content="" name="author"/>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/plugins/bootstrap/css/bootstrap-responsive.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/plugins/uniform/css/uniform.default.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/css/add-ons.min.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/css/custom-styles.css'); ?>" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?php echo Template::theme_url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/plugins/fullcalendar/fullcalendar.min.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/plugins/jqvmap/jqvmap/jqvmap.css'); ?>" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link href="<?php echo Template::theme_url('assets/admin/pages/css/tasks.css'); ?>" rel="stylesheet" type="text/css"/>
<!-- END PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo Template::theme_url('assets/global/css/components.css'); ?>" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/global/css/plugins.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/admin/layout/css/layout.css'); ?>" rel="stylesheet" type="text/css"/>
<link id="style_color" href="<?php echo Template::theme_url('assets/admin/layout/css/themes/darkblue.css'); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo Template::theme_url('assets/admin/layout/css/custom.css'); ?>" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="<?php echo Template::theme_url('assets/global/favicon.ico'); ?>"/>
    <!--<script>window.jQuery || document.write('<script src="<?php /*echo js_path(); */?>jquery-1.7.2.min.js"><\/script>');</script>-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo Template::theme_url('js/modernizr-2.5.3.js'); ?>"></script>

<!-- Ignite UI Required Combined CSS Files -->
<link href="http://cdn-na.infragistics.com/igniteui/latest/css/themes/infragistics/infragistics.theme.css" rel="stylesheet" />
<link href="http://cdn-na.infragistics.com/igniteui/latest/css/structure/infragistics.css" rel="stylesheet" />

<!--<script src="http://modernizr.com/downloads/modernizr-latest.js"></script>-->
<!--<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>-->
<!--<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>-->

    <?php
    Assets::add_js(array("fancybox/source/jquery.fancybox.js", 'modernizr-latest.js'));
    Assets::add_css("js/fancybox/source/jquery.fancybox.css");
    ?>
    <?php // echo Assets::css(null, true); ?>
<script type="text/javascript">
    window.loaderImage = "<?php echo Template::theme_url("images/ajax_loader.gif"); ?>";
    window.base_url = "<?php echo base_url(); ?>";
    window.site_url = "<?php echo site_url(); ?>";
    $(function(){
        var this1=$('.hor-menu').find('ul');
        //console.log(this1);
    });
</script>

</head>

<body class="desktop page-header-fixed page-quick-sidebar-over-content page-full-width">
<!--[if lt IE 7]>
<p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different
    browser</a> or
    <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.
</p>
<![endif]-->
<noscript>
    <p>Javascript is required to use Bonfire's admin.</p>
</noscript>
<div class="page-header navbar navbar-fixed-top">
<div class="page-header-inner">
    <!-- BEGIN LOGO -->
    <!--<div class="page-logo">
        <a href="/">
            <img src="<?php /*echo Template::theme_url('assets/admin/layout/img/logo.png'); */?>" alt="logo" class="logo-default"/>
        </a>
    </div>-->
    <div class="page-logo">
        <a href="<?php echo base_url();?>" style="color: #ffffff;text-decoration: none;font-size: 24px;margin: 7px 0;text-shadow: 1px 1px #1caf9a;">Web Clues</a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN HORIZANTAL MENU -->
    <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
    <!-- DOC: This is desktop version of the horizontal menu. The mobile version is defined(duplicated) sidebar menu below. So the horizontal menu has 2 seperate versions -->
        <ul class="hor-menu">
            <?php echo Contexts::render_menu('text', 'normal'); ?>
        </ul>

    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>

    <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
            <?php
            if (isset($shortcut_data) && is_array($shortcut_data['shortcuts'])
                && is_array($shortcut_data['shortcut_keys']) && count($shortcut_data['shortcut_keys'])
            ) :
                ?>
                <!-- Shortcut Menu -->
            <div class="nav pull-right" id="shortcuts">
                <!--<div class="btn-group">
                    <a class="dropdown-toggle light btn" data-toggle="dropdown" href="#"><img
                            src="<?php /*echo Template::theme_url('images/keyboard-icon.png'); */?>" id="shortkeys_show"
                            title="Keyboard Shortcuts" alt="Keyboard Shortcuts"/></a>
                    <ul class="dropdown-menu pull-right toolbar-keys">
                        <li>
                            <div class="inner keys">
                                <h4><?php /*echo lang('bf_keyboard_shortcuts'); */?></h4>
                                <ul>
                                    <?php /*foreach ($shortcut_data['shortcut_keys'] as $key => $data) : */?>
                                        <li><span><?php /*e($data); */?></span>
                                            : <?php /*echo $shortcut_data['shortcuts'][$key]['description']; */?></li>
                                    <?php /*endforeach; */?>
                                </ul>
                                <?php /*if (has_permission('Bonfire.UI.View') && has_permission('Bonfire.UI.Manage')): */?>
                                    <a href="<?php /*echo site_url(SITE_AREA . '/settings/ui'); */?>"><?php /*echo lang('bf_keyboard_shortcuts_edit'); */?></a>
                                <?php /*endif; */?>
                            </div>
                        </li>
                    </ul>
                </div>-->
            </div>
            <?php endif; ?>
            <li class="dropdown dropdown-user">
                <a href="<?php echo site_url(SITE_AREA .'/settings/users/edit');?>" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <img alt="" class="img-circle" src="<?php echo base_url('assets/images/avatar.png'); ?>">

                  <span class="username username-hide-on-mobile">
					 <?php
                     $userDisplayName = isset($current_user->display_name) && !empty($current_user->display_name) ? $current_user->display_name : ($this->settings_lib->item('auth.use_usernames') ? $current_user->username : $current_user->email);
                     echo $userDisplayName;
                     ?>	 </span>
                    <i class="fa fa-angle-down"></i>
                </a>
<!--                <a href="--><?php //echo site_url(SITE_AREA .'/settings/users/edit'); ?><!--" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" title="--><?php //echo lang('bf_user_settings'); ?><!--">-->
<!--					<span class="username username-hide-on-mobile">-->
<!--					 --><?php
//                     $userDisplayName = isset($current_user->display_name) && !empty($current_user->display_name) ? $current_user->display_name : ($this->settings_lib->item('auth.use_usernames') ? $current_user->username : $current_user->email);
//                     echo $userDisplayName;
//                     ?><!-- </span>-->
<!--                    <i class="fa fa-angle-down"></i>-->
<!--                </a>-->
                <ul class="dropdown-menu dropdown-menu-default" style="width: auto;">
                    <li>
                        <a href="#"><i class="icon-user"></i><?php echo $userDisplayName; ?></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-envelope-open"></i> <?php e($current_user->email); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo site_url(SITE_AREA . '/settings/users/edit'); ?>"><i class="icon-settings"></i><?php echo lang('bf_user_settings'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('logout'); ?>"><i class="icon-key"></i><?php echo lang('bf_action_logout'); ?> </a>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
            <!-- END QUICK SIDEBAR TOGGLER -->
        </ul>
    </div>
    <!-- END TOP NAVIGATION MENU -->
    <div class="clearfix"></div>
</div>
</div>
<div class="col-md-12">

    <ul class="nav nav-tabs">
        <div class="pull-left" id="sub-menu">
            <?php if (isset($toolbar_title)) : ?>
                <h3 class="page-title" style="margin-top: 40px"><?php echo $toolbar_title; ?></h3>
            <?php endif; ?>
        </div>
        <div class="pull-right" id="sub-menu" style="margin-top: 55px"><?php Template::block('sub_nav', ''); ?></div>
    </ul>
</div>

