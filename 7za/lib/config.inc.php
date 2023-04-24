<?php
/**
 * Configuration file for SmartMVC framework.
 *
 * Contains all options for proper work of the framework, including
 * DB settings, debug options, folder settings, etc.
 */

/****************************************************************************
 *                    Directory and file Settings                           *
 ****************************************************************************/

// some general path preparations
define ( 'DIR_SEP', DIRECTORY_SEPARATOR  );	 // shortcut
$curPath  = realpath( dirname( __FILE__ ) );
$initPath = DIR_SEP . 'lib';

// common lib: contains modules
define ( 'LIB', $curPath . DIR_SEP );

// URL Preparation
// do not edit URL_ROOT constant to do something like:
// "http://" . $_SERVER["HTTP_HOST"] . "/webroot/"
// doing this will lead to problems when you publish the appliaction.
// Better to use virtual hosts for this issue.
define ( 'URL_ROOT'     , "/" );
define ( 'URL_IMAGE'    , URL_ROOT . 'resources/images/' );
define ( 'URL_STYLE'    , URL_ROOT . 'resources/styles/' );
define ( 'URL_SCRIPT'   , URL_ROOT . 'resources/scripts/' );

// Edit next line if you have another config file for your project
define ( 'PATH_TO_RESOURCE_BUNDLE', LIB . 'myProject.conf');

/****************************************************************************
 *                      Database settings                                   *
 ****************************************************************************/

define ( 'DB_SERVER'		, '127.0.0.1' );
define ( 'DB_USER'			, 'root' );
define ( 'DB_PASSWORD'		, '' );
define ( 'DB_NAME'		    , '7za' );

// this constant is used in model classes, it preceded to
// each table name, in order to to allow multiple smartmvc
// based projects within the same DB
define ( 'TABLE_PREFIX'     , 'za_' );

/****************************************************************************
 *                      System settings                                     *
 ****************************************************************************/

// debug settings
// Next option is for method of debug output
// Available values are: 'noAction', 'screen' and 'email'
// define ( 'DEBUG_MODE'       , 'noAction' );
define ( 'DEBUG_MODE'       , 'screen' );
//define ( 'MAIL_4_DEBUG'     , 'support@fairpoint.com.ua' );
define ( 'MAIL_4_DEBUG'     , 'debug@tecm.in' );
define ( 'ERROR_PAGE'       , '/error.html' );

// base path ( root for SmartMVC framework )
define ( 'ROOT'             , str_replace( 'lib' . DIR_SEP , '', LIB ) );


// path to document root
// change this constant if your environment requires smth else for instance 'htdocs'
define ( 'WEBROOT'          ,  substr(ROOT, 0, strlen(ROOT)-1) );

// path to base template dir
define ( 'TEMPLATE_DIR'     , ROOT . 'templates' );

// path to dir with business-logic classes
define ( 'MODEL_DIR'        , ROOT . 'model' . DIR_SEP );

// path to dir with area-based controllers
define ( 'CONTROLLER_DIR'   , ROOT . 'controller' . DIR_SEP );

// path to base image dir
define ( 'IMAGE_PATH'       , WEBROOT.DIR_SEP.'resources'.DIR_SEP.'images'.DIR_SEP  );

// path to language files
define( 'LANG_DIR'          , TEMPLATE_DIR . DIR_SEP . 'lang' . DIR_SEP );

// the key for URL hashing feature
define( 'URL_HASH_KEY'      , 'megahit' );

//define( 'FROM_EMAIL'        , "postmaster@" . $_SERVER['HTTP_HOST'] );
define( 'FROM_EMAIL'        , "shop@7za.com.ua" );
//define( 'ADMIN_EMAIL'       , "ira@fomichov.kiev.ua,andrew@fomichov.kiev.ua,tetyana@7za.com.ua,fedorenkotbt@gmail.com" );
define( 'ADMIN_EMAIL'       , "orders@7za.com.ua" );
//define( 'ADMIN_EMAIL'       , "corvax@7za.com.ua" );
//define( 'REPORTS_EMAIL'     , "support@fairpoint.com.ua" );
define( 'REPORTS_EMAIL'     , "corvax@7za.com.ua" );

// the path of root of MediaManager for storing files
define( 'MM_ROOT'   , IMAGE_PATH . "mm_files" . DIR_SEP );

// the URL for stored files of MediaManager
define( 'MM_URL_ROOT', URL_IMAGE . "mm_files/" );

// the switch for using ImageMagick for image resizing
define( 'USE_IMAGICK', false );

// the path to ImageMagick binaries
define( 'IMAGICK_PATH', "C:\\Imagemagick\\" );

// whether to strip whitespaces in outputted html code
define( 'STRIP_WHITESPACES' , true );

// cost of delivery
define( 'COST_DELIVERY' , '0' );

// threshold of cost
define( 'COST_THRESHOLD' , '900' );

// product quantity for all pages
define( 'PRODUCTS_PER_PAGE' , 15 );

// secret key for integration with 1C
define( 'KEY_1C' , "test" );

// global error level
// Note, that during the development it must be equal to E_ALL, but on a production
// server you have to decrease this value
error_reporting( E_ALL );

// clean up
unset($curPath);
unset($initPath);

// set locale
setlocale(LC_TIME, 'ru_RU.CP1251');
//setlocale(LC_ALL, "ru_RU.KOI8-R");

/****************************************************************************
 *                      Default includes                                    *
 ****************************************************************************/

// including main classes
require_once( LIB . "debug" . DIR_SEP . "debugHandler.class.php" );
require_once( LIB . "db" . DIR_SEP . "mysql" . DIR_SEP . "dbHandler.class.php" );
require_once( LIB . "main.class.php" );
require_once( LIB . "wrapper.class.php" );
require_once( CONTROLLER_DIR . "MasterController.class.php" );

require_once('Mail.php');
require_once('Mail/mail.php');
require_once('Mail/mime.php');
//$params['host'] = 'mx.org.ua';
$params['host'] = 'mail.tecmgroup.com';
//$params['auth'] = true;
//$params['username'] = 'notify@7za.com.ua';
//$params['password'] = 'lkjhlglg';
$params['auth'] = false;

$smtp_mail =& Mail_mail::factory('smtp', $params);
// the handler to "core" of a framework
$core = new main();

?>
