<?PHP
require_once "../../Student_Module/class_models/assignment_model.php";

class AssignmentInterface{
  protected $ass_model;

  public function __construct(){
    $this->ass_model = new AssignmentModel();
    $this->ass_model->connect_to_db();
  }
  public function showABadge($id){
    $AbadgeCount = NULL;
    $ass_list = $this->ass_model->getAllCourseAss($id);
    foreach($ass_list as $key){
         if($this->ass_model->isSubmitted($_SESSION['studC_id'],$key['assign_id'])){
	   
	 }else{
	   $AbadgeCount++;
	 }
    }
    echo "<span class='badge pull-right alert-danger'>".
           $AbadgeCount
          ."</span>";


  }
  public function notify_rating($id){
    $rateCount = NULL;
    $rs = $this->ass_model->getAllCourseAss($id);
    foreach($rs as $row){
      if($this->ass_model->isRate_viewed($_SESSION['studC_id'],$row['assign_id'])){
	$rateCount++;
      }else{
	
      }
    }
    echo "<span class='badge pull-right alert-info' id='notify'>".
          $rateCount
         ."</span>";
  }
  
  public function subAssignment(){
    $date_submitted = new DateTime();
    $ass_params = array(":scr_id"=>$_POST['scr_id'],
			":assign_id"=>$_POST['assign_id'],
			":ds"=>$date_submitted->format('Y-m-d'));
    $stat = null;
    if($this->ass_model->subAssignment($ass_params)){
      $stat = "?stat=ok";
        header("Location: ../../Student_Module/pages/Assignment.php".$stat);
    }else{
      $stat = "?stat=fail";
        header("Location: ../../Student_Module/pages/sub_assignment.php".$stat);
    }
     
  }
  public function viewRating(){
    if(isset($_GET['scr_id'])&&isset($_GET['assign_id'])){
    $ass_params = array(":scr_id" => $_GET['scr_id'],
			":assign_id" => $_GET['assign_id']);

    if($this->ass_model->updateRating($ass_params)){
      
      //echo "ok";
      echo $this->ass_model->count_rated($_GET['scr_id']);
    }else{
      echo "err";
    }

      }
  }


  public function addAssignment(){
    $due = new DateTime(sanitize($_POST['dd']));
    $da = new DateTime(sanitize($_POST['da']));    
    $ass_params  = array(":ic_id"=>$_POST['ic_id'],
			 ":title"=>$_POST['title'],
			 ":i"=>$_POST['instruction'],
			 ":dd"=>$due->format('Y-m-d'),
			 ":da"=>$da->format('Y-m-d'));
    $stat = null;
    if($this->ass_model->addAssignment($ass_params)){
      $stat = "?stat=ok";
      header("Location: assignment_page.php");
    }else{
      $stat = "?stat=fail";
    }
    header("Location: ../../instructor_module/pages/add_assignment.php".$stat);
  }


  public function updateAssigment(){
    $due = new DateTime(sanitize($_POST['dd']));
    $da = new DateTime(sanitize($_POST['da']));    
    $ass_params  = array(":ass_id"=>$_POST['assignment_id'],
			 ":ic_id"=>$_POST['ic_id'],
                         ":i"=>$_POST['instruction'],
			 ":im"=>$_POST['im_url'],
			 ":dd"=>$due,
			 "da"=>$da);
    if($this->updateAssignment($ass_params))
      echo "ok";
    else{
      echo "err";
    }
  }
  
  public function displayAssignments($ic_id){
    $ass_list = $this->ass_model->getAllCourseAss($ic_id);
    if(count($ass_list)>0){
      $count = 1;
	echo "<div class='panel-group' id='accordion'>";
      foreach ($ass_list as $ass){
	$this->showAssInfo($ass,$count);
	$count++;
      }
        echo "</div>";
    }else{
      echo "No Assignments Yet.";
    }
  }





  public function showAssInfo($ass_info,$count){
    $due = new DateTime($ass_info['due_date']);
    $today = new DateTime();
    $interval = $today->diff($due);
    // print_r($ass_info);
    if($ass_info!=null){
      $URL = "../../assignment_attachment/{$ass_info['inst_material']}";
      
      if($this->ass_model->isSubmitted($_SESSION['studC_id'],$ass_info['assign_id'])){
	$submitInfo = $this->ass_model->getSubAssInfo($_SESSION['studC_id'],$ass_info['assign_id']);
	echo "<div class='panel panel-default'>
            <div class='panel-heading'>
            <a data-toggle='collapse' data-parent='#accordion' href='#{$ass_info['assign_id']}'";
	if($this->ass_model->isRate_viewed($_SESSION['studC_id'],$ass_info['assign_id'])){
	  echo "onclick=viewRating(".$_SESSION['studC_id'].",".$ass_info['assign_id'].")"; 
	  //	  echo "onclick=alert()";
	}


     
	echo ">
              <h4 class='panel-title'>{$ass_info['title']} <span class='caret'></span></h4>
            </a>
            </div>";
        if($count == 1){    
	  echo "<div id='{$ass_info['assign_id']}' class='panel-collapse collapse in'>";
	}
	else{
	  echo "<div id='{$ass_info['assign_id']}' class='panel-collapse collapse'>";
	}
          echo "<div class='panel-body'>
            <p>";
	foreach ($submitInfo as $key){
	  $file = $key['file_url'];
	  $date_sub = new DateTime($key['date_submitted']);
	  $rating = $key['rating'];
	  $message = $key['message'];
	}
	echo " <nav class='navbar-right navbar-top'>
               <label class='form-inline'> Date Submitted: </label>
                {$date_sub->format('F j, Y, l')} </br> 
                <label class='form-inline'> Rating: </label>";
	if($rating == 0){
	  echo "Not yet rated!";
	}else{
	  echo $rating;
	}
 
       echo  "       </br>
                <label>File Submitted: </label> {$file}
               </nav> ";

          echo    "<nav class='panel-body'>
                   <strong> Instructor {$_SESSION['inst']}: </strong></br>
                      &nbsp&nbsp&nbsp {$message}
                ";
      }else{
	echo "<div class='panel panel-info'>
            <div class='panel-heading'>
            <a data-toggle='collapse' data-parent='#accordion' href='#{$ass_info['assign_id']}'>
              <h4 class='panel-title'>{$ass_info['title']} <span class='caret'></span></h4>
            </a>
            </div>
            <div id='{$ass_info['assign_id']}' class='panel-collapse collapse'>
            <div class='panel-body'>
            <p>";
      echo "     <nav class='navbar-right'>
                  <label class='form-inline'> Deadline: </label>
                  {$due->format('F j, Y, l')}
                  </nav>
                 <nav class='panel-body'>
                   <nav id='instruction' name='instruction'>
                       <strong>Instruction: </strong></br>
                      &nbsp&nbsp&nbsp {$ass_info['instruction']}
                   </nav>
                 </nav>
                
                <nav class='navbar-right'>";
     
      if($interval->format('%R%d')>=0){
	if($ass_info['inst_material']!=null){
		       echo "<a href='{$URL}' class='btn btn-danger' style='width: 250px'>
                              Download Instruction Material

                           </a>&nbsp";
	    echo "<form action='../pages/sub_assignment.php' method='post'>
                             <input type='hidden' value='{$ass_info['assign_id']}' name='assignID'>
                             <input type='hidden' value='{$ass_info['ic_id']}' name='ic_id'>
                             <input type='submit' class='form-inline btn btn-default' value='Submit Assignment' style='width: 250px'>
                           </form>";
	}else{
	  //	  echo                               $interval->format('%R%d');
	  		    echo "<form action='../pages/sub_assignment.php' method='post'><input type='hidden' value='{$ass_info['assign_id']}' name='assignID'><input type='hidden' value='{$ass_info['ic_id']}' name='ic_id'><input type='submit' class='form-inline btn btn-default' value='Submit Assignment' style='width: 250px'></form>";
	}
      }else{
	echo "<p class='text text-danger'><span class='glyphicon glyphicon-warning-sign'></span> Today is: <b>{$today->format('F j, Y, l')}</b>; so the due date has elapsed! </br>you cannot submit this assignment </p>";
      }
      }             
        
              echo "</nav></p> </div></div></div>";
      
    } //end of if function
    }
}



?>