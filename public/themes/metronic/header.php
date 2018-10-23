<?php
    Assets::add_css(array('assets/global/plugins/bootstrap/css/bootstrap.min.css',
                          'assets/global/plugins/bootstrap/css/bootstrap-responsive.css',
                          'assets/admin/layout/css/custom.css',
                          'assets/admin/layout/css/layout.css',
                          'assets/admin/layout/css/themes/darkblue.css',
                          'assets/global/css/components.css',
                          'assets/global/css/add-ons.min.css',
                          'assets/global/css/custom-styles.css',
                          'assets/global/plugins/font-awesome/css/font-awesome.min.css',
                          'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
                          'flick/jquery-ui-1.8.13.custom.css'
                        ));
?>
<link href="<?php echo Template::theme_url('css/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css"/>
<!doctype html>
<html lang="en" class="ie8 no-js">
<html lang="en" class="ie9 no-js">
<html lang="en">
<head>
<meta charset="utf-8"/>
<title> <?php echo isset($toolbar_title) ? "{$toolbar_title} : " : ''; e($this->settings_lib->item('site.title')); ?> </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!--<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>-->
<link rel="shortcut icon" href="<?php echo Template::theme_url('assets/global/favicon.ico'); ?>"/>
<script type="text/javascript" src="<?php echo Template::theme_url('js/modernizr-2.5.3.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Template::theme_url('js/jquery-1.11.3.min.js'); ?>"></script>
<script type="text/javascript">
    window.loaderImage = "<?php echo Template::theme_url("images/ajax_loader.gif"); ?>";
    window.base_url = "<?php echo base_url(); ?>";
    window.site_url = "<?php echo site_url(); ?>";
</script>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<?php echo Assets::css(); ?>
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
        <div class="page-logo col-xs-2 col-md-2">
            <!--<a href="<?php /*echo base_url();*/?>" class="logo_text">Dove Network</a>-->
            <img src="<?php echo base_url();?>images/logo_white_pattern.png" class="logo_text" style="height: 23px;">
        </div>
        <div class="col-xs-6 col-md-7">
            <div class="navbar-headers">
                <a href="javascript:void(0);" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <div class="hor-menu">
                    <?php echo Contexts::render_menu('text', 'normal'); ?>
                </div>
            </div>
        </div>
        <div class="top-menu col-xs-3 col-md-2">
            <ul class="nav navbar-nav pull-right">
            <li class="dropdown dropdown-user"> <a href="<?php echo site_url(SITE_AREA .'/settings/users/edit');?>" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <img alt="" class="img-circle" src="<?php echo base_url('assets/images/avatar.png'); ?>"> <span class="username username-hide-on-mobile">
          <?php
          $userDisplayName = isset($current_user->display_name) && !empty($current_user->display_name) ? $current_user->display_name : ($this->settings_lib->item('auth.use_usernames') ? $current_user->username : $current_user->email);
          echo $userDisplayName;

          ?>
          </span> <i class="fa fa-angle-down"></i> </a>
                <ul class="dropdown-menu dropdown-menu-default" style="width: auto;">
                    <?php if($current_user->role_id == 1){ ?>
                    <li> <a href="#"> <i class="icon-user"></i><?php echo $userDisplayName; ?></a> </li>
                    <li> <a href="#"> <i class="icon-envelope-open"></i>
                            <?php e($current_user->email); ?>
                        </a> </li>
                    <li> <a href="<?php echo site_url(SITE_AREA . '/settings/users/edit'); ?>"><i class="icon-settings"></i><?php echo lang('bf_user_settings'); ?></a> </li>
                    <?php }?>
                    <li> <a href="<?php echo site_url('logout'); ?>"><i class="icon-key"></i><?php echo lang('bf_action_logout'); ?> </a> </li>
                </ul>
            </li>
        </ul>
        </div>
    </div>
</div>
<div class="col-md-12">
    <ul class="nav nav-tabs">
        <div class="pull-left" id="sub-menu">
            <?php if (isset($toolbar_title)) : ?>
                <h3 class="page-title" style="margin-top: 40px"><?php echo $toolbar_title; ?></h3>
            <?php endif; ?>
        </div>
        <div class="pull-right" id="sub-menu" style="margin-top: 55px">
            <?php Template::block('sub_nav', ''); ?>
        </div>
    </ul>
</div>
