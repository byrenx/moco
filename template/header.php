
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">  
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width"> 
  
	<title> </title> 
        
        <link href="../../libraries/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">  
        <link href="../../libraries/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css">
        <link href="../../libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../../libraries/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
        <link href="../../libraries/themes/jquery-ui.css" rel="stylesheet" type="text/css">
	<link href="../../libraries/themes/moco-theme.css" rel="stylesheet" type="text/css">
        
        <script type="text/javascript" src="../../libraries/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="../../libraries/jQuery/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="../../libraries/jQuery/jquery-ui.js"></script>        
        <script type="text/javascript" src="../../libraries/ajax/ajax_modal_script.js"></script>
        <script type="text/javascript" src="../../libraries/js/input_validator.js"></script>
        
        <script type="text/javascript" src="../javascript/moco.js"></script>
        <script type="text/javascript">
           $(function(){
	      $('#dd').datepicker();
              
	      });
          
           $(function(){
	      $('#da').datepicker();
              
	   });

           function hide(){
             $("#c1").hide();
           }

        </script>
  </head>


<body style="font-family: verdana">
	<div id="h_bar">
	  <!--univ name-->
	  <div id="sys-logo">
	    <img src='../../images/moco_logo.png' width='100px' height='100px'>
	  </div>
          <div id='cur-date'>
            <b>Today</b> <?php echo date('F j, Y');?>
          </div>
          <div id='user-menu'>
             <?php
	     if(isset($_SESSION)){
               echo "<img src='../../images/kevin.png' width='80px' height='80px' style='float:right;'/>";
	       echo "<ul class='user'>";
               echo "<li>";
               echo "<a href='#'>";
               echo "<span id='user-name'>";
                 echo $_SESSION['instructor_name'];
               echo "</span>";   
               echo " <img src='../../images/caret_down.png'/>";
               echo "</a>";
               echo "<ul>";
               echo "<li><a href='../../instructor_module/pages/course_dashboard.php'>";
               echo "Course Dashboard";
               echo "</a>";
               echo "</li>";
               echo "<li><a href='#'>Logout</a></li>";
               echo "</ul>";
               echo "</li>";
               echo "</ul>";
              }

             ?>             
          </div>
	</div>
	<center>
		 
		
		
