<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

define('_ADMIN',FALSE); 
define('_BASEPATH',1);
define('ext','.php');
define('DS',DIRECTORY_SEPARATOR);
define('Conf', 'Configuration');
$root_temp = dirname(__FILE__);

include $root_temp . DS . 'msu_includes' . DS . 'defines' . ext;
include INCLUDES.DS.'cache'.ext; //cache
include INCLUDES.DS.'system'.ext;
include COMPONENTS.DS.'controller'.ext;

if(isset($_SESSION['pType'])){
    session_destroy($_SESSION['pType']);
    unset($_SESSION['pType']);
}

//$cache = new Cache($CF->cache_time,'cache');
//system_cache_initialise('cache.details.html');
//error_reporting(E_ALL);
//ini_set('display_errors', '1');


/****
 * 
 * ASSUMPTIONS:
 * Tags: /tag/parent_cat_alias/keyword
 * Year: /archive/cat_alias/year
 * Content:
 * NON NEWS (PRIORITY) /cat_alias/alias
 * or /parent_cat_alias/cat_alias/alias {Usually for News}
 * or /parent_cat_alias/cat_alias/
 * or /parent_cat_alias/
 * or /parent_cat_alias/cat_alias/1/
 * 
 */

$selected_parent_cat_info = array();
$selected_cat_info = array();
$selected_content_info = array();
$uri = $_SERVER['REQUEST_URI'];
$arrs = explode('/',$uri);
$catAlias = "";
$details = true;
$page = 0;
$tag = "";
$year = 0;
$pageDetailsTitle = "";
$detailsNavigation = "<a href='" . URL . "index.php' title='Home Page'>Home</a>";

//Counting the ARRS....
//Exception Handler
function myException($exception)
{
    $_SESSION['e'] = $exception;
    ?>
    <script>window.location.href = '<?php echo URL; ?>error.php'; </script>
    <?php
}
set_exception_handler('myException');

if(count($arrs)>0){
    $lastString = explode("?",$arrs[count($arrs)-1]);
    $arrs[count($arrs)-1]  = $lastString[0];
}


switch(count($arrs)){
    case HOST_SIZE + 1:
	$parentAlias = str_replace(array("'","#","\\","\"",";"),"",$arrs[HOST_SIZE]); //Avoid for hacking
	$selected_parent_cat_info = getCategoryInfoByAlias($parentAlias);
	$selected_content_info = getDefaultSelectedSubCon($parentAlias);
	if(empty($selected_content_info)){
	    $selected_cat_info = getDefaultSelectedSubCat($parentAlias);
	    if(empty($selected_parent_cat_info) || empty($selected_cat_info)){
	        throw new Exception('Error 404: Page Not Found. No selected category information.');
	    }
	}   
	$CF->MetaDesc =  $selected_parent_cat_info['metadesc'] . " | " . $selected_parent_cat_info['title'];
	$CF->MetaKeys .= ", " . $selected_parent_cat_info['metakey'];
	$CF->client_details_sitename .= " | " . $selected_parent_cat_info['title'];
	break;
    case HOST_SIZE + 2:
	$parentAlias = str_replace(array("'","#","\\","\"",";"),"",$arrs[HOST_SIZE]);
	$catAlias = str_replace(array("'","#","\\","\"",";"),"",$arrs[HOST_SIZE + 1]);
	$selected_parent_cat_info = getCategoryInfoByAlias($parentAlias);
	$selected_cat_info = getCategoryInfoByAlias($catAlias);
	if(empty($selected_parent_cat_info) || empty($selected_cat_info)){
	    $selected_content_info = getContentInfoByAlias($catAlias);
	    if(empty($selected_content_info) || empty($selected_parent_cat_info)){
		throw new Exception('Error 404: Page Not Found. No selected content information.');
	    }else{
		$CF->MetaDesc =  $selected_content_info['metadesc'] . " | " . $selected_content_info['title'];
		$CF->MetaKeys .= ", " . $selected_content_info['metakey'];
		$CF->client_details_sitename .= (" | " . $selected_parent_cat_info['title'] . " | " . $selected_content_info['title']);
	    }
	}else{	
	    $CF->MetaDesc =  $selected_cat_info['metadesc'] . " | " . $selected_cat_info['title'];
	    $CF->MetaKeys .= ", " . $selected_cat_info['metakey'];
	    $CF->client_details_sitename .= (" | " . $selected_parent_cat_info['title'] . " | " . $selected_cat_info['title']);
	}
	break;
    case HOST_SIZE + 3:
	$parentAlias = str_replace(array("'","#","\\","\"",";"),"",$arrs[HOST_SIZE]);
	$catAlias = str_replace(array("'","#","\\","\"",";"),"",$arrs[HOST_SIZE + 1]);
	$alias = urldecode(str_replace(array("'","#","\\","\"",";"),"",$arrs[HOST_SIZE + 2]));  
	
	if($parentAlias=="tag"){
	    $tag = $alias;
	    $selected_parent_cat_info = getCategoryInfoByAlias($catAlias);
	    $selected_cat_info = getDefaultSelectedSubCat($catAlias);
	}else if($parentAlias=='archive' && is_numeric($alias)){
	    $year = intval($alias);
	    $selected_cat_info = getCategoryInfoByAlias($catAlias);
	    if(empty($selected_cat_info)){
		throw new Exception('Error 404: Page Not Found. No selected category information.');
	    }
	    $selected_parent_cat_info = getCategoryInfoById($selected_cat_info['parent_id']);
	}else{
	    $selected_parent_cat_info = getCategoryInfoByAlias($parentAlias);
	    $selected_cat_info = getCategoryInfoByAlias($catAlias);
	    
	    if(is_numeric($alias)){
		$page = intval($alias);
	    }else{
		$selected_content_info = getContentInfoByAlias($alias);
	    }
	    
	    if(empty($selected_cat_info) || ($page<=0 && empty($selected_content_info))){
		$selected_cat_info = getDefaultSelectedSubCat($parentAlias);
	    }
	    
	    if(empty($selected_cat_info) || ($page<=0 && empty($selected_content_info))){
		throw new Exception('Error 404: Page Not Found. No selected category information. Invalid URL');
	    }
	}
	
	if(empty($selected_parent_cat_info) || empty($selected_cat_info)){
	    throw new Exception('Error 404: Page Not Found. No parent or selected category information.');
	}else if(empty($selected_content_info)){
	    $CF->MetaDesc =  $selected_parent_cat_info['metadesc'] . " | " . $selected_parent_cat_info['title'];
	    $CF->MetaKeys .= ", " . $selected_parent_cat_info['metakey'];
	    $CF->client_details_sitename .= " | " . $selected_parent_cat_info['title'];
	}else{
	    //print_r($selected_content_info);
	    $CF->MetaDesc = $selected_content_info['title'] . " | " . $selected_content_info['metadesc'];
	    $CF->MetaKeys .= ", " . $selected_content_info['metakey'];
	    $CF->client_details_sitename  = "MSU Main - Marawi | " . $selected_cat_info['title'];
	    $CF->client_details_sitename .= (" | " . $selected_parent_cat_info['title'] . " | " . $selected_content_info['title']);
	}
	break;
    case HOST_SIZE + 4:
	$parentAlias = str_replace(array("'","#","\\","\"",";"),"",$arrs[HOST_SIZE]);
	$catAlias = str_replace(array("'","#","\\","\"",";"),"",$arrs[HOST_SIZE + 1]);
	$alias = urldecode(str_replace(array("'","#","\\","\"",";"),"",$arrs[HOST_SIZE + 2]));
	$pg = str_replace(array("'","#","\\","\"",";"),"",$arrs[HOST_SIZE + 3]);
	
	if($parentAlias=="tag"){
	    $tag = $alias;
	    $selected_parent_cat_info = getCategoryInfoByAlias($catAlias);
	    $selected_cat_info = getDefaultSelectedSubCat($catAlias);
	}else if($parentAlias=='archive' && is_numeric($alias)){
	    $year = intval($alias);
	    $selected_cat_info = getCategoryInfoByAlias($catAlias);
	    if(empty($selected_cat_info)){
		throw new Exception('Error 404: Page Not Found. No selected category information. Invalid URL for archive section.');
	    }
	    $selected_parent_cat_info = getCategoryInfoById($selected_cat_info['parent_id']);
	}
	
	if(is_numeric($pg)){
	    $page = intval($pg);
	}
	
	if(empty($selected_parent_cat_info) || empty($selected_cat_info)){
	    throw new Exception('Error 404: Page Not Found. No parent or selected category information. Invalid for URL for paging, tag or achive section.');
	}else{
	    $CF->MetaDesc =  $selected_parent_cat_info['metadesc'] . " | " . $selected_parent_cat_info['title'];
	    $CF->MetaKeys .= ", " . $selected_parent_cat_info['metakey'];
	    $CF->client_details_sitename .= " | " . $selected_parent_cat_info['title'];
	}
	break;
    default:
	throw new Exception('Error 404: Page Not Found. Invalid URL for a section. \'' . $uri . '\'');
	break;
}

// Check if a user is trying to view college page through details.php
if(strpos($selected_parent_cat_info['path'],'school/')==0 && !(strpos($selected_parent_cat_info['path'],'school/')===FALSE)
   || strpos($selected_parent_cat_info['path'],'library/')==0 && !(strpos($selected_parent_cat_info['path'],'library/')===FALSE)){
    throw new Exception('Error 404: Page Not Found');
}

$pageDetailsTitle = $selected_parent_cat_info['title'];
if(!empty($selected_cat_info)){
    $detailsNavigation .= ("<a href='" . URL . "details.php/" . $selected_parent_cat_info['alias'] . "' title='" . $selected_parent_cat_info['title'] . "'>" .
			  $selected_parent_cat_info['title'] . "</a><a href='" . URL . "details.php/" . $selected_parent_cat_info['alias'] . "/" . $selected_cat_info['alias'] . "' title='" .
			  $selected_cat_info['title'] . "'>" . $selected_cat_info['title'] . "</a>");
    $detailsNavigation .= ("<span class='detailsNavExtra'><a href='javascript:history.go(-1)' id='backButton' title='Go Back to the Last Visited Page'>&nbsp;&nbsp;&nbsp;</a><a id='bottomButton' title='Go to the Bottom of the Page'>&nbsp;</a><a id='printButton' href='javascript:window.print()' title='Print this Article'>&nbsp;&nbsp;&nbsp;</a></span>");
}else if(!empty($selected_content_info)){
    $detailsNavigation .= ("<a href='" . URL . "details.php/" . $selected_parent_cat_info['alias'] . "' title='" . $selected_parent_cat_info['title'] . "'>" .
			  $selected_parent_cat_info['title'] . "</a><a href='" . URL . "details.php/" . $selected_parent_cat_info['alias'] . "/" . $selected_content_info['alias'] . "' title='" .
			  $selected_content_info['title'] . "'>" . $selected_content_info['title'] . "</a>");
    $detailsNavigation .= ("<span class='detailsNavExtra'><a href='javascript:history.go(-1)' id='backButton' title='Go Back to the Last Visited Page'>&nbsp;&nbsp;&nbsp;</a><a id='bottomButton' title='Go to the Bottom of the Page'>&nbsp;</a><a id='printButton' href='javascript:window.print()' title='Print this Article'>&nbsp;&nbsp;&nbsp;</a></span>");
}else{
    $detailsNavigation .= ("<a href='" . URL . "details.php/" . $selected_parent_cat_info['alias'] . "' title='" . $selected_parent_cat_info['title'] . "'>" .
			  $selected_parent_cat_info['title'] . "</a>");
    $detailsNavigation .= ("<span class='detailsNavExtra'><a href='javascript:history.go(-1)' id='backButton' title='Go Back to the Last Visited Page'>&nbsp;&nbsp;&nbsp;</a><a id='bottomButton' title='Go to the Bottom of the Page'>&nbsp;</a><a id='printButton' href='javascript:window.print()' title='Print this Article'>&nbsp;&nbsp;&nbsp;</a></span>");
}

$meta = array('description'=>$CF->MetaDesc,'keywords'=>$CF->MetaKeys,'author'=>$CF->client_meta_author ,'charset'=>$CF->client_charset,
	'owner'=>$CF->client_meta_owner,'copyright'=>$CF->MetaRights);
html_head_init($CF->client_details_sitename, $meta);
load_css(URL . THEMES."/".'reset.css');
//echo "<script type='text/javascript'>var preLink = '" . URL . "';</script>";
readfolder(THEMES."/".$CF->client_theme);
setIco(URL . $CF->client_ico);
end_head();

if(isset($pageDetailsTitle)){
    if(($selected_parent_cat_info['alias']=='news'
       ||$selected_parent_cat_info['alias']=='bulletin') && !empty($selected_cat_info)){
	include_once INCLUDES . DS . 'news' . ext;
    }else{
	include_once INCLUDES . DS . 'generic' . ext;
    }
}
?>