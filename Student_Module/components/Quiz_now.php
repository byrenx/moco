<script type="text/javascript" scr="../javascript/quiz.js"> </script>

<div id="page-container">
   <!-- course title --->
   
   <!-- content --->
   <div id="about_cont_con2">
     <!--- header --->
    
     <div id="about_hdrStartQ">
       <span id="about_hdr_title"><h2>
   <?php 
   if(isset($_POST['title'])){
     echo $_POST['title'];
   }
      ?>
      </h2></span>
     </div>

   <!--- Take Quiz Content --> 

   <?php  


	/* echo "<p class='alert alert-warning'> <span class='glyphicon glyphicon-warning'>
         </span> 
         <b>Warning!</b> Do not try to attempt to return to the previous page
         or change the url of this page. Otherwise this quiz will be considered
         as invalid and the system will  set your score as zero.


</p>"; */

   if(isset($_POST['test_id'])&&isset($_POST['ttype'])){
     
     //echo $_POST['ttype'];
     $QuizStart->setQuestionsBox($_POST['test_id'],$_SESSION['scr_id'],
				 $_POST['Operation']);

   }else{
     header("Location: ../../Student_Module/pages/Quiz.php");
   }


   ?>