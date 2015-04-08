<center>
<div id='popup_background'></div>

<div id='popup_div'>

  <div id='pd-header'>  
     <span id="pd-header-title"> Un Enroll 
      </span>
     <span>
        <button type="button" class="close" aria-hidden="true" 
                onclick="javascript:hide_form('popup_background','popup_div')">&times;</button>
     </span>
  </div>
<?php

  echo "<form  id='UN' action='../../libraries/php/executeAction.php' method='post'>";
  echo  "<input type='hidden' name='std_id' value='{$_SESSION['stud_id']}'>";
  echo  "<input type='hidden' id='scr_id' name='scr_id' value=''>";
  echo  "<input type='hidden' name='action' value='Unenroll'>";
// echo "<input type='text' id='SCK' value='' name='SCK'>";
     ?>
<div id="Prompt">Are you Sure to Un Enroll
  <p id="DashCourse"> </p>
</div>
<p class='panel panel-warning'>Note: If you have already taken a quiz, exam, or assignment. You can no longer Un Enroll from this course.</p>
   <div id='pd-footer'>
       <span style='position: absolute;
                    left:70%;
                    top: 60%'>
          <input type="button" class="btn btn-default" name="cancel" value="Cancel"
                onclick="javascript:hide_form('popup_background','popup_div')">
         <input type="submit" class="btn btn-danger"  name='enter' value='Yes'>
    
       </span>

   </div>
   </form>
   </div></center>