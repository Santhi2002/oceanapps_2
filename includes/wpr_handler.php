<?php
class Wpr_Handler extends Connection
{
 public $db;
  function __construct()
  {
    $this->db=new Connection();
 
  }
 
  public function getColumnData($tblname, $colname,$crcolname, $crvalue)
  {
		$columndata=$this->db->getRecord("SELECT ".$colname." FROM ". $tblname."  WHERE ".$crcolname." = '".$crvalue."' LIMIT 1 ");
		return $columndata;
  }


  public function getColumnDataWithCriteria($tblname, $colname,$crcolname, $crvalue)
  {
		$columndata=$this->db->getRecords("SELECT ".$colname." FROM ". $tblname."  WHERE ".$crcolname." = '".$crvalue."' order by ".$colname);
		return $columndata;
  }
  public function getAllColumnsDataWithCriteria($tblname, $crcolname, $crvalue)
  {
		$columndata=$this->db->getRecords("SELECT * FROM ". $tblname."  WHERE ".$crcolname." = '".$crvalue."' order by ".$crcolname );
		return $columndata;
  }
  public function getAllColumnsDataWithLike($tblname, $crcolname, $crvalue)
  {
		$columndata=$this->db->getRecords("SELECT * FROM ". $tblname."  WHERE ".$crcolname." LIKE '%".$crvalue."%'   ");
		return $columndata;
  }
  public function getAllColumnsData($tblname)
  {
		$columndata=$this->db->getRecords("SELECT * FROM ". $tblname."   ");
		return $columndata;
  }
  
  public function getSpecificColumnsData($tblname, $colnames ,$orderbycols)
  {
		$columndata=$this->db->getRecords("SELECT ". $colnames." FROM ". $tblname." order by ". $orderbycols);
		return $columndata;
  }
  public function getSpecificColumnsDataWithCriteria($tblname, $colnames,$criteria ,$orderbycols)
  {
		$columndata=$this->db->getRecords("SELECT ". $colnames." FROM ". $tblname." WHERE ".$criteria." order by ". $orderbycols);
		return $columndata;
  }


// Joins related queries

public function getColumnsDataWithJoin($tblname1,$tblname2,$joincolname,$colnames)
{
  $columndata=$this->db->getRecords("SELECT ".$colnames." FROM ". $tblname1."," .$tblname2." WHERE ". $tblname1.".".$joincolname ." = ".$tblname2.".".$joincolname ." order by ".$joincolname);
  return $columndata;
}

public function getMultiRowDataWithSQL($sql)
{
	  $columndata=$this->db->getRecords($sql) ;
	  return $columndata;
}
  // sum  max related queries

public function getSumWithCriteria($tblname, $crcolname, $crvalue)
{
	  $columndata=$this->db->getRecord("SELECT sum($crcolname) FROM ". $tblname."  WHERE ".$crcolname." = '".$crvalue."'   ");
	  return $columndata;
}
public function getSumWithCriterias($tblname, $crcolname, $criteria)
{
	  $columndata=$this->db->getRecord("SELECT sum($crcolname) FROM ". $tblname."  WHERE ".$criteria   );
	  return $columndata;
}

public function getMaxValueofColumn($tblname, $colname)
{
	  $columndata=$this->db->getRecord("SELECT max(".$colname.") as rno FROM ". $tblname     );
	  return $columndata;
}

public function getMaxValueofColumnWithCriteria($tblname, $colname,$criteria)
{
	  $columndata=$this->db->getRecord("SELECT max(".$colname.") as rno FROM ". $tblname."  WHERE ".$criteria  );
	  return $columndata;
}
} 