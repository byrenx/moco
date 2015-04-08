<script type="text/javascript">
   
   function validateInput(){
     var course_id = $('#cc').val();
     var desc = $('#cdesc').val();
     //var overview = $('#overview').val();
     var ccode = $("#ccode").val();//content of course code inout box
     var dept_name = $("#dept_name").val();//content of department input box
     var isComplete = true;
     var message = "<b>You must do the ff. to succesfully save a new course:</b></br>";
     
     if($("#c-type-hidden").val()==1){
	 var start = $("#start_date").val();
	 var end = $("#end_date").val();
	 if(!isValidDateFormat(start)){
     	     message+="*Input a valid start date format e.g 03/10/2015 </br>";
	     isComplete = false;
	 }

	 if(!isValidDateFormat(end)){
     	     message+="*Input a valid end date format e.g 03/05/2015 </br>";
    	     isComplete = false;
	 }

	 if(isValidDateFormat(start) && isValidDateFormat(end)){
	     if(compDate1toDate2(end, start)<1){
		 message+="*End date must not be before the start date.</br>";
		 isComplete = false;
	     }
	     if(!isLaterToday(start)){
		 message+="*Start date must not be before today.</br>";
		 isComplete = false;
	     }
	     if(!isLaterToday(end)){
		 message+="*End date must not be before today.</br>";
		 isComplete = false;
	     }
	 }
     }

     if($("#course_opt").val()==1){
	 if(emptyStr(ccode) || ccode.length<=0){
	     message+="* Fill out Course Code field</br>";
	     isComplete = false;
	 }
     }

     if($("#dept_opt").val()==1){
	 if(emptyStr(dept_name) || dept_name.length<=0){
     	     message+="* Fill out Department field</br>";
	     isComplete = false;
	 }
     }

     if(!isComplete){
       $('#msg').removeClass()
       .addClass('alert alert-danger')
       .html(message);
     }

     return isComplete;
   }

   
   $(function(){
       var ctype = $("#c-type-hidden").val();
       $("#start_date").datepicker();
       $("#end_date").datepicker();
       $("#ccode").hide();
       $("#dept_name").hide();
       $("#select-dept").hide();
       $("#select-link-ccode").hide();

       //course option is either 'create new'=1 or 'select'=0
       $("#course_opt").val("0");
       //department option is either 'create new'=1 or 'select'=0
       $("#dept_opt").val("0");
       
       if(ctype==0){
	  $("#div-start-date").hide();
	  $("#div-end-date").hide();
       }
       
   });

   function showDates(){
       $("#div-start-date").show();
       $("#div-end-date").show();
       $("#c-type-hidden").val(1);
   }

   function hideDates(){
       $("#div-start-date").hide();
       $("#div-end-date").hide();
       $("#c-type-hidden").val(0);
   }

   function showNewCCcde(){
       $("#ccode").show();
       $("#sel-ccode").hide();
       $("#create-link-ccode").hide();
       $("#select-link-ccode").show();

       //change course opt
       $("#course_opt").val("1");
   }

   function showNewDept(){
       $("#dept_name").show();
       $("#dept_select").hide();
       $("#create-dept").hide();
       $("#select-dept").show();
       
       //
       $("#dept_opt").val("1");
   }

   function showSelectCCode(){
       $("#sel-ccode").show();
       $("#ccode").hide();
       $("#select-link-ccode").hide();
       $("#create-link-ccode").show();

       //change course option
       $("#course_opt").val("0");
   }

   function showSelectDept(){
       $("#create-dept").show();
       $("#dept_select").show();
       $("#dept_name").hide();
       $("#select-dept").hide();
       //
       $("#dept_opt").val("0");
   }

</script>

<div class="container">

<!--page title-->
   <h2 class="header-title">
     <?php
       if($mode=="edit"){
 	 echo "Edit Course";   
       }else{
	 echo "Add Course";
       }

     ?>
   </h2>
<!--- end of page title ---->

   <div style="position:relative;left:0px;text-align: left; padding: 10px; width: 90%;">

<!------feedback container------>
      <div id='msg'
     <?php if(isset($_GET['status']) && urldecode($_GET['status'])=='duplicate entry'){
              echo 'class="alert alert-warning">';//class with closing tag for div msg
              echo '<b>You already had <em>'.urldecode($_GET['ccode']).'</em> in your dashboard!</b>
              </br> You can only add course which is not in your dashboard';
           }else if(isset($_GET['status']) && urldecode($_GET['status'])=='connect fail'){
              echo 'class="alert alert-warning">';
	      echo 'Transaction failed due to loss of network connection.!';
           }else{
               echo '>';
           }
     ?>
      </div>

<!----end of feedback container---->

<!---- add course form ------->
      <!---../../libraries/php/executeAction.php-->
      <form class="form-horizontal" role="form" action="../../libraries/php/executeAction.php" method="post" onsubmit="return validateInput()">
         <input type="hidden" name="action" value="<?php echo $mode; ?>">
         <input type="hidden" name="target" value="course">
         <input type="hidden" name="inst_id" value="<?php echo $_SESSION['inst_id'];?>">
         <input type="hidden" name="ic_id" value="<?php echo $instcourse_id;?>">
	 <!---course option---->
	 <input type="hidden" id="course_opt" name="course_opt" value=""/>
	 <!---department option---->
	 <input type="hidden" id="dept_opt" name="dept_opt" value=""/>
	 <!---course code---->
	 <input type="hidden" id="cc" name="cc" value="<?php if($mode=='edit'){echo $cc;}else{echo $course_table[0][0];}?>"/>
	 <input type="hidden" id="c-type-hidden" name="c_type_hidden" value="<?php echo $ctype;?>">
	 
	 <div class="form-group">

	   <label class="col-sm-2 control-label">Course Type</label>

	   <div class="form-group">
	     <div class="col-sm-4">
	       <div class="radio">
		  <label>
                  <?php if($ctype==1){?>
		               <input type="radio" id="oc" name="ctype" value="1" onclick="showDates()" checked='true'> Online Course
                   <?php }else{ ?>
		               <input type="radio" id="oc" name="ctype" value="1" onclick="showDates()"> Online Course
                   <?php }?>
		  </label>
	       </div>

	       <div class="radio">
		 <label>
		   <?php if($ctype==0){?>
		      <input type="radio" id="ocw" name="ctype" value="0" onclick="hideDates()" checked='true'> Open Courseware				       
                   <?php }else{ ?>
             	      <input type="radio" id="ocw" name="ctype" value="0" onclick="hideDates()"> Open Courseware				       
                   <?php }?>
		 </label>
	       </div>

	       <div class="radio">
		 <label>
		   <?php if($ctype==2){?>
		      <input type="radio" id="ococw" name="ctype" value="2" onclick="showDates()" checked='true'> Both OpenCourseware and Online Course				       
                   <?php }else{ ?>
             	      <input type="radio" id="ococw" name="ctype" value="2" onclick="showDates()"> Both OpenCourseware and Online Course				       
                   <?php }?>
		 </label>
	       </div>

	     </div>
	   </div>
	 </div>

         
	 <!--start date field--->

	 <div id="div-start-date" class="form-group">
	    <label class="col-sm-2 control-label">Date Start</label>
	    <div class="col-sm-4">
              <input type="text" id="start_date" name="start_date" class="form-control" placeholder="mm/dd/yyyy" value="<?php echo $start_date;?>"/>
	    </div>
	 </div>

	 <!--date end field--->         

         <div id="div-end-date" class="form-group">
	    <label class="col-sm-2 control-label">Date End</label>
	    <div class="col-sm-4">
              <input type="text" id="end_date" name="end_date" class="form-control" placeholder="mm/dd/yyyy" value="<?php echo $end_date;?>"/>
	    </div>
	 </div>

	 <!--course code text box--->

         <div class="form-group">
           <label class="col-sm-2 control-label">Course Code</label>
	   <div class="col-sm-4">
	       <select class="form-control" id="sel-ccode" onchange="$('#cdesc').val(this.options[this.selectedIndex].value);$('#cc').val(this.options[this.selectedIndex].text);" <?php echo $disabled;?> />
	       <?php    
	  	 foreach($course_table as $ct){
		   if($ct['course_id']==$cc){
		     echo "<option value='{$ct['course_desc']}' selected='true'>{$ct['course_id']}</option>"; 
		   }else{
		     echo "<option value='{$ct['course_desc']}'>{$ct['course_id']}</option>";
		   }
                 }
                ?>
	       </select>
	     
	     <input type="text" id="ccode" name="ccode" class="form-control" placeholder="New Course Code here"/>
	     
	   </div>

	   <!---add course--->
	   <div class="col-sm-3">
	     <?php if($mode!='edit'){ ?>
	     <a id="create-link-ccode" class="btn btn-link" href="javascript:showNewCCcde()"> 
	       <span class="glyphicon glyphicon-plus"></span>
	       Create
	     </a>
	     <?php } ?>

	     <a id="select-link-ccode" class="btn btn-link" href="javascript:showSelectCCode()"> 
	       <span class="glyphicon glyphicon-hand-up"></span>
	       Select
	     </a>	     

           </div>
         </div>

	 <!--course title field--->

         <div class="form-group">
           <label class="col-sm-2 control-label">Description</label>
	   <div class="col-sm-8">
             <input type="text" id="cdesc" name="cdesc" class="form-control" 
                   value="<?php if($mode=='edit'){
                                   echo $desc;
                                }else{ 
                                   if (isset($course_table[0][1])){
                                      echo $course_table[0][1];
                                   }
                                }?>"/>
	   </div>
         </div>
      
         <div class="form-group">
           <label class="col-sm-2 control-label">Course Overview</label>
	   <div class="col-sm-8">
             <textarea class="form-control" id="overview" name="overview" rows="4"><?php echo $ov;?></textarea>
	   </div>
         </div>

<!---         <div class="form-group">
           <label class="col-sm-2 control-label">Department</label>
	   <div class="col-sm-4">
             <select class="form-control" id="dept_select" name="dept">
	       <?php
	         foreach($dept->getAllDept() as $da){
                    echo "<option value={$da['id']} ";
		    if ($dpt==$da['id']){
		      echo "selected";
		    }
                    echo ">{$da['name']}</option>";
		 }
	       ?>
             </select>
	     <input type="text" id="dept_name" name="dept_name" class="form-control" placeholder="Type New Deparment here.."/>
	   </div>--->

	   <!---add department--->

<!---	   <div class="col-sm-4">
	     <a id="create-dept" class="btn btn-link" href="javascript:showNewDept()"> 
	       <span class="glyphicon glyphicon-plus"></span>
	       Create
	     </a>	     

	     <a id="select-dept" class="btn btn-link" href="javascript:showSelectDept()"> 
	       <span class="glyphicon glyphicon-hand-up"></span>
	       Select
	     </a>	     

           </div>
         </div>--->

         <!---submit button--->
	 <div class="form-group">
	   <div class="col-sm-offset-2 col-sm-10">
	     <button type="submit" class="btn btn-primary">Save</button>
	   </div>
	 </div>
         
      </form>
   </div>

  
   <!--<div id="add_course_form">
     <form id="c_form" action="../../libraries/php/executeAction.php" method="post" onsubmit="return hasDup('c_form')">
          "../../libraries/php/executeAction.php"

   
            <div class='alert alert-info'>
	      <b>Reminders </b>Select the course you want to teach or 
              type the course code and description of the course if it is not
              on the list.</br>
              Also fill in the required fields mark with an askterisk(*)
              </br></br>
            </div>
              
	    <div id="form_el">
               course type
                <b>Select a Course Type</b> 
               </br>
               <label>
                 <input type='radio' name='ctype' value='1' checked="<?php echo ($ctype==1);?>">
		Online Course (Available to students who has provided with a coursekey)
               </label>
               <label>
                 <input type='radio' name='ctype' value='0' checked="echo ($ctype==0);?>">
		OpenCourseware (Open to All students, no course key is needed)
               </label>
            </br>
		<label>*Course Code</label>
                 <input style="position:absolute;top: 117px;left:0px;width:179px"
                        type="text" id="cc" name="cc" 
                       value="<?php echo $cc;?>" 
                       placeholder="Course Code">
                <select onchange="$('#cc').val(this.options[this.selectedIndex].text);$('#cdesc').val(this.options[this.selectedIndex].value);"
                       >
                  <?php
	  	              foreach($course_table as $ct){
		                   echo "<option value='{$ct['course_desc']}'>{$ct['course_id']}</option>";
                    }
                  ?>
                </select>
               
	     </div>
		<div id="form_el"> 
		   <label>*Course Description</label>
	       <input type="search" id="cdesc" name="cdesc"
                      value="<?php echo $desc;?>"
                       placeholder="Course Description"
                      style='width:600px;'>
		</div>
		
		<div id="form_el">  
		    <label>*Course Overview</label>
		    <textarea id="overview" name="overview" style="width: 600px;height:150px;" 
                              placeholder="Course Description">
	               <?php echo $ov;?>
		    </textarea>
		</div>
		
		<div id="form_el">
		    <label>Department</label>
		    <select id="dept" name="dept">
		      <?php
	                foreach($dept->getAllDept() as $da){
		          echo "<option value={$da['id']} selected='";
                          echo ($dpt==$da['id']);
                          echo "'>{$da['name']}</option>";
			}
		      ?>
		    </select>
		</div>
		
		<div id="form_el">
		  <input class="btn btn-primary" type="submit" id="addc" name="addc" value="Save">
		  </br>
		  </br>
		</div>
	 </form>
   </div>---->
</div>
