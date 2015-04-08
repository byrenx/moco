<?php
class TimeLib{
  public function __construct(){
  }

  public function formatTime($mins){
    /*
     * @param $mins -> minutes
        
     * this function will format and return hour, min
      conversion of minutes
     */

    $hr = (int)($mins/60);
    $min = 0;
    $str_time_format = null;
    if($hr>0){
      $str_time_format.=$hr." Hour(s)  ";
      $min = ($mins-($hr*60));
      $str_time_format.=$min." Minute(s)";
      return $str_time_format;
    }else{
      return $mins." Minute(s)";
    }
  }

  public function dateSQL($date){
    /*
      precondition: date is a in a format mm/dd/yyyy
                    date is a valid format mm/dd/yyyy

      postcondition: return a Sql date format
     */
    $sql_date = null;
    $month = substr($date, 0, 2);
    $day = substr($date, 3, 2);
    $year = substr($date, 6, 4);

    return $year."-".$month."-".$day;
  }
}

?>