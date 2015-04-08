<?php


class Account{
  protected $db_connector;
  protected $uname;
  protected $password;
  protected $query;  
  protected $account_session = 'active';
  public function __construct($connector){
    $this->db_connector = $connector;
  }

  public function validatingAccess(){
    $target = $_POST['target'];
    $this->uname=$_POST['uname'];
    $this->password = $_POST['password'];
    $this->Stud_Enroll = $_POST['EnrollID'];
    $this->C_name = $_POST['Cor_code'];

    echo $this->uname . ' ' . $this->password . ' ' . $target . ' ' . $this->isValidInstructor();
    
    if($target=='i' && $this->isValidInstructor()){
       session_start();
       $this->createInstructorSession();
       header("Location: ../../instructor_module/pages/course_dashboard.php");
    }else if($target=='s' && $this->isValidStudent()){
      session_start();
      $this->createStudentSession();
      if(isset($_SESSION['CourseID']) && isset($_SESSION['CourseName'])){
	header("Location: ../../Student_Module/pages/Offered_Courses.php");
      }else{
	header("Location: ../../Student_Module/pages/Course_Dashboard.php");}
    }else{
       header("Location: ../../login.php?status=error");
    }
  }

  private function isValidInstructor(){
    $this->query = "SELECT COUNT(*) FROM employees
                    WHERE IDNUMBER=?
                    AND PASS_WORD=?";
    $params = array(sanitize($this->uname),sanitize($this->password));
    $rs = $this->db_connector->select($this->query, $params);
    return  $rs->fetchColumn()>0;
  }

  private function isValidStudent(){
     $this->query = "SELECT COUNT(*) FROM studentaccounts
                    WHERE IDNUMBER=?
                    AND PASS_WORD=?";
    $params = array($this->uname,$this->password);
    $rs = $this->db_connector->select($this->query, $params);

    return  $rs->fetchColumn()>0;
  }

  private function loadInstructorInfo(){
    $this->query = "SELECT * from employees
                    WHERE idnumber=?";
    $rs = $this->db_connector->select($this->query, array($this->uname));
    if($rs)
      return $rs->fetch();
    else return null;
  }  

  private function loadStudentInfo(){
    $this->query = "SELECT * from students
                    WHERE IDNUMBER=?";
    $rs = $this->db_connector->select($this->query, array($this->uname));
    if($rs)
      return $rs->fetch();
    else return null;
  } 

  private function createInstructorSession(){
   
    $inst_inf=$this->loadInstructorInfo();
   
    $_SESSION['inst_id'] = $this->uname;
    $_SESSION['pix'] = '';
    $_SESSION['instructor_name'] = $inst_inf[1]." ". $inst_inf[2]." ". $inst_inf[3];
      //$inst_inf['middlename']." ".
      //                           $inst_inf['lastname'];*/
    
  }
 private function createStudentSession(){
    $stud_inf=$this->loadStudentInfo();
    if(isset($_POST['EnrollID']) && isset($_POST['Cor_code'])){
      $_SESSION['CourseID'] = $_POST['EnrollID'];
      $_SESSION['CourseName'] = $_POST['Cor_code'];
      $_SESSION['acc_stat'] = $account_session;
    }
    $_SESSION['stud_id'] = $this->uname;
    $_SESSION['pix'] = $stud_inf["PICTURE"];
    $_SESSION['student_name'] = $stud_inf['LASTNAME']. ", " . $stud_inf['FIRSTNAME'] . " " . $stud_inf['MIDDLENAME'];
      //$inst_inf['middlename']." ".
      //                           $inst_inf['lastname'];*/
    
  }
}



?>