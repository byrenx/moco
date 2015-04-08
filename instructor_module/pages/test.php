<?php
include '../template/header.php';
include '../../libraries/php/sanitizer.php';
?>
  <div style='position: absolute; top: 200px; width: 100%;'>
    <nav>
    <ul>
      <li>
        <a href='#'>Link 1</a>
        <ul>
          <li>Download</li>
          <li>Remove</li>
        </ul>
      </li>
      <li>
        <a href='#'>Link 2</a>
         <ul>
          <li>Download</li>
          <li>Remove</li>
        </ul>
      </li>
      <li>
        <a href='#'>Link 3</span>
        </a>
        
         <ul>
          <li><a href='#'>Download</a></li>
          <li><a href='#'>Remove</a></li>
        </ul>
      </li>
      <li>
        <a href='#'>Sample 1</a>
      </li>
      <li>
        <a href='#'>Sample 2</a>
      </li>
    </ul>
    </nav>
  </div>

  <div style='position: relative; top:180px;'>
     <?php
  if(isset($_POST)){
    $input1 = $_POST['text'];
    echo "$input1";
  }
     ?>

    <form action='test.php' method='post'>
      <textarea name='text' cols='5' rows='5'>
        
      </textarea>
      <input type='submit' value='submit'>
    </form>
  </div>
</body> 
</html>