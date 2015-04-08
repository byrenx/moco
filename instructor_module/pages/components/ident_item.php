<div id="ident-item-con">
   <!--- header --->
  <div id="pd-header">
     <span id="pd-header-title">
       Identification Item
     </span>
     <span>
        <button type="button" id="id_close" class="close" aria-hidden="true"
                onclick="javascript:hide_form('popup_background','ident-item-con')">&times;</button>
     </span>
  </div>

  <!-------content-form---->
  <div class="pd-content">
     <p id="ident-alert">
     </p>
     <form id="ident_item" class="form-horizontal" role="form" action="javascript:au_iditem('ident_item')" method="post">
          <input type="hidden" id="action" name="action" value="add">
          <input type="hidden" id="target" name="target" value="item_ident">
          <input type="hidden" id="item_id" name="item_id" value="">
          <input type="hidden" id="test_id" name="test_id" value="<?php echo $test_id;?>">
          <input type="hidden" id="ident_item_id" name="ident_item_id" value="">

          <table class="table">
            <tr>
              <td valign="top" width="100"><label>Question</label></td>
              <td valign="top">
                  <textarea class="form-control" id="question" name="question" rows="3" cols="10" required></textarea>
              </td>
            </tr>
          </table>
          <table class="table">
            <tr>
               <td valign="top" width="100"><label>Answer</label></td>
               <td valign="top">
                  <input id="ans" name="ans" type="text" class="form-control" />
               </td>
            </tr>
            <tr>
               <td width="100"><label>Points</label></td>
               <td><input type="text" class="form-control" id="points" name="points" style="width:50px" maxlength="4" onkeydown="return true" required></td>
            </tr>
         </table>
         <div id="pd-footer">
             <span style='position: absolute;left: 70%;top:10px;'>
               <input type='button' class="btn btn-default" value="Cancel">
               <input type='submit' class="btn btn-primary" value="Save">
             </span>
         </div>
     </form>
  </div>
</div>