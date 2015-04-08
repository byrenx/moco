<div id="tf-item-con">
   <!--- header --->
  <div id="pd-header">
     <span id="pd-header-title">
        New True or False Item
     </span>
     <span>
        <button type="button" id="tf_close" class="close" aria-hidden="true"
                onclick="javascript:hide_form('popup_background','tf-item-con')">&times;</button>
     </span>
  </div>

  <!-------content-form---->
  <div class="content">
     <div id="tf-alert">
     </div>

     <form id="tf_item" action="javascript:au_tf('tf_item')" method="post" onsubmit="return isValidPoints('tf_item');">

     <!---<form id="tf_item" action="javascript:addUpdateTFItem('tf_item')" method="post" onsubmit="return isValidPoints('tf_item');">-->

          <input type="hidden" id="action" name="action" value="add">
          <input type="hidden" id="target" name="target" value="item_tf">
          <input type="hidden" id="item_id" name="item_id" value="">
          <input type="hidden" id="test_id" name="test_id" value="<?php echo $test_id;?>">
          <input type="hidden" id="tf_item_id" name="tf_item_id" value="">

          <label>Question</label></br>
          <textarea id="question" name="question" class="form-control" required="true"></textarea>
          </br>
          <label>Answer</label>
          <select id="ans" name="ans">
            <option value="1">True</option>
            <option value="0">False</option>
          </select>
          <label>Points</label>
          <input type="text" id="points" name="points" style="width:50px;" maxlength="3" required="true" value="">
          </br></br>
       <input type='submit' class="btn btn-primary" value="Save">
     </form>
  </div>
</div>
