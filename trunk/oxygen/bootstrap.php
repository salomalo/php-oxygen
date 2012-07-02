<?php

/**
 * This file is part of the PHP Oxygen package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright   Copyright (c) 2011 Sébastien HEYD <sheyd@php-oxygen.com>
 * @author      Sébastien HEYD <sheyd@php-oxygen.com>
 * @package     PHP Oxygen
 */


// First, check the php version for the correct one
if (version_compare(PHP_VERSION, '5.2.0', '<') === true)
{
    echo '<h1>You have an invalid PHP version.</h1>';
    echo '<p>PHP Oxygen supports PHP 5.2.0 or newer. Please upgrade your PHP version</p>';
    echo '<hr />';
    echo 'Current PHP Version : '.PHP_VERSION;
    exit;
}

// Set the default umask to define rights on paths
umask(0002);

// Constants definitions
define('DS', DIRECTORY_SEPARATOR);
define('PROJECT_DIR', realpath(dirname(__FILE__).DS.'..'));
define('FW_DIR', dirname(__FILE__));
define('MODULES_DIR', PROJECT_DIR.DS.'module');
define('WEBAPP_DIR', PROJECT_DIR.DS.'webapp');
define('HOOKS_DIR', WEBAPP_DIR.DS.'hooks');
define('WWW_DIR', PROJECT_DIR.DS.'www');
define('CACHE_DIR', WEBAPP_DIR.DS.'cache');
define('WEBAPP_MODULES_DIR', WEBAPP_DIR.DS.'module');
define('CONFIG_DIR', WEBAPP_DIR.DS.'config');
define('LOGS_DIR', WEBAPP_DIR.DS.'logs');
define('CLI_MODE', PHP_SAPI === 'cli');
define('DATETIME_SQL', 'Y-m-d H:i:s');
define('DATE_SQL', 'Y-m-d');
define('TIME_SQL', 'H:i:s');
if(isset($_SERVER['HTTP_HOST'])) define('HTTP_HOST', $_SERVER['HTTP_HOST']);

// Load additional procedural functions
require_once(FW_DIR.DS.'functions.php');

// Loading the __autoload PHP5 magic method
require_once(FW_DIR.DS.'autoload.php');

// Sets error handlers
error_reporting(-1);
set_error_handler(array(new Error(),'errorHandler'));
set_exception_handler(array(new Error(),'exceptionHandler'));
register_shutdown_function(array(new Error(), 'shutdownHandler'));

// Get default timezone
if(ini_get('date.timezone') === '') date_default_timezone_set('Europe/Paris');

// Are the url ended by a prefix (ex: .html)
define('HTTP_PREFIX', Config::get('route', 'prefix', ''));

try
{
    // Init the session
    Session::getInstance();
    // Set the default localization
    I18n::setLocale('en_US');    
}
catch (Exception $e)
{
    die('Cannot start session : '.$e->getMessage());
}
