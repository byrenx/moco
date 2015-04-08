<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
defined('_BASEPATH') or die("No direct Access Allowed!");
if(file_exists(Conf.ext)){
   require Conf.ext;
}else if(file_exists('..'.DS.Conf.ext)){
   require ('..'.DS.Conf.ext);
}else if(file_exists ('configuration.php')){
   include_once 'configuration.php';
}else if(file_exists ('../configuration.php')){
   include_once '../configuration.php';
}

$CF = new JConfig();

/** define directories**/
if($_SERVER['SERVER_NAME']=='localhost' || $_SERVER['SERVER_NAME']=='127.0.0.1'){
   define('URL','http://localhost/msumaincms/'); 
   define('HOST_SIZE',3); // http:->1, localhost->, msumaincms->3 //
}else if(!isset($CF->default_url) || $CF->default_url == NULL
         || $CF->default_url == ''){
   define('URL',"http://" . $_SERVER["SERVER_NAME"] . "/");
   define('HOST_SIZE',2); // http:->1, 192.168.4.10->2 //
}else{   
   define('URL',$CF->default_url);
   define('HOST_SIZE',2); // http:->1, your default URL->2 //
}

define('LIB','msu_libraries');
define('INCLUDES','msu_includes');
define('THEMES','themes');
define('APPS','apps');
define('ADMINISTRATOR', 'administrator');
define('CACHE','cache');
define('MENU_TYPE','mainmenu');
define('COM','msu_components');
define('COMPONENTS','msu_components');
define('DETAILS','details.php');
define("URLS","/");

if($CF->offline)
{
   define('JWCMSYSTEM',FALSE);
   include_once 'offline.php';   
   unset($CF);
   exit;
}else{
   define('JWCMSYSTEM',TRUE);
}
//define('ext','.php');

defined('JWCMSYSTEM') or die("System not Rendered!");
/**database definition**/
define('ROOT',str_replace('msu_includes','',dirname(__FILE__)));
define('DBHOST', $CF->client_dbhost);
define('DBUSER',$CF->client_dbuser);
define('DBPASS',$CF->client_dbpass);
define('DBDATA',$CF->client_db);
define('DBDRIVER',$CF->dbtype);
?>
