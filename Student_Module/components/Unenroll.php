
<?php
 echo "     <form id='{$course['ic_id']}' action='javascript:showUnEnrollDg(\"popup_background\",\"popup_div\",\"{$course['ic_id']}\");' method='post'>

          <input type='hidden' id='mode' value='Unenroll'>
	   <input type='hidden' id='ic_id' value='{$course['ic_id']}'>
          <input type='hidden' id='Co_id' 
           value='{$course['course_id']}'>
          <button type='submit' name='add' class='btn btn-danger' onclick='javascript:$('#action').val('add')'><span class='glyphicon glyphicon glyphicon-remove-sign'></span> Un Enroll</button>
       </form>
";

?>