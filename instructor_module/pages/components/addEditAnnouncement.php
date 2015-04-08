<script language="javascript">
   function validate(){
      var subject = $('#ann_title').val();
      var content = $('#ann_stmt').val();
      if(subject=="" || content==""){
	$('#validation_msg').addClass('alert alert-danger').
	  html("<span class='glyphicon glyphicon-warning-sign'></span>&nbsp;Content is Required");
	return false;
      }else{
	return true;
      }
   }
</script>


<div id="about_cont_con">
   <h3>Course Announcement</h3>
   <hr/>
  <div id="feedback" style='margin-top:10px;'></div>
<form class="form" id="addann" action="../../libraries/php/exec_controller.php"  method="post" onsubmit="return validate()">

  <div id='pd-content'>
    
        <input type="hidden" id="action" name="action" 
          value="<?php echo $action; ?>">
	<input type='hidden' id='target' name='target' value='announcement'>
	<input type="hidden" id="icr_id" name="icr_id" value="<?php echo $_SESSION['icr_id'];?>">
	<input type="hidden" id="ann_id" name="ann_id" value="<?php echo $ann_id;?>">
	  
        <p id="validation_msg"></p>
	<div class="form-group">
          <label>
            Subject
          </label>
          <input type='text' class="form-control" required="true" id="ann_title" name="ann_title" value="<?php echo $announcement['title'];?>"/>
        </div>
	<div class="form-group">
          <label>Content</label>
          <textarea class="widgEditor" id="ann_stmt" name="ann_stmt" rows="8" required="True"><?php echo $announcement['ann_stmt'];?></textarea>
        </div>
   </div>
   <input type="submit" class="btn btn-primary"  name='save' value='Save'>
   &nbsp;
   <input type="button" class="btn btn-default" name="close" value="Back"
                onclick="javascript:hide_form('popup_background','popup_div')">
   </div>
   </form>
</div>
