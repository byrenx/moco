
<div id='popup_background'></div>

<div id='popup_div'>
  <div id='pd-header'>  
     <span id="pd-header-title">Course Announcement
     </span> 
     <span>
        <button type="button" class="close" aria-hidden="true" 
                onclick="javascript:hide_form('popup_background','popup_div')">&times;
        </button>
     </span>
  </div>
 
  <div id="feedback" style='margin-top:10px;'></div>
<!----javascript:addUpdateAnnouncement('addann')--->
<form class="form" id="addann" action="../../libraries/php/exec_controller.php"  method="post" onsubmit="return true">

  <div id='pd-content'>
    
        <input type="hidden" id="action" name="action" value="">
	<input type='hidden' id='target' name='target' value='announcement'>
	<input type="hidden" id="icr_id" name="icr_id" value="<?php echo $_SESSION['icr_id'];?>">
	<input type="hidden" id="ann_id" name="ann_id" value="">
	  
	<div class="form-group">
          <label>
            Subject
          </label>
          <input type='text' class="form-control" required='true' id='ann_title' name='ann_title' value=''/>
        </div>
	<div class="form-group">
          <label>Content</label>
          <textarea class="widgEditor" id="ann_stmt" name="ann_stmt" rows="8"></textarea>
        </div>
   </div>
   <div id='pd-footer'>
       </br>
       <span style='position: absolute;
                    left: 70%;
                    top:5px;'>
          <input type="button" class="btn btn-default" name="close" value="Close"
                onclick="javascript:hide_form('popup_background','popup_div')">
   &nbsp;<input type="submit" class="btn btn-primary"  name='save' value='Save'>
       </span>
   </div>
   </form>
</div>
