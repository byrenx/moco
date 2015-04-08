<script type="text/javascript" src="../javascript/quiz.js"> </script>
  
  <!--- side bar --->
  <!--- content --->
  <div id="about_cont_con">
     <!--- header --->
     <div id="about_hdr">
	<span class='h3'>
	   Exams
	</span>
        <form action="add_exam.php">  
          <input type="hidden" name="icr_id" value="<?php $_SESSION['icr_id']?>">
          <span style='position: absolute;
                     left: 180px;
                     top: 5px;'>
          <button class='btn btn-primary' name='add_q' value='Add Exam'>
             <span class='glyphicon glyphicon-plus-sign'></span>
             Add Exam
          </button>
          </span>
        </form>
     </div>

    <!------- quiz content --->


    <div id="sub-content">
      <?php 
        $quiz_intrfc->showExamList($_SESSION['icr_id']);
      ?> 
    </div>
 </div>
	 
	 
  
  
