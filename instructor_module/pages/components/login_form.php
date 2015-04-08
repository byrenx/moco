<div id="login_container">
   <!--title-->
   <h4 class="header">
      <?php
        echo "Sign In";
      ?>
   </h4>

   <?php
      if(isset($_GET) && isset($_GET['status']) && $_GET['status']=='error'){
        echo "<div style='text-align: left;' class='alert alert-danger'>
                Either Username or Password is invalid
              </div>";
     }
   ?>
    
   <!--form elems-->
   <div id="add_course_form">
     <form role="form" action="../../libraries/php/executeAction.php" method="post"
           onsubmit="javascript: return validateAccountInput();">
          <input type="hidden" name="action" value="login">

        <div class="login-form">
            <!------ousername ------>    
	    <div class="form-group">
		<label>Username</label>
	        <input class="form-control" type="text" id="uname" name="uname" value="" required="true" 
                       placeholder="Username"  onkeydown="return allNumbers(event)"
                       size='10'>
	    </div>
	    
            <!-------password--------->
	    <div id="form-el"> 
		<label>Password</label>
	        <input type="password" class="form-control" id="password" name="password" value="" required="true"
                       placeholder="Password"  
                       maxlength='10'>
                <!---onkeydown="return allNumbers(event)"--->
	    </div>
               
            <!------ options ---------> 
            <div id="form_el">
               <div style="position:absolute;left:0px;">
                  <label>
                    <input type="radio" id="target" name="target" value="s"
                           checked="true">
                    Student
                  </label>
               </div>

               <div style="position:absolute;left:100px;">
                  <label>
                    <input type="radio" id="target" name="target" value="i">
                    Instructor
                  </label>
              </div>
            </div>
	    </br>
            </br> 

            <!-------- button ------>
	    <div id="form_el">
	       <input class="btn btn-primary" type="submit" id="login" name="login" value="Sign In">
	       
	   </div>

	 </form>
       </div ><!----end of login form--->
        
       <!---login note----->        
        <div id="login_note">
          <span>  
             <img src="../../images/info.png"/>
          </span>
          <span style="position: absolute;left:60px;">
             Use Your AKAN account to</br>
             Sign In for MOCO
          </span>
        </div>
         
   </div>  <!-----end of login form----->

</div>