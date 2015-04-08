<div class="mp-item-con">
  <!--- header --->

  <div class="hdr">Quiz item 1</div>
  <!--- content --> 
  <div class="content">
    <form id="mp_item_form" action="javascript:addQuizItem('mp_item_form')">
      <input type='hidden' id='test_id' name='test_id' value=''>
      <input type='hidden' id='action' name='action' value='add'>
      <input type='hidden' id='target' name='target' value='item_mp'>

      <label>Question</label>
      <textarea name='question' class='text'></textarea>
      <label>Answer: </label>
      <select>
         <option>A</option>
         <option>B</option>
         <option>C</option>
         <option>D</option>
      </select>
      <label>Choices: </label>
     
       A <input type="text" class="form-control" placeholder='A'></br>
       B <input type="text" class="form-control" placeholder='B'></br>
       C <input type="text" class="form-control" placeholder='C'></br>
       D <input type="text" class="form-control" placeholder='D'></br>
       <input type='submit' class='btn btn-primary' value='Save'>
    </form>
  </div>
</div>
</br>
</br>