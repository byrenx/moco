<?php define('BASEPATH','http://' . $_SERVER['SERVER_NAME'] . '/apps/moco/');?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">  
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width"> 
  
	<title>
          MOCO-MSU Online Courseware
        </title> 
        
	<link rel="stylesheet" type="text/css" href="<?php echo BASEPATH;?>libraries/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEPATH;?>libraries/themes/moco-theme.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEPATH;?>libraries/widgEditor/css/widgEditor.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEPATH;?>libraries/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEPATH;?>libraries/themes/jquery-ui.css">
	<script type="text/x-mathjax-config">
	   MathJax.Hub.Config({
                 extensions: ["tex2jax.js","mml2jax.js","asciimath2jax.js","MathMenu.js","MathZoom.js"],
                 TeX: {extensions: ["AMSmath.js","AMSsymbols.js","noErrors.js","noUndefined.js"]},
	     tex2jax: {inlineMath: [["$","$"],["\\(","\\)"]],
		       processEscapes: true,
		       displayMath: [ ['$$','$$'], ["\\[","\\]"] ]}
	  });
        </script>
	<script type="text/javascript" src="../../libraries/mathjax2.3/MathJax.js?config=TeX-AMS_HTML-full"></script>

        <script type="text/javascript" src="../javascript/jquery.min.js"></script>
        <script type="text/javascript" src="../../libraries/jQuery/jquery-ui.js"></script>
        <script type="text/javascript" src="../../libraries/bootstrap/js/bootstrap.min.js"></script>        
        <script type="text/javascript" src="../../libraries/ajax/ajax_modal_script.js"></script>
        <script type="text/javascript" src="../../libraries/js/input_validator.js"></script>
	<script type="text/javascript" src="../../libraries/js/date.js"></script>
	<script type="text/javascript" src="../javascript/moco.js"></script>
        <script type="text/javascript" src="../javascript/question_preview.js"></script>
        <script type="text/javascript" src="../../libraries/widgEditor/scripts/widgEditor.js"></script>

  <link type="image/x-icon" href="../../images/moco_logo.png" rel="icon"></link>
<link type="image/x-icon" href="../../images/moco_logo.png" rel="shortcut icon"></link>




  </head>


<body>
  <nav class="navbar navbar-inverse" role="navigation" style="border-radius:0; background-color: maroon;min-height: 70px; padding-top: 10px;color: white;">
    <div class="container">      
      <div class="navbar-header">
	 <img src='../../images/moco_logo.png' width='90px' height='60px'>
      </div>
    
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
	    <li>
              <a>Today</b> <?php echo date('F j, Y');?></a>
            </li>
        </ul>
       
        <ul class="nav navbar-nav navbar-right">
	  <a class="navbar-brand">  </a>
          <li class="dropdown">
	    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	      <?php echo $_SESSION['instructor_name'];?><span class="caret"></span>
	    </a>
	    <ul class="dropdown-menu">
	      <li><a href="../../instructor_module/pages/course_dashboard.php">Course Dashboard</a></li>
	      <li><a href="../../login.php">Logout</a></li>
	    </ul>
	  </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>	
  <!----
  <div id="h_bar">
      <div id="sys-logo">
	 <img src='../../images/moco_logo.png' width='90px' height='60px'>
      </div>
      <div id='cur-date'>
         
      </div>
          <?php 
	    if(isset($_SESSION)){
	      echo  "<div id='user-menu'>";
	       echo "<ul class='user'>";
                 echo "<li><a href='../../instructor_module/pages/course_dashboard.php'>Dashboard</a></li>";
                 echo "<li><a href='../../login.php'>Logout</a></li>";
                 echo "<li><a href='#'>{$_SESSION['instructor_name']}</a></li>";
               echo "</ul>";
            }
          ?>             
       </div>
     </div>---->
  <center>
		 
		
		
