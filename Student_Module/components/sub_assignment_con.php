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

<div id='popup_div' style="display: block; left:450px; top:200px">
  
  <div id='pd-content'>

    <div id="alert"></div>
 
    <form class="form" id="addupdate_ass" action="../../libraries/php/executeAction.php" 
        enctype="multipart/form-data" method="post" onsubmit="return true">
        <input type="hidden" id="action" name="action" value="SubmitAss">
	
	<input type="hidden" id="ic_id" name="scr_id" value="<?php echo $_SESSION['studC_id'];?>">
	<input type="hidden" id="assign_id" name="assign_id" value="<?php echo $_POST['assignID'];?>">
	  
	<div class="form-group">
   <label>Submit only the following file types: <small>.doc(x), .pdf, .txt</small></label>
        </div>
        <div class="form-group">
          <input type="hidden" name="MAX_FILE_SIZE" value="41943040"/>
          <input type="file" name="f_attach" />
        </div>
   </div>
   <div id='pd-footer'>
       </br>
       <span style='position: absolute;
                    left: 70%;
                    top:5px;'>
         <input type="submit" class="btn btn-primary"  name='submit' value='Submit'>
       </span>
   </div>
   </form>
</div>
