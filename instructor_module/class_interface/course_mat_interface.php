<?php
require_once '../../instructor_module/class_models/im_syllabus.php';

class CoursematInterface{

  protected $IM_SYLLABUS;

  protected $lectures;  
 
  public function __construct(){
    $this->IM_SYLLABUS = new IMSyllabus();
  }

  public function addDisplayNewLecture(){
    $q_params = array(sanitize($_POST['title']), $_POST['chapter_id']);
    if($this->IM_SYLLABUS->isLectExist(0, $q_params[1], $q_params[0])){
      return "dup";
    }else{
      $this->IM_SYLLABUS->addLecture($q_params);
      $new_lecture = $this->IM_SYLLABUS->getNewLecture();
      $str_output = "<tr id='{$new_lecture['lect_id']}'>";
      $str_output .= "<td width='30'><a href='javascript:delLect(\"{$new_lecture['lect_id']}\");' title='Delete this Lecture'><span class='glyphicon glyphicon-remove text-danger'></span></a></td>";
      $str_output .= "<td width='30'><a href='javascript:showEditLectForm(\"popup_background\", \"popup_div\", \"{$new_lecture['lect_id']}\", \"{$new_lecture['ch_id']}\")' title='Update this Lecture'><span class='glyphicon glyphicon-edit'></span></a></td>";
      $str_output .= "<td width='30'><a href='javascript:showAddLectureMaterialForm(\"{$new_lecture['lect_id']}\")' title='Upload Lecture material for this lecture'><span class='glyphicon glyphicon-upload'></span></button></td>";
      $str_output .= "<td>{$new_lecture['tittle']}</td>";//lecture title
      $str_output .= "<td width='40%'>";
      $str_output .= "<nav>";
      $str_output .= "<ul id='ab"."{new_lecture['lect_id']}'>";
      $str_output .= "</ul>";
      $str_output .= "</nav>";
      $str_output .= "</td>";
      $str_output .= "</tr>";
      return $str_output;
    }
    
  }

  public function updateLecture(){
    $q_params = array($_POST['title'], $_POST['chapter_id'], $_POST['lecture_id']);
    if($this->IM_SYLLABUS->updateLecture($q_params)){
      return $_POST['title'];
    }else{
      return 'dup';
    }
  }

  public function delLecture(){
    $lecture_materials = $this->IM_SYLLABUS->getLectMatssFrLect($_POST['lecture_id']);
    foreach ($lecture_materials as $material){
      $this->IM_SYLLABUS->del_lm($material['lectmat_id']);
      unlink("../../lecture_media_storage/".$material['file_url']);
    }
    return $this->IM_SYLLABUS->delLect($_POST['lecture_id']);
  }

  public function addDisplayNewMaterial(){
    try{
      $upload_status = $this->IM_SYLLABUS->addMaterial();

      if($upload_status==1){
	header('Location: ../../instructor_module/pages/course_mat.php');
      }else if($upload_status==0){
	header('Location: ../../instructor_module/pages/course_mat.php?stat=0');
      }else{
	header('Location: ../../instructor_module/pages/course_mat.php?stat=2');
      }
    }catch(Exception $e){
      header('Location: ../../instructor_module/pages/course_mat.php?stat=0');
    }
  }

  public function showLectureOptions(){
    foreach($this->lectures as $lecture){
      echo "<option value='{$lecture['lect_id']}'>";
      echo "{$lecture['title']}";
      echo "</option>";
    }
  }

  public function showChapterOptions($icr_id){
    $chapters = $this->IM_SYLLABUS->getAllChapters($icr_id);
    
    foreach($chapters as $chapter){
      echo "<option value='{$chapter['ch_id']}'>";
      echo "{$chapter['chapter_id']}"." {$chapter['title']}";
      echo "</option>";
    }
  }


  public function displayLectsAndMats($icr_id){
    /* precondition: $icr -> instructor course record id

       postcondition: display all lectures axnd its
       corresponding materials
    */

    $chapters = $this->IM_SYLLABUS->getSyllabus($icr_id);
    if(count($chapters)>0){
      echo "<div class='panel-group' id='accordion'>";
      foreach($chapters as $chapter){
	echo "<div class='panel panel-default'>";
	echo   "<div class='panel-heading' style='background-color: rgba(204, 204, 204, .5)'>";
	echo      "<form id='frm_chid' name='frm_chid'>";
	echo          "<input type='hidden' 
                           id='chapter_id' 
                           name='chapter_id' 
                           value='{$chapter['chapter_id']}'>";
	echo           "<input type='hidden' 
                           id='displayed' 
                           name='displayed' value='0'>";
	//chapter title
	//javascript:showpopup_form(\"popup_background\",\"popup_div\")
	echo            "<a href='javascript:showAddLectForm(\"addlect\")' 
                           title='Add Lecture' onclick='$(\"#ch_id\").val({$chapter['chapter_id']})'
                        >
                          <span class='glyphicon glyphicon-plus-sign'></span>
                         </a>&nbsp;
                         <a data-toggle='collapse' data-parent='#accordion' href='#{$chapter['chapter_id']}'>{$chapter['title']}</a>
                   </div>";
	echo      "<a id='{$chapter['chapter_id']}' href='javascript:hide(\"".$chapter['chapter_id']."\")'>";
	echo "</a>";
	echo "</form>";
	echo "</div>"; //panel-heading   
	echo "<div class='panel-collapse collapse in' id='{$chapter['chapter_id']}'>";//collapse open tag
	echo "<div class='panel-body' id='{$chapter['chapter_id']}' style='padding: 0px'>";
	echo "<table id='{$chapter['chapter_id']}' class='table table-condensed table-striped'>";
	//content
	foreach($chapter['lectures'] as $lecture){
	  $this->lectures[] = array('lect_id'=>$lecture['lect_id'], 
				    'title'=>$lecture['tittle']);  
	  echo "<tr id='{$lecture['lect_id']}'>";
	  echo "<td style='vertical-align: middle;' width='30'><a href='javascript:delLect(\"{$lecture['lect_id']}\");' title='Delete this Lecture'><span class='glyphicon glyphicon-remove text-danger'></span></a></td>";
	  echo "<td style='vertical-align: middle' width='30'><a href='javascript:showEditLectForm( \"popup_background\", \"popup_div\", \"{$lecture['lect_id']}\",\"{$lecture['ch_id']}\")' title='Update this Lecture'><span class='glyphicon glyphicon-edit'></span></a></td>";
	  echo "<td width='30' style='vertical-align: middle'><a href='javascript:showAddLectureMaterialForm(\"{$lecture['lect_id']}\")' title='Upload Lecture material for this lecture'><i class='fa fa-upload'></i></a></td>";
	  echo "<td style='vertical-align: middle'>{$lecture['tittle']}</td>"; 
	  echo "<td width='40%' style='vertical-align: middle'>";
	  $this->displayLectMat($lecture['lect_id'], $lecture['materials']);
	  echo "</td>";
	  echo "</tr>";
	}
	echo "</table>";
	echo "</div>"; //panel-body
	echo "</div>"; //collapse div
      }//end of foreach
      echo "</div>";
    }else{//end of if
      echo "<h3>Currently no syllabus content found!</h3>";
      echo "<p>To manage this page you need create syllabus<p>";
    }//end of if else
    
  }


  public function displayLectMat($lect_id, $lecture_material){
    echo "<nav>";
    echo "<ul id='ab".$lect_id."' class='nav nav-pills'>";
    foreach($lecture_material as $lm){
      echo "<li id='{$lm['lectmat_id']}' class='dropdown'>";
      $URL = "../../lecture_media_storage/{$lm['file_url']}";
      echo "<a title='{$lm['file_url']}' class='dropdown-toggle' data-toggle='dropdown' href='#'>";
      //href='../../lecture_media_storage/{$lm['file_url']}'
      $this->displayMatType($lm['file_type']);
      echo "<span class='caret'></span>";
      echo "</a>";
      echo "<ul class='dropdown-menu'>"; 

      echo "<li>";
      echo "<a href='#' class='checkbox'>";
      echo "<label>";
      echo "<input type='checkbox' id='dl{$lm['lectmat_id']}' onchange='setdownloadable(\""."#dl{$lm['lectmat_id']}\", {$lm['lectmat_id']})'";
      if ($lm['allow_download']==1) echo " checked = 'checked' value='1'";
      else echo " value='0'";
      echo ">&nbsp;Downloadable";
      echo "</label>";
      echo "</a>";
      echo "</li>";
      echo "<li class='divider'></li>";
      echo "<li>"; 
      echo "<a href='$URL' target='_blank'>";
      echo "<span class='glyphicon glyphicon-download-alt'></span>";
      echo "&nbsp;Download";
      echo "</a>";
      echo "</li>";


      echo "<li>";
      echo "<a href='javascript:dellm(\"{$lm['lectmat_id']}\")'>";
      echo "<span class='glyphicon glyphicon-remove'></span>";
      echo "&nbsp;Remove";
      echo "</a>";
      echo "</li>";
      echo "</ul>";
      echo "</li>";
    }  
    echo "</ul>";
    echo "</nav>"; 
  }
 

  public function displayMatType($file_type){
    //this function display the coprresponding 
    //image if a file
    switch($file_type){
    case 'doc':
      echo "<i class='fa fa-file-word fa-2x text-primary'></i>";
      break;
    case 'docx':
      echo "<i class='fa fa-file-word-o fa-2x text-primary'></i>";
      break;
    case 'mp4':
      echo "<i class='fa fa-file-video-o fa-2x text-danger'></i>";
      break;
    case 'pdf':
      echo "<i class='fa fa-file-pdf-o fa-2x text-danger'></i>";
      break;
    case 'webm':
      echo "<i class='fa fa-file-video-o fa-2x text-danger'></i>";
      break;
    case 'mov':
      echo "<i class='fa fa-file-video-o fa-2x text-danger'></i>";
      break;
    case 'mp3':
      echo "<i class='fa fa-file-audio-o fa-2x text-warning'></i>";
      break;
    case 'ppt':
      echo "<i class='fa fa-file-powerpoint-o fa-2x text-warning'></i>";
      break;
    case 'txt':
      echo "<i class='fa fa-file-text-o fa-2x text-warning'></i>";
      break;
    case 'pptx':
      echo "<i class='fa fa-file-powerpoint-o fa-2x text-warning'></i>";
      break;

    }
  }

  public function del_lm(){
    $lm_id = $_GET['lm_id'];
    $lect_material = $this->IM_SYLLABUS->getLectureMaterial($lm_id)->fetch();
    if($this->IM_SYLLABUS->del_lm($lm_id)){
      unlink("../../lecture_media_storage/".$lect_material['file_url']);
      echo 'ok';
    }else{
      echo 'err';
    }
  }
}
?>
