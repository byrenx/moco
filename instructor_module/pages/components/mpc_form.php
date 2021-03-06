<div class="modal fade" id="mpc_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Multiple Choice Item</h4>
      </div>
      <form id="mp_item_form"  class="form-horizontal" name="mp_item_form" action="javascript:au_mpitem('mp_item_form')" method="post" onsubmit="return validateMPItem();">

         <div class="modal-body">
             <p id="mp-alert"></p>
             <input type="hidden" id="test_id" name="test_id" value="<?php echo $test_id;?>">
             <input type="hidden" id="item_id" name="item_id" value="">
             <input type="hidden" id="action" name="action" value="add">
             <input type="hidden" id="target" name="target" value="item_mp">
             <table class="table table-bordered table-condensed">
             <tr>
                <th>Question</th>
                <td>
                     <textarea id="mpcq" name="question" class="form-control" onkeyup="return mpcq_preview()" required></textarea>
                </td>
             </tr>
             <tr style="background-color: rgb(240,240,240)">
                <th width="100">Question Preview</th>
                <td>
                    <p id="mpcq_preview" class="panel panel-default" style="min-height: 90px;padding: 10px;"></p>
                </td>
             </tr>
             <tr>
               <th colspan="2">Choices</th>
             </tr>
             <tr>
                <th> A </th>
                <td>
                    <input type="hidden" id="c1" name="c1" value="">
                    <input type="text" id="a" name="a" class="form-control" onkeyup="return preview('#a', '#a_preview')" required>
                </td>
             </tr>
             <tr><!--- A preview --->
                <th></th>
                <td>
                    <div id="a_preview" style="min-height: 30px;padding: 10px;"></div>
                </td>
             </tr><!---/ A preview --->
             <tr>
                <th> B </th>
                <td>
                   <input type="hidden" id="c2" name="c2" value="">
                   <input type="text" id="b" name="b" class="form-control" onkeyup="return preview('#b', '#b_preview')" required>
                </td>  
             </tr>
             <tr><!-----B preview--->
                <th></th>
                <td>
                    <div id="b_preview" style="min-height: 30px;padding: 10px;"></div>
                </td>
             </tr><!-----/. B preview --->
      
             <tr>
                <th> C </th>
                <td>
                   <input type="hidden" id="c3" name="c3" value="">
                   <input type="text" id="c" name="c" class="form-control" onkeyup="return preview('#c', '#c_preview')" required>
                </td>
             </tr>
             <tr><!-----C preview--->
                <th></th>
                <td>
                    <div id="c_preview" style="min-height: 30px;padding: 10px;"></div>
                </td>
             </tr><!-----/. C preview --->
             <tr>
                <th> D </th>
                <td>
                   <input type="hidden" id="c4" name="c4" value="">
                   <input type="text" id="d" name="d" class="form-control" onkeyup="return preview('#d', '#d_preview')" required>
                </td>
             </tr>
             <tr><!-----D preview--->
                <th></th>
                <td>
                    <div id="d_preview" style="min-height: 30px;padding: 10px;"></div>
                </td>
             </tr><!-----/. D preview --->


             <tr>
                <th>Answer</th>
                <td>
                   <select id="ans" name="ans" class="form-control">
                       <option value="a">A</option>
                       <option value="b">B</option>
                       <option value="c">C</option>
                      <option value="d">D</option>
                   </select>
                </td>
              </tr>
              <tr>
                 <th>Points</th>
                 <td>
                    <input type="text" id="points" class="form-control" name="points" maxlength="2" style="width:100px" onkeydown="return allNumbers(event)" value="1" required>
                 </td>
             </tr>
           </table>
         </div> <!----/ .modal-body --->
         <div class="modal-footer">
             <button type="button" id="mp_close" class="btn btn-default" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-primary">Save</button>
         </div>
       </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

