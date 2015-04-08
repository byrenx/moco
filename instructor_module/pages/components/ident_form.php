<div class="modal fade" id="ident_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Identification Item</h4>
      </div>
      <form id="ident_item"  class="form-horizontal" name="mp_item_form" action="javascript:au_iditem('ident_item')" method="post">

         <div class="modal-body">
             <p id="ident-alert"></p>
             <input type="hidden" id="action" name="action" value="add">
             <input type="hidden" id="target" name="target" value="item_ident">
             <input type="hidden" id="item_id" name="item_id" value="">
             <input type="hidden" id="test_id" name="test_id" value="<?php echo $test_id;?>">
             <input type="hidden" id="ident_item_id" name="ident_item_id" value="">
             <table class="table table-condensed table-bordered">
               <tr>  
                <th>Question</th>
                <td>
                      <textarea id="iq" name="question" class="form-control" onkeyup="return preview('#iq', '#iq_preview')" required></textarea>
                </td>
             </tr>
             <tr>
                <th>Preview</th>
                <td>
                    <p id="iq_preview" class="panel panel-default" style="min-height: 90px;padding: 10px;"></p>
                </td>
             </tr>
             <tr>
                 <th>Answer</th>
                 <td>
                    <input id="ident_ans" name="ans" type="text" class="form-control" onkeyup="return preview('#ident_ans', '#ident_ans_preview')" required>
                 </td>
             </tr>
             <tr>
                 <th>Preview</th>
                 <td>
                    <div id="ident_ans_preview" style="min-height: 30px;padding: 10px;"></div>
                 </td>
             </tr>
             <tr>
                <th>Points</th>
                <td>
                   <input type="text" id="points" class="form-control" name="points" maxlength="2" style="width:150px" onkeydown="return allNumbers(event)" value="1" required>
                </td>
             </tr>
           </table>
         </div> <!----/ .modal-body --->
         <div class="modal-footer">
             <button type="button" id="id_close" class="btn btn-default" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-primary">Save</button>
         </div>
       </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

