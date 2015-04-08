<?PHP
require_once "../../instructor_module/class_models/assignment_model.php";

class AssignmentInterface{
  protected $ass_model;

  public function __construct(){
    $this->ass_model = new AssignmentModel();
    $this->ass_model->connect_to_db();
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


  public function updateAssignment(){
    $due = new DateTime(sanitize($_POST['dd']));
    $ass_params  = array(":ass_id"=>$_POST['assign_id'],
                         ":i"=>$_POST['instruction'],
			 ":im"=>($_POST['f_attach']==''? $_POST['f_edit']: $_POST['f_attach']),
			 ":dd"=>$due->format('Y-m-d'));
    if($this->ass_model->updateAssignment($ass_params))
      header("Location: ../../instructor_module/pages/add_assignment.php?action=edit"."&ass_id=".$_POST['assign_id']."&stat=updated");
    else{
      echo "err";
    }
  }
  
  public function displayAssignments($ic_id){
    $ass_list = $this->ass_model->getAllCourseAss($ic_id);
    if(count($ass_list)>0){
      $count = 1;
      //echo "<input type='hidden' id='ass_count' value='".count($ass_list)."'>";
      echo "<div id='accordion' class='panel-group'>";
      foreach ($ass_list as $ass){
	$this->showAssInfo2($ass, $count);
	$count++;
      }
      echo "</div><!--/accordion--->";
    }else{
      
    }
  }

  public function showAssInfo2($ass_info, $count){
    if($ass_info!=null){
      echo "<div class='panel panel-default'>";
      echo    "<div class='panel-heading'>";
      echo       "<h4 class='panel-title'>
                     <a data-toggle='collapse' data-parent='#accordion'>{$ass_info['title']}
                     </a>
                 </h4>";
      echo     "</div>";
      if ($count==1){
	echo   "<div id='{$ass_info['assign_id']}' class='panel-collapse collapse in' >";
      }else{
       	echo   "<div id='{$ass_info['assign_id']}' class='panel-collapse collapse in' >"; 
      }

      echo       "<div class='panel-body'>
                      <h5><b>Due Date:</b>&nbsp;{$ass_info['due_date']}</h5>
                      <div style='font-family:Helvetica;text-align:justify; min-height:100px;'>
                           {$ass_info['instruction']}
                      </div>";

                      echo " <ol class='breadcrumb'>";
                        echo "<li>
                              <a href='javascript:edit_ass(\"{$ass_info['assign_id']}\")' class='btn btn-link'>
                                 <span class='glyphicon glyphicon-pencil'></span>
                               Edit
                             </a></li>";

                        echo "<li>
                               <a href='javascript:del_ass(\"{$ass_info['assign_id']}\",\"{$ass_info['title']}\")' class='btn btn-link'>
                                 <span class='glyphicon glyphicon-remove'></span>
                                 Delete
                              </a></li>";


			if($ass_info['inst_material']!=null){
			  $url = "../../assignment_attachment/{$ass_info['inst_material']}";
			  echo "<li><a href='$url' class='btn btn-link' target='_blank'>
                                <span class='glyphicon glyphicon-download-alt'></span>
                                Instructional Material
                             </a></li>";                        
			}
			echo "<li>
		            <a href='../../instructor_module/pages/ass_submsns.php?ass_id={$ass_info['assign_id']}' class='btn btn-link'>
                               <span class='glyphicon glyphicon-file'></span>
		               Submissions&nbsp;<span class='badge'>{$ass_info['submissions']}</span>
                            </a></li>";
			    echo "</ol>";
		   echo "</div>"; //-panel-body
	 echo   "</div>";//<!---/ panel-collapse--->
      echo "</div>";//</div><!---/ panel-default--->";
    }
  }//end of function

  public function rate_sub(){
    $inputs  = array(':sub_id'=> $_POST['sub_id'],
                     ':rate' => $_POST['rate'],
                     ':msg' => sanitize($_POST['msg']));  
    if($this->ass_model->rate_sub($inputs)){
      echo $inputs[':rate'];
    }else{
      echo 'err';
    }
  }

}



?>