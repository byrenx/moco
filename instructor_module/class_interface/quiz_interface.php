<?php
require_once '../../instructor_module/class_models/quiz_model.php';
require_once '../../libraries/php/time_lib.php';

class QuizInterface{

  protected $_quizmodel;
  protected $time_lib;

  public function __construct(){
    $this->_quizmodel = new QuizModel();
    $this->time_lib = new TimeLib();
  }

  public function showQuizList($icr_id){
    $quizzes = $this->_quizmodel->getQuizzes($icr_id);
    foreach($quizzes as $quiz){
      $this->showQuizBox($quiz);
    }
  }

  public function showExamList($icr_id){
    $exams = $this->_quizmodel->getExams($icr_id);

    if(count($exams)>0){
      foreach($exams as $exam){
	$this->showQuizBox($exam);
      }
    }else{
      echo "<div class='alert alert-danger'><b>Currently You have no Exam created for this Course!</b></div>";
    }
    
  }

  public function addTest(){
    $due = new DateTime(sanitize($_POST['dd']));
    $start = new DateTime(sanitize($_POST['da']));
    $ttype = $_POST['ttype'];
    $params = array($_POST['icr_id'],
                    sanitize($_POST['q_title']),
                    $ttype,
                    $due->format('Y-m-d'),
                    $start->format('Y-m-d'),
                    ($_POST['time']==1? $_POST['duration']: -1));

    if($this->_quizmodel->addTest($params)){
      $new_test = $this->_quizmodel->getNewTest($ttype);
      //      $this->showQuizBox($new_test);
      if($ttype==0){
	header("Location: ../../instructor_module/pages/add_quiz.php?status=ok&action=add");
      }
      if($ttype==1){
	header("Location: ../../instructor_module/pages/add_exam.php?status=ok&action=add");
      }
      
    }else{
      echo "err";
    }    
  }

  public function vd_test(){//return true if test is valid to be deleted
    if($this->_quizmodel->has_test_rec($_POST['test_id'])){
      echo 'false';
    }else{
      echo 'true';
    }
  }

  public function getTestInfo($id){
    return $this->_quizmodel->getTest($id);
  }
  
  public function updateTest(){
    
    if($this->_quizmodel->updateTest()){
      $quiz = $this->_quizmodel->getQuiz($_POST['test_id']);
      //      $this->setQuizBox($quiz);
      if($_POST['ttype']==1){
	header("Location: ../../instructor_module/pages/add_exam.php?status=ok&action=edit");
      }else{
	header("Location: ../../instructor_module/pages/add_quiz.php?status=ok&action=edit");
      }

    }else{
      header("Location: ../../instructor_module/pages/add_quiz.php?status=fail&action=edit");
    }
    
  }

  public function showQuizBox($quiz){
    echo "<div id='page_dialog' class='{$quiz['test_id']}'>";
    $this->setQuizBox($quiz);
    //end-dialog-content
    echo "</div>";
  }

  public function setQuizBox($quiz){
    //header 
    $due = new DateTime($quiz['due_date']);
    $start = new DateTime($quiz['test_date']);
    $duration = ($quiz['duration']==-1? 'None': $this->time_lib->formatTime($quiz['duration']));

      echo "<div id='hdr'>";
	echo "<span id='hdr-title'>";
	   echo $quiz['title'];
	echo "</span>";
	echo "<span id='xbutton'>
	     <a href=\"javascript:removeTest({$quiz['test_id']}, '{$quiz['title']}')\" 
		title='Delete this quiz'
                class='close text-danger'
                aria-hidden='true'>";
	    echo "&times";
            echo "</a>";
	    echo "</span>";
        echo "</div>";
        //end-header
            
        //dialog-content
        echo "<div id='pg-diag-content'>";
	  echo "<table border='0' style='width:70%' class='quiz-details'>";
          //total items row
	  echo "<tr>";
	  echo "<td><b>Total Items: </b></td><td>{$quiz['total_items']}</td>";
          echo "</tr>";
          //due date row
          echo "<tr>";
         
	  echo "<td><b>Due Date:</b></td><td>{$due->format('D, M d Y')}</td> </tr>";
	  //date avaailability row
          echo "<tr>"; 
	  echo "<td><b>Date Available:</b></td><td>{$start->format('D, M d Y')} </td>";
          echo "</tr>";
          echo "<tr><td><b>Time Limit</b></td>";
          echo "<td>{$duration}</td></tr>";
          echo "</table>";
          //end of table
          //'javascript:quiz_diag_action(\"{$quiz['test_id']}\")'
          echo "<div class='right-buttons'>";
	  if($quiz['test_type']==1){
	    echo "<form id='".$quiz['test_id']."' 
                  action='../../instructor_module/pages/add_exam.php' 
                  method='post'>";
	  }else{
	    echo "<form id='".$quiz['test_id']."' 
                  action='../../instructor_module/pages/add_quiz.php' 
                  method='post'>";
	  }
           
	      echo "<input type='hidden' id='action' name='action' value='edit'>";
	      echo "<input type='hidden' id='test_id' name='test_id' value='{$quiz['test_id']}'>";
	      echo "<input type='hidden' id='title' name='title' value='{$quiz['title']}'>";
              echo "<input type='hidden' id='dd' name='dd' value='{$quiz['due_date']}'>";
              echo "<input type='hidden' id='da' name='da' value='{$quiz['test_date']}'>";
              echo "<input type='hidden' id='duration' name='duration' value='{$quiz['duration']}'>";
            echo "<input type='hidden' id='total_p' name='total_p' value='{$quiz['total_points']}'>";
	      echo "<input type='hidden' id='ttype' name='ttype' value='qz'>";
              echo "<input type='submit' class='btn btn-default' name='edit' value='Edit' onclick='$(\"#{$quiz['test_id']} #action\").val(\"edit\")'>  ";
              echo "<a href='../../instructor_module/pages/view_quiz.php?id={$quiz['test_id']}' 
                   class='btn btn-primary' 
                   name='view' value='Manage' 
                   onclick='$(\"#{$quiz['test_id']} #action\").val(\"manage\")'>Manage Items</a>&nbsp;";
	      $test_id = $quiz['test_id'];
	      echo "<a href='../../instructor_module/pages/stud_results.php?tid=$test_id' 
name='show_rs' class='btn btn-default'>
                      Results&nbsp;<span class='badge'>{$quiz['results']}</span>
                    </a>";
	    echo "</form>";
          echo "</div>";
      echo "</div>";
  }

  /*
   *  quiz item form scripts
   */

  public function addMPItem(){ 
    $answer_key = $_POST['ans'];
    $test_id=$_POST['test_id'];
    $param = array($test_id,
                   1,
                   sanitize($_POST['question']),
		   $_POST['points']
		   );
    try{
      $this->_quizmodel->beginTransaction();
      if($this->_quizmodel->isQuestionExist($test_id, 0)){
	echo "dup";
      }else if($this->_quizmodel->addItem($param)){
        $item_id = $this->_quizmodel->getNewItemID($test_id);
        
        //saving choices
        $this->_quizmodel->addChoice($answer_key, $item_id, 'a', 1);//A
        $this->_quizmodel->addChoice($answer_key, $item_id, 'b', 2);//B
        $this->_quizmodel->addChoice($answer_key, $item_id, 'c', 3);//C
        $this->_quizmodel->addChoice($answer_key, $item_id, 'd', 4);//D
        //showing new item
        $item = $this->_quizmodel->getMPItem($item_id);
        //display new item
        echo "<div class='panel panel-default' id='{$item['item_id']}'>";
        $this->showMPItem($item);
	echo "</div>";
      }else{
	echo "err";       
      }
      $this->_quizmodel->commitTransaction();
    }catch(Exception $e){
      $this->_quizmodel->rollBack();
    }
  }

  public function addTFItem(){
    $item = array($_POST['test_id'],
		  2,
		  $_POST['question'],
		  $_POST['points']);

    if($this->_quizmodel->addItem($item)){
      $item_id = $this->_quizmodel->getNewItemID($_POST['test_id']);
      $tf_item = array($item_id, ($_POST['ans']==1? True : False));
      $this->_quizmodel->addTFItem($tf_item);
      $item_info = $this->_quizmodel->getTFItem($item_id);
      echo "<div class='panel panel-default' id='$item_id'>";
      $this->showTFItem($item_info);
      echo "</div>";
    }else{
      echo "err";
    }
  }

  public function displayAllItem($test_id){
    
    $items = $this->_quizmodel->getAllItems($test_id);
    $max_items = count($items);
    $item_count = 1;

    echo "<input type='hidden' id='max_item_count' name='max_item_count' value='$max_items'>";
    $first_item = ($max_items>0? 1: 0);

    foreach($items as $item){
      if($item_count==1) echo "<input type='hidden' id='cur_item' name='cur_item' value='{$item['item_id']}'>";

      if($item['item_type']==1){//multiple choice
	//display Item 
        $item['choices'] = $this->_quizmodel->getItemChoices($item['item_id']);
        echo "<div class='panel panel-default' id='{$item['item_id']}'>";
        $this->showMPItem($item); 
	echo "</div>";
      }
      if($item['item_type']==2){//true or false
	//display item
        $tf_item = $this->_quizmodel->getTFItem($item['item_id']);
        echo "<div class='panel panel-default' id='{$item['item_id']}'>";
        $this->showTFItem($tf_item);
        echo "</div>";
      }
      if($item['item_type']==3){
	//display item info
	$mtf_item = $this->_quizmodel->getMTFItem($item['item_id']);
        echo "<div class='panel panel-default' id='{$mtf_item['item_id']}'>";
	$this->showMTFItem($mtf_item);
	echo "</div>";

      }
      if($item['item_type']==4){
	$iden_item = $this->_quizmodel->getIdenItem($item['item_id']);
        echo "<div class='panel panel-default' id='{$item['item_id']}'>";
	$this->showIdenItem($iden_item, $item_count);
	echo "</div>";
      }

      $item_count++;
    }//end of foreach
  } 


  public function updateMpItem(){
    //for db access purpose
    $item = array(":question" => sanitize(trim($_POST['question'])),
		  ":item_id" => $_POST["item_id"],
		  ":points" => $_POST['points']
		  );
    $answer = $_POST['ans'];
   
    //choices
    $choice_letters = array("a", "b", "c", "d");
    $choice_ids = array("c1", "c2", "c3", "c4");
    //for db access
    $choices = array();

    for($i=0;$i<4; $i++){
      $correct = ($answer==$choice_letters[$i]? 1: 0);
      $choices[] = array(":choice_val" => $_POST[$choice_letters[$i]],
                         ":correct" => $correct,
			 ":choice_id" => $_POST[$choice_ids[$i]]
                        );
    }
   
    if($this->_quizmodel->isQuestionExist($_POST['test_id'],$item[':item_id'])){
      echo "dup";
    }else if($this->_quizmodel->updateMPItem($item, $choices)){
      $item_display = $this->_quizmodel->getItem($item[':item_id']);
      $item_display['choices'] = $this->_quizmodel->getItemChoices($item[':item_id']);
      $this->showMPItem($item_display);
    }else{
      echo "err";
    }
  }

  private function showUpdatedMPItem($item, $choices){
    //this function display the updates of an item
    
  }

  public function updateTFItem(){
    $test_id = $_POST['test_id'];
    $item = array(":question" => sanitize($_POST['question']),
		  ":item_id" => $_POST["item_id"],
		  ":points" => $_POST['points']
		  );
        
    $tf_data = array(":item_id"=>$_POST['item_id'],
                     ":ans"=>$_POST['ans'],
                     ":tf_id"=>$_POST['tf_item_id']);
    
    if($this->_quizmodel->isQuestionExist($test_id, $tf_data[':item_id'])){
      echo "dup";
    }else if($this->_quizmodel->updateTFItem($item, $tf_data)){
      $tf_item  = array("test_id"=>$test_id,
                        "question"=>$item[':question'],
                        "item_type"=>2,
                        "item_id"=>$tf_data[':item_id'],
                        "tf_id"=>$tf_data[':tf_id'],
                        "ans"=>$tf_data[':ans'],
                        "points"=>$item[':points']);
      $this->showTFItem($tf_item);
    }else{
      echo "err";
    }
    
  }

  /**
   * Modifies True or Falsed Item
   *
   */

  public function addMTFItem(){
     //getting form element inputs
    //item type 3--modified true or false

    $item = array($_POST['test_id'],
		  3,
		  $_POST['question'],
		  $_POST['points']);


    //add to Item table
    if($this->_quizmodel->isQuestionExist($item[0], 0)){
      echo "dup";
    }else if($this->_quizmodel->addItem($item)){
      //get newly addded item id
      $item_id = $this->_quizmodel->getNewItemID($item[0]);
      $item_params = array(":item_id"=>$item_id,
			   ":ans"=>($_POST['ans_sel']=='True'? "True": $_POST['ans_text']));
      $this->_quizmodel->addMTFItem($item_params);
      //getting new item details
      $item_data = $this->_quizmodel->getMTFItem($item_id);
      echo "<div class='panel panel-default' id='$item_id'>";
      $this->showMTFItem($item_data);
      echo "</div>";
    }else{
      echo "err";
    }
  }

  public function updateMTFItem(){  
    $test_id = $_POST['test_id'];
    $item = array(":question" => sanitize($_POST['question']),
		  ":item_id" => $_POST["item_id"],
		  ":points" => $_POST['points'],
		  ":ans" => ($_POST['ans_sel']=='True'? "True": $_POST['ans_text'])
		  );
        
    
    if($this->_quizmodel->isQuestionExist($test_id, $item[':item_id'])){
      echo 'dup';
    }else if($this->_quizmodel->u_mtf($item)){
      $tf_item  = array("test_id"=> $test_id,
                        "question"=> $item[':question'],
                        "item_id"=> $item[':item_id'],
			"item_type"=> 3,
                        "mtf_id"=> $_POST['mtf_item_id'],
                        "ans"=> $item[':ans'],
                        "points"=> $item[':points']);
      $this->showMTFItem($tf_item);
    }else{
      echo "err";
    }
  }

  /* identification item*/
  public function addIdentItem(){
     $item = array($_POST['test_id'],
		   4,
		   $_POST['question'],
		   $_POST['points']);
     //check for question dupplicate
     if($this->_quizmodel->isQuestionExist($item[0], 0)){
       echo "dup";
     }else if($this->_quizmodel->addItem($item)){
       //get new item item id
       $item_id = $this->_quizmodel->getNewItemId($item[0]);
       //get item info
       $item_params = array(":item_id"=>$item_id,
			    ":ans"=>$_POST['ans']);
       //insert new identification item
       $this->_quizmodel->addIdenItem($item_params);
       //get new Item Info
       $item_data = $this->_quizmodel->getIdenItem($item_id);
       echo "<div class='panel panel-default' id='$item_id'>";
          $this->showIdenItem($item_data);
       echo "</div>";
     }else{
       echo "err";
     }

  }


  function updateIditem(){
    $test_id = $_POST['test_id'];
    $item = array(":question" => $_POST['question'],
		  ":item_id" => $_POST["item_id"],
		  ":points" => $_POST['points'],
		  ":ans" => $_POST['ans']
		  );
        
    if($this->_quizmodel->isQuestionExist($test_id, $item[':item_id'])){
      echo 'dup';
    }else if($this->_quizmodel->u_iditem($item)){
      $id_item  = array("test_id"=> $test_id,
                        "question"=> $item[':question'],
                        "item_id"=> $item[':item_id'],
			"item_type"=>4,
                        "ident_id"=> $_POST['ident_item_id'],
                        "ans"=> $item[':ans'],
                        "points"=> $item[':points']);
      $this->showIdenItem($id_item);
    }else{
      echo "err";
    }
  }

  
  /*
    item display fuunctions
   */

  public function showMPItem($item){
      $points = 0;
      $ans = null;
      echo "<div class='panel-heading'>
               <form id='{$item['item_id']}' action='javascript:showEditItemForm(\"{$item['item_id']}\",\"{$item['item_type']}\")' method='post'>
                  <b>Question</b>
                  <input type='hidden' name='item_id' value='{$item['item_id']}'>
                  <input type='hidden' name='action' value='del'>
                  <input type='hidden' name='target' value='quizitem'>
                  <button type='submit' class='btn btn-link'>
                     <p class='text-primary'>
                       <span class='glyphicon glyphicon-pencil'></span>
                       Edit
                     </p>
                  </button>
                  <a href='javascript' class='btn btn-link'>
                     <p class='text-danger'>
                       <span class='glyphicon glyphicon-remove'>
                       </span>
                       Delete
                     </p>
                  </a>
               </form>
            </div>
            <div class='panel-body'> 
                  <input type='hidden' id='test_id' name='test_id' value='{$item['test_id']}'>
                  <input type='hidden' id='item_id' name='item_id' value='{$item['item_id']}'>
                  <input type='hidden' id='target' name='target' value='item_mp'>
<textarea id='q{$item['item_id']}' style='display:none'>{$item['question']}</textarea>
                  <p class='question' id='question' name='question'>{$item['question']}</p>
            </div>
            <ul class='list-group'>";
               $count = 1;
               $ans_arr = array("a","b","c","d");
               $choice_ids = array("c1", "c2", "c3", "c4");

               foreach($item['choices'] as $choice){ 
                  echo "<li class='list-group-item'>";

                  if($choice['iscorrect']){
                     echo "<p class='text-success'>";
                     echo "<b>{$ans_arr[$count-1]}. </b>"; 
                     echo "<input type='hidden' id='$count' value='{$choice['choice_val']}'>";
                     echo "<input type='hidden' id='{$choice_ids[$count-1]}' value='{$choice['choice_id']}'>";
                     echo " {$choice['choice_val']} ";
                     echo "<span class='glyphicon glyphicon-check'></span>  ";
                     echo "{$item['points']} Points";
                     echo "</p>";
                     $ans    = $count;
                  }else{
		     echo "<b>{$ans_arr[$count-1]}. </b>"; 
		     echo "<input type='hidden' id='$count' value='{$choice['choice_val']}'>";
		     echo "<input type='hidden' id='{$choice_ids[$count-1]}' value='{$choice['choice_id']}'>";
		     echo "{$choice['choice_val']}";
                  }
		  $count++;
		  echo "</li>";
	       }
		  echo "</ul>";
		  echo "<input type='hidden' id='points' value='{$item['points']}'>";
		  echo "<input type='hidden' id='ans' value='{$ans_arr[$ans-1]}'>";
  }

  private function showTFItem($item){
   
    echo "<div class='panel-heading'>
            <form id='{$item['item_id']}' action='javascript:showEditItemForm(\"{$item['item_id']}\",\"{$item['item_type']}\")' method='post'>
                <b>Question </b>
                 <input type='hidden' name='action' value='del'>
                 <input type='hidden' name='item_id' value='{$item['item_id']}'>
                 <input type='hidden' name='target' value='quizitem'>
                 <input type='hidden' name='item_id' value='{$item['item_id']}'>
                 <input type='hidden' name='action' value='del'>
                 <input type='hidden' name='target' value='quizitem'>
                 <button type='submit' class='btn btn-link'>
                    <p class='text-primary'>
                      <span class='glyphicon glyphicon-pencil'></span>
                      Edit
                    </p>
                 </button>
                 <a href='#' class='btn btn-link'>
                    <p class='text-danger'>
                      <span class='glyphicon glyphicon-remove'></span>
                      Delete
                    </p>
                 </a> 
            </form>
          </div>

          <div class='panel-body'>
              <input type='hidden' id='test_id' name='test_id' value='{$item['test_id']}'>
              <input type='hidden' id='item_id' name='item_id' value='{$item['item_id']}'>
              <input type='hidden' id='tf_item_id' name='tf_item_id' value='{$item['tf_id']}'>
              <input type='hidden' id='target' name='target' value='item_tf'>
             
<textarea id='q{$item['item_id']}' style='display:none'>{$item['question']}</textarea>
              <p class='question' id='question' name='question'>{$item['question']}</p>
          </div>
             <ul class='list-group'>
                <li class='list-group-item'>
                   <p class='text-success'>";
                       
                       if($item['ans']){
			 echo " True ";
		       }else{
			 echo " False ";
		       }
		       echo "<span class='glyphicon glyphicon-check'></span>
                         {$item['points']} Points
                    </p>
                 </li>
             </ul>
             <input type='hidden' id='points' value='{$item['points']}'>
             <input type='hidden' id='ans' value='{$item['ans']}'>
          </form>";
  }


  private function showMTFItem($item){
   
    echo "<div class='panel-heading'>
             <form id='{$item['item_id']}' action='javascript:showEditItemForm(\"{$item['item_id']}\",\"{$item['item_type']}\")' method='post'>
                 <b>Question</b>
                 <input type='hidden' id='item_id' name='item_id' value='{$item['item_id']}'>
                 <input type='hidden' id='mtf_item_id' name='mtf_item_id' value='{$item['mtf_id']}'>
                 <input type='hidden' id='points' value='{$item['points']}'>
                 <input type='hidden' id='ans' value='{$item['ans']}'>

                 <button type='submit' class='btn btn-link'>
                    <p class='text text-primary'>
                       <span class='glyphicon glyphicon-pencil'></span>
                       Edit
                    </p>
                 </button>
                 <a href='#' class='btn btn-link'>
                    <p class='text-danger'>
                       <span class='glyphicon glyphicon-remove'></span>
                       Delete
                    </p>
                 </a>   
              </form>
          </div>

          <div class='panel-body'>
               <input type='hidden' id='test_id' name='test_id' value='{$item['test_id']}'>
               <input type='hidden' id='item_id' name='item_id' value='{$item['item_id']}'>
               <input type='hidden' id='tf_item_id' name='tf_item_id' value='{$item['mtf_id']}'>
               <input type='hidden' id='target' name='target' value='item_mtf'>
             
<textarea id='q{$item['item_id']}' style='display:none'>{$item['question']}</textarea>
               <p class='question' id='question' name='question'>{$item['question']}</p>
           </div>
           <ul class='list-group'>
                <li class='list-group-item'>
                   <p class='text-success'>";
                      if($item['ans']=="True"){
                        echo " True ";
                      }else{
                        echo $item['ans'];
                      }
                      echo "&nbsp;<span class='glyphicon glyphicon-check'></span>
                         {$item['points']} Points
                    </p>
                 </li>
             </ul>
         ";
  }
  
  public function showIdenItem($item){
      echo "<div class='panel-heading'>
                <form id='{$item['item_id']}' action='javascript:showEditItemForm(\"{$item['item_id']}\",\"{$item['item_type']}\")' method='post'>

                   <b>Question</b>
                   <input type='hidden' name='item_id' value='{$item['item_id']}'>
                   <input type='hidden' id='id_id' name='id_id' value='{$item['ident_id']}'>
                   <button type='submit' class='btn btn-link'>
                      <p class='text-primary'>
                         <span class='glyphicon glyphicon-pencil'></span>
                         Edit
                      </p>
                   </button>
                   <a href='' type='submit' class='btn btn-link'>
                      <p class='text-danger'>
                         <span class='glyphicon glyphicon-remove'></span>
                         Delete
                      </p>
                   </a>   
                </form>
             </div>

             <div class='panel-body'>
               <input type='hidden' id='test_id' name='test_id' value='{$item['test_id']}'>
               <input type='hidden' id='item_id' name='item_id' value='{$item['item_id']}'>
              
               <input type='hidden' id='target' name='target' value='item_mtf'>
             
<textarea id='q{$item['item_id']}' style='display:none'>{$item['question']}</textarea>
               <p class='question' id='question' name='question'>{$item['question']}</p>
             </div>
             <ul class='list-group'>
                <li class='list-group-item'>
                   </br>
                   <p class='text-success'>";
                      echo "<strong>Answer: </strong>";
                      echo "<span class='glyphicon glyphicon-check'></span>
                         {$item['points']} Points
                   </p>
                   </br>
                   <p>
                      {$item['ans']}
                   </p>
                 </li>
             </ul>
             <input type='hidden' id='points' value='{$item['points']}'>
             <input type='hidden' id='ans' value='{$item['ans']}'>
          ";
    }
  
}

?>