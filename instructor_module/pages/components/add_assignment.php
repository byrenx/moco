<script type="text/javascript">
   $(function(){
       $("#da").datepicker();
       $("#dd").datepicker();       
     });
/*
   function validate(){
     var title = $("#q_title").val();
     var da = $("#da").val();//date available
     var dd = $("#dd").val();//due date
     var duration = $("#duration").val();
     var ok = true;
     var message = "";

     if(emptyStr(title) || title.length<0){
       message+="Please Input quiz title\n";
       ok = false;
     }
     if(!isValidDateFormat(da)){
       message+="Date Available must be a valid date in a format like 07/01/2013";
       ok = false;
     }
     if(!isValidDateFormat(dd)){
       message+="Due date must be a valid date in a format like 07/01/2013";
       ok = false;
     }
     return ok;
     }*/
</script>

<div id='popup_div'>
  <div id='pd-header'>  
     <span id="pd-header-title">Add Assignment</span> 
     <span>
        <button type="button" class="close" aria-hidden="true" 
                onclick="javascript:hide_form('popup_background','popup_div')">&times;</button>
     </span>
  </div>

  <div id='pd-content'>

    <div id="alert"></div>
 
    <form class="form" id="addupdate_ass" action="../../libraries/php/exec_controller.php" 
        enctype="multipart/form-data" method="post" onsubmit="return true">
        <input type="hidden" id="action" name="action" value="add">
	<input type="hidden" id="target" name="target" value="assignment">
	<input type="hidden" id="ic_id" name="ic_id" value="<?php echo $_SESSION['icr_id'];?>">
	<input type="hidden" id="assign_id" name="assign_id" value="">
	  
	<div class="form-group">
          <label>
            Title
          </label>
          <input type='text' class="form-control" required='true' id='ann_title' name='ann_title' value='' style='width: 95%'/>
        </div>
	<div class="form-group">
          <label>Instruction</label>
          <textarea class="widgEditor nothing" id="id_instruction" name="instruction"></textarea>
        </div>
        <div class="form-group">
          <label>Attachment</label>
   <p>Attach only valid file types like .pdf, .doc(x), .txt </p>
          <input type="hidden" name="MAX_FILE_SIZE" value="41943040"/>
          <input type="file" name="f_attach" />
        </div>
   </div>
   <div id='pd-footer'>
       </br>
       <span style='position: absolute;
                    left: 70%;
                    top:5px;'>
         <input type="submit" class="btn btn-primary"  name='save' value='Save'>
       </span>
   </div>
   </form>
</div>
