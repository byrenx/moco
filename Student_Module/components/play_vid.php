
<div id='popup_div'>
  <div id='pd-header'>  
     <span style='position:absolute;
                  left: 10px;
                  top: 5px;
                  '>New Quiz Details</span>
  </div>

  <div id='pd-content'>
    <form id='addquiz' action="javascript:addQuiz('addquiz')"> 
      <table>
	<tr>
          <td>
	  <label> Quiz Title </label>
          </td>
          <td>
	  <input type='text' name='q_title' style='width:250px;'>
          </td>
	</tr>

        <tr>
          <td>
	  <label> Due Date </label>
          </td>
          <td>
	  <input type='text' id='dd' name='dd' style='width:250px;'>
          </td>
	</tr>

        <tr>
          <td>
	  <label> Date Available </label>
          </td>
          <td>
	  <input type='text' id='da' name='da' style='width:250px;'>
          </td>
	</tr>
     </table>

     <div id='pd-footer'>
       <span style='position: absolute;
                    left: 70%;
                    top:5px;'>
         <input type='submit' name='save' value='Save'>
         <input type='button' name='cancel' value='Cancel' onclick="javascript:hide_form('popup_background','popup_div')">
       </span>
     </div>
    </form>
  </div>
</div>
