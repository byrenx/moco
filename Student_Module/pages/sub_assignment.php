<?php
   session_start();


   if(isset($_SESSION['stud_id']) && isset($_SESSION['scr_id'])){
     $title = $_SESSION['title'];
    include "../templates/header.php";
    include "../templates/c_title.php";
    include "../templates/side_bar.php";

    include "../components/sub_assignment_con.php";
   }
?>
     </center>
   </body>
</html>
