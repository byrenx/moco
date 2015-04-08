<?php

	      echo "<ul class'user'>";
	      echo "<li>".$_SESSION['student_name']."</li>";
	      echo "</ul>";
	      echo "<div style='position: fixed; left: 80%;z-index:500; 
                    background-color: rgba(0,0,0,.3)'>
              <h3> Time Remaining: 
	      <span id='countdown'> 00:00:00:00 </span></h3>
              
              <form id='example2form' method='POST'>
                 <input type='hidden' id='stipTime' name='stipTime' value='$init_time' />
<input type='hidden' id='testID' name='testID' value='$testID' />
              </form>
              </div>";
	      echo "<script type='text/javascript' src='../javascript/Qtimer.js'></script>";




?>