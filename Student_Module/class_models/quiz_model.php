<?php
require_once '../../libraries/proj_abs_cls/quiz_abs.php';

class QuizModel extends Quiz{
 
  public function addQuiz(){
    $due = new DateTime(sanitize($_POST['dd']));
    $start = new DateTime(sanitize($_POST['da']));
    
    $params = array($_POST['icr_id'],
                    sanitize($_POST['q_title']),
                    false,
                    $due->format('Y-m-d'),
                    $start->format('Y-m-d'),
                    $_POST['duration']);
    $query = "INSERT INTO test(ic_id,
                               title,
                               test_type,
                               due_date,
                               test_date,
                               duration)
             VALUES(?,?,?,?,?,?)";
    
    return $this->db_connector->insert($query, $params);
  }  

  public function getNewQuiz(){
    $query = "SELECT * FROM test
              WHERE test_id=(SELECT MAX(test_id)
                           FROM test 
                           WHERE test_type=0)";
    return $this->db_connector->selectAll($query)->fetch();
  }

  public function getQuiz($id){
    $query = "SELECT * FROM test
              WHERE test_id=$id";
    return $this->db_connector->selectAll($query)->fetch();
  }

  public function updateQuiz(){
    $due = new DateTime(sanitize($_POST['dd']));
    $start = new DateTime(sanitize($_POST['da']));

    $params = array(sanitize($_POST['q_title']),
		    $due->formatclass_interface/('Y-m-d'),
                    $start->format('Y-m-d'),
                    $_POST['duration'],
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


  /*
   * Quiz Item 
   */

  private function countItems($test_id){
    $query = "SELECT COUNT(*) FROM
              item WHERE test_id=$test_id";
    return $this->db_connector->count($query);
  }
  
 
}

?>