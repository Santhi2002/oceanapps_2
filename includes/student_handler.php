<?php
class StudentManager extends Connection
{
 public $db;
  function __construct()
  {
    $this->db=new Connection();
 
  }
  
  public function getStudentMasterData($rollno)
  {
		$columndata=$this->db->getRecord("SELECT * FROM tblstudents  WHERE rollno='".$rollno."'  LIMIT 1 ");
		return $columndata;
  }
  public function getStudentProfileData($rollno)
  {
		$columndata=$this->db->getRecord("SELECT * FROM tblstudents INNER JOIN tblextstudents ON tblstudents.rollno= tblextstudents.student_id  WHERE tblstudents.rollno='".$rollno."'  LIMIT 1 ");
		return $columndata;
  }

  public function searchStudentData($search)
  {
		$columndata=$this->db->getRecords("SELECT * FROM tblstudents   WHERE rollno like '%".$search."%' or studentname like '%".$search."%'   LIMIT 1 ");
		return $columndata;
  }
  
  public function getStudentFeeHistory($rollno)
  {
		$columndata=$this->db->getRecords("SELECT * FROM tblstudents   WHERE rollno like '%".$search."%' or studentname like '%".$search."%'   LIMIT 1 ");
		return $columndata;
  }
  public function getStudentFeeDueList($rollno)
  {
		$columndata=$this->db->getRecords("SELECT * FROM tblstudents   WHERE rollno like '%".$search."%' or studentname like '%".$search."%'   LIMIT 1 ");
		return $columndata;
  }
  public function getStudentFeeDueAmount($rollno)
  {
		$columndata=$this->db->getRecord("SELECT * FROM tblstudents   WHERE rollno like '%".$search."%' or studentname like '%".$search."%'   LIMIT 1 ");
		return $columndata;
  }

  public function getStudentReceiptHistory($rollno)
  {
		$columndata=$this->db->getRecords("SELECT * FROM tblstudents   WHERE rollno like '%".$search."%' or studentname like '%".$search."%'   LIMIT 1 ");
		return $columndata;
  }
} 
?>