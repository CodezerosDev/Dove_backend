<?php


/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your current environment.
 * Setting the environment also influences things like logging and error
 * reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
//define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting. By
 * default, development will show errors but testing and production will hide
 * them.
 */
switch (ENVIRONMENT) {
    case 'development':
        error_reporting(E_ALL);
        if ( ! ini_get('display_errors')) {
            ini_set('display_errors', 1);
        }
        break;

    case 'testing':
        // no break;
    case 'production':
        error_reporting(0);
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * DEFAULT INI SETTINGS
 *---------------------------------------------------------------
 *
 * Necessary setting for PHP 5.3+ compatibility.
 *
 * Note: This now defaults to UTC instead of GMT if the date.timezone value is
 * not set (PHP 5.4+), but on PHP 5.3 it may use the TZ environment variable or
 * attempt to guess the timezone from the host operating system. It is
 * recommended to set date.timezone to avoid this, or you can replace
 * @date_default_timezone_get() below with 'UTC' or 'GMT', as desired.
 *
 * Inspired by PyroCMS and Composer code.
 * @link https://www.pyrocms.com/ PyroCMS
 * @link http://getcomposer.org/ Composer
 */
if (ini_get('date.timezone') == ''
    && function_exists('date_default_timezone_set')
) {
    if (function_exists('date_default_timezone_get')) {
        date_default_timezone_set(@date_default_timezone_get());
    } else {
        date_default_timezone_set('GMT');
    }
}

/*
 *---------------------------------------------------------------
 * BONFIRE PATH
 *---------------------------------------------------------------
 *
 * Simply change the first "path" variable, and the individual paths
 * will be set accordingly.
 */
$path = "..";


$bonfire_path = "${path}/bonfire";

/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same  directory
 * as this file.
 *
 */
$system_path = "${path}/bonfire/codeigniter";

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 *
 */
$application_folder = "${path}/application";

/*
 *---------------------------------------------------------------
 * VIEW FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want to move the view folder out of the application
 * folder set the path to the folder here. The folder can be renamed
 * and relocated anywhere on your server. If blank, it will default
 * to the standard location inside your application folder.  If you
 * do move this, use the full server path to this folder
 *
 * NO TRAILING SLASH!
 *
 */
$view_folder = '';

/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here.  For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT:  If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller.  Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 *
 */
// The directory name, relative to the "controllers" folder.  Leave blank
// if your controller is not in a sub-folder within the "controllers" folder
// $routing['directory'] = '';

// The controller class file name.  Example:  Mycontroller.php
// $routing['controller'] = '';

// The controller function you wish to be called.
// $routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 *
 */
// $assign_to_config['name_of_config_item'] = 'value of config item';

//--------------------------------------------------------------------
// CSRF ByPASS
//--------------------------------------------------------------------
//
// By default, Bonfire ships with CSRF protection set to ON for all
// forms in the system. We also highly encourage it's use for security
// reasons in your own applications. On rare occasions, you may need
// to bypass the CSRF protection for a controller, such as within
// an API where the request is coming from an external controller and
// no CSRF token would be available.
//
// The controllers currently must either be in the root controllers
// folder(NOT in a subfolder), or in a module.
//
// Example:
//      array( 'users', 'activities/activity')
//
$assign_to_config['csrf_ignored_controllers'] = array();


// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------




/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}

if (realpath($system_path) !== false) {
    $system_path = realpath($system_path) . '/';
}

// Ensure there's a trailing slash
$system_path = rtrim($system_path, '/') . '/';

// Is the system path correct?
if (! is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3); // EXIT_CONFIG
}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// The PHP file extension
// this global constant is deprecated.
define('EXT', '.php');

// Path to the system folder
define('BASEPATH', str_replace("\\", "/", $system_path));

// Path to the front controller (this file)
define('FCPATH', str_replace(SELF, '', __FILE__));

// Name of the "system folder"
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

// Bonfire Path
define('BFPATH', $bonfire_path . '/');


// custome messages
define('COUNTRYLISTSUCCESS','List country successfully');
define('ALLOWONLYNUMBER','Allow only numeric value');
define('PHONENUMBERREQUIRED','Phone number is required');
define('OTPREQUIRED','Verification code is required');
define('PINNOTSETUP','Pin not setuped');
define('USERALREADYREGISTER','User Already Register');
define('APPDEVICEREQUIRED','App device is required');
define('USERIDREQUIRED','User id is required');
define('INVLIDRESETCODE','code does not match,kindly enter valid code');
define('PINFILDREQUIRED','Pin is required');
define('PINSETSUCCESSFULLY','Pin Set Successfully');
define('PINSETUNSUCCESSFULLY','Pin Set Unsuccessfully');
define('USERREGISTERSUCCESS','User register successfully.');
define('RESENDSUCCESS','Resend Code Successfully');
define('RESENDUNSUCCESS','Resend Code Unsuccessfully');
define('PHONENOTREGISTER','Phone number is not registered with us.');

define('WALLETCREATEDSUCCESSFULLY','Wallet created successfully.');
define('FETCHBALANCESUCCESSFULLY','Fetch wallet balance successfully.');

define('FAILFETCHBALANCE','There is some issue with fetch token balance.');
define('FAILWALLETCREATED','There is some issue with wallet creation.');
define('WALLETCREATEDUNSUCCESSFULLY','There is some issue with wallet creation.');
define('TRANSFERSUCCESSFULLY','Token trnsfer successfully.');
define('FAILTRANSFER','There is some issue with token transfer.');





// The path to the "application" folder
if (is_dir($application_folder)) {
    define('APPPATH', $application_folder . '/');
} else {
    if (! is_dir(BASEPATH . $application_folder . '/')) {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
        exit(3); // EXIT_CONFIG
    }

    define('APPPATH', BASEPATH . $application_folder . '/');
}

// The path to the "views" folder
if (is_dir($view_folder)) {
    define('VIEWPATH', $view_folder . '/');
} else {
    if (! is_dir(APPPATH . 'views/')) {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
        exit(3); // EXIT_CONFIG
    }

    define('VIEWPATH', APPPATH . 'views/');
}


/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once(BASEPATH . 'core/CodeIgniter.php');

/* End of file public/index.php */
