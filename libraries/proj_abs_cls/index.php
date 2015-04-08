<?php
/*if($_SERVER['REMOTE_ADDR'] == "121.54.69.247" && $_SERVER['HTTP_X_FORWARDED_FOR'] == "192.168.4.10")
{*/
session_start();
define('_ADMIN',FALSE); 
define('_BASEPATH',1);
define('ext','.php');
define('DS',DIRECTORY_SEPARATOR);
define('Conf', 'configuration');

include 'msu_includes' . DS . 'defines' . ext;
include INCLUDES.DS.'cache'.ext; //cache
include INCLUDES.DS.'system'.ext;

$cache = new Cache($CF->cachetime,'cache');
define('admin',FALSE);

system_cache_initialise('index.html');

include 'home'.ext;

system_cache_flush();
/*}
else
{
  echo "<div style='border:1px solid #fbd5f2; padding:5px; background-color:#fff6ca'><h1>Website is down for maintenance.</h1><p>Sorry for the inconvenience.</p></div>";
}*/
?>