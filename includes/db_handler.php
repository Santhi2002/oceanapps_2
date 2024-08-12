<?php
class Connection
{
  public $hostName;
  public $dbName;
  public $dbUserName;
  public $dbPass;
  public $dbConn;
  public $cError;
  public $connectError;
  public $SQLStatement;
  public $Error;
    function __construct()
    {
      $this->hostName=DB_HOST;
      $this->dbUserName=DB_USERNAME;
      $this->dbPass=DB_PASSWORD;
      $this->dbName=DB_NAME;
      $this->connectionToDb();
    }
    function connectionToDb()
    {
      if (!$this->dbConn = @mysqli_connect($this->hostName,
                                       $this->dbUserName,
                                       $this->dbPass,$this->dbName)) {
             trigger_error('Could not connect to DBserver');
             $this->connectError=true;
           }
    }
    
    function beginTrans()
    {
      mysqli_begin_transaction($this->dbConn);
    }
    function commitTrans()
    {
      mysqli_commit($this->dbConn);
       
    }
    function rollbackTrans()
    {
      mysqli_rollback($this->dbConn);
    }
    function closeConnection()
    {
      mysqli_close($this->dbConn);
    }

    function query($sql)
    {
      if (!$queryResource=mysqli_query($this->dbConn,$sql))
            trigger_error ('Query failed: '.mysqli_error($this->dbConn));

        return $queryResource;
    }
    function getRecord($sql)
		{			  
            $result=mysqli_query($this->dbConn,$sql) or die("Query failed with error:".mysqli_error($this->dbConn));
            $row=mysqli_fetch_assoc($result);
            return $row;
    }
    function getRecords($sql)
	{
        $result=mysqli_query($this->dbConn,$sql) or die("Query failed with error:".mysqli_error($this->dbConn));
        $i = 0;
				$records = array();
         while($row=mysqli_fetch_assoc($result)) {
             foreach($row as $k => $v) {
                      $records[$i][$k] = $v;
               }
                     $i++;
           }
          return $records;
  }
  function size ($sql)
	{
		$result = mysqli_query($this->dbConn,$sql);

		return mysqli_num_rows($result);

    }
  function directInsert( $sql)
    {
      $this->SQLStatement = $sql;
      $res= @mysqli_query($this->dbConn,$this->SQLStatement) ;
      $last_id = $this->dbConn->insert_id;  
      return $last_id;
    }
  function directUpdate( $sql)
    {
      $this->SQLStatement = $sql;
      $res= @mysqli_query($this->dbConn,$this->SQLStatement) ;
      return $res;
    } 
    function directDelete( $sql)
    {
      $this->SQLStatement = $sql;
      $res= @mysqli_query($this->dbConn,$this->SQLStatement) ;
      return $res;
    }   
    public function getColumns($tbl)  {
      $sql_columns = array();
       $pull_cols = mysqli_query($this->dbConn,"SHOW COLUMNS FROM ".$tbl) or die("MYSQL ERROR: ".mysqli_error($this->dbConn));
  
       while ($columns = mysqli_fetch_assoc($pull_cols))
          $sql_columns[] = $columns["Field"];
       return $sql_columns;
   } 
  
   public  function insertRow($tbl, $columns,$data){
      $escapedColumns = array_map(function($col) {
          return "`" . mysqli_real_escape_string($this->dbConn, $col) . "`";
      }, $columns);
      $columnNames = implode(",", $escapedColumns);
      $escapedData = array_map(function($value) {
          return "'" . mysqli_real_escape_string($this->dbConn, $value) . "'";
      }, $data);
      $dataValues = implode(",", $escapedData);
        $this->SQLStatement = "INSERT INTO ".$tbl." ($columnNames) VALUES ( $dataValues)";
      if ( @mysqli_query($this->dbConn,$this->SQLStatement) )
        return true;
      else
      {
         $this->Error = "Error: ".mysqli_error($this->dbConn);
        return false;
      }
   }
  
   public  function updateRow($tbl, $columns,$data,$id){  
        $sql_value_use = array();
         
        foreach($columns as $key => $value) 
        {
          $sql_value_use[] = $value."='".trim(addslashes($data[$key]))."'";
        }
        if (sizeof($sql_value_use) == 0 ) {
          $this->Error = "Error: No values were passed that matched any columns.";
          return false;
        }
        else {
          $this->SQLStatement = "UPDATE ".$tbl." SET ".implode(",",$sql_value_use)." WHERE id =".$id;
          if ( @mysqli_query($this->dbConn,$this->SQLStatement) )
                return true;
          else {
                $this->Error = "Error: ".mysqli_error($this->dbConn);
                return false;
          }
        }
    }  
  function addToDBWithDoc($tbl,$field_name)
	{
		$doc_path="../pdfs/NAAC/C-".substr($_POST['metricno'],0,1)."/"; 
       	$sql_columns = array();
       	$sql_columns_use = array();
       	$sql_value_use = array();

       	$pull_cols = mysqli_query($this->dbConn,"SHOW COLUMNS FROM ".$tbl) or die("MYSQL ERROR: ".mysqli_error($this->dbConn));

		if(isset($_FILES[$field_name]['name']) && $_FILES[$field_name]['name']!='')
		{
			$filename_err = explode(".",$_FILES[$field_name]['name']);
			$filename_err_count = count($filename_err);
			$file_ext = $filename_err[$filename_err_count-1];
			
			$_POST['linkfile'] = $doc =$file_name= $_POST['metricno'].'_'.$_FILES[$field_name]['name'];
			if($file_name != '')
			{
				$fileName = $file_name;
			}
			else
			{
				$fileName = $_FILES[$field_name]['name'];
			}
			
			$tmpdoc=$_FILES[$field_name]['tmp_name'];
			 
				if(move_uploaded_file($tmpdoc,$doc_path.$doc))
				{
				    	 
				}
		}
       	while ($columns = mysqli_fetch_assoc($pull_cols))
            $sql_columns[] = $columns["Field"];

	  	foreach( $_POST as $key => $value )
		{
			if ( in_array($key, $sql_columns) && htmlspecialchars(trim($value)) )
			{
				if ($value == "DATESTAMP")
					$sql_value_use[] = "NOW()";
				else
					$sql_value_use[] = "'".addslashes($value)."'";

				$sql_columns_use[] = $key;
			}
	  	}

        if ( (sizeof($sql_columns_use) == 0) || (sizeof($sql_value_use) == 0) )
		{
        	$this->Error = "Error: No values were passed that matched any columns.";
            return false;
        }
        else
		{
        	$this->SQLStatement = "INSERT INTO ".$tbl." (".implode(",", $sql_columns_use).") VALUES (".implode(",", $sql_value_use).")";


            if ( @mysqli_query($this->dbConn,$this->SQLStatement) )
            	return true;
            else
			{
            	$this->Error = "Error: ".mysqli_error($this->dbConn);
                return false;
            }
        }
	}
  
  function addToDB($tbl)
	{
		//print_r($_REQUEST);
	//	exit;
       	$sql_columns = array();
       	$sql_columns_use = array();
       	$sql_value_use = array();

       	$pull_cols = mysqli_query($this->dbConn,"SHOW COLUMNS FROM ".$tbl) or die("MYSQL ERROR: ".mysqli_error($this->dbConn));

       	while ($columns = mysqli_fetch_assoc($pull_cols))
            $sql_columns[] = $columns["Field"];

	  	foreach( $_POST as $key => $value )
		{
			if ( in_array($key, $sql_columns) && htmlspecialchars(trim($value)) )
			{
				if ($value == "DATESTAMP")
					$sql_value_use[] = "NOW()";
				else
					$sql_value_use[] = "'".addslashes($value)."'";

				$sql_columns_use[] = $key;
			}
	  	}

        if ( (sizeof($sql_columns_use) == 0) || (sizeof($sql_value_use) == 0) )
		    {
        	$this->Error = "Error: No values were passed that matched any columns.";
            return false;
        }
        else
	    	{
        	$this->SQLStatement = "INSERT INTO ".$tbl." (".implode(",", $sql_columns_use).") VALUES (".implode(",", $sql_value_use).")";


            if ( @mysqli_query($this->dbConn,$this->SQLStatement) )
            	return true;
            else
			      {
            	$this->Error = "Error: ".mysqli_error($this->dbConn);
                return false;
            }
        }
	}
  function addProgramRolesToDb($tbl)
	{
     $userids=array();
     $i=0;
        foreach($_POST['optuserids'] as $userid){
          $userids[$i]=$userid;
          $i++;
        } 
     $collegecode= $_POST["optprogram"];
         $i=0;
        $arroles=array();
        foreach($_POST['revokeroles'] as $role){
          $arroles[$i]=$role;
          $i++;
        } 
        $sql_columns = array();
     
       	$pull_cols = mysqli_query($this->dbConn,"SHOW COLUMNS FROM ".$tbl) or die("MYSQL ERROR: ".mysqli_error($this->dbConn));

       	while ($columns = mysqli_fetch_assoc($pull_cols))
             $sql_columns[] = $columns["Field"];
        for($k=0;$k<count($userids);$k++)
        {
          $this->SQLStatement = "DELETE FROM ".$tbl." where userid='".$userids[$k]."' and collegecode='".$collegecode."'";
          $f= @mysqli_query($this->dbConn,$this->SQLStatement) ;
         
          for($m=0;$m<count($arroles);$m++)
          {
            $this->SQLStatement = "INSERT INTO ".$tbl." (".implode(",", $sql_columns).") VALUES ('".$collegecode."','".$arroles[$m]."','".$userids[$k]."')";
            
            $f= @mysqli_query($this->dbConn,$this->SQLStatement) ; 
           }

        }

  }

 

  function addRolesToDb($tbl)
	{
		    $cprograms= array();
        $i=0;
        foreach($_POST['chkprograms'] as $chkprogram){
          $cprograms[$i]=$chkprogram;
          $i++;
        } 
        $strcprograms = implode(',', $cprograms);
        $croles= array();
        $i=0;
        foreach($_POST['chkroles'] as $chkrole){
          $croles[$i]=$chkrole;
          $i++;
        } 
        $cfunctions= array();
        $i=0;
        foreach($_POST['chkfunctions'] as $chkfunction){
          $cfunctions[$i]=$chkfunction;
          $i++;
        } 
        $r=array();
        $fcroles="";
        for($i=0;$i<count($cprograms);$i++)
        {
          if($i>0 and  (substr($fcroles, -1)=="," ) )
              $fcroles = substr($fcroles, 0, -1).":";
          if($i>0 and  (substr($fcroles, -1)==":" ) )
              $fcroles = substr($fcroles, 0, -1).":";  
          for($j=0;$j<count($croles);$j++)
          { if($j>0 and substr($fcroles, -1)!="," and substr($fcroles, -1)!=":")
            $fcroles.=",";
            
             if(strpos($croles[$j],$cprograms[$i])!== false)
              { 
                $r=explode("-",$croles[$j]);
                $fcroles.=$r[1];  
                 
              }
          }
         
        } 
       
        $fcfunctions="";
        for($i=0;$i<count($cprograms);$i++)
        {
           
           if($i>0 and  (substr($fcfunctions, -1)=="," ) )
              $fcfunctions = substr($fcfunctions, 0, -1).":";
          else if($i>0 and  (substr($fcfunctions, -1)==":" ) )
              $fcfunctions = substr($fcfunctions, 0, -1).":";  
          else  if($i>0 and  (substr($fcfunctions, -1)==";" ) )
              $fcfunctions = substr($fcfunctions, 0, -1).":";   
          else  if($i>0  )
              $fcfunctions .= ":";     
          for($j=0;$j<count($croles);$j++)
          {
            if($j>0 and  (substr($fcfunctions, -1)=="," ) )
              $fcfunctions = substr($fcfunctions, 0, -1).";";
           else if($j>0 and  (substr($fcfunctions, -1)==";" ) )
              $fcfunctions = substr($fcfunctions, 0, -1).";"; 
           else if($j>0 and  (substr($fcfunctions, -1)==":" ) )
              $fcfunctions = substr($fcfunctions, 0, -1).":"; 
            else if($j>0  )
              $fcfunctions .= ";";    
          for($k=0;$k<count($cfunctions);$k++)
          {
            if($k>0 and substr($fcfunctions, -1)!="," and substr($fcfunctions, -1)!=";" and substr($fcfunctions, -1)!=":")
              $fcfunctions.=",";
             if(strpos($cfunctions[$k],$cprograms[$i])!== false and strpos($cfunctions[$k],$croles[$j])!== false)
            {
              $f=explode("-",$cfunctions[$k]);
              $fcfunctions.=$f[2];
            }
          }
         
             
          }
           
        } 
        $email="";
       	$sql_columns = array();
       	 
       	$pull_cols = mysqli_query($this->dbConn,"SHOW COLUMNS FROM ".$tbl) or die("MYSQL ERROR: ".mysqli_error($this->dbConn));

       	while ($columns = mysqli_fetch_assoc($pull_cols))
            $sql_columns[] = $columns["Field"];

	  	   
        	$this->SQLStatement = "INSERT INTO ".$tbl." (".implode(",", $sql_columns).") VALUES ('".$email."','".$strcprograms."','".$fcroles."','".$fcfunctions."','".$_SESSION['email']."','".date("Y-m-d")."','".$_SESSION['email']."','".date("Y-m-d")."',0)";


            if ( @mysqli_query($this->dbConn,$this->SQLStatement) )
            	return true;
            else
			      {
            	$this->Error = "Error: ".mysqli_error($this->dbConn);
                return false ;
            }
       
	}
    function updateDBWithDoc($tbl, $id, $id_name,$field_name)
	  {
           
		   $doc_path="../pdfs/NAAC/C-".substr($_POST['metricno'],0,1)."/"; 
		   
		   $sql_columns = array();
           $sql_value_use = array();

           $pull_cols = mysqli_query($this->dbConn,"SHOW COLUMNS FROM ".$tbl) or die( "MYSQL ERROR:".mysqli_error($this->dbConn) );
           while ($columns = mysqli_fetch_assoc($pull_cols))
              $sql_columns[] = $columns["Field"];
			
			if(isset($_FILES[$field_name]['name']) && $_FILES[$field_name]['name']!='')
			{
			$filename_err = explode(".",$_FILES[$field_name]['name']);
			$filename_err_count = count($filename_err);
			$file_ext = $filename_err[$filename_err_count-1];
			
			$_POST['linkfile'] = $doc =$file_name= $file_name= $_POST['metricno'].'_'.$_FILES[$field_name]['name'];
			if($file_name != '')
			{
				$fileName = $file_name;
			}
			else
			{
				$fileName = $_FILES[$field_name]['name'];
			}
			 
			$tmpdoc=$_FILES[$field_name]['tmp_name'];
				if(move_uploaded_file($tmpdoc,$doc_path.$doc))
				{
					 
				}
			}
			
              foreach($_POST as $key => $value) {

                  if ( in_array($key, $sql_columns))
                      {

                        $sql_value_use[] = $key."='".trim(addslashes($value))."'";

                      }
                  }

                  if (sizeof($sql_value_use) == 0 ) {
                        $this->Error = "Error: No values were passed that matched any columns.";
                        return false;
                  }
                  else {
                        $this->SQLStatement = "UPDATE ".$tbl." SET ".implode(",",$sql_value_use)." WHERE ".$id_name."=".$id;
                        				//echo $this->SQLStatement."<br>";
										//exit;
                        if ( @mysqli_query($this->dbConn,$this->SQLStatement) )
                              return true;
                        else {
                              $this->Error = "Error: ".mysqli_error($this->dbConn);
                              return false;
                        }
                  }
           }
		   function updateDB($tbl, $id, $id_name)
	    {
           $sql_columns = array();
           $sql_value_use = array();

           $pull_cols = mysqli_query($this->dbConn,"SHOW COLUMNS FROM ".$tbl) or die( "MYSQL ERROR:".mysqli_error($this->dbConn) );
           while ($columns = mysqli_fetch_assoc($pull_cols))
              $sql_columns[] = $columns["Field"];

              foreach($_POST as $key => $value) {

                  if ( in_array($key, $sql_columns))
                      {

                        $sql_value_use[] = $key."='".trim(addslashes($value))."'";

                      }
                  }

                  if (sizeof($sql_value_use) == 0 ) {
                        $this->Error = "Error: No values were passed that matched any columns.";
                        return false;
                  }
                  else {
                        $this->SQLStatement = "UPDATE ".$tbl." SET ".implode(",",$sql_value_use)." WHERE ".$id_name."=".$id;
                        				//echo $this->SQLStatement."<br>";
										//exit;
                        if ( @mysqli_query($this->dbConn,$this->SQLStatement) )
                              return true;
                        else {
                              $this->Error = "Error: ".mysqli_error($this->dbConn);
                              return false;
                        }
                  }
           }

           public function getColumnData($tblname, $colname,$crcolname, $crvalue)
           {
             $columndata=$this->getRecord("SELECT ".$colname." FROM ". $tblname."  WHERE ".$crcolname." = '".$crvalue."' LIMIT 1 ");
             return $columndata;
           }
         
         
           public function getColumnDataWithCriteria($tblname, $colname,$crcolname, $crvalue)
           {
             $columndata=$this->getRecords("SELECT ".$colname." FROM ". $tblname."  WHERE ".$crcolname." = '".$crvalue."' order by ".$colname);
             return $columndata;
           }
           public function getAllColumnsDataWithCriteria($tblname, $crcolname, $crvalue)
           {
             $columndata=$this->getRecords("SELECT * FROM ". $tblname."  WHERE ".$crcolname." = '".$crvalue."' order by ".$crcolname );
             return $columndata;
           }
           public function getAllColumnsDataWithLike($tblname, $crcolname, $crvalue)
           {
             $columndata=$this->getRecords("SELECT * FROM ". $tblname."  WHERE ".$crcolname." LIKE '%".$crvalue."%'   ");
             return $columndata;
           }
           public function getAllColumnsData($tblname)
           {
             $columndata=$this->getRecords("SELECT * FROM ". $tblname."   ");
             return $columndata;
           }
           
           public function getSpecificColumnsData($tblname, $colnames ,$orderbycols)
           {
             $columndata=$this->getRecords("SELECT ". $colnames." FROM ". $tblname." order by ". $orderbycols);
             return $columndata;
           }
           public function getSpecificColumnsDataWithCriteria($tblname, $colnames,$criteria ,$orderbycols)
           {
             $columndata=$this->getRecords("SELECT ". $colnames." FROM ". $tblname." WHERE ".$criteria." order by ". $orderbycols);
             return $columndata;
           }
         
         
         // Joins related queries
         
         public function getColumnsDataWithJoin($tblname1,$tblname2,$joincolname,$colnames)
         {
           $columndata=$this->getRecords("SELECT ".$colnames." FROM ". $tblname1."," .$tblname2." WHERE ". $tblname1.".".$joincolname ." = ".$tblname2.".".$joincolname ." order by ".$joincolname);
           return $columndata;
         }
         
         public function getMultiRowDataWithSQL($sql)
         {
             $columndata=$this->getRecords($sql) ;
             return $columndata;
         }
           // sum  max related queries
         
         public function getSumWithCriteria($tblname, $crcolname, $crvalue)
         {
             $columndata=$this->getRecord("SELECT sum($crcolname) FROM ". $tblname."  WHERE ".$crcolname." = '".$crvalue."'   ");
             return $columndata;
         }
         public function getSumWithCriterias($tblname, $crcolname, $criteria)
         {
             $columndata=$this->getRecord("SELECT sum($crcolname) FROM ". $tblname."  WHERE ".$criteria   );
             return $columndata;
         }
         
         public function getMaxValueofColumn($tblname, $colname)
         {
             $columndata=$this->getRecord("SELECT max(".$colname.") as rno FROM ". $tblname     );
             return $columndata;
         }
         
         public function getMaxValueofColumnWithCriteria($tblname, $colname,$criteria)
         {
             $columndata=$this->getRecord("SELECT max(".$colname.") as rno FROM ". $tblname."  WHERE ".$criteria  );
             return $columndata;
         }   
}

 ?>
