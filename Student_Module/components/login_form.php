<div id="add_course_form_container">
   <!--title-->
   <h4 class="header">
      <?php
        echo "Sign In";
      ?>
   </h4>
   <?php
     if(isset($_GET) && isset($_GET['status']) && $_GET['status']=='error'){
        echo "<div style='text-align: left;' class='alert alert-danger'>";
        echo 'Either Username or Password is invalid';
        echo '</div>';
     }
   ?>    
   <!--form elems-->
   <div id="add_course_form">
     <form role="form" action="../components/initialize.php" method="post"
           onsubmit="javascript: return validateAccountInput();">
          
            <input type="hidden" name="action" value="login">
            
	    <div class="form-group">
		<label>Username</label>
	        <input class="form-control" type="search" id="uname" name="uname" value="" 
                       placeholder="Username"  onkeydown="return allNumbers(event)"
                       size='10'>
	    </div>
		
	    <div class="form-group"> 
		<label>Password</label>
	        <input type="password" id="password" name="password" value=""
                       placeholder="Password"  onkeydown="return allNumbers(event)"
                       style='height: 30px;' size='6'>
	    </div>
                
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
	    <div id="form_el">
	       <input class="btn btn-primary" type="submit" id="login" name="login" value="Sign In">
	       </br>
	       </br>
	   </div>
	 </form>
        <!---notice div for here----->
        <div style="position:absolute;
                    left:350px;
                    top:40px;
                    width:300px;
                    height: 100px;
                    padding:10px;
                    background-color:rgb(204,250,250);">
          <span>  
             <img src="../../images/info.png"/>
          </span>
          <span style="position: absolute;left:60px;">
             Use Your AKAN account to</br>
             Sign In for MOCO
          </span>
        </div>
   </div>
</div>