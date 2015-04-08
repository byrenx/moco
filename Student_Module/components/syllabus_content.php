  <!--- content--->
  <div id="about_cont_con">
     <!---header-->
     <div id="about_hdr">
	    <span id="about_hdr_title">
		  Course Syllabus
		</span>
	 </div>
	 
	
	<!---topic table--->
	
	<!---table content option--->
	<div id="table_option">
	    
	</div>
	<!----topic list table---->
	 <div id="tbl_container">
	    <table class="table">
		  <?php
     if(count($topic_list)>0){
		    foreach($topic_list as $tpl){
			   echo "<tr>";
			   echo "<td>";
			   //echo $tpl['seq_no']; echo "."; 
				  echo "</td>";
			      echo "<td>";
			   if($_SESSION['chap_t'] == $tpl['title']){
                           
                           }else{    
			   echo "<h4> {$tpl['title']}</h4></br> </br>"; 
			   $_SESSION['chap_t'] = $tpl ['title'];
			   }
			   echo  "{$tpl['tittle']}</br>";
			
				  echo "</td>";
			   echo "</tr>";
			}
     }else{
       echo "<h3> No Syllabus Yet! </h3>";
     }
		  ?>
		</table>
	 </div>
  </div>