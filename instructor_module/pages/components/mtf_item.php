<div id="mtf-item-con">
   <!--- header --->
  <div id="pd-header">
     <span id="pd-header-title">
        Modified True or False Item
     </span>
     <span>
        <button type="button" id="mtf_close" class="close" aria-hidden="true"
                onclick="javascript:hide_form('popup_background','mtf-item-con')">&times;</button>
     </span>
  </div>

  <!-------content-form---->
  <div class="content">
     <p id="mtf-alert">
     </p>
   <form id="mtf_item" action="javascript:au_mtf('mtf_item')" method="post">
<!---     <form id="mtf_item" action="javascript:addUpdateMTFItem('mtf_item')" method="post">-->
          <input type="hidden" id="action" name="action" value="add">
          <input type="hidden" id="target" name="target" value="mtf_item">
          <input type="hidden" id="item_id" name="item_id" value="">
          <input type="hidden" id="test_id" name="test_id" value="<?php echo $test_id;?>">
          <input type="hidden" id="mtf_item_id" name="mtf_item_id" value="">
          </br>
          <table cellpadding="10" border="1" width="95%">
            <tr>
              <td valign="top" width="100"><label>Question</label></td>
              <td valign="top">
                  <textarea class="form-control" id="question" name="question" rows="3" required>
                  </textarea>
              </td>
            </tr>
          </table>
          </br>
          <table class="table">
            <tr>
               <td valign="top" width="100"><label>Answer</label></td>
               <td width="150">
                  <select id="ans_sel" name="ans_sel" class="form-control">
                     <option value="True" onclick="$('#ans_text').css('visibility','hidden');$('#ans_text').attr('required', 'false')">True</option>
                     <option value="False" onclick="$('#ans_text').css('visibility','visible');$('#ans_text').focus();$('#ans_text').attr('required', 'true')">Other</option>
                  </select>
               </td>
               <td>
                   <input style="visibility:hidden" class="form-control" type="text" id="ans_text" name="ans_text" placeholder="Please specify the answer">
               </td>
            </tr>
            <tr>
               <td width="100"><label>Points</label></td>
               <td><input type="text" id="points" class="form-control" name="points" style="width:50px" maxlength="4" onkeydown="return true" required></td>
            </tr>
          </table>
       <input type='submit' class="btn btn-primary" value="Save">
     </form>
  </div>
</div>