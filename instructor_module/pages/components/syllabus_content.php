  <!--- content--->
  <div id="about_cont_con">
     <!---header-->
     <div id="about_hdr">
	<span class='h3'>
	   Course Syllabus
	</span>
     </div>
     
     <div id="sub-content">
	   <!----add/edit chapter  pane-->
       
  <div id="topic_add_pane">
    <!---action="javascript:addEditChapter('frm_topic')"---->
	   <form id="frm_topic" class="form-inline" action="../../libraries/php/exec_controller.php" method="post"> 
              <input type="hidden" id="action" name="action" value="add"> 
              <input type="hidden" id="target" name="target" value="chapter">
              <input type="hidden" id="icr_id" name="icr_id" value="<?php echo $_SESSION['icr_id'];?>">
              <input type="hidden" id="ch_id" name="ch_id" value="">
              <input type="hidden" id="ch_count" name="ch_count" value="<?php echo (count($chapters)+1);?>">
              <input type="hidden" id="curselrow" name="curselrow" value="">
              <div class="form-group">
                <input class="form-control" type="search" id="topic-title" name="chapter" required="true" placeholder="Type New Module" style="width:350px;">
              </div>
	      <button type="submit" id="chap_axn" class="btn btn-primary">
                 <span class='glyphicon glyphicon-plus-sign'></span>
                 Add
              </button>
	   </form>
        </div>
        </br>
        <!---topic table--->
	
	      <!---table content option--->
     <?php 
        $message = null;
        $icon = "";
        $class_alert = "";
        if(isset($_GET['action']) && isset($_GET['status']) && isset($_GET['title'])){
	  if($_GET['action']=="add" && $_GET['status']=='ok'){
	    $icon = "glyphicon glyphicon-check";
	    $class_alert = "text text-success";
	    $message = "Chapter '{$_GET['title']}' succesfully inserted to the Syllabus";
	  }
	  if($_GET['action']=='add' && $_GET['status']=='dup'){
	    $icon = "glyphicon glyphicon-warning-sign";
   	    $class_alert = "text text-warning";
	    $message = "Chapter '".urlencode($_GET['title'])."' already exist in this syllabus";
	  }
	  if($_GET['action']=='edit' && $_GET['status']=='ok'){
	    $icon = "glyphicon glyphicon-check";
    	    $class_alert = "text text-success";
	    $message = "'{$_GET['title']}' is a newly updated Chapter";
	  }
	  if($_GET['action']=='edit' && $_GET['status']=='dup'){
	    $icon = "glyphicon glyphicon-warning-sign";
	    $class_alert = "text text-warning";
	    $message = "Chapter '{$_GET['title']}' already exist in this syllabus";
	  }
	}	       
     ?>	</br>				  
	<div class="<?php echo $class_alert; ?>" style="padding:10px;">
	  <span class="<?php echo $icon; ?>"></span>
	  <?php echo $message; ?>
	</div>
	<!----topic list table---->
	<?php if($chapters!=null){ ?>
				    
	<div id="tbl_container">
	  <table class='table table-condensed' id='syllabus-table'>
	    <tr style='background-color: rgb(230,230,230)'>
        <th></th>
        <th></th>
        <th></th>
        <th></th>

        <th>Module</th>
        <th>Title</th>
      </tr>
      <?php
	    $i=0;
            
     foreach($chapters as $tpl){
       echo "<tr id='$i'>";
       //options
       echo "<td width='40px'>";
       //conf_del_chapter({$tpl['title']})
       echo "<form action='../../libraries/php/exec_controller.php' method='POST' onsubmit='return conf_del_chapter(\"".$tpl['title']."\")'>";
       echo "<input type='hidden' name='icr_id' value='{$_SESSION['icr_id']}'>";
       echo "<input type='hidden' name='ch_id' value='{$tpl['ch_id']}'>";
       echo "<input type='hidden' name='action' value='del'>";
       echo "<input type='hidden' name='target' value='chapter'>";
       echo "<button type='submit' class='btn btn-link' title='delete this Chapter'>";
       echo "<span class='glyphicon glyphicon-remove text-danger'></span>";
       echo "</button> ";
       echo "</form>";

       echo "</td>";
       echo "<td width='40px'>";
       echo "<a href='javascript:topicEditMode(\"$i\",\"{$tpl['ch_id']}\");' 
                        title='Edit this Chapter'>
                        <span class='glyphicon glyphicon-edit'></span>
                       </a> ";
       echo "</td>";
       echo "<td width='40px'>";
       if($i>0){
	 echo "<form action='../../libraries/php/exec_controller.php' method='POST'>";
	 echo "<input type='hidden' name='icr_id' value='{$_SESSION['icr_id']}'>";
	 echo "<input type='hidden' name='ch_id' value='{$tpl['ch_id']}'>";
	 echo "<input type='hidden' name='action' value='up'>";
	 echo "<input type='hidden' name='target' value='chapter'>";
	 echo "<input type='hidden' name='seq_no' value='{$tpl['seq_no']}'>";
	 echo "<button type='submit' class='btn btn-link' title='Move Up'>";

	 echo "<span class='glyphicon glyphicon-arrow-up'></span>";
	 echo "</button>";
	 echo "</form>";
       }
	 echo "</td>";
	 echo "<td width='40px'>";
      if($i < count($chapters)-1){
	 echo "<form action='../../libraries/php/exec_controller.php' method='POST'>";
	 echo "<input type='hidden' name='icr_id' value='{$_SESSION['icr_id']}'>";
	 echo "<input type='hidden' name='ch_id' value='{$tpl['ch_id']}'>";
	 echo "<input type='hidden' name='action' value='down'>";
	 echo "<input type='hidden' name='target' value='chapter'>";
	 echo "<input type='hidden' name='seq_no' value='{$tpl['seq_no']}'>";
	 echo "<button type='submit' class='btn btn-link' title='Move Down'>";
	 echo "<span class='glyphicon glyphicon-arrow-down'></span>";
	 echo "</button>";
	 echo "</form>";
      }
       echo "</td>";

       //chapter no
       echo "<td width='70px'>";
       echo ($i+1);  
       echo "</td>";
       //chapter title
       echo "<td>";
       echo $tpl['title'];
       echo "</td>";
       echo "</tr>";
       $i++;
	     }
      ?>
    </table>
    <?php }else{ ?>
    <h3> Currently No Chapters Created Yet! </h3>
    <?php } ?>
         </br></br>
	 </div>
     </div>
  </div>
</div>
