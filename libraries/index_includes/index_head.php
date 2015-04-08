<?php
ob_start();
session_start();

if(isset($_SESSION['scr_id'])){
  unset($_SESSION['scr_id']);
}
if(isset($_SESSION['pcr_id'])){
  unset($_SESSION['pcr_id']);
}else
  {}



define('BASEPATH','http://' . $_SERVER['SERVER_NAME'] . '/apps/moco/');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">  
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width"> 
  
	<title>
            MSU Online Courseware System
        </title> 

    <link href="<?php echo BASEPATH; ?>libraries/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BASEPATH; ?>libraries/themes/jquery-ui.css" type="text/css" rel="stylesheet">
    <link href="<?php echo BASEPATH; ?>libraries/themes/moco-theme-stud.css" type="text/css" rel="stylesheet">


<link type="image/x-icon" href="images/moco_logo.png" rel="icon"></link>
<link type="image/x-icon" href="images/moco_logo.png" rel="shortcut icon"></link>
  </head>

<nav id="h_bar_stud"> 
	  <!--univ name-->
	  <div id="sys-logo">
	    <img src='images/moco_logo.png' width='90px' height='60px'>
	  </div>
          <div id='cur-date-stud'>
            <b>Today</b> <?php echo date('F j, Y');?>
          </div>
   </nav>
