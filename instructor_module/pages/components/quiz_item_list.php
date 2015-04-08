<?php $test_type = $quiz_info['test_type']; ?>

<script type="text/javascript">
   /*
   function runEffect(c_item, next_item) {
       // get effect type from
        alert(c_item+" "+next_item);
       var selectedEffect = $("#effect").val();
       // most effect types need no options passed by default
       var options = {};
       // some effects have required parameters
       if ( selectedEffect === "scale" ) {
         options = { percent: 0 };
       }else if ( selectedEffect === "transfer" ) {
         options = { to: "#button", className: "ui-effects-transfer" };
       }else if ( selectedEffect === "size" ) {
         options = { to: { width: 200, height: 60 } };
       }
       // run the effect
       $("#"+c_item).hide();
       $("#"+next_item).effect( selectedEffect, options, 500, callback("div#"+next_item));
   }

   // callback function to bring a hidden box back
   function callback(form_id) {
     setTimeout(function() {
	 $(form_id).removeAttr( "style" ).fadeIn();
        }, 1000 );
   }

   // set effect from select menu value
   function next() {
     /*var c_item = new Number($('#c_item').val());
       alert(c_item);
       var next_item = c_item+1;
       var max_num = new Number($('#max').val()); 

       if(c_item < max_num){
         runEffect(c_item, next_item);
         $('#c_item').val(next_item.toString());         
       }
       return false;
     $("div#1").hide();
     alert($("#2").html());
     }


   function prev(){
      var c_item = new Number($('#c_item').val());
      var prev_item = c_item-1;
      var min = 1;
      if(c_item>min){
         runEffect(c_item, prev_item);
         $('#c_item').attr("value", prev_item.toString());    
      }
      }*/

   function setItemModalType(){
     var item_type = $("#item_type").val();
     if(item_type==1){//mp choice
       $("#item_modal_launcher").attr('data-target', "#mpc_form");
     }else if(item_type == 2){
       $("#item_modal_launcher").attr("data-target", "#tf_form");
     }else if(item_type == 3){//modified true or false
       $("#item_modal_launcher").attr("data-target", "#mtf_form");
     }else{//identification
       $("#item_modal_launcher").attr("data-target", "#ident_form");
     }
   }

   function reset_form(){
       var item_type = $("#item_type").val();
       if(item_type==1){//mp choice
	 reset_mpc_form();
       }else if(item_type == 2){
	 reset_tf_form();
       }else if(item_type == 3){//modified true or false
	 reset_mtf_form();
       }else{//identification
	 reset_ident_form();
       }

   }
      

</script>


<!--- content --->
  <div id="about_cont_con">
     <!--- header --->
     <div id="about_hdr">
	<span class="h3">
           <?php echo $quiz_title;?>
	</span>
        <?php if($test_type==0){ ?>
                 <a href="quiz.php">
                 <span class='glyphicon glyphicon-backward'></span>&nbsp;Go Back to Quizzes
         </a>
        <?php }else{ ?>
	          <a href="exam.php">
                 <span class='glyphicon glyphicon-backward'></span>&nbsp;Go Back to Exams
                 </a>
       <?php  }?>
     </div>
     </br>
     <div>
       <form action="javascript:showItemForm()" class='form-inline' role='form' method="post">
	 <div class="alert alert-info">
	   <b>Tips: </b>This application is powered by MathJax, therefore LaTex commands are supported
	 </div>
         <div class="form-group">
         <select name="item_type" id="item_type" class="form-control" onchange="setItemModalType()">
           <option>-----Select Item Type-----</option>
           <option value="1">Multiple Choice</option>
           <option value="2">True or False</option>
           <option value="3">Modified True or False</option>
           <option value="4">Identification</option>
         </select>
         <a id="item_modal_launcher" data-toggle="modal" class="btn btn-primary" onclick="reset_form()">Add Item</a>
        </div>
       </form> 
     </div>

    <div id='sub-content'>
     <!----add item form--->     
      <div>
        
      </div>

      <div style='position: relative; top: 30px;'>
        <form>
        <input type='hidden' id='effect' value='slide'>
        <input type='hidden' id='max' value='4'>
        <input type='hidden' id='c_item' value='1'>
        <input type='hidden' id='item_prefix' value='q'>
        <input type='hidden' id='test_id' name='test_id' value='<?php echo $test_id;?>'>
        </form>
       <?php 
           require_once "../class_interface/quiz_interface.php";
           $qi = new QuizInterface();
           $qi->displayAllItem($test_id);
       ?>       
       <?php include "../pages/components/mpc_form.php";?>
       <?php include "../pages/components/tf_form.php";?>
       <?php include "../pages/components/mtf_form.php";?>
       <?php include "../pages/components/ident_form.php";?>
      </div>
    </div>