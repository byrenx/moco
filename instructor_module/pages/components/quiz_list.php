<script type="text/javascript" src="../javascript/quiz.js"> </script>
<script type='text/javascript'>
   function dpicker(){
      $("#da").datepicker();
      $("#dd").datepicker(); 
   }
</script>  
  <!--- side bar --->
  <!--- content --->
  <div id="about_cont_con">
     <!--- header --->
     <div id="about_hdr">
	<span class='h3'>
	   Quizzes
	</span>
        <form action="add_quiz.php">  
          <input type="hidden" name="icr_id" value="<?php $_SESSION['icr_id']?>">
          <span style='position: absolute;
                     left: 180px;
                     top: 5px;'>
          <button name='add_q' class='btn btn-primary'>
              <span class='glyphicon glyphicon-plus-sign'></span>
              Add Quiz
          </button>
          </span>
        </form>
     </div>

    <!------- quiz content --->


    <div id="sub-content">
      <?php 
        $quiz_intrfc->showQuizList($_SESSION['icr_id']);
      ?> 
    </div>
 </div>
	 
	 
  
  
