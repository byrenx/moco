<?php
if(count($_GET)>0 && $_GET['ass_id']){
  $ass_id = $_GET['ass_id'];
  require_once "../class_models/assignment_model.php";
  
  $ass_model = new AssignmentModel();
  $ass_model->connect_to_db();
  $ass_edit = $ass_model->get_ass($ass_id);
}

?>

<script type="text/javascript">
$(function(){
    $("#dd").datepicker();
});

var form ={
  //variables
msg: '',
valid: true,
title: null,
date_due: null,
instruction: null,
f_attach: null,
//initialize and get the value of the fields involved
Init: function(){
    this.title = $("#ann_title").val();
    this.date_due = $("#dd").val();
    this.instruction = $("#instruction").val();
    this.f_attach = $("#f_attach").val();
  } ,//end of Init

validate: function(){
    this.Init();

    if(emptyStr(this.title) || this.title.length<0 ){
      this.msg += " * Type the Title of the Assignment</br>";
      this.valid = false;
    }
    if(!isValidDateFormat(this.date_due)){
      this.msg += " * Enter a valid date for due date e.g 03/05/2013 </br>";
      this.valid = false;

    }
    if(isValidDateFormat(this.date_due)){
      if(!isLaterToday(this.date_due)){
	this.msg += " * Due date must not be before today</br>";
	this.valid = false;
      }
    }

    if(!valid_ass_file(this.f_attach) && !emptyStr(this.f_attach) && !(this.f_attach=='')){
      this.msg += " * Upload a valid file type e.g .doc(x), .pdf, .txt</br>";
      this.valid = false;
    }

    if(this.valid==false){
      $("#msg").removeClass()
      .addClass('alert alert-danger')
      .html('<b>You must follow the ff. validation rules(*) to add this Assignment:</b> </br>'+this.msg);
      this.clear();
      return false;
    }else{
      return true;
    }
    
  },//end of valid function,
  //clear data
clear: function(){
    this.msg = '';
    this.valid = true;
  }

};


</script>

<div id='about_cont_con'>  
     <div id="about_hdr">
        <span class="h3"> Add Assignment | </span>
        <a href="assignment_page.php">
           <span class='glyphicon glyphicon-backward'></span>
           Back to List of Assignments
        </a>
     </div> 
     <div id='sub-content'>
          <div id='msg' 
        <?php if ($stat=='ok'){?>
             class="alert alert-success">
	     <b>New Assignment sucesfuly added</b>
	  <?php }else if($action=='edit' && $stat=='updated'){
                   echo 'class="alert alert-success">';
                   echo '<b>Assignment succesfully updated!</b>';
                }else{
                     echo '>';
                }
          ?>
        </div>
	 							

<?php if($stat=='ok' || ($stat=='updated' && $action=='edit')){ ?>
<?php }else{ ?>

         <form class="form" id="addupdate_ass" action="../../libraries/php/exec_controller.php" 
        enctype="multipart/form-data" method="post" onsubmit="return form.validate()">
           <input type="hidden" id="action" name="action" value="<?php if(isset($_GET['action']) && $_GET['action']=='edit') echo 'edit'; else echo 'add';?>">
           <input type="hidden" id="target" name="target" value="assignment">
	   <input type="hidden" id="ic_id" name="ic_id" value="<?php echo $_SESSION['icr_id'];?>">
	   <input type="hidden" id="assign_id" name="assign_id" value="<?php if(isset($ass_edit)) echo $ass_edit['assign_id']; ?>">
           <input type="hidden" name="da" value="<?php $d = new DateTime(); echo $d->format('Y-m-d');?>" >

	   <div class="form-group">
              <label>
               Title
              </label>
              <input type="text" name="title" class="form-control" required='true' id='ann_title' name='ann_title' value="<?php if (isset($ass_edit)) echo $ass_edit['title']?>"/>
           </div>
           <div class="form-group">
             <label>Submission Deadline</label>
             <input type="text" name="dd" 
                    id="dd" class="form-control" 
                    style="width:200px" value="<?php if(isset($ass_edit)) echo $ass_edit['due_date'];?>" required/>
           </div>
           <div class="form-group">
             <label>Instruction</label>
             <textarea class="widgEditor" id="instruction" name="instruction" rows="5" required><?php if(isset($ass_edit)) echo $ass_edit['instruction'];?></textarea>
           </div>
           <div class="form-group">
             <label>Attachment</label> &nbsp;
             <span>Attach only the ff. file types: .doc(x), .pdf, .txt</span>
             <input type="hidden" name="MAX_FILE_SIZE" value="41943040"/>
             <input type="hidden" name="f_edit" value="<?php echo $ass_edit['inst_material'];?>">
             <input type="file" id="f_attach" name="f_attach" value="sample"/>
           </div>
           <div id='pd-footer'>
             </br>
             <span style='position: absolute;
                    left: 70%;
                    top:5px;'>
                 <input type="button" class="btn btn-default" name="Back" value="Back"
                onclick="javascript:hide_form('popup_background','popup_div')">
                 <input type="submit" class="btn btn-primary"  name='save' value='Save'>
              </span>
           </div>
     </div>
   </form>
<?php } ?>
</div>

