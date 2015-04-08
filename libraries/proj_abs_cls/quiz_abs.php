<?php

require_once '../../libraries/database/pdo/db_connect.php';
require_once '../../libraries/php/sanitizer.php';


abstract class Quiz{

  protected $db_connector;
  protected $query;

  public function __construct(){
    $this->db_connector = new DBConnector();  
    $this->db_connector->connect();   
  }
  public function isTaken($test_id,$scr_id){
    $this->query = "SELECT *
                    FROM studenttestrec
                    WHERE test_id=$test_id
                    AND scr_id=$scr_id";
    return $this->db_connector->doesExist($this->query);    
  }

  public function isCorrectMTF($item_id,$ans){
    $this->query = "SELECT *
                    FROM mt_f
                    WHERE item_id=$item_id
                    AND ans='$ans'";
    return $this->db_connector->doesExist($this->query);    
  }
  public function getStudentTestRec($test_id,$scr_id){
    $this->query = "SELECT *
                    FROM studenttestrec
                    WHERE test_id=$test_id
                    AND scr_id=$scr_id";
    return $this->db_connector->selectAll($this->query)->fetchAll();
  }

  public function getQuizzes($icr_id){
    //$icr_id -> instructor course record id
    //test type 0 is Quiz, 1 for Exam
    $this->query = "SELECT * FROM test
                    WHERE ic_id=$icr_id
                    AND test_type=0
                    ORDER BY test_id DESC"; 
     return $this->db_connector->selectAll($this->query)->fetchAll();
  }
   public function getExams($icr_id){
    //$icr_id -> instructor course record id
    //test type 0 is Quiz, 1 for Exam
    $this->query = "SELECT * FROM test
                    WHERE ic_id=$icr_id
                    AND test_type=1
                    ORDER BY test_id DESC"; 
     return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function getAllItems($testID){
    $this->query = "SELECT * FROM item
                    WHERE test_id=$testID
                    ORDER BY rand(), item_id";
    //echo $this->query;
     return $this->db_connector->selectAll($this->query)->fetchAll();
  }

  public function getRev_Items($testID){
    $this->query = "SELECT * FROM item
                    WHERE test_id=$testID
                    ORDER BY item_id ASC";
    //echo $this->query;
     return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function getAllMPC($itemID){
    $this->query = "SELECT *
                     FROM mpchoice
                     WHERE item_id=$itemID
                     ORDER BY rand(), choice_id";
    //echo $this->query;
     return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function getAllTF($itemID){
    $this->query = "SELECT *
                     FROM t_f
                     WHERE item_id=$itemID";
        return $this->db_connector->selectAll($this->query)->fetchAll();
  }

  public function getAllMTF($itemID){
    $this->query = "SELECT *
                     FROM mt_f
                     WHERE item_id=$itemID";
        return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function getAllIdent($itemID){
    $this->query = "SELECT *
                     FROM identification
                     WHERE item_id=$itemID";
        return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function getMCPAnsby_ChoiceID($choice_id){
    if($choice_id){
    $this->query = "SELECT mpc.choice_id, mpc.item_id, mpc.iscorrect,
                           i.item_id, i.points
                      FROM mpchoice mpc, item i
                      WHERE mpc.choice_id=$choice_id
                      AND mpc.item_id=i.item_id
                      AND mpc.iscorrect=1";
     return $this->db_connector->selectAll($this->query)->fetchAll();
    }else
      return false;
  }

  public function getTFAnsby_ChoiceID($choice_id,$item_id){
    if($choice_id&&$item_id){
        $this->query = "SELECT tf.ans, tf.item_id,
                           i.item_id, i.points
                     FROM t_f tf, item i                    
                     WHERE tf.ans=$choice_id
                     AND i.item_id=$item_id
                     AND i.item_id=tf.item_id";
        return $this->db_connector->selectAll($this->query)->fetchAll();
    }else{
      return false;
    }

  }

  public function getMTFAnsby_ChoiceID($choice_id,$item_id){
    if($choice_id&&$item_id){
    $this->query = "SELECT mtf.ans, mtf.item_id,
                               i.points, i.item_id
                     FROM mt_f mtf, item i
                     WHERE mtf.ans='$choice_id'
                     AND mtf.item_id=$item_id
                     AND i.item_id=mtf.item_id";
    return $this->db_connector->selectAll($this->query)->fetchAll();
    }else{
      return false;
    }
  }
  public function getIDENTIFICATIONans($item_id){
    if($item_id){
    $this->query = "SELECT idn.ans, idn.item_id,
                               i.points, i.item_id
                     FROM identification idn, item i
                     WHERE idn.item_id=$item_id
                     AND i.item_id=idn.item_id";
    
    return $this->db_connector->selectAll($this->query)->fetchAll();
    }else{
      return false;
    }
  } 
  public function getMPC_StoredA($strec_id,$item_id){
    $this->query = "SELECT * 
                    FROM stud_mpc_ans
                    WHERE strec_id=$strec_id
                    AND item_id=$item_id";
    return $this->db_connector->selectAll($this->query)->fetchAll();
  }

  public function getTF_StoredA($strec_id,$item_id){
    $this->query = "SELECT * 
                    FROM stud_tf_ans
                    WHERE strec_id=$strec_id
                    AND item_id=$item_id";
    return $this->db_connector->selectAll($this->query)->fetchAll();
  }

  public function getMTF_StoredA($strec_id,$item_id){
    $this->query = "SELECT * 
                    FROM stud_mtf_ans
                    WHERE strec_id=$strec_id
                    AND item_id=$item_id";
    return $this->db_connector->selectAll($this->query)->fetchAll();
  }
public function getIdent_StoredA($strec_id,$item_id){
    $this->query = "SELECT * 
                    FROM stud_ident_ans
                    WHERE strec_id=$strec_id
                    AND item_id=$item_id";
    return $this->db_connector->selectAll($this->query)->fetchAll();
  }

  public function reviewMPC ($item_id){
    $this->query = "SELECT mpc.choice_id, mpc.item_id, mpc.choice_val,
                           mpc.iscorrect, mpc.c_no, i.item_id, i.points
                    FROM  mpchoice mpc, item i
                    WHERE mpc.item_id=$item_id
                    AND i.item_id=mpc.item_id";
    return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function reviewTF($item_id){
       $this->query = "SELECT tf.ans, tf.item_id,
                               i.points, i.item_id
                     FROM t_f tf, item i
                     WHERE tf.item_id=$item_id
                     AND i.item_id=tf.item_id";

    return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function reviewMTF($item_id){
       $this->query = "SELECT mtf.ans, mtf.item_id,
                               i.points, i.item_id
                     FROM mt_f mtf, item i
                     WHERE mtf.item_id=$item_id
                     AND i.item_id=mtf.item_id";
    
    return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function reviewIdent($item_id){
    $this->query = "SELECT idn.ans, idn.item_id,
                               i.points, i.item_id
                     FROM identification idn, item i
                     WHERE idn.item_id=$item_id
                     AND i.item_id=idn.item_id";
    
    return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  
  

  public function getQuizItems($testID){
    $QuizItems = $this->getAllItems($testID);
    //print_r($QuizItems);
    $itemsAndQ = array();
    $mpChoice = array();
    $MPC = array();
    $TF = array();
    $MTF = array();
    $identification = array();
      foreach($QuizItems as $items){
      if($items['item_type']==1){
	$MPCVar = $this->reviewMPC($items['item_id']);
	foreach($MPCVar as $Choices){
               $mpChoice[] = array( "choice_val"=>$Choices['choice_val'],
			      "c_no"=>$Choices['c_no'],
                              "isCorrect"=>$Choices['iscorrect'],
   			      "points"=>$Choices['points'],
			      "Choice_ID"=>$Choices['choice_id']);
	                      
	}
	/*$MPC [] = array("item_id"=>$items['item_id'],
		        "MPQ"=>$items['question'],
			"Choices"=>$mpChoice);*/
	$itemsAndQ[]= array("item_id"=>$items['item_id'],
		        "MPQ"=>$items['question'],
        		"item_type"=>$items['item_type'],
			"Choices"=>$mpChoice);
	     $mpChoice = array();
      }
 	if($items['item_type']==2){
	    $itemsAndQ[] = array("item_id"=>$items['item_id'],
				 "question"=>$items['question'],
				 "item_type"=>$items['item_type']);
	}if($items['item_type']==3){
	  $itemsAndQ[] = array("item_id"=>$items['item_id'],
			       "question"=>$items['question'],
			       "item_type"=>$items['item_type']);
	}if($items['item_type']==4){
	  $itemsAndQ[] = array("item_id"=>$items['item_id'],
			       "question"=>$items['question'],
			       "item_type"=>$items['item_type']);
	}
      }
    return $itemsAndQ;
    $itemsAndQ = array();
      }

  public function getReviewItems($testID){
    $QuizItems = $this->getRev_Items($testID);
    //print_r($QuizItems);
    $itemsAndQ = array();
    $mpChoice = array();
    $MPC = array();
    $TF = array();
    $MTF = array();
    $identification = array();
      foreach($QuizItems as $items){
      if($items['item_type']==1){
	$MPCVar = $this->reviewMPC($items['item_id']);
	foreach($MPCVar as $Choices){
               $mpChoice[] = array( "choice_val"=>$Choices['choice_val'],
			      "c_no"=>$Choices['c_no'],
                              "isCorrect"=>$Choices['iscorrect'],
   			      "points"=>$Choices['points'],
			      "Choice_ID"=>$Choices['choice_id']);
	                      
	}
	/*$MPC [] = array("item_id"=>$items['item_id'],
		        "MPQ"=>$items['question'],
			"Choices"=>$mpChoice);*/
	$itemsAndQ[]= array("item_id"=>$items['item_id'],
		        "MPQ"=>$items['question'],
        		"item_type"=>$items['item_type'],
			"Choices"=>$mpChoice);
	     $mpChoice = array();
      }
 	if($items['item_type']==2){
	    $itemsAndQ[] = array("item_id"=>$items['item_id'],
				 "question"=>$items['question'],
				 "item_type"=>$items['item_type']);
	}if($items['item_type']==3){
	  $itemsAndQ[] = array("item_id"=>$items['item_id'],
			       "question"=>$items['question'],
			       "item_type"=>$items['item_type']);
	}if($items['item_type']==4){
	  $itemsAndQ[] = array("item_id"=>$items['item_id'],
			       "question"=>$items['question'],
			       "item_type"=>$items['item_type']);
	}
      }
    return $itemsAndQ;
    $itemsAndQ = array();
      }
  public function getSCR_ID($stud_id,$ic_id){
    $this->query = "SELECT *
                     FROM studentcourserecord
                     WHERE IDNUMBER=$stud_id
                     AND ic_id=$ic_id";
    return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function insertStudenttestrec($studenttestrec){
    $this->query = "INSERT INTO studenttestrec(test_id,scr_id,score,date_taken)
                  VALUES(:test_id,:scr_id,:score,:date_taken)";
     try{
       //    print_r($studenttestrec);
     $this->db_connector->insert($this->query, $studenttestrec);
      }catch(Exception $ex){
      //redirect to system error pageg
      }
  }
  public function getNewStrec_id(){
    $this->query = "SELECT max(strec_id)
                    FROM studenttestrec";
     return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function getSrec_id($test_id,$scr_id){
    $this->query = "SELECT *
                    FROM studenttestrec
                    WHERE test_id=$test_id
                    AND scr_id=$scr_id";
     return $this->db_connector->selectAll($this->query)->fetchAll();
  }
  public function storeMPCAns($MPCAns){
    $this->query = "INSERT INTO stud_mpc_ans(item_id,choice_id,strec_id)
                    VALUES (:item_id,:choice_id,:strec_id)";
    try{
      $this->db_connector->insert($this->query,$MPCAns);
    }catch(Exception $ex){
      //redirect to system error page
    }
  }
  public function storeTFAns($TFAns){
    $this->query = "INSERT INTO stud_tf_ans(item_id,strec_id,ans)
                    VALUES (:item_id,:strec_id,:ans)";
    try{
      $this->db_connector->insert($this->query,$TFAns);
    }catch(Exception $ex){
      //redirect to system error page
    }
  }
  public function storeMTFAns($MTFAns){
    $this->query = "INSERT INTO stud_mtf_ans(item_id,strec_id,ans)
                    VALUES (:item_id,:strec_id,:ans)";
    try{
      $this->db_connector->insert($this->query,$MTFAns);
    }catch(Exception $ex){
      //redirect to system error page
    }
  }
  public function storeIdentAns($identAns){
    $this->query = "INSERT INTO stud_ident_ans(item_id,strec_id,ans)
                    VALUES (:item_id,:strec_id,:ans)";
    try{
      $this->db_connector->insert($this->query,$identAns);
    }catch(Exception $ex){
      //redirect to system error page
    }
  }
}
 

?>