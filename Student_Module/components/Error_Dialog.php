<?php
  echo "<div style='display:none'>

     <form id='{$_SESSION['CourseID']}' action='javascript:showErrorDg(\"popup_background\",\"popup_div\",\"{$_SESSION['CourseID']}\");' method='post'>

          <input type='hidden' id='mode' value='err'>
	   <input type='hidden' id='ic_id' value='{$_SESSION['CourseID']}'>
           <input type='hidden' id='Course_cor' value='{$_SESSION['CourseName']}'>
        {$_SESSION['CourseName']}
          <input type='submit' name='add' id='formButton'
                 onclick='javascript:$('#action').val('err')'>
       </form>
  
         
  </div>
";

?>