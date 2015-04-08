
<div id="mp-item-con">
  <!--- header --->

  <div id="pd-header">
     <span id="pd-header-title">
        New Multiple Choice Item
     </span>
     <span>
        <button type="button" id="mp_close" class="close" aria-hidden="true" onclick="javascript:hide_form('popup_background','mp-item-con')">&times;</button>
     </span>
  </div>

  <!--- content --> 
  <div class="content">
     <p id="mp-alert"></p>
   
    <form id="mp_item_form"  class="form-horizontal" name="mp_item_form" action="javascript:au_mpitem('mp_item_form')" method="post" onsubmit="return validateMPItem();">


<!---    <form id="mp_item_form" name="mp_item_form" action="javascript:addUpdateMPItem('mp_item_form')" method="post" onsubmit="return validateMPItem();">-->
      <input type="hidden" id="test_id" name="test_id" value="<?php echo $test_id;?>">
      <input type="hidden" id="item_id" name="item_id" value="">
      <input type="hidden" id="action" name="action" value="add">
      <input type="hidden" id="target" name="target" value="item_mp">

      <label>Question</label></br>
      <textarea id='question' name='question' class='form-control' required></textarea></br>
      <div class="form-group">
          <label>Preview</label>
          <textarea id="mp_preview"></textarea>
      </div>

      <label>Choices:</label></br>
       <div class="form-group">
          <label class="col-sm-1"> A </label>
          <div class="col-sm-11">
            <input type="hidden" id="c1" name="c1" value="">
            <input type="text" id="a" name="a" class="form-control" required>
          </div>
       </div>
       <div class="form-group">
          <label class="col-sm-1"> B </label>
          <div class="col-sm-11">
             <input type="hidden" id="c2" name="c2" value="">
             <input type="text" id="b" name="b" class="form-control" required>
          </div>  
       </div>        
       <div class="form-group">
          <label class="col-sm-1"> C </label>
          <div class="col-sm-11">
             <input type="hidden" id="c3" name="c3" value="">
             <input type="text" id="c" name="c" class="form-control" required>
          </div>
       </div>
       <div class="form-group">
          <label class="col-sm-1"> D </label>
          <div class="col-sm-11">
            <input type="hidden" id="c4" name="c4" value="">
            <input type="text" id="d" name="d" class="form-control" required>
          </div>
       </div>
       <div class="form-group">
          <label class="col-sm-2">Answer</label>
          <div class="col-sm-3">
              <select id="ans" name="ans" class="form-control">
                 <option value="a">A</option>
                 <option value="b">B</option>
                 <option value="c">C</option>
                 <option value="d">D</option>
              </select>
          </div>
          <label class="col-sm-1">Points</label>
          <div class="col-sm-3">
              <input type="text" id="points" class="form-control" name="points" maxlength="2" style="width:50px" onkeydown="return allNumbers(event)" required>
          </div>
       </div>
        <input type='submit' class='btn btn-primary' value='Save'>
    </form>
  </div>
</div>
</br>
</br>