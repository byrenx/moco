<?php
require_once '../../libraries/proj_abs_cls/quiz_abs.php';

class QuizModel extends Quiz{
 
  public function beginTransaction(){
    $this->db_connector->trans_beg();
  }

  public function commitTransaction(){
    $this->db_connector->commit();
  }

  public function rollBack(){
    $this->db_connector->rollback();
  }
  
  public function addTest($test_param){

    $query = "INSERT INTO test(ic_id,
                               title,
                               test_type,
                               due_date,
                               test_date,
                               duration)
             VALUES(?,?,?,?,?,?)";
    
    return $this->db_connector->insert($query, $test_param);
  }  
  
  public function getNewTest($ttype){
    $query = "SELECT * FROM test
              WHERE test_id=(SELECT MAX(test_id)
                             FROM test 
                             WHERE test_type=$ttype)";
    return $this->db_connector->selectAll($query)->fetch();
  }

  public function getTest($test_id){
    $query = "SELECT * FROM test WHERE test_id = ?";
    return $this->db_connector->select($query, array($test_id))->fetch();
  }

  public function getQuiz($id){
    $query = "SELECT test_id, ic_id, test_type, 
                     date_format(due_date, '%m/%d/%Y') as due_date,
                     date_format(test_date, '%m/%d/%Y') as test_date,
                     total_items, 
                     total_points, title, duration
              FROM test
              WHERE test_id=$id";
    return $this->db_connector->selectAll($query)->fetch();
  }

  public function getQuizzes($icr_id){
    //$icr_id -> instructor course record id
    //test type 0 is Quiz, 1 for Exam
    $this->query = "SELECT test_id, ic_id, test_type, 
                     date_format(due_date, '%m/%d/%Y') as due_date,
                     date_format(test_date, '%m/%d/%Y') as test_date,
                     total_items, 
                     total_points, title, duration,
                     (select count(*) from studenttestrec where test_id=test.test_id) as results 
                    FROM test
                    WHERE ic_id=$icr_id
                    AND test_type=0"; 
     return $this->db_connector->selectAll($this->query)->fetchAll();
  }

  public function getExams($ic_id){
    $query = "SELECT test_id, ic_id, test_type, 
                     date_format(due_date, '%m/%d/%Y') as due_date,
                     date_format(test_date, '%m/%d/%Y') as test_date,
                     total_items, 
                     total_points, title, duration,
                     (select count(*) from studenttestrec where test_id=test.test_id) as results 
             FROM test
             WHERE ic_id = $ic_id
             AND test_type=1";
    return $this->db_connector->selectAll($query)->fetchAll();
  }

  public function updateTest(){
    $due = new DateTime(sanitize($_POST['dd']));
    $start = new DateTime(sanitize($_POST['da']));

    $params = array(sanitize($_POST['q_title']),
		    $due->format('Y-m-d'),
                    $start->format('Y-m-d'),
                    ($_POST['time']==1? $_POST['duration']: -1),
                    $_POST['test_id']
                    );
    $query = "UPDATE test
              SET title=?,
              due_date=?,
              test_date=?,
              duration=?
              WHERE test_id=?";
    
    return $this->db_connector->update($query, $params);
  }

  public function del_test(){
    $query = "DELETE FROM test WHERE test_id = ?";
    return $this->db_connector->delete($query, array($_POST['test_id']));
  }

  public function addItem($item){

     $query = "INSERT INTO item(test_id,item_type,question, points)
               VALUES(?, ?, ?, ?)";

     return $this->db_connector->insert($query, $item);
  }

  public function has_test_rec($test_id){
    $query = "SELECT COUNT(*) FROM studenttestrec where test_id=$test_id";
    return $this->db_connector->count($query)>0;
  }

  public function getNewItemID($test_id){
    $query = "SELECT MAX(item_id) FROM item
              WHERE test_id=$test_id";
    return $this->db_connector->selectAll($query)->fetchColumn(0); 
  }

  public function delItem($item_id){
    $query = "DELETE FROM item
              WHERE item_id=?";
    $this->db_connector->delete($query, array($item_id));
  }

  /*
   * Quiz Item 
   */
  

  public function getMPItem($item_id){
    $query="SELECT * FROM item WHERE item_id=?";

    $item = $this->db_connector->select($query, array($item_id))->fetch();

    $query = "SELECT * FROM mpchoice WHERE item_id=? ORDER BY c_no ASC";
    $item['choices'] = $this->db_connector->select($query, array($item_id))->fetchAll();
    //$this->db_connector->closeConn();
    return $item;
  }


  /*
   *TRUE OR FALSE ITEM
   */
 
  public function addTFItem($item){
    $query = "INSERT INTO t_f(item_id, ans) VALUES(?,?)";
    return $this->db_connector->insert($query, $item);
  }

  public function updateTFItem( $item, $tf_data){
    if($this->updateItem($item)){
      $query = "UPDATE t_f
                SET 
                item_id = :item_id,
                ans = :ans
                WHERE tf_id = :tf_id";

      return $this->db_connector->update($query, $tf_data);
    }else{
      return false;
    }
    

  }

  public function getTFItem($item_id){
    $query = "SELECT item.*,t_f.*
              FROM item INNER JOIN t_f
              ON item.item_id=$item_id
              AND t_f.item_id=$item_id";
    return $this->db_connector->selectAll($query)->fetch();
  }

  /*
    modified true or false
   */
  public function addMTFItem($item_params){

    $query= "INSERT INTO mt_f(item_id, ans)
             VALUES(:item_id,:ans)";

    return $this->db_connector->insert($query, $item_params);
  }

  public function getMTFItem($item_id){
    $query = "SELECT *
              FROM item INNER JOIN mt_f
              ON item.item_id = $item_id
              AND mt_f.item_id = $item_id";
    return $this->db_connector->selectAll($query)->fetch();
  }

  public function u_mtf($item_params){//update t or f item
    $query = "UPDATE item, mt_f  SET
              item.question = :question,
              item.points = :points,
              mt_f.ans = :ans
              WHERE item.item_id = :item_id AND mt_f.item_id = :item_id";
    return $this->db_connector->update($query, $item_params);
  }

  /*******end of true pr false item*******/

  /*
    identification item
   */

  public function addIdenItem($item_params){
    $query = "INSERT INTO identification
              (item_id, ans)
              VALUES(:item_id, :ans)";
    return $this->db_connector->insert($query, $item_params);
  }
  
  public function u_iditem($item_params){
    $query = "UPDATE item, identification SET 
              question = :question,
              ans = :ans,
              points = :points
              WHERE item.item_id = :item_id AND identification.item_id = :item_id";
    return $this->db_connector->update($query, $item_params);
  }

  public function getIdenItem($item_id){
    $query = "SELECT item.*, identification.*
              FROM item INNER JOIN identification
              ON item.item_id = $item_id
              AND identification.item_id = $item_id";
    return $this->db_connector->selectAll($query)->fetch();
  }

  /*
    end of identification item
   */

  public function countItems($test_id){
    $query = "SELECT COUNT(*) FROM
              item WHERE test_id=$test_id";
    return $this->db_connector->count($query);
  }

  public function addChoice($answer_key, $item_id, $letter, $c_no){

    $param = array($item_id,
                  $_POST[$letter], //choice value
                  ($answer_key==$letter? 1: 0),
		  $c_no);
    
    $query = "INSERT INTO mpchoice(item_id, choice_val, iscorrect, c_no)
              VALUES(?,?,?,?)";

    $this->db_connector->insert($query, $param);
  }

  
  public function updateItem($param){
     $query = "UPDATE item SET
              question = :question,
              points = :points
              WHERE item_id=:item_id";
     
     return $this->db_connector->update($query, $param);
  }

  public function updateMPItem($item, $choices){

    if($this->updateItem($item)){
      foreach($choices as $choice){
         $this->updateChoice($choice);
      }
      return true;
    }else{
      return false;
    }
  }

  public function updateChoice($choice){
     $query = "UPDATE mpchoice SET
               choice_val = :choice_val,
               iscorrect= :correct
               WHERE choice_id = :choice_id 
              ";
     $this->db_connector->update($query, $choice);
  }




  public function getAllItems($test_id){
    
    $query = "SELECT * FROM item
              WHERE test_id = $test_id";
    return $this->db_connector->selectAll($query)->fetchAll(); 
  }

  public function getItem($item_id){
    $query = "SELECT * FROM item
              WHERE item_id=$item_id";
    return $this->db_connector->selectAll($query)->fetch();
  }

  public function getItemChoices($item_id){
    $query = "SELECT * FROM mpchoice
              WHERE item_id=$item_id";
    return $this->db_connector->selectAll($query)->fetchAll();
  }

  //get the answer and points corresponds to a true or false item
  public function getTFAnsPoints($item_id){
    $query = "SELECT * FROM t_f
            WHERE item_id=$item_id";
    return $this->db_connector->selectAll($query)->fetch();
  }


  //****** modified true or false item**********//
  
  private function addMTFAns($item_id, $answer){
    $query = "INSERT INTO mt_f(item_id, ans, points)
              VALUES(?,?,?)";
    $param = array($item_id, $answer, $_POST['points']);
    $this->db_connector->insert($query, $param);
  }

  
  private function updateMTFAnsPoints($mtf_item_id){
     
    $query = "UPDATE mt_f SET
              ans=:ans,
              points=:points
              WHERE mtf_id=:mtf_id";
      
    $param = array("mtf_id"=>$_POST['mtf_id'],
                   "ans"=>$_POST['ans']);

       
  }

  
  //*****end of modified true or false item*********//

  public function isQuestionExist($test_id, $item_id){
    /**
       $item_id : if item_id is 0 then this item is new
                  else it already exist and needs ony an update
		     //the purpose of this mechanism is to check
		     //if there exist a question which its item_id 
		     //is different from the parameter item_id
     */
    
    $query = "SELECT * FROM item
              WHERE question=? 
              AND test_id=$test_id";

    if($item_id>0){
      $query.=" AND item_id<>$item_id";
    }

    $param = array(sanitize($_POST['question']));
    return $this->db_connector->doesExistSelect($query, $param);
  }

  public function getRs($test_id){
    $query = "SELECT students.IDNUMBER, 
                     students.LASTNAME,
                     students.MIDDLENAME,
                     students.FIRSTNAME, 
                     studenttestrec.date_taken, 
                     studenttestrec.score
              FROM studenttestrec
              INNER JOIN studentcourserecord
                    ON studentcourserecord.scr_id = studenttestrec.scr_id
              INNER JOIN students
                    ON students.IDNUMBER = studentcourserecord.IDNUMBER
              WHERE studenttestrec.test_id = ?
                    ORDER BY studenttestrec.date_taken DESC"; 
    
    return $this->db_connector->select($query, array($test_id))->fetchAll();
  }
  
}

?>