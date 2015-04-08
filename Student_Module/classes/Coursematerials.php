<?php
require_once 'sm_syllabus.php';

class CoursematInterface{

  protected $IM_SYLLABUS;

  protected $lectures;  
 
  public function __construct(){
    $this->IM_SYLLABUS = new SM_Syllabus();
  }

  public function displayLectsAndMats($icr_id){
    /* precondition: $icr -> instructor course record id

       postcondition: display all lectures axnd its
                     corresponding materials
     */
    $chapters = $this->IM_SYLLABUS->getSyllabus($icr_id);
     
     foreach($chapters as $chapter){
       echo "<div class='exp-header'>";
         echo "<form id='frm_chid' name='frm_chid'>";
            echo "<input type='hidden' 
                  id='chapter_id' 
                  name='chapter_id' 
                  value='{$chapter['chapter_id']}'>";
            echo "<input type='hidden' 
                  id='displayed' 
                  name='displayed' value='0'>";
              echo "<span class='header'>{$chapter['title']}</span>";
                echo "<a id='{$chapter['chapter_id']}' href='javascript:hide(\"".$chapter['chapter_id']."\")'>";
                  echo "<span id='{$chapter['chapter_id']}' class='caret-down'>";
                    echo "<img src='../../images/d_arrow_down.ico'
                          title='Show Lectures'/>";
                  echo "</span>";
                 echo "</a>";
	        echo "</form>";
              echo "</div>";  
              echo "<div id='{$chapter['chapter_id']}'
                    class='exp-content'>";
                echo "<table id='{$chapter['chapter_id']}' class='table'>";
              //content
                foreach($chapter['lectures'] as $lecture){
                  $this->lectures[] = array('lect_id'=>$lecture['lect_id'], 
                                      'title'=>$lecture['tittle']);  
	            echo "<tr id='{$lecture['lect_id']}'>";
		    echo "<td>{$lecture['tittle']}</td>"; 
                    echo "<td width='40%'>";
                    $this->displayLectMat($lecture['lect_id'], $lecture['materials']);
                    echo "</td>";
                  echo "</tr>";
                }
	        echo "</table>";
              echo "</div>"; 
           }
      }

  public function displayLectMat($lect_id, $lecture_material){
       echo "<nav>";
	echo "<ul id='ab".$lect_id."'>";
        foreach($lecture_material as $lm){
	  echo "<li>";
	    $URL = "../../lecture_media_storage/{$lm['file_url']}";
	    echo "<a>";
	      $this->displayMatType($lm['file_type']);
	      echo "<img src='../../images/caret_down_gray.png'>";
	    echo "</a>";
	    echo "<ul>"; 
	      echo "<li>"; 
	        echo "<a href='$URL'>";
		  echo "download";
                echo "</a>";
		echo "</li>";
	    echo "</ul>";
	  echo "</li>";
	 }  
	echo "</ul>";
       echo "</nav>"; 
  }
 
  public function  displayMaterial($material){

    $URL = "../../lecture_media_storage/{$material['file_url']}";
    echo "<li id='{$material['lectmat_id']}'>";
      echo "<a href='$URL'>";
        $this->displayMatType($material['file_type']);
        echo "<img src='../../images/caret_down_gray.png'>";
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
       echo "<img src='../../images/word.ico'>";
       break;
     case 'docx':
       echo "<img src='../../images/word.ico'>";
       break;
     case 'mp4':
       echo "<img src='../../images/play.ico'>";
       break;
     case 'pdf':
       echo "<img src='../../images/pdf.ico'>";
       break;
     }
  }
}
?>