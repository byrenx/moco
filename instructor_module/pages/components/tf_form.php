<div class="modal fade" id="tf_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">True or False Item</h4>
      </div>
      <form id="tf_item"  class="form-horizontal" name="tf_item" action="javascript:au_tf('tf_item')" method="post" onsubmit="return isValidPoints('tf_item');">

         <div class="modal-body">
             <p id="tf-alert"></p>
             <input type="hidden" id="action" name="action" value="add">
             <input type="hidden" id="target" name="target" value="item_tf">
             <input type="hidden" id="item_id" name="item_id" value="">
             <input type="hidden" id="test_id" name="test_id" value="<?php echo $test_id;?>">
             <input type="hidden" id="tf_item_id" name="tf_item_id" value="">
             <table class="table table-condensed table-bordered">
                <tr>
                   <th>Question</th>
                   <td>
                       <textarea id="tfq" name="question" class="form-control" onkeyup="return preview('#tfq', '#tfq_preview')" required></textarea>
                   </td>
                </tr>
                <tr>
                   <th>Preview</th>
                   <td>
                       <p id="tfq_preview" class="panel panel-default" style="min-height: 90px;padding: 10px;"></p>
                   </td>
                </tr>
                <tr>
                   <th>Answer</th>
                   <td>
                      <select id="ans" name="ans" class="form-control">
                        <option value="1">True</option>
                        <option value="0">False</option>
                      </select>
                   </td>
                </tr>
                <tr>
                  <th></th>
                  <td>
                     <div id="tfqa_preview"></div>
                  </td>
                </tr>
                <tr>
                    <th>Points</th>
                    <td>
                       <input type="text" id="points" class="form-control" name="points" maxlength="2" style="width:50px" onkeydown="return allNumbers(event)" value="1" required>
                    </td>
                </tr>
             </table>
         </div> <!----/ .modal-body --->
         <div class="modal-footer">
             <button type="button" id="tf_close" class="btn btn-default" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-primary">Save</button>
         </div>
       </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

