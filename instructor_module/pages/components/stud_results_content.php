

 <!--- content--->
<div id="about_cont_con">
  <!---header-->
  <div id="about_hdr">
     <span class='h3'>
    <?php if($test_inf['test_type'] == 0){?>
       Quiz Results&nbsp;-&nbsp; <?php echo $test_inf['title'];?>
    <?php }if($test_inf['test_type'] == 1){?>
       Exam Results&nbsp;-&nbsp; <?php echo $test_inf['title'];?>
    <?php }?>
     </span>
  </div>
    
  <div id="sub-content">
    <?php if(count($qrs) > 0){ ?>
       <table class='table table-striped'>
          <caption style='color: blue'><b>Showing <?php echo count($qrs);?> result(s)</b></caption>
          <thead>
	  <tr><th>Name</td><th>Date Taken</td><th>Score/<?php echo $test_inf['total_points']; ?></td></tr>
          </thead>
          <tbody>
	    <?php foreach($qrs as $rs){?>
	      <tr>
	        <td>
                    <?php echo $rs['LASTNAME']; ?>,&nbsp;
	            <?php echo $rs['FIRSTNAME']; ?>&nbsp;
	            <?php echo $rs['MIDDLENAME']; ?>
                </td>
	        <td><?php 
                        $dt = new DateTime($rs['date_taken']);
		        echo $dt->format('F, j, Y');
                     ?>
                </td>
		<td><?php 
		if($rs['score']>0){
		  echo $rs['score'];
		}else{
		  echo '0';
		}
                     ?>
                </td>
	      </tr>
	  </tbody>
             <?php }?>
	</table>
	<?php }else{ 
                 $ttype = ($test_inf['test_type']==1? 'Exam': 'Quiz');
                 echo "<div class='alert alert-danger'><b>Currently nobody has taken the $ttype</b></br>
                      No results found!</div>";
              }
        ?>
  </div>
</div>