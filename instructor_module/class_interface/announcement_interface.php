<?php
require_once '../../instructor_module/class_models/im_announcement.php';

class AnnouncementInterface{
  protected $IM_ANNOUNCEMENT;

  public function __construct(){
    $this->IM_ANNOUNCEMENT = new IM_Announcement();
  }


  public function addAnnouncement(){
    $this->IM_ANNOUNCEMENT->addAnnouncement();
    header('Location: ../../instructor_module/pages/announcement.php');
  }

  public function updateAnnouncement(){
    $this->IM_ANNOUNCEMENT->updateAnnouncement();
    header('Location: ../../instructor_module/pages/announcement.php#'.$_POST['ann_id']);
  }

  public function delAnnouncement(){
    if($this->IM_ANNOUNCEMENT->delAnnouncement()){
      echo "ok";
    }else{
      echo "restrict";
    }
  }


  public function json_ann(){
   
    if($this->IM_ANNOUNCEMENT->isExist()){
      echo 'dup';
    }else{
      $ann = $this->IM_ANNOUNCEMENT->agn_ann();
      if($ann!=null){
	$dp = new DateTime($ann['date_posted']);
	$json = '{"ann_id": "'.$ann['ann_id'].'",
                "date": "'.$dp->format("F, j, Y, g:i a").'",
                "title":"'.$ann["title"].'",
                "stmt":"'.$ann['ann_stmt'].'"}';
	echo $json;
      }else{
	echo 'con_err';
      }
    }
  }

  private function showNewAnnouncement(){
    
    $ann = $this->IM_ANNOUNCEMENT->getNewAnnouncement();

    $str_ann_panel = null;
    
    if(count($ann)>0){
      $dp = new DateTime($ann['date_posted']);
      $str_ann_panel.="<div id='ca_ann_con' class='{$ann['ann_id']}'>";
      $str_ann_panel.="<div id='ca_date_con'>";
      $str_ann_panel.="<span id='ca_date_cont'>";
      $str_ann_panel.="Date Updated : ".$dp->format("F, j, Y, g:i a");
      $str_ann_panel.="</span>";
      $str_ann_panel.="</div>";
      //announcement content
      $str_ann_panel.="<h2>{$ann['title']}</h2>";
      $str_ann_panel.="<div id='ca_content'>";
      $str_ann_panel.="{$ann['ann_stmt']}";
      $str_ann_panel.="</div>";
      $str_ann_panel.="<div id='ca-edit-pane'>";
      $str_ann_panel.="<form id='".$ann['ann_id']."' 
                       action='javascript:showUpdateDelAnnDg(\"popup_background\",\"popup_div\",\"".$ann['ann_id']."\");' method='post'>";
      $str_ann_panel.="<input type='hidden' id='action' name='action' value='edit'>";
      $str_ann_panel.="<input type='hidden' id='target' name='target' value='announcement'>";
      $str_ann_panel.="<input type='hidden' id='ann_id' name='ann_id' value='".$ann['ann_id']."'>";
      $str_ann_panel.="<input type='hidden' id='ann_title' name='ann_title' value='".$ann['title']."'>";
      $str_ann_panel.="<button class='btn btn-default'  onclick='javascript:$(\"#{$ann['ann_id']} #action\").val(\"edit\")'>
                       <span class='glyphicon glyphicon-edit'></span>
                       Edit</button>    ";
      $str_ann_panel.="<button class='btn btn-default' onclick='javascript:$(\"form#{$ann['ann_id']} #action\").val(\"del\")'>
                       <span class='glyphicon glyphicon-remove text-danger'></span>
                       Delete</button>";
      $str_ann_panel.="</form>";
      $str_ann_panel.="</div>";
      $str_ann_panel.="</br></br>";
      $str_ann_panel.="</div>";
    }
    echo $str_ann_panel;
  }

  public function updateAnnouncementPanel(){
    
    $str_ann_panel=null;
 
    $ann = $this->IM_ANNOUNCEMENT->getUpdatedAnnouncement($_POST['ann_id']);
    $dp = new DateTIme($ann['date_posted']);

    $str_ann_panel.="<div id='ca_date_con'>";
    $str_ann_panel.="<span id='ca_date_cont'>";
    $str_ann_panel.="<span class='glyphicon glyphicon-calendar'>&nbsp;</span>Date Updated : ".$dp->format("F, j, Y, g:i a");
    $str_ann_panel.="</span>";
    $str_ann_panel.="</div>";
    $str_ann_panel.="<h2>{$ann['title']}</h2>";
    //announcement content
    $str_ann_panel.="<div id='ca_content'>";
    $str_ann_panel.="{$ann['ann_stmt']}";
    $str_ann_panel.="</div>";
    $str_ann_panel.="<div id='ca-edit-pane'>";
    $str_ann_panel.="<form id='{$ann['ann_id']}' 
                      action='javascript:showUpdateDelAnnDg(\"popup_background\",\"popup_div\",\"{$ann['ann_id']}\");'
                      method='post'>";
    $str_ann_panel.="<input type='hidden' id='action' name='action' value='edit'>";
    $str_ann_panel.="<input type='hidden' id='target' name='target' value='announcement'>";
    $str_ann_panel.="<input type='hidden' id='ann_id' name='ann_id' value='".$ann['ann_id']."'>";
    $str_ann_panel.="<input type='hidden' id='ann_title' name='ann_id' value='".$ann['title']."'>";
    $str_ann_panel.="<button class='btn btn-default'  onclick='javascript:$(\"#{$ann['ann_id']} #action\").val(\"edit\")'>
                       <span class='glyphicon glyphicon-edit'></span>
                       Edit</button>  ";
    $str_ann_panel.="<button class='btn btn-default' onclick='javascript:$(\"#{$ann['ann_id']} #action\").val(\"del\")'>
                       <span class='glyphicon glyphicon-remove text-danger'></span>
                       Delete</button>";
    $str_ann_panel.="</form>";
    $str_ann_panel.="</div>";
    $str_ann_panel.="</br></br>";
    
    echo $str_ann_panel;
  }

}

?>