<?php
defined('_BASEPATH') or die("No direct Access Allowed!");
if(get_magic_quotes_gpc ()){
    $_GET = array_map('stripslashes',$_GET);
    //$_POST = array_map('stripslashes', $_POST);
    $_COOKIE = array_map('stripslashes', $_COOKIE);
}else{
    $_GET = array_map('addslashes',$_GET);
    //  $_POST = array_map('addslashestostring', $_POST);
    $_COOKIE = array_map('addslashes', $_COOKIE);
}

if(isset($_GET) && !empty($_GET)){
    $_GET = array_map('parse_url', $_GET);
}


/***********  Instantiate Controller  
if(file_exists('../controllers/Controller.php')){
    include_once '../controllers/Controller.php';
}else if(file_exists('controllers/Controller.php')){
    include_once 'controllers/Controller.php';
}
$controller = new Controller(); //don't use any variable like this.


/***********  Instantiate Database  
if(file_exists('../includes/jwcms/Database.php')){
    include_once '../includes/jwcms/Database.php';
}if(file_exists('includes/jwcms/Database.php')){
    include_once 'includes/jwcms/Database.php';
}
$db = new Database();   //don't use any variable like this.
$db->connect(); //timebounded; else magreconnect will close in n seconds.
$db->selectDb(DBDATA);
$db->use_active_record(); //use active record;


/******** Include Utilities ********/
if(file_exists('..'.DS.LIB.DS.'utilities'.ext)){
    require_once ('..'.DS.LIB.DS.'utilities'.ext);
}else if(file_exists(LIB.DS.'utilities'.ext)){
    require LIB.DS.'utilities'.ext;
}


/******** Initialize Session Class.*****/
if(file_exists(ROOT. DS . INCLUDES . DS . 'session'.ext)){
    include_once ROOT . DS . INCLUDES . DS . 'session'.ext;
}else if(file_exists(DS . INCLUDES . DS . 'session'.ext)){
    include_once DS . INCLUDES . DS . 'session'.ext;
}
$session = new Session(); //restrict the use of this variable

/*
if(file_exists('../components/do/Dma.php')){
    include_once '../components/do/Dma.php';
}
*/
/************* DEFINE FUNCTIONS ***************/


function _set($dir)
{   
    define('dir',$dir);
}

function __autoload($class)
{
    if(file_exists(ROOT.DS.$class.ext)){
	include ROOT.DS.$class.ext;
    }
    return true;
}

function system_cache_initialise($caching_file)
{
    global $CF;
    global $cache;
    if(intval($CF->caching)==1){
	$cache->setCacheFile($caching_file);
	$cache->read_cache();
	$cache->cache_start();
    }  
    unset($CF);
    unset($cache);
}

function system_cache_flush()
{
    global $cache;
    global $CF;
    if(intval($CF->caching)==1){
        $cache->cache_contents();
	$cache->flush();
    }
    unset($CF);
    unset($cache);
}

function html_head_init($title,$meta)
{
    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">';
    $html.= "<head>";
    $html.= "<title>".$title."</title>";
    $charset = $meta['charset'];
    $html.= "<meta http-equiv='Content-Type' content='text/html' charset=".$charset.">";
    if(!empty($meta)){
	foreach($meta as $key=>$m){
	    $html.=" <meta name='$key' content='$m'/>";
	}
    }
    echo $html." ";
}


function end_head()
{
    echo "</head><body>";
}

function html_end()
{
    echo "</body></html>";
}

function load_css($css)
{
    echo " <link rel='stylesheet' type='text/css' href='$css'/>";
}

function load_jscript($jsfile)
{
    echo " <script type='text/javascript' language='Javascript' src='$jsfile'>";
    echo "</script>";
}

function insert_jscript($fullpathjs)
{
    echo "<script>";
    echo file_get_contents($fullpathjs);
    echo "</script>";
}

function insert_inlineCss($fullpathCss)
{
    echo "<style>";
    echo file_get_contents($fullpathCss);
    echo "</style>";
}

function setIco($path)
{
    echo "<link rel='shortcut icon' type='image/x-icon' href='$path'/>";
}

function readfolder($pathtofile)
{
    if ($handle = opendir($pathtofile)) {
	$scannedFiles = array();
	while ($scannedFiles[] = readdir($handle));
	sort($scannedFiles);
	closedir($handle);
	
	$files = array('');
	foreach ($scannedFiles as $file){
	    $files = explode('.',$file);
	    if(!empty($files))
	    {
		$newPathToFile = str_replace(ROOT,'',$pathtofile);
		switch($files[count($files)-1])
		{
		    case 'css':
			load_css(URL . $newPathToFile."/".$files[0].'.'.$files[1]);
			break;
		    case 'js':
			load_jscript(URL . $newPathToFile."/".$files[0].'.'.$files[1]);
			break;
		}
	    }
	}
    }
}

function system_debug($var)
{
    echo "<pre>";
    if(is_array($cache)){
	print_r($cache);
    }else{
        var_dump($var);
    }
    echo "</pre>";
}















































































































































































/****************************************
$adminsecret = md5(sha1('12354'.'jwcms'));
*****************************************/
?>
