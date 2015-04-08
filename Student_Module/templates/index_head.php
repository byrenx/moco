
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">  
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width"> 
  
	<title> </title> 
   <style type='text/css'>
   @import  "../../libraries/bootstrap/css/bootstrap.min.css";
   @import  "../../libraries/themes/jquery-ui.css";
   @import  "../../libraries/themes/moco-theme-stud.css";
   @import "css/prettyPhoto.css";
    </style>

        <script type="text/javascript" src="../../libraries/js/input_validator.js"></script>
        <script type="text/javascript" src="../../libraries/jQuery/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="../../libraries/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../libraries/ajax/ajax_modal_script.js"></script>



        <script type="text/javascript" src="../../libraries/index_includes/javascript/moco.js"></script>

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
<script type="text/javascript">


function ReadMore(){
  $('#RMore').show();
  $('#ReadM').hide();

}

</script>
  </head>

<nav id="h_bar_stud"> 
	  <!--univ name-->
	  <div id="sys-logo">
	    <img src='../../images/moco_logo.png' width='90px' height='60px'>
33	  </div>
          <div id='cur-date-stud'>
            <b>Today</b> <?php echo date('F j, Y');?>
          </div>
<div id="accessOCW">
       <ul class="nav nav-pills navbar-right" >
           <li><a href="../../index.php" class="glyphicon glyphicon-home">Home</a></li>
           <li><a href="../../Courses.php" class="glyphicon glyphicon-briefcase">Courses</a></li>
           <li><a href="../../login.php" class="glyphicon glyphicon-user">Login</a>
       </ul>
     </div>
    
   </nav>
<center>

