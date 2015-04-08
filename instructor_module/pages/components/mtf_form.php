<div class="modal fade" id="mtf_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modified True or False</h4>
      </div>
      <form id="mtf_item"  class="form-horizontal" name="mtf_item" action="javascript:au_mtf('mtf_item')" method="post">

         <div class="modal-body">
             <p id="mtf-alert"></p>
             <input type="hidden" id="action" name="action" value="add">
             <input type="hidden" id="target" name="target" value="mtf_item">
             <input type="hidden" id="item_id" name="item_id" value="">
             <input type="hidden" id="test_id" name="test_id" value="<?php echo $test_id;?>">
             <input type="hidden" id="mtf_item_id" name="mtf_item_id" value="">
             <table class="table table-bordered" width="95%">
               <tr>
                  <th width="100">Question</th>
                  <td>
                     <textarea class="form-control" id="mtfq" name="question" rows="3" onkeyup="return preview('#mtfq', '#mtfq_preview')" required></textarea>
                  </td>
               </tr>
               <tr style="background-color: rgb(240,240,240);">
                  <th>Question Preview</th>
                  <td>
                      <p id="mtfq_preview" class="panel panel-default" style="min-height: 80px;padding: 10px;"></p>
                  </td>
               </tr>
               <tr>
                  <th>Answer</th>
                  <td>
                     <select id="ans_sel" name="ans_sel" class="form-control">
                         <option value="True" onclick="$('#ans_text').css('visibility','hidden');$('#ans_text').attr('required', 'false')">True</option>
                         <option value="False" onclick="$('#ans_text').css('visibility','visible');$('#ans_text').focus();$('#ans_text').attr('required', 'true')">Other</option>
                    </select>
                  </td>
               </tr>
               <tr>
                 <th></th>
                 <td>
                      <input class="form-control" type="text" id="ans_text" name="ans_text" placeholder="Please specify the answer">
                 </td>
               </tr>
               <tr>
                  <th>Points</th>
                  <td><input type="text" id="points" class="form-control" name="points" style="width:100px" maxlength="4" onkeydown="return true" value="1" required></td>
               </tr>
            </table>

         </div> <!----/ .modal-body --->
     
         <div class="modal-footer">
             <button type="button" id="mtf_close" class="btn btn-default" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-primary">Save</button>
         </div>
       </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

