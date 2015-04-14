<?php
require_once '../../instructor_module/class_models/im_syllabus.php';

class CoursematInterface{

  protected $IM_SYLLABUS;

  protected $lectures;  
 
  public function __construct(){
    $this->IM_SYLLABUS = new IMSyllabus();
  }

  public function addDisplayNewLecture(){
    $this->IM_SYLLABUS->addLecture();
    $new_lecture = $this->IM_SYLLABUS->getNewLecture();
    
    echo "<tr id='{$new_lecture['lect_id']}'>";
    echo "<td>{$new_lecture['tittle']}</td>";//lecture title
    echo "<td>";
    echo "<nav>";
    echo "<ul id='ab"."{$new_lecture['lect_id']}'>";
    echo "</ul>";
    echo "</nav>";
    echo "</td>";
    echo "</tr>";
  }

  public function addDisplayNewMaterial(){
    if($this->IM_SYLLABUS->addMaterial()){
      header('Location: ../../instructor_module/pages/course_mat.php');
    }else{
      echo 'error';
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
	echo "<div class='panel-heading' style='background-color: rgba(204, 204, 204, 0.5);'>";
	echo "<form id='frm_chid' name='frm_chid'>";
	echo "<input type='hidden' 
                  id='chapter_id' 
                  name='chapter_id' 
                  value='{$chapter['chapter_id']}'>";
	echo "<input type='hidden' 
                  id='displayed' 
                  name='displayed' value='0'>";
	echo "<h4 class='panel-title'>
<a data-toggle='collapse' data-parent='#accordion' href='#{$chapter['chapter_id']}'>
<span class='header'>{$chapter['title']}</a>";
	echo "</h4>";
	echo "</form>";
	echo "</div>";  
	echo "<div id='{$chapter['chapter_id']}' class='panel-collapse collapse-in'>";
	echo "<table id='{$chapter['chapter_id']}' class='table table-condensed table-striped'>";
	//content
	//print_r($chapter['lectures']);
	foreach($chapter['lectures'] as $lecture){
	  $this->lectures[] = array('lect_id'=>$lecture['lect_id'], 
				    'title'=>$lecture['tittle']);  
	  echo "<tr id='{$lecture['lect_id']}'>";
	  echo "<td style='vertical-align: middle'>{$lecture['tittle']}</td>"; 
	  echo "<td style='text-align: right; margin-right: 10px; vertical-align: middle'>";
	  $this->displayLectMat($lecture['lect_id'], $lecture['materials']);
	  echo "</td>";
	  echo "</tr>";
	}
	echo "</table>";
	echo "</div>"; // .end 
	echo "</div>"; // .end of accordion

      }
    }else{
      echo "<h3> No Course Materials yet! </h3>";
    }
  }
  public function displayLectMat($lect_id, $lecture_material){
    echo "<nav>";
    //print_r($lecture_material);
    foreach($lecture_material as $lm){
      if($lm['allow_download'] == 1){
	$URL = "../../lecture_media_storage/{$lm['file_url']}";
	echo "<a title='{$lm['file_url']}'  href='$URL' class='btn btn-link'>";
	$this->displayMatType($lm['file_type']);
	echo "</a>  ";
      }
    }  
    echo "</nav>"; 
  }
 
  public function  displayMaterial($material){
    $URL = "../../lecture_media_storage/{$material['file_url']}";
    echo "<li id='{$material['lectmat_id']}'>";
    echo "<a href='$URL' title='{$material['file_url']}'>";
    $this->displayMatType($material['file_type']);
    echo "dow";
    echo "</a>";
    echo "<ul>";
    echo "<li>";
    echo "<a href='$URL'>";
    echo "download";    
    echo "</a>";
    echo "</li>";
    echo "<li>";
    echo "<a href=''>";
    echo "delete";
    echo "</a>";
    echo "</li>";
    echo "</ul>";
    echo "</li>";

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
}
?>
