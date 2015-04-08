

<div id="add-course-item-diag" class="popup_div">
  <div id="pd-header">  
     <span id="pd-header-title">Add Course
     </span> 
     <span>
        <button type="button" class="close" aria-hidden="true" 
		onclick="javascript:hide_form('popup_background','add-course-item-diag')">&times;</button>
     </span>
  </div>

  <div id='pd-content'>

  <div id="alert"></div>
 
  <form class="form" id="addann" action="javascript:addUpdateAnnouncement('addann')" 
        method="post" onsubmit="return true">
      <input type="hidden" id="action" name="action" value="">
      <input type='hidden' id='target' name='target' value='announcement'>
      <input type="hidden" id="icr_id" name="icr_id" value="">
      <input type="hidden" id="ann_id" name="ann_id" value="">

      <div class="form-group">
	<label>
	  Course Code
        </label>
      </div>
        
        <input type='text' required='true' id='ann_title' name='ann_title' value='' style='width: 95%'/>
        <label>Announcement Content</label>
        <textarea id="ann_stmt" name="ann_stmt" style="width:95%;height:100px;"> 
        </textarea>
        
   </div>
   <div id='pd-footer'>
       </br>
       <span id='feedback' style='position: absolute; left: 5px;width: 60%;color:green'>
          
       </span>
       <span style='position: absolute;
                    left: 70%;
                    top:5px;'>
          <input type="button" class="btn btn-default" name="cancel" value="Cancel"
                onclick="javascript:hide_form('popup_background','popup_div')">
         <input type="submit" class="btn btn-primary"  name='save' value='Save'>
       </span>
   </div>
   </form>
</div>
