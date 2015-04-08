<div id='popup_background'></div>

<div id='popup_div'> 
  <div id='pd-header'>  
     <span id="pd-header-title">
       Add New Lecture
     </span>
 
     <span>
        <button type="button" 
                id="close"
                class="close" aria-hidden="true" 
                onclick="javascript:hide_form('popup_background','popup_div')">&times;</button>
     </span>
  </div>
  </br>		
  <div id="feedback"></div>		
  <form id='addlect' name='addlect'
        action="javascript:ajaxLecture('addlect');" 
        method='POST'>
     <input type="hidden" id="action" name="action" value="add"/>
     <input type="hidden" id="target" name="target" value="lecture"/>
     <input type="hidden" id="id" name="id" value="">
     <div id='pd-content'> 
        <div class='form-group'>
           <label>Lecture Title</label>
           <input type="text" id="title" class="form-control" name="title"/>
        </div>
	<input type='hidden' id='ch_id' name='chapter_id' value=''>
	   
     </div>
     </br>
     <div id='pd-footer'>
        <span style='position: absolute;
                    left: 70%;
                    top:5px;'>
          <input type="button" class="btn btn-default" name="cancel" value="Close"
                onclick="javascript:hide_form('popup_background','popup_div')">
          <input type="submit" class="btn btn-primary"  name='save' value='Save'>
        </span>
     </div>
   </form>
</div>