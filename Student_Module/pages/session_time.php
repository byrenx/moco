<?php
   session_start();
   $current_time = $_GET['current_time'];
   $testID = $_GET['test_id'];
   
   $_SESSION['time_remain_'.$testID] = $current_time;
   echo $current_time;
?>