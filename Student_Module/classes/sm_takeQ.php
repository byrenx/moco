<?php

require_once '../../Student_Module/class_models/quiz_model.php';
require_once '../../libraries/php/time_lib.php';

class TakeQuizInterface{
  protected $Questions;
  protected $time_lib;
  protected $itemType;

  public function __construct(){
    $this->Questions= new QuizModel();
    $this->time_lib = new TimeLib();
  }
  public function showTestList($testID){
    $quiz = $this->Questions->getAllItems($testID);
    foreach($quiz as $QuizItem){
      $this->ShowQuestionsBox($QuizItem['test_id']);
    }
  }
  public function showQuestionsBox($QuizItem){
    echo "<div id='page_dialog' >";
    $this->setQuestionsBox($QuizItem['test_id']);
    echo "</div";
  }
  
  /*
  public function setContainerBox($testID){
    $container = $this->Questions->getQuizItems($testID);
    if(count($container)>0){
      echo "div class='hiddenContainerBox'>";
      echo "<form>";
      echo "<input type='hidden' name='action' value='SubmitAns'>";
      echo "<input type='hidden' name='SOperation' value='QuizContainer'>";
    
      }*/
  public function setQuestionsBox($testID,$scr_id,$testtype){
       $items = $this->Questions->getQuizItems($testID);
       $text = NULL;
       $testtype;
       //print_r($items);

    if(count($items)>0){
	echo "<div>";
        echo "<form id='frm_chid' name='frm_chid' action='../../libraries/php/executeAction.php' method='post' >";{
	  echo"<input type='hidden' name='action' value='SubmitAns'>";
	  echo"<input type='hidden' name='Operation' value='{$testtype}'>";
	  echo"<input type='hidden' name='Course_id' value='{$scr_id}'>";
	  echo"<input type='hidden' name='test_id' value='{$testID}'>";
	
      foreach($items as $PerItem){
	//	print_r($PerItem);
	if($PerItem['item_type']==1){
     	 echo " <div class='panel panel-default'>
	    <div class='panel-heading'>";
	  echo "<p><b>".$PerItem['MPQ']."</b></p>";
	  
	    // print_r($Pick);
	    echo " </div> <div class='panel-body'>";
	    echo "<ul class='list-group'>";
	    foreach($PerItem['Choices'] as $Pick){
	    echo "<li class='list-group-item'>";
	    echo " <input  name='{$PerItem['item_id']}' type='radio' value='{$Pick['Choice_ID']}'>&nbsp".$Pick['choice_val'];
	     }	    
	  echo "</li></ul></div>
	     </div>";	  
	}else if($PerItem['item_type']==2){
	 echo " <div class='panel panel-default'>
	    <div class='panel-heading'>";
	  echo "<p><b>".$PerItem['question']."</b></p>";
    	  echo"   </div>
	     <div class='panel-body'>
	     <input class='form-inline' name='{$PerItem['item_id']}' type='radio' value='0'>&nbsp  False
	     &nbsp&nbsp<input class='form-inline' name='{$PerItem['item_id']}' type='radio' value='1'>&nbsp  True
             </div>
	     </div>";
	}else if($PerItem['item_type']==3){
	  echo " <div class='panel panel-default'>
	    <div class='panel-heading'>";
	  
	  echo "<p><b>".$PerItem['question']."</b></p>";
    	  echo"   </div>
	     <div class='panel-body'>
             
	  <input name='{$PerItem['item_id']}' type='radio'  value='True' onclick='javascript:hideOtherItem({$PerItem['item_id']});'>&nbsp True  
          &nbsp&nbsp<input id='{$PerItem['item_id']}112' name='{$PerItem['item_id']}' type='radio' value='' onclick='javascript:showOtherItem({$PerItem['item_id']});'>&nbspOther
          <input style='visibility:hidden' type='text' id='{$PerItem['item_id']}' name='{$text}' class='form-control' placeholder='Please specify the answer'  maxlength='6' onchange='javascript:changeValue({$PerItem['item_id']},{$PerItem['item_id']}112);'>";
          
          echo"</div>
	     </div>";
	}else if($PerItem['item_type']==4){
	  echo "<div class='panel panel-default'>
               <div class='panel-heading'>";
	  echo "<p><b>".$PerItem['question']."</b></p>";
	  echo"</div>
               <div class='panel-body'>
          <input class='form-control' name='{$PerItem['item_id']}' type='text' placeholder='Your Answer...'>
              </div>
              </div>";
	}
      }
     
      echo "</div>";
  
      foreach($items as $PerContainer){
	echo "<input type='hidden' name='Ans_Sheet[]' value='{$PerContainer['item_id']}'>";
	echo "<input type='hidden' name='item_types[]' value='{$PerContainer['item_type']}'>";
      }    
      echo "<div style='position:relative;left:700px;'>";
      echo "<input id='sub_ans' class='btn-primary form-inline' type='submit' name='subans' value='Submit Answers' style='width:200px;height:40px;'>";
      //echo "<input class='btn-default form-inline' type='submit' name='subans' value='Save Answers' style='width:200px;height:40px;'>";
	echo"</form></br></br></br>";
      echo "</div>";
	}
    }
  }
  public function setReviewBox($testID,$type,$scr_id,$totalP){
    //echo $testID;
    // echo $type;
    // echo $scr_id;
    // echo $totalP;
    $Choice_id = NULL;
    $StudAns = NULL;

       $items = $this->Questions->getReviewItems($testID);
       //print_r($items);
       // echo $_SESSION['stud_id'];
       //echo $_SESSION['scr_id'];
       $key = $this->Questions->getSCR_ID($_SESSION['stud_id'],$_SESSION['scr_id']);
       foreach($key as $out){
	 $scr_id = $out['scr_id'];
       }
       $strec = $this->Questions->getSrec_id($testID,$scr_id);
       foreach($strec as $out){
	 $strec_id = $out['strec_id'];
	 $date_taken = new DateTime($out['date_taken']);
	 $score = $out['score'];
       }
       echo "<div class='well 000well-sm'><center><H4 class='list-group-item-text'><b>Your Score: </b>"; 
       if($score) {
         echo "{$score} / {$totalP}";
       }else{
	 echo "0 / {$totalP}";
       }

      echo "</br></br><b>";
      echo "Date Taken: </b>".$date_taken->format('D,M d Y')."
           </H4></center> </div>";
    if(count($items)>0){
	echo "<div class='exp-header'>";
	if($type=='Exam'){
        echo "<form id='frm_chid' name='frm_chid' action='../../Student_Module/pages/Exam.php' method='post'>";
	}else{
	  echo "<form id='frm_chid' name='frm_chid' action='../../Student_Module/pages/Quiz.php' method='post'>";
	}
	{
	  echo"<input type='hidden' name='action' value='SubmitAns'>";
	  echo"<input type='hidden' name='SOperation' value='quiz'>";
	  echo"<input type='hidden' name='Course_id' value='{$scr_id}'>";
	
      foreach($items as $PerItem){
	//print_r($PerItem);
	if($PerItem['item_type']==1){
     	 echo " <div class='panel panel-default'>
	    <div class='panel-heading'>";
	  echo "<h4  class='panel-title'>".$PerItem['MPQ']."</h4>";
	  foreach($PerItem['Choices'] as $Pick){
	    // print_r($Pick);
	     $MPC_StoredA = $this->Questions->getMPC_StoredA($strec_id,$PerItem['item_id']);
	     foreach($MPC_StoredA as $out){
	       $Choice_id = $out['choice_id'];
	     }
	    echo " </div> <div class='panel-body'>";
	    //echo $Choice_id;
	    //echo $Pick['Choice_ID'];
	    if(($Choice_id==$Pick['Choice_ID'])&&($Pick['isCorrect']==1)){
	     echo "<p class='text-success'> <b>Your Answer:
                    ".$Pick['choice_val']." ".
                   "<span class='glyphicon glyphicon-check'></span>".$Pick['points']."Points"."</b></br>"; 
	    }else if($Choice_id==$Pick['Choice_ID']){
      	      echo "<p class='text-danger'> <b>Your Answer:
                    ".$Pick['choice_val']." ".
		    "<span class='glyphicon glyphicon-remove'></span></b></p></br>"; 
	    }else if($Pick['isCorrect']==1){
	      echo "<p class='text-success'> <b>Correct Answer: 
                    ".$Pick['choice_val']." ".
                   "<span class='glyphicon glyphicon-check'></span>".$Pick['points']."Points"."</b></br>"; 
		   }
	    else{   echo $Pick['choice_val']."</br>";}
	     }	    
	  echo " </div>
	     </div>";	  
	}else if($PerItem['item_type']==2){
          $t_fInfo = $this->Questions->reviewTF($PerItem['item_id']);
	  $storedTF = $this->Questions->getTF_StoredA($strec_id,$PerItem['item_id']);
	  foreach($t_fInfo as $key){
	    if($key['ans']){
	      $ans = "TRUE";
	    }else{
	      $ans = "FALSE";  
	    }
	    $points = $key['points'];
	  }
	  foreach($storedTF as $out){
           if($out['ans']){
             $StudAns = "TRUE";
           }else{ $StudAns = "FALSE";}
          }
	 echo " <div class='panel panel-default'>
	    <div class='panel-heading'>";
	  echo "<h4  class='panel-title'>".$PerItem['question']."</h4>";
    	  echo"   </div>
	     <div class='panel-body'>";
	  if(($StudAns==$ans)&&$ans=="TRUE"){
	    echo "<p class='text-success'>Your Answer: <b>True 
                  <span class='glyphicon glyphicon-check'></span>"
                  .$points." Point(s)</b></p>";
	  }else if(($StudAns==$ans)&&$ans=="FALSE"){
            echo "<p class='text-success'>Your Answer: <b>False 
                  <span class='glyphicon glyphicon-check'></span>"
                  .$points." Point(s)</b></p>";	  
          }
	  else if(($StudAns!=$ans)&&$ans=="FALSE"){
	    echo "<p class='text-success'> Correct Answer: <b>False
                  <span class='glyphicon glyphicon-check'></span>"
                  .$points." Point(s)</b></p>
                  <p class='text-danger'> Your Answer: <b>
                  <span class='glyphicon glyphicon-remove'></span> True</b>";
	  }else{	    
	    echo "<p class='text-success'> Correct Answer: <b>True
                  <span class='glyphicon glyphicon-check'></span>"
                  .$points." Point(s)</b></p>
                  <p class='text-danger'> Your Answer: <b>
                  <span class='glyphicon glyphicon-remove'></span>False</b>";
	  }
	    echo" </div></div>";
	}else if($PerItem['item_type']==3){
          $mt_fInfo = $this->Questions->reviewMTF($PerItem['item_id']);
	  $storedMTF = $this->Questions->getMTF_StoredA($strec_id,$PerItem['item_id']);	  
	  foreach($mt_fInfo as $key){
	    $MTFans = $key['ans'];
	    $points = $key['points'];	
	  }
	    
	  foreach($storedMTF as $out){
	    $StudMTFAns = trim($out['ans']);             
	  }
	  echo " <div class='panel panel-default'>
	    <div class='panel-heading'>";
	  echo "<h4  class='panel-title'>".$PerItem['question']."</h4>";
    	  echo"   </div>
	     <div class='panel-body'>";
	  if($this->Questions->isCorrectMTF($PerItem['item_id'],$StudMTFAns)){
	    echo "<p class='text-success'> Your Answer: <b> {$StudMTFAns}
                  <span class='glyphicon glyphicon-check'></span>".$points."
                  Point(s)</b></p>";
	  }else{
	     echo "<p class='text-danger'> Your Answer: 
                   <span class='glyphicon glyphicon-remove'></span>
                   <b> {$StudMTFAns}</b>                  
	          </b></p>
                  <p class='text-success'> Correct Answer: <b> {$MTFans}
                  <span class='glyphicon glyphicon-check'></span>
                  ".$points."Point(s)</b>";  
	  }echo"</div> </div>";	 
	}else if($PerItem['item_type']==4){
          $IdentInfo = $this->Questions->reviewIdent($PerItem['item_id']);
	  $storedIdent = $this->Questions->getIdent_StoredA($strec_id,$PerItem['item_id']);
	  foreach($IdentInfo as $key){
	    $IdentAns = trim($key['ans']);
	    $points = $key['points'];
	  }

	  foreach($storedIdent as $out){
	    $StudIdentAns = trim($out['ans']);
	  }
	 $storedLow =  strtolower($StudIdentAns);
	 $ansLow = strtolower($IdentAns);
	  echo " <div class='panel panel-default'>
	    <div class='panel-heading'>";
	  echo "<h4  class='panel-title'>".$PerItem['question']."</h4>";
    	  echo"   </div>
	     <div class='panel-body'>";
	  if($ansLow==$storedLow){
	    echo "<p class='text-success'> Your Answer: <b> {$StudIdentAns}
                  <span class='glyphicon glyphicon-check'></span>".$points."
                  Point(s)</b></p>";
	  }else{
	     echo "<p class='text-danger'> Your Answer: <b> 
                  <span class='glyphicon glyphicon-remove'></span>
                  {$StudIdentAns}</b>
	          </b></p>
                  <p class='text-success'> Correct Answer: <b> {$IdentAns}
                  <span class='glyphicon glyphicon-check'></span>
                  ".$points."Point(s)</b>";  
	  }echo"</div> </div>";	 
	
	}
      }
	}
     
	echo "</div>";  
      echo "<input class='btn-primary btn-lg' type='submit' name='subans' value='Return'>";
	echo"</form>";

	}
}
   public function CheckAnswers($AnsInfo){
     $Score = NULL;
     $studenttestrec = array();
     echo "stud_id".$_SESSION['stud_id'];
     echo "studC_id".$_SESSION['studC_id'];
     echo "scr_id".$_SESSION['scr_id'];
     print_r($AnsInfo);
       $test_id = $AnsInfo['test_id'];
       $icr_id = $AnsInfo['Course_id'];
       $scr = $this->Questions->getSCR_ID($_SESSION['stud_id'],$icr_id); 
       //print_r($scr);
       foreach($scr as $key){
       $scr_id = $key['scr_id'];
       }
       $DateTaken = $ansInfo['DateTaken'];

       foreach($AnsInfo['Answers'] as $Picked){
	 if($Picked['item_type']==1){
	  $MPCAns = $this->Questions->getMCPAnsby_ChoiceID($Picked['choice_id']);
	   if(isset($MPCAns)){
	     foreach($MPCAns as $key){$Score+=$key['points'];}
	   }
	 }else if($Picked['item_type']==2){
	   $TFAns = $this->Questions->getTFAnsby_ChoiceID($Picked['choice_id'],$Picked['item_id']);
	   if(isset($TFAns)){
	   foreach($TFAns as $key){$Score+=$key['points'];}
	   }
	 }else if($Picked['item_type']==3){
	   if($Picked['choice_id']=="True"){
	     $MTFAns = $this->Questions->getMTFAnsby_ChoiceID($Picked['choice_id'],$Picked['item_id']);
	   }else{
	     $answer = strtolower($Picked['choice_id']);
	     trim($answer);
	     $MTFAns = $this->Questions->getMTFAnsby_ChoiceID($answer,$Picked['item_id']);
             print_r($MTFAns);
	   }
	   if(isset($MTFAns)){
	     foreach($MTFAns as $key){$Score+=$key['points'];}
	   }
	 }else if($Picked['item_type']==4){
	   $Ianswer = strtolower($Picked['choice_id']);
	   trim($Ianswer);
	   $identAns = $this->Questions->getIDENTIFICATIONans($Picked['item_id']);
           print_r($identAns);
	   if(isset($identAns)){
	     foreach($identAns as $key){
	       $fstCor = trim($key['ans']);
	       $correctAns  = strtolower($fstCor);
	       if($correctAns==$Ianswer){
	       $Score+=$key['points'];
	       }
	     }
	   }
	 }
       }
       $currentDate = new DateTime();  
       $studenttestrec = array(":test_id"=>$test_id,
			       ":scr_id"=>$scr_id,
			       ":score"=>$Score,
			       ":date_taken"=>$currentDate->format('Y-m-d'));
       print_r($studenttestrec);
       $this->Questions->insertStudenttestrec($studenttestrec);
}
    public function storeStudentAnswers($AnsInfo){
   $studenttest = $this->Questions->getNewStrec_id();
   
       foreach($studenttest as $key){
	 $strec_id = $key['max(strec_id)'];
       }
       foreach($AnsInfo['Answers'] as $Storeby_item){

	 if($Storeby_item['item_type']==1){ 
	   $MPCAns = array(":strec_id"=>$strec_id,
			   ":item_id"=>$Storeby_item['item_id'],
			   ":choice_id"=>$Storeby_item['choice_id']);
	   $this->Questions->storeMPCAns($MPCAns);
	 }else if($Storeby_item['item_type']==2){
	   $TFAns = array(":item_id"=>$Storeby_item['item_id'],
			  ":strec_id"=>$strec_id,			   
			  ":ans"=>($Storeby_item['choice_id']));
	   $this->Questions->storeTFAns($TFAns);
	 }else if($Storeby_item['item_type']==3){
	  if($Storeby_item['choice_id']=="True"){
	    $answer = $Storeby_item['choice_id'];
	  }else{
	     $answer = strtolower($Storeby_item['choice_id']);
	     trim($answer);
	  } 
	   $MTFAns = array(":item_id"=>$Storeby_item['item_id'],
			   ":strec_id"=>$strec_id,
			   ":ans"=>sanitize($answer));
	   $this->Questions->storeMTFAns($MTFAns);
	 }else if($Storeby_item['item_type']==4){
	   $answer = strtolower($Storeby_item['choice_id']);
	   trim($answer);
	   $identAns = array(":item_id"=>$Storeby_item['item_id'],
			     ":strec_id"=>$strec_id,
			     ":ans"=>sanitize($answer));
	   $this->Questions->storeIdentAns($identAns);
	 }
       }
    }
}
	      