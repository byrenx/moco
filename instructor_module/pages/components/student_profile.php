<?php
require_once "../class_models/student_profile_model.php";

$student_profile = new IMStudentProfile();
$student = null;
$quiz_results = null;

try{
    $ic_id = $_SESSION['icr_id'];
    $student_id = $_POST['id'];
    $ic_id = $_POST['ic_id'];
    $student = $student_profile->getStudentInfo($student_id, $ic_id);
    $quiz_results = $student_profile->getQuizResults($ic_id, $student_id);
    $ass_results = $student_profile->getAssignmentResults($ic_id, $student_id);
    $exam_results = $student_profile->getExamResults($ic_id, $student_id);
}catch(Exception $e){
  print $e;
}

?>

<div id="about_cont_con">
   <div id="about_hdr">
     <span class="h3">
       Student Profile
     </span>
   </div>
   <div id="sub-content">
      <div class="media">
        <div class="media-body">
          <h4><?php echo $student['FIRSTNAME'].' '.$student['LASTNAME'];?></h4>
	  <p>
	    <B>
              <?php echo $student['COURSE'];?>
	    </B>
	    </br>
	    Joined &nbsp;<?php echo $student['date_joined'];?>
	  </p>
        </div>
      </div><!----/ media--->
      <hr/>

      <div class="panel-group" id="record_accordion">
        <div class="panel panel-default">
           <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#record_accordion">
                   Quiz Results
                </a>
              </h4>
           </div>
           <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body">
                <?php
                    if (count($quiz_results)>0){
		?>
		<table class="table table-condensed table-striped">
		   <thead>
		     <th>Quiz Title</th>
		     <th>
		        <span class="glyphicon glyphicon-calendar"></span>&nbsp;Date Taken
                     </th>
		     <th>
                        <span class="glyphicon glyphicon-check"></span>&nbsp;
                        Score
                     </th>
		   </thead>
		     <tbody>
		       <?php 
		//print_r($quiz_results);
                         foreach($quiz_results as $qrs){
			   echo "<tr>";
			   echo    "<td>{$qrs['title']}</td>";    
			   echo    "<td>{$qrs['date_taken']}</td>";
			   echo    "<td>{$qrs['score']}/{$qrs['total_points']}</td>";    
			   echo "</tr>";
		         }
                       ?>
		     </tbody>
                 </table>
                 <?php
                    }
                ?>
               
              </div>
           </div><!---/collapse one--->
        </div><!---/panel 1--->
        <div class="panel panel-default">
          <div class="panel-heading">
             <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#record_accordion">
                 Assignment Results
                </a>
             </h4>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse in">
             <div class="panel-body">
                 <?php
                    if (count($quiz_results)>0){
		 ?>
		 <table class="table table-condensed table-striped">
		   <thead>
		     <th>Assignment Title</th>
		     <th>
		        <span class="glyphicon glyphicon-calendar"></span>&nbsp;Date Submitted
                     </th>
		     <th>
                        <span class="glyphicon glyphicon-check"></span>&nbsp;
                        Score
                     </th>
		   </thead>
		     <tbody>
		       <?php 
		//print_r($quiz_results);
                         foreach($ass_results as $ars){
			   echo "<tr>";
			   echo    "<td>{$ars['title']}</td>";    
			   echo    "<td>{$ars['date_submitted']}</td>";
			   echo    "<td>{$ars['rating']}</td>";    
			   echo "</tr>";
		         }
                       ?>
		     </tbody>
                 </table>
                 <?php
                    }
                 ?>
               
             </div>
          </div><!----/ collapse 2--->
        </div><!---/panel 2---->
        <div class="panel panel-default">
          <div class="panel-heading">
             <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#record_accordion">
                  Exam Results
                </a>
             </h4>
          </div>
          <div id="collapseThree" class="panel-collapse collapse in">
             <div class="panel-body">
                <?php
                    if (count($exam_results)>0){
		?>
		<table class="table table-condensed table-striped">
		   <thead>
		     <th>Quiz Title</th>
		     <th>
		        <span class="glyphicon glyphicon-calendar"></span>&nbsp;Date Taken
                     </th>
		     <th>
                        <span class="glyphicon glyphicon-check"></span>&nbsp;
                        Score
                     </th>
		   </thead>
		     <tbody>
		       <?php 
		//print_r($quiz_results);
                         foreach($exam_results as $ers){
			   echo "<tr>";
			   echo    "<td>{$ers['title']}</td>";    
			   echo    "<td>{$ers['date_taken']}</td>";
			   echo    "<td>{$ers['score']}/{$ers['total_points']}</td>";    
			   echo "</tr>";
		         }
                       ?>
		     </tbody>
                 </table>
                 <?php
                    }
                ?>
             </div>
          </div><!---/ collapse 3 --->
        </div><!---/panel 3---->
      </div><!---/accordion ---->
    </div><!-----/ sub-content---->
</div>