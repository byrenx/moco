

<div id='popup_div'>
  <div id='pd-header'>  
     <span id="pd-header-title">
        Exam Details
     </span>
     
     <span>
        <button type="button" class="close" aria-hidden="true" 
                onclick="javascript:hide_form('popup_background','popup_div')">&times;</button>
     </span>
  </div>

  <div id='pd-content'>
    <form id='exam_frm' method='post' class="form-horizontal" role="role" action="javascript:manageQuiz('exam_frm')"> 
      <input type="hidden" id="icr_id" name="icr_id" value="<?php echo $_SESSION['icr_id']?>">  
      <input type="hidden" id="action" name="action" value="add">
      <input type="hidden" id="target" name="target" value="quiz">
      <input type="hidden" id="test_id" name="test_id" value="">
      <input type="hidden" name="ttype" value="1">
   
      <div class="form-group">
         <label class="col-sm-3 control-label">Quiz Title</label>
         <div class="col-sm-7">
           <input type="text" id="q_title" name="q_title" class="form-control"/>
         </div>
      </div>

      <div class="form-group">
         <label class="col-sm-3 control-label">Date Available</label>
         <div class="col-sm-7">
           <input type="text" id="da" name="da" class="form-control"/>
         </div>
      </div>

      <div class="form-group">
         <label class="col-sm-3 control-label">Due Date</label>
         <div class="col-sm-7">
           <input type="text" id="dd" name="dd" class="form-control"/>
         </div>
      </div>

      <div class="form-group">
         <label class="col-sm-3 control-label">Duration(min.)</label>
         <div class="col-sm-7">
           <input type="text" id="duration" name="duration" class="form-control" onkeydown="return allNumbers(event);" maxlength="3"/>
         </div>
      </div>

      <div id='pd-footer'>
        <span style='position: absolute;
                    left: 70%;
                    top:5px;'>
          <input type="button" class="btn btn-default" name="cancel" value="Cancel" 
                      onclick="javascript:hide_form('popup_background','popup_div')">
         <input type='submit' class="btn btn-primary" name='save' value='Save'>

        </span>
      </div>
    </form>
  </div>
</div>
