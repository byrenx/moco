<!--- content--->
 <div id="about_cont_con">
   <!---header-->
   <div id="about_hdr">
     <span class="h3">
       Course Announcement
     </span>
     <span style="position: absolute;left: 320px; top: 2px;">
       <form id='addfrm' action="add_announcement.php">
<!--   action="javascript:showAddAnnDg('popup_background','popup_div');" method="post">-->
          <input type="hidden" id="mode" value="add">
          <input type="hidden" id="icr_id" value="<?php echo $_SESSION['icr_id'];?>" >
          <button type="submit" name="add" class="btn btn-primary" value="Add Announcement"
                 onclick="javascript:clearAnnouncementText()">
            <span class="glyphicon glyphicon-plus-sign"></span>
            Add Announcement
          </button>
       </form>
     </span>
   </div>
   <?php if(!empty($anns)){?>
       <div class='ann_browser'>
	  <label>Announcement Browser</label>
         <?php echo "<input type='hidden' id='d_stat' value='1'>";
	       echo "<div>";
               echo "<select id='go_ann' class='form-control' onchange='sat()'>";
               foreach($anns as $ca){
	         echo "<option value='#{$ca['ann_id']}'>{$ca['title']}</option>";
               }
               echo "</select>";
               echo "</div>"; ?>
       </div>
   <?php }else{?>
       <div class='ann_browser' style='display:none'>
       <label>Announcement Browser</label>
	  <input type='hidden' id='d_stat' value='0'>
          <div>
	    <select id='go_ann' class='form-control' onchange='sat()'></select>
          </div>
       </div>
   <?php }?>

    <!---display announcement--->
   <div id="sub-content">
    <?php
    if(!empty($anns)){

      foreach($anns as $ca){
         $dp = new DateTime($ca['date_posted']);

	 if($ca['date_edited']=='0000-00-00 00:00:00'){
	   $de = 'Not Yet Edited!'; 
         }else{
	   $de = new DateTime($ca['date_edited']);
	   $de = $de->format('F, j, Y, g:i a');
         }

	 print "<div class='ca_ann_con' id='".$ca['ann_id']."'>";
	    //announcement date
	    print "<div id='ca_date_con'>";
	      print "<span id='ca_date_cont'>";
	        
	 print "<span class='glyphicon glyphicon-calendar'>&nbsp;</span><b>Date Posted : </b>".$dp->format("F, j, Y, g:i a");
	      print "&nbsp;|&nbsp;<span class='glyphicon glyphicon-calendar'></span>&nbsp;<b>Date Edited: </b>".$de."</span>";
	    print "</div>";
	  //announcement content
	    print "<h2>{$ca['title']}</h2>";
	    print "<div id='ca_content'>";
	      print "{$ca['ann_stmt']}";
	 //print $ca['ann_stmt'];
	    print "</div>";
	    print "<div id='ca-edit-pane'>";
	      print "<form id='".$ca['ann_id']."' 
                       action='javascript:showUpdateDelAnnDg(\"popup_background\",\"popup_div\", \"".$ca['ann_id']."\");'
                       method='post'>";
	        print "<input type='hidden' id='action' name='action' value='edit'>";
	        print "<input type='hidden' name='target' value='announcement'>";
	        print "<input type='hidden' id='ann_id' name='ann_id' value='".$ca['ann_id']."'/>";
                print "<input type='hidden' id='ann_title' name='ann_title' value='{$ca['title']}'/>";
	        print "<a href='add_announcement.php?action=edit&ann={$ca['ann_id']}' class='btn btn-default' href=''  onclick='javascript:$(\"#{$ca['ann_id']} #action\").val(\"edit\")'>
                       <span class='glyphicon glyphicon-edit'>
                       Edit</a>&nbsp;";
	        print "<button class='btn btn-default' onclick='javascript:$(\"#{$ca['ann_id']} #action\").val(\"del\")'><span class='glyphicon glyphicon-remove text-danger'></span>
                       Delete</button>";
	      print "</form>";
	    print "</div>";
	  print "</br></br>";
	  print "</div>";
      }
    }else{
      echo '<h3 id="empty">No Announcement Yet!</h3>';
    }
    ?>
   </div>
</div>