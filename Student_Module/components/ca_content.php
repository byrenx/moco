  <!-- course title --->  
  <!--- content--->
  <div id="about_cont_con">
     <!---header-->
     <div id="about_hdr">
	    <span id="about_hdr_title">
		  Course Announcement
		</span>
		
		<!--description-->
	 </div>
	 
	 <!---display announcement--->
	 <?php
	    foreach($ann as $ca){
     //print_r($ca);
            $datePosted = new DateTime($ca['date_posted']);
		   echo "<div id='ca_ann_con'>";
		      //announcement date
	   
		      echo "<div id='ca_date_con'>";
	    echo "<i>Date Posted : {$datePosted->format('F j, Y, g:i a l')}</i>";
	    
	    echo "<h3> {$ca['title']}</h3>";

			  echo "</div></br></br></br>";
			  //announcement content
			  echo "<div id='ca_content'>&nbsp&nbsp&nbsp&nbsp&nbsp";
			  echo $ca['ann_stmt'];
			  echo "</div>";
		     	  echo "</br></br>";
		   echo "</div>";
		}
	 ?>
  </div>
