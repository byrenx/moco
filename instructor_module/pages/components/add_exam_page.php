<script>
$(function(){
    $("#da").datepicker();
    $("#dd").datepicker();
  });
</script>
<script type='text/javascript' src='../../instructor_module/javascript/test.js'></script>

<div id='about_cont_con'>  
     <div id="about_hdr">
        <span class="h3"> Add Exam </span>
        <a href="exam.php">
  <span class='glyphicon glyphicon-backward'></span>&nbsp;Go Back to Exams
         </a>
     </div> 
     <div id='sub-content'>
        <?php if (isset($_GET['status']) && $_GET['status']=='ok'){?>
          <div class="alert alert-success">
	     <?php if($get_action=='add' && $get_status=='ok'){
	              echo '<b>New Exam succesfully added!</b>';
	           }
	           if($get_action=='edit' && $get_status=='ok'){
	              echo '<b> Exam Info was succesfully updated!</b>';
	           }
             ?>
	     
          </div>
	     <?php }else if(isset($_GET['status']) && $_GET['status']=='fail'){ ?>
	  <div class="alert alert-danger">
             Adding new Exam failed					          </div>								  
	     <?php }else{ ?>
			<div id='msg'></div>
	     <?php }?>
	
<?php if($get_action=='add' || $get_action=='edit' && $get_status=='ok'){?>
<?php }else{?> 							
        <form id='addquiz' method='post' 
              role="form" action="../../libraries/php/exec_controller.php"
	      style='width:60%; margin: 20px 20px 40px 20px;' 
              onsubmit="return form.validate()"> 
             <input type='hidden' id='icr_id' 
                    name='icr_id' 
                    value="<?php echo $_SESSION['icr_id']?>">  
             <input type='hidden' id='action' name='action' value='<?php echo $action; ?>'>
             <input type='hidden' id='target' name='target' value='exam'>
             <input type='hidden' id='test_id' name='test_id' value='<?php echo $test_id; ?>'>
             <input type="hidden" id="ttype" name="ttype" value="1">
      
   
             <div class="form-group">
                  <label>Exam Title</label>
                  <input type="text" id="q_title" value='<?php echo $q_title; ?>'
                        name="q_title" class="form-control"/>
            </div>

            <div class="form-group">
	     <label>Date Available</label>
	     <input type="text" id="da" name="da" value='<?php echo $date_avail;?>'
	     class="form-control" style='width: 250px;'/>
	     </div>
	     
	     <div class="form-group">
    	        <label>Due Date</label>

	        <input type="text" id="dd" name="dd" value='<?php echo $date_due;?>'
	        class="form-control" style='width: 250px;'/>
	     </div>
	     
	     <div class="form-group">
	         <input type='hidden' id="utt" value="0">
	     <label><input type="radio" id="untime" name="time" value="0" onclick="untimed()" <?php if($duration==-1) echo 'checked';?>>&nbsp;Untimed </label>&nbsp;
<label><input type="radio" id="time" name="time" value="1" onclick="timed()" <?php if($duration>-1) echo 'checked';?>>&nbsp;Timed</label>&nbsp;
	         <input type="text" id="duration" name="duration" placeholder="Time Limit in Minutes" value="<?php if($duration>-1)echo $duration; ?>" 
      	         class="form-control" onkeydown="return allNumbers(event);"
	         maxlength="3" style='width: 200px;<?php if($duration>0){ echo "display:block;"; }else{ echo "display:none;";}?>'/>
	     </div>

	     
	     <input type="submit" class="btn btn-primary" 
	     name='save' value='Save'>
	     &nbsp;
     </form>			  
<?php }?>
</div>
