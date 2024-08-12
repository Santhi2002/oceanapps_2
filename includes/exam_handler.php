<?php
class Exam_Handler extends Connection
{
 public $db; public $date;
 public $coursesData;
  function __construct()
  {
    $this->db=new Connection();
    $this->date=date('Y-m-d H:i:s');
  }
// BEGIN OF EXAM MonTH YEAR
    public function setExamMonthYear($inputData, $username){
        $result=0;
        $data=explode(",",$inputData);
        //program=$data[0], examtype=$data[1] ,exammonth=$data[2], examyear=$data[3],studyyear=$data[4] and semester=$data[5]
        $ExamMonthYearData =$this->db->getRecord("select * from tblexammonthyear WHERE program='".$data[0]."' and examtype='$data[1]' and exammonth='$data[2]' and examyear='$data[3]' and studyyear='$data[4]' and semester='$data[5]'   ");
        if(count($ExamMonthYearData)<=0){
           $result = $this->db->directInsert("INSERT INTO tblexammonthyear (program,examtype,exammonth,examyear,exammonthyear,studyyear,semester,createdby,createdon,modifiedby,modifiedon,remarks,deletestatus)  VALUES ('$data[0]' ,'$data[1]','$data[2]','$data[3]' ,'".$data[2]."-".$data[3]."','".$data[4]."','".$data[5]."','$username','$this->date','$username','$this->date','',0 )") ;
           return $result;
        }
         return  $result; 
    }
    public function updateExamMonthYear($inputData,$id, $username){   
        $result=0;
        $data=explode(",",$inputData);
        $ExamMonthYearData =$this->db->getRecord("select * from tblexammonthyear WHERE  id='$id'  ");
        if(count($ExamMonthYearData)>0){
           $result = $this->db->directUpdate("update tblexammonthyear set program='$data[0]', examtype='$data[1]',exammonth='$data[2]',examyear='$data[3]',exammonthyear='".$data[2]."-".$data[3]."',,studyyear='$data[4]',semester='$data[5]' modifiedby='$username',modifiedon='$this->date', remarks='' , deletestatus=0 where id='$id' ") ;
           return $result;     
        }
        return  $result;
    }
    public function deleteExamMonthYear($id){
        $result=0;
        $ExamMonthYearData =$this->db->getRecord("select * from tblexammonthyear WHERE  id='$id'  ");
        if(count($ExamMonthYearData)>0){
           $result = $this->db->directUpdate("update tblexammonthyear set  deletestatus=1 where id='$id' ") ;
           return $result;     
        }
        return $result;
    }
    public function getExamMonthYear($id){
        $ExamMonthYearData =$this->db->getRecord("select * from tblexammonthyear WHERE id='".$id."' and deletestatus=0 ");
        return $ExamMonthYearData;
    }
    public function getExamMonthYearList(){
        $ExamMonthYearData =$this->db->getRecords("select * from tblexammonthyear  WHERE  deletestatus=0  order by id desc ");
        return $ExamMonthYearData;
    }

    public function DeclareResult($id){
        $result = $this->db->directUpdate("update tblexammonthyear set active='1' where id='$id' and  deletestatus=0 ") ;
        return $result;  

    }
    public function HoldResult($id){
        $result = $this->db->directUpdate("update tblexammonthyear set active='0' where id='$id'  and  deletestatus=0") ;
        return $result;      
    }
// END OF EXAM MonTH YEAR

// BEGIN  OF SET SESSIon & TIMING
    public function setSessionTimimg($inputData,$username){
        $result=0;
        $data=explode(",",$inputData);
        //program=$data[0], examsession=$data[1]  and examtiming=$data[2]  
        $ExamSessionData =$this->db->getRecord("select * from tblexammsession WHERE program='".$data[0]."' and examsession='$data[1]' and examtiming='$data[2]'   ");
        if(count($ExamSessionData)<=0){
        $result = $this->db->directInsert("INSERT INTO tblexamsession (program,examsession,examtiming,createdby,createdon,modifiedby,modifiedon,remarks,deletestatus)  VALUES ('$data[0]' ,'$data[1]','$data[2]','$username','$this->date','$username','$this->date','',0 )") ;
        return $result;
        }
        return  $result; 
    }
    public function updateSessionTiming($inputData,$id,$username){
        $result=0;
        $data=explode(",",$inputData);
        $ExamSessionData =$this->db->getRecord("select * from tblexamsession WHERE  id='$id'  ");
        if(count($ExamSessionData)>0){
        $result = $this->db->directUpdate("update tblexamsession set program='$data[0]', examsession='$data[1]',examtiming='$data[2]', modifiedby='$username',modifiedon='$this->date', remarks='' , deletestatus=0 where id='$id' ") ;
        return $result;     
        }
        return  $result;
    }
    public function deleteSessionTiming($id){
        $result=0;
        $ExamSessionData =$this->db->getRecord("select * from tblexamsession WHERE  id='$id'  ");
        if(count($ExamSessionData)>0){
        $result = $this->db->directUpdate("update tblexamsession set  deletestatus=1 where id='$id' ") ;
        return $result;     
        }
        return $result;
    }
    public function getSessionTiming($id){
        $ExamSessionData =$this->db->getRecord("select * from tblexamsession WHERE id='".$id."' and deletestatus=0 ");
        return $ExamSessionData;
    }
    public function getSessionTimingList(){
        $ExamSessionData =$this->db->getRecords("select * from tblexamsession  WHERE  deletestatus=0  order by id desc ");
        return $ExamSessionData;
    }
// END OF SET SESSIon & TIMING

// BEGIN  OF SET GRADE & POINTS
public function setGradePoints($inputData,$username){
    $result=0;$remarks="";
    $data=explode(",",$inputData);
    //program=$data[0], course=$data[1] ,regulation=$data[2],grade=$data[3], grademapping=$data[4] ,points=$data[5], 
    // percent=$data[6] and subjecttype=$data[7],gradedesc=$data[8] ,percentdesc=$data[9] and revalcutoff=$data[10]
    $ExamGradePointsData =$this->db->getRecord("select * from tblexamgradepoints where program ='$data[0]' and course='$data[1]'  and  regulation='$data[2]' and grade='$data[3]' and grademapping='$data[4]' and points='$data[5]' and percent='$data[6]' and subjecttype='$data[7]' ");
    if(!isset($ExamGradePointsData )){
    $result = $this->db->directInsert("INSERT INTO tblexamgradepoints (program	,course, regulation,	grade,	grademapping,points,	percent,subjecttype, gradedesc, percentdesc, revalcutoff,remarks, createdby, createdon,deletestatus ) VALUES ('$data[0]','$data[1]', '$data[2]', '$data[3]' , '$data[4]', '$data[5]', '$data[6]', '$data[7]' , '$data[8]', '$data[9]', '$data[10]','$remarks','$username','$this->date',0)");
    return $result;
    }
    return  $result; 
}
public function updateGradePoints($inputData,$id,$username){
    $result=0;
    $data=explode(",",$inputData);
    //program=$data[0], course=$data[1] ,regulation=$data[2],grade=$data[3], grademapping=$data[4] ,points=$data[5], 
    // percent=$data[6] and subjecttype=$data[7],gradedesc=$data[8] ,percentdesc=$data[9] and revalcutoff=$data[10]
    $ExamGradePointsData =$this->db->getRecord("select * from tblexamgradepoints WHERE  id='$id'  ");
    if(isset($ExamGradePointsData )){
    $result = $this->db->directUpdate("update tblexamgradepoints set program='$data[0]', course='$data[1]',regulation='$data[2]' ,grade='$data[3]' ,grademapping='$data[4]' ,points='$data[5]'  ,percent='$data[6]' ,subjecttype='$data[7]',  gradedesc='$data[8]', percentdesc='$data[9]', revalcutoff= '$data[10]' , modifiedby='$username',modifiedon='$this->date', remarks='' , deletestatus=0 where id='$id' ") ;
    return $result;     
    }
    return  $result;
}
public function deleteGradePoints($id){
    $result=0;
    $ExamGradePointsData =$this->db->getRecord("select * from tblexamgradepoints WHERE  id='$id'  ");
    if(count($ExamGradePointsData)>0){
    $result = $this->db->directUpdate("update tblexamgradepoints set  deletestatus=1 where id='$id' ") ;
    return $result;     
    }
    return $result;
}
public function getGradePoints($id){
    $ExamGradePointsData =$this->db->getRecord("select * from tblexamgradepoints WHERE id='".$id."' and deletestatus=0 ");
    return $ExamGradePointsData;
}
public function getGradePointsList(){
    $ExamGradePointsData =$this->db->getRecords("select * from tblexamgradepoints  WHERE  deletestatus=0  order by id desc ");
    return $ExamGradePointsData;
}
// END OF SET GRADE & POINTS

// BEGIN  OF SUBJECTS and MARKS
public function saveSubjectsandMaxMarks($inputData){
    $result=0;$remarks="";
    $data=explode(",",$inputData); 
    //program=$data[0], course=$data[1] ,regulation=$data[2],grade=$data[3], grademapping=$data[4] ,points=$data[5], 
    // percent=$data[6] and subjecttype=$data[7],gradedesc=$data[8] ,percentdesc=$data[9] and revalcutoff=$data[10]
    $ExamSubjectsMaxMarks =$this->db->getRecord("select * from tblexamsubjects where program ='$data[0]' and course='$data[1]'  and branch='$data[2]'  and  regulation='$data[3]' and studyyear='$data[4]' and semester='$data[5]' and subjectcode='$data[6]' and delete_status=0  ");
     
    if(!isset($ExamSubjectsMaxMarks ))
    {
        $columns=$this->db->getColumns("tblexamsubjects")  ;  
        $columns= array_slice($columns, 1); // except id column
        $result=$this->db->insertRow("tblexamsubjects",$columns, $data)  ; 
        
       return $result;
    }
    return  $result; 
}
public function updateSubjectsandMaxMarks($inputData,$id){
    $result=0;$remarks="";
    $data=explode(",",$inputData);
    //program=$data[0], course=$data[1] ,regulation=$data[2],grade=$data[3], grademapping=$data[4] ,points=$data[5], 
    // percent=$data[6] and subjecttype=$data[7],gradedesc=$data[8] ,percentdesc=$data[9] and revalcutoff=$data[10]
    $ExamSubjectsMaxMarks =$this->db->getRecord("select * from tblexamsubjects where id=$id ");
   
    if(isset($ExamSubjectsMaxMarks ))
    {   
        $columns=$this->db->getColumns("tblexamsubjects")  ;  
        $columns= array_slice($columns, 1); // except id column
        $result=$this->db->updateRow("tblexamsubjects",$columns, $data,$id)  ; 
        
       return $result;
    }
    return  $result; 
}
// END OF SET SUBJECTS and MARKS

// BEGIN  OF ALLOTMENT OF SUBJECTS WRITTEN on 15-05-2024
 
public function allocateSubjects($inputData, $subcategory, $username,$chkrollnos,$secondlang,$electivesubject,$electivenumber){
    $allotcount=0;$notallotcount=0;
    $data=explode(",",$inputData);
    //program=$data[0], regulation=$data[1] ,course=$data[2],branch=$data[3] ,batch=$data[4],studyyear=$data[5],semester=$data[6] 
    $sql = "select ts.* from tblexamsubjects ts LEFT JOIN tblexamallottedsubjects te on ts.subjectcode = te.subjectcode
    and te.rollno = ?    and te.studyyear = ?    and te.semester = ?    WHERE ts.program = ?    and ts.course = ?
    and ts.branch = ?    and ts.regulation = ?    and ts.studyyear = ?    and ts.semester = ?
    and ts.deletestatus = '0'    and ts.subjectcategory = ?    and te.rollno IS NULL";   

    $params = [null, $data[5], $data[6],$data[0], $data[2],  $data[3],  $data[1], $data[5], $data[6],  $subcategory];
    if ($subcategory == "E") {
        $sql .= " and ts.electivenumber = ? and ts.subjectcode = ?";
        $params[] = $electivenumber;
        $params[] = $electivesubject;
    } elseif ($subcategory == "S") {
        $sql .= " and ts.subjectcode = ?";
        $params[] = $secondlang;
    }
    $stmt = $this->db->dbConn->prepare($sql);
    foreach ($chkrollnos as $rollno) {
        $params[0] = $rollno; 
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_assoc()) {
            $query2 = "INSERT INTO tblexamallottedsubjects (rollno, studyyear, semester, subjectorder, subjectcode, createdby, createdon) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $this->db->dbConn->prepare($query2);
            $stmt2->bind_param('sssssss', $rollno, $data[5], $data[6], $row['subjectorder'], $row['subjectcode'], $username, $this->date);
            $stmt2->execute();
            $query3 = "INSERT INTO tblexaminternalmarks (rollno, studyyear, semester, subjectcode, createdby, createdon) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt3 = $this->db->dbConn->prepare($query3);
            $stmt3->bind_param('ssssss', $rollno, $data[5], $data[6], $row['subjectcode'], $username, $this->date);
            $stmt3->execute();

            $allotcount++;
        }

        if ($res->num_rows == 0) {
            $notallotcount++;
        }
    }
    return $allotcount.",".$notallotcount;
}

public function deAllocateSubjects($inputData, $subcategory, $username,$dechkrollnos,$secondlang,$electivesubject,$electivenumber){
    $delcount=0;
    $data=explode(",",$inputData);
    $program = $data[0];$course = $data[2];$branch = $data[3];$regulation = $data[1];$studyyear = $data[5];
    $semester = $data[6];$subcategory = $subcategory;
    $sql = "select rollno  from tblexamallottedsubjects  WHERE subjectcode IN (
            select subjectcode from tblexamsubjects  WHERE program = ? and course = ? 
            and branch = ? and regulation = ?  and studyyear = ? and semester = ? 
              and subjectcategory = ?";
    if ($subcategory == "E") {
        $sql .= " and electivenumber = ? and subjectcode = ?)";
        $params = [$program, $course, $branch, $regulation, $studyyear, $semester, $subcategory, $electivenumber, $electivesubject];
    } elseif ($subcategory == "S") {
        $sql .= " and subjectcode = ?)";
        $params = [$program, $course, $branch, $regulation, $studyyear, $semester, $subcategory, $secondlang];
    } else {  // subcategory "O"
        $sql .= ")";
        $params = [$program, $course, $branch, $regulation, $studyyear, $semester, $subcategory];
    }

    $stmt = $this->db->dbConn->prepare($sql);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $rollnoExists = in_array($row['rollno'], $dechkrollnos);
    if (!$rollnoExists) {
        $delSql = "DELETE from tblexamallottedsubjects   WHERE rollno = ? 
                and subjectcode = ?  and subjectcode IN (select subjectcode from tblexamsubjects 
                WHERE program = ? and course = ? and branch = ? and regulation = ? 
                and studyyear = ? and semester = ?   and subjectcategory = ?";
            if ($subcategory == "E") {
                $delSql .= " and electivenumber = ? and subjectcode = ?)";
                $deleteParams = [$row['rollno'], $electivesubject, $program, $course, $branch, $regulation, $studyyear, $semester, $subcategory, $electivenumber, $electivesubject];
            } elseif ($subcategory == "S") {
                $delSql .= " and subjectcode = ?)";
                $deleteParams = [$row['rollno'], $secondlang, $program, $course, $branch, $regulation, $studyyear, $semester, $subcategory, $secondlang];
            } else { // subcategory "O"
                $delSql .= ")";
                $deleteParams = [$row['rollno'], $electivesubject, $program, $course, $branch, $regulation, $studyyear, $semester, $subcategory];
            }
            $stmtDelete = $this->db->dbConn->prepare($delSql);
            $stmtDelete->bind_param(str_repeat('s', count($deleteParams)), ...$deleteParams);
            $stmtDelete->execute();
            $delcount++;
        }
    }
    return $delcount;
}
public function showSubjectsandStrength($inputData)
{
    $result=0;$remarks="";
    $data=explode(",",$inputData);
    $program = $data[0];$course = $data[2];$branch = $data[3];$regulation = $data[1];$studyyear = $data[4];
    $semester = $data[5]; $batch = $data[6]; 
	$sql = "select  es.*, COALESCE(eas.cnt, 0) AS cnt  from  tblexamsubjects es
    LEFT JOIN (select subjectcode, COUNT(subjectcode) AS cnt from tblexamallottedsubjects 
        WHERE  studyyear = ?  and semester = ?  and rollno IN (
                select  rollno  from tblstudents 
                WHERE program = ? and course = ? and branch = ? and regulation = ? and batch = ?)
        GROUP BY subjectcode ) eas on es.subjectcode = eas.subjectcode
    WHERE  es.program = ? and es.course = ?  and es.branch = ? and es.regulation = ? 
        and es.studyyear = ? and es.semester = ? and es.delete_status = '0'";

    $params = [
        $studyyear, $semester, $program, $course, $branch, $regulation, $batch, $program, 
        $course, $branch, $regulation, $studyyear, $semester];
    $stmt = $this->db->dbConn->prepare($sql);

    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $i = 0;
    $records = array();
    while($row=$result->fetch_assoc()) {
    foreach($row as $key => $value) {
        $records[$i][$key] = $value;
    }
        $i++;
    }
    return $records;
    }
public function getElectiveNumbers($inputData)
    {   $electiveNumbers="";
        $data=explode(",",$inputData);
        $program = $data[0];$course = $data[2];$branch = $data[3];$regulation = $data[1];$studyyear = $data[4];
        $semester = $data[5]; 
        $electiveNumbers =$this->db->getRecords("select  distinct(electivenumber) from tblexamsubjects WHERE program= '".$program."' and course= '".$course."'  and branch= '".$branch."'  and regulation= '".$regulation."' and studyyear= '".$studyyear."'  and semester= '".$semester."' and electivenumber!='' order by electivenumber ");
        if(isset($electiveNumbers ))
            return $electiveNumbers;
    
}
public function getElectiveSubjects($inputData)
{   $electivesubjects="";
    $data=explode(",",$inputData);
    $program = $data[0];$course = $data[2];$branch = $data[3];$regulation = $data[1];$studyyear = $data[4];
    $semester = $data[5];  $electivenumber=$data[6];
    $electivesubjects =$this->db->getRecords("select  distinct(subjectcode), subjectname  from tblexamsubjects WHERE program= '".$program."' and course= '".$course."'  and branch= '".$branch."'  and regulation= '".$regulation."' and studyyear= '".$studyyear."'  and semester= '".$semester."' and electivenumber='$electivenumber' order by subjectcode ");
    if(isset($electivesubjects ))
        return $electivesubjects;
    
}
public function getSecondLanguages($inputData)
{   $secondLanguages="";
    $data=explode(",",$inputData);
    $program = $data[0];$course = $data[2];$branch = $data[3];$regulation = $data[1];$studyyear = $data[4];
    $semester = $data[5];  $subcategory=$data[6];
    $languageSubjects =$this->db->getRecords("select  distinct(subjectcode), subjectname  from tblexamsubjects WHERE program= '".$program."' and course= '".$course."'  and branch= '".$branch."'  and regulation= '".$regulation."' and studyyear= '".$studyyear."'  and semester= '".$semester."' and subjectcategory='$subcategory' order by subjectcode ");
    if(isset($secondLanguages ))
        return $secondLanguages;
    
}
// END OF ALLOTMENT OF SUBJECTS WRITTEN on 15-05-2024
  
//EXAM SCHEDULE START -WRITTEN on 16-05-2024
public function createExamBatch($program,$regulation, $course,$studyyear,$semester ,$examtype,$fromdate, $todate,$examfee, $startdate,$enddate,$username){
    $result=0;
    $currentdate = new DateTime($fromdate);
    $exammonthyear = strtoupper($currentdate->format('F-Y'));
    $month3chrs=substr($exammonthyear,0,3);
    $activeAcYear =$this->db->getRecord("select academicyear from tblactiveacademicyear WHERE  active=1   ");
    $feebatch=$activeAcYear['academicyear']."_".$program."_".$studyyear."_".$semester."_".$month3chrs."_AUTONOMOUS_".$examtype."_EXAMFEE";
    $feebatchfine=$activeAcYear['academicyear']."_".$program."_".$studyyear."_".$semester."_".$month3chrs."_AUTONOMOUS_".$examtype."_EXAMFEEFINE";
    $ExamBatchData =$this->db->getRecord("select * from tblexambatch WHERE program='".$program."' and course='$course'  and regulation='$regulation' and studyyear='$studyyear' and semester='$semester' and examtype='$examtype'    and exammonthyear ='$exammonthyear' ");
    
    if(!isset($ExamBatchData) ){
       
       $this->db->beginTrans();
       $feebatchid = $this->db->directInsert("INSERT INTO tblfeebatch (feetype, acyear,program,feebatch,amount,startdate, enddate,studyyear,semester,enrolltype,paytype,examtype,exammonthyear,refid,createdby,createdon )  VALUES ('EXAMFEE' ,'".$activeAcYear['academicyear']."','$program','$feebatch' ,'$examfee','$startdate','$enddate' ,'".$studyyear."','".$semester."','1','onetime','".$examtype."','$exammonthyear','0','$username','$this->date'  )") ;
       
       $exambatchid = $this->db->directInsert("INSERT INTO tblexambatch (program,regulation,course,studyyear,semester,examtype, exammonthyear,fromdate,todate,examfee,feebatchid,createdby,createdon,modifiedby,modifiedon,remarks,deletestatus)  VALUES ('$program' ,'$regulation' ,'$course','$studyyear','$semester' ,'".$examtype."','".$exammonthyear."','".$fromdate."','".$todate."','".$examfee."','".$feebatchid."','$username','$this->date','$username','$this->date','',0 )") ;

       $result = $this->db->directInsert("INSERT INTO tblfeebatch (feetype, acyear,program,feebatch,amount,startdate, enddate,studyyear,semester,enrolltype,paytype,examtype,exammonthyear,refid,createdby,createdon )  VALUES ('EXAMFEEFINE' ,'".$activeAcYear['academicyear']."','$program','$feebatchfine' ,'$examfee','$startdate','$enddate' ,'".$studyyear."','".$semester."','1','onetime','".$examtype."','$exammonthyear','$exambatchid','$username','$this->date'  )") ;
       $this->db->commitTrans();
       return $result;
    }
    else  if(isset($ExamBatchData) and count($ExamBatchData)>0){
        $result = $this->db->directUpdate("update tblexambatch set program='$program', regulation='$regulation' ,  course='$course',  examtype='$examtype',studyyear='$studyyear',semester='$semester',fromdate='$fromdate',todate='$todate' ,examfee='$examfee', modifiedby='$username',modifiedon='$this->date', remarks='' , deletestatus=0 where exambatchid='$exambatchid' ") ;
        
        $result = $this->db->directUpdate("update tblfeebatch set program='$program',  acyear='".$activeAcYear['academicyear']."' ,  course='$course', feebatch='$feebatch', examtype='$examtype',studyyear='$studyyear',semester='$semester',startdate='$startdate',enddate='$enddate' ,amount='$examfee', modifiedby='$username',modifiedon='$this->date', remarks='' , delete_status=0 where refid='$exambatchid' and feetype ='EXAMFEE' ") ;
        
        $result = $this->db->directUpdate("update tblfeebatch set program='$program',  acyear='".$activeAcYear['academicyear']."' ,  course='$course', feebatch='$feebatchfine', examtype='$examtype',studyyear='$studyyear',semester='$semester',startdate='$startdate',enddate='$enddate' ,amount='$examfee', modifiedby='$username',modifiedon='$this->date', remarks='' , delete_status=0 where refid='$exambatchid' and feetype = 'EXAMFEEFINE'") ;
        return $result;     
     }
     return  $result; 
}
public function updateExamBatch($exambatchid, $program,$regulation, $course,$studyyear,$semester ,$examtype,$fromdate, $todate, $examfee,$startdate,$enddate,$username){   
    $result=0;
    $currentdate = new DateTime($fromdate);
    $exammonthyear = strtoupper($currentdate->format('F-Y'));
    $month3chrs=substr($exammonthyear,0,3);
    $ExamBatchData =$this->db->getRecord("select * from tblexambatch WHERE  exambatchid='$exambatchid'  ");
    $activeAcYear =$this->db->getRecord("select academicyear from tblacademicyears WHERE  active=1   ");
    $feebatch=$activeAcYear['academicyear']."_".$program."_".$studyyear."_".$semester."_".$month3chrs."_AUTONOMOUS_".$examtype."_EXAMFEE";
    $feebatchfine=$activeAcYear['academicyear']."_".$program."_".$studyyear."_".$semester."_".$month3chrs."_AUTONOMOUS_".$examtype."_EXAMFEEFINE";
   
    if(isset($ExamBatchData) and count($ExamBatchData)>0){
       $result = $this->db->directUpdate("update tblexambatch set program='$program', regulation='$regulation' ,  course='$course',  examtype='$examtype',studyyear='$studyyear',semester='$semester',fromdate='$fromdate',todate='$todate' ,examfee='$examfee', modifiedby='$username',modifiedon='$this->date', remarks='' , deletestatus=0 where exambatchid='$exambatchid' ") ;
       
       $result = $this->db->directUpdate("update tblfeebatch set program='$program',  acyear='".$activeAcYear['academicyear']."' ,  course='$course', feebatch='$feebatch', examtype='$examtype',studyyear='$studyyear',semester='$semester',startdate='$startdate',enddate='$enddate' ,amount='$examfee', modifiedby='$username',modifiedon='$this->date', remarks='' , delete_status=0 where refid='$exambatchid' and feetype ='EXAMFEE' ") ;
       
       $result = $this->db->directUpdate("update tblfeebatch set program='$program',  acyear='".$activeAcYear['academicyear']."' ,  course='$course', feebatch='$feebatchfine', examtype='$examtype',studyyear='$studyyear',semester='$semester',startdate='$startdate',enddate='$enddate' ,amount='$examfee', modifiedby='$username',modifiedon='$this->date', remarks='' , delete_status=0 where refid='$exambatchid' and feetype = 'EXAMFEEFINE'") ;
       return $result;     
    }
    return  $result;
}
public function deleteExamBatch($exambatchid){
    $result=0;
    $ExamBatchData =$this->db->getRecord("select * from tblexambatch WHERE  exambatchid='$exambatchid'  ");
    if(count($ExamBatchData)>0){
       $result = $this->db->directUpdate("update tblexambatch set  deletestatus=1 where exambatchid='$exambatchid' ") ;
       return $result;     
    }
    return $result;
}
public function getExamBatch($exambatchid){
    $ExamBatchData =$this->db->getRecord("select * from tblexambatch WHERE exambatchid='".$exambatchid."' and deletestatus=0 ");
    return $ExamBatchData;
}
public function getExamBatchId($program,$regulation, $course,$studyyear,$semester ,$examtype){
    $ExamBatchId =$this->db->getRecord("select * from tblexambatch WHERE program='".$program."' and regulation='$regulation' and course='$course' and studyyear='$studyyear'   and semester='$semester' and examtype='$examtype'");
    return $ExamBatchId;
}
public function getExamBatchList(){
    $ExamBatchData =$this->db->getRecords("select * from tblexambatch  WHERE  deletestatus=0  order by exambatchid desc ");
    return $ExamBatchData;
}
public function getExamBatches($program, $regulation , $course, $examtype){
    $ExamBatchesData =$this->db->getRecords("select * from tblexambatch  WHERE  deletestatus=0  and program='".$program."' and regulation='$regulation' and course='$course'   and examtype='$examtype'");
    return $ExamBatchesData;
}
public function DeclareExamResultOfExamBatch($exambatchid){
    $result = $this->db->directUpdate("update tblexambatch set active='1' where exambatchid='$exambatchid' and  deletestatus=0 ") ;
    return $result;  

}
public function HoldExamResultOfExamBatch($exambatchid){
    $result = $this->db->directUpdate("update tblexambatch set active='0' where exambatchid='$exambatchid'  and  deletestatus=0") ;
    return $result;      
}

public function getSimilarSubjectCode($exambatchid,$subjectcode)
    {        
        $similarSubjectcodeData =$this->db->getRecords("select * from tblexamtimetable  WHERE  delete_status=0  and exambatchid='$exambatchid' and subjectcode='$subjectcode' ");
        
        return $similarSubjectcodeData; 

    }
public function  getSimilarExamDate($exambatchid, $branch,$examdate)
{
    $similarExamDateData =$this->db->getRecords("select * from tblexamtimetable  WHERE  delete_status=0  and exambatchid='$exambatchid' and fromdate='$examdate'  and branch='$branch'");
        
    return $similarExamDateData; 
}
public function getBranchSubjectCode($exambatchid,$subjectcode,$branch)
{        
    $branchSubjectcodeData =$this->db->getRecords("select * from tblexamtimetable  WHERE  delete_status=0  and exambatchid='$exambatchid' and subjectcode='$subjectcode' and  branch='$branch'");
    return $branchSubjectcodeData; 

}
public function getProgram_Regulation_Related_Courses($program,$regulation,$courses)
    {
        $courseArray = explode(",", $courses);
        $courseList = "'" . implode("','", $courseArray) . "'";
        if($courseList!="")
            $coursesData =$this->db->getRecords("select distinct(course) as course from tblbatchstrength  WHERE  deletestatus=0  and program='$program' and regulation='$regulation'   and course IN ($courseList) order by course ");
        else
            $coursesData =$this->db->getRecords("select distinct(course) as course from tblbatchstrength  WHERE  deletestatus=0  and program='$program' and regulation='$regulation'  order by course ");  
        return $coursesData; 

    }
public function getBranch_Studyyear_Semester_Related_Subjects($program,$regulation,$courses,$studyyear,$semester)
    {
        if ($courses!=""){
        $courseArray = explode(",", $courses);
        $courseList = "'" . implode("','", $courseArray) . "'";
        $subjectsData =$this->db->getRecords("select distinct bs.program,bs.course, bs.regulation, bs.branch, es.studyyear,es.semester,es.subjectcode, es.subjectname,es.subjectcategory
            from tblbatchstrength bs  inner join tblexamsubjects es 
                                          on  bs.program='$program'
                                          and bs.program = es.program 
                                          and bs.course = es.course 
                                          and bs.branch = es.branch 
                                          and bs.regulation = es.regulation
            WHERE bs.course in  ($courseList)
              
              and bs.regulation = '$regulation'
              and es.studyyear = '$studyyear'
              and es.semester = '$semester' 
              ORDER BY bs.course, bs.branch, es.studyyear, es.semester,es.subjecttype desc, es.subjectcode");
       }
        else 
        $subjectsData=  $this->db->getRecords("select bs.program,bs.course, bs.regulation,  bs.branch, es.studyyear, es.semester, es.subjectcode, es.subjectname,es.subjectcategory  from tblbatchstrength bs
            inner join tblexamsubjects es on  bs.program='$program'
                                          and bs.program = es.program 
                                          and bs.course = es.course 
                                          and bs.branch = es.branch 
                                          and bs.regulation = es.regulation
                                          and es.studyyear = '$studyyear'
                                          and es.semester = '$semester' 
                                           
            ORDER BY bs.course, bs.branch, es.studyyear, es.semester,es.subjecttype desc ,es.subjectcode");  
        return $subjectsData; 
    }
public function assign_Date_and_Time_for_All_Subjects($subjectsData, $examtype,$fromdate , $todate,$theoryexamtime,$excludedates,$username )
{
    $currentdate = new DateTime($fromdate);
    $lastdate = new DateTime($todate);
    $interval = new DateInterval('P1D'); 
    $lastBranch = null;
    $lastSubjectCategory="";
    $exammonthyear="";
    $createddate=date("Y-m-d");  
    $examtiming = $theoryexamtime;
     
    $excludedatesArray = explode(',', $excludedates);
    foreach ($subjectsData as $subject) {
        if ($lastBranch !== null && $lastBranch !== $subject['branch']) {
            $currentdate = new DateTime($fromdate);
        }
        if($lastSubjectCategory=="S" and $subject['subjectcategory']=="S")
        {
            $currentdate->sub($interval);  
        }
        if ($currentdate > $lastdate) {
            break;
        }
        $excludeflag=1;
        while($excludeflag==1){
        $examdate = $currentdate->format('Y-m-d');
        $examdatecp = $currentdate->format('d-m-Y');
        $dtflg=1;
     
        foreach( $excludedatesArray as $aedate){
           
            if(trim($examdatecp)==trim($aedate))
            {
                $dtflg=0;
            }
        }

        if ($dtflg==1) 
        {
        if($exammonthyear=="")
        $exammonthyear = strtoupper($currentdate->format('F-Y'));
        $exambatchid=$this->getExamBatchId($subject['program'],$subject['regulation'], $subject['course'],$subject['studyyear'],$subject['semester'] ,$examtype);

        $branchSubjectcodeData=$this->getBranchSubjectCode($exambatchid['exambatchid'], $subject['subjectcode'], $subject['branch']);

        if(isset($branchSubjectcodeData) and count($branchSubjectcodeData)>0)
        {
          $this->db->DirectDelete( "delete from tblexamtimetable  WHERE  delete_status=0  and exambatchid='".$exambatchid['exambatchid']."' and subjectcode='".$subject['subjectcode']."' and  branch='".$subject['branch']."'");
        }
        $similarSubjectcodeData=$this->getSimilarSubjectCode($exambatchid['exambatchid'], $subject['subjectcode']);
        $similarExamDateData=$this->getSimilarExamDate($exambatchid['exambatchid'], $subject['branch'],$examdate); 
         
         
        if(count($similarExamDateData)>0 and ($lastSubjectCategory!="S" and $subject['subjectcategory']!="S"))
        {
            $currentdate->add($interval); 
            $excludeflag=1;
        }
        else
        {
        if(count($similarSubjectcodeData)>0 and ($lastSubjectCategory!="S" and $subject['subjectcategory']!="S"))
        {
             $sql="INSERT INTO tblexamtimetable (exambatchid, branch, subjectcode, fromdate, todate, examsession, examtiming,createdby, createdon) VALUES (?,?, ?, ?, ?, ?, ?,?,?)";
            $stmt = $this->db->dbConn->prepare($sql);
            $stmt->bind_param('sssssssss', $exambatchid['exambatchid'],
                                $subject['branch'], $subject['subjectcode'],
                                $similarSubjectcodeData[0]['fromdate'],$similarSubjectcodeData[0]['todate'], $examtiming, $examtiming, $username ,$createddate );
            $stmt->execute();
            $lastBranch = $subject['branch'];
            $lastSubjectCategory = $subject['subjectcategory'];
            $excludeflag=0;   
        }
        
        else
        {
            $sql="INSERT INTO tblexamtimetable (exambatchid, branch, subjectcode, fromdate, todate, examsession, examtiming,createdby, createdon) VALUES (?,?, ?, ?, ?, ?, ?,?,?)";
            $stmt = $this->db->dbConn->prepare($sql);
            $stmt->bind_param('sssssssss', $exambatchid['exambatchid'],
                                $subject['branch'], $subject['subjectcode'],
                                $examdate,$examdate, $examtiming, $examtiming, $username ,$createddate );
            $stmt->execute();
            
            $currentdate->add($interval);
             
            $lastBranch = $subject['branch'];
            $lastSubjectCategory = $subject['subjectcategory'];
            $excludeflag=0;
        }
        }
        }
        else
        {
        $currentdate->add($interval);
        $excludeflag=1;
        }
     }
       
    }
}

private function generateTimeTable($program,$regulation,$courses ,$studyyear,$semester,$examtype,$fromdate, $todate,$theoryexamtime, $excludedates, $username)
        {
            
            $subjectsData= $this->getBranch_Studyyear_Semester_Related_Subjects($program,$regulation,$courses,$studyyear,$semester);
            $this->assign_Date_and_Time_for_All_Subjects($subjectsData, $examtype,$fromdate , $todate,$theoryexamtime,$excludedates,$username);
        }

public function prepareExamSchedule($program,$regulation,$courses ,$studyyear,$semester,$examtype,$fromdate, $todate,$theoryexamtime,$examfee,$startdate,$enddate, $excludedates,$username)
{
    $coursesData=$this->getProgram_Regulation_Related_Courses($program,$regulation,$courses);
    for($i=0;$i<count($coursesData); $i++){
        $lastexambatchid=$this->createExamBatch($program,$regulation,$coursesData[$i]['course'],$studyyear,$semester ,$examtype,$fromdate, $todate,$examfee,$startdate,$enddate,$username);
    }
    $timeTablesData=$this->generateTimeTable($program,$regulation,$courses ,$studyyear,$semester,$examtype,$fromdate, $todate,$theoryexamtime,$excludedates ,$username);
}

public function getExamSchedule($exambatchid)
{   $timeTablesData="";
    $timeTablesData=$this->db->getRecords("select * from tblexamtimetable where exambatchid='$exambatchid' group by branch");
    return  $timeTablesData; 
}
public function getExamScheduleBranchGroup($exambatchid)
{   $timeTablesData="";
    $timeTablesData=$this->db->getRecords("select branch, count(subjectcode) as subject,approvestatus  from tblexamtimetable where exambatchid='$exambatchid' group by branch");
    return  $timeTablesData; 
}
public function getExamTimeTable($exambatchid, $branch)
{   $branchTimeTableData="";
    $branchTimeTableData=$this->db->getRecords("select tblexamtimetable.subjectcode,subjectname, fromdate, examtiming, timetableid,exambatchid from tblexamtimetable,tblexamsubjects where exambatchid='$exambatchid'and tblexamtimetable.branch='$branch' and tblexamtimetable.subjectcode=tblexamsubjects.subjectcode  and tblexamtimetable.branch=tblexamsubjects.branch    order by fromdate ");
    return  $branchTimeTableData; 
}
public function approveExamTimeTable($exambatchid, $branch)
{    
    $approveStatus=$this->db->DirectUpdate("update tblexamtimetable set approvestatus=1 where exambatchid='$exambatchid'and branch='$branch'");
    return  $approveStatus; 
}
public function approveExamTimeTableStatus($exambatchid, $branch)
{    
    $approveStatus=$this->db->getRecords("select approvestatus from tblexamtimetable where  exambatchid='$exambatchid'and branch='$branch'");
    return  $approveStatus; 
}
public function generateHallTickets($exambatchid,$theoryexamtime,$username)
{
    $examBatchdata=getExamBatch($exambatchid);
    $program=$examBatchdata['program'];
    $studyyear=$examBatchdata['studyyear'];
    $semester=$examBatchdata['semester'];
    $emy=explode("-",$examBatchdata['exammonthyear']);
    $exammonth=$emy[0];
    $examyear=$emy[1];
    $examsession=$theoryexamtime;
    $etype=substr($examBatchdata['examtype'],0,1);
    $m=substr($emy[0],0,3);
    $y=$emy[1];
    $etmy=$etype.$m.$y;
   $courseArray = explode(",", $examBatchdata['course']);
   $courseList = "'" . implode("','", $courseArray) . "'";
    
   $document_root = $_SERVER['DOCUMENT_ROOT']; 
   $outputr = $document_root.'/oceanerp/modules/exams/barcodes/rollnos/';
   if (!is_dir($outputr)) {
        mkdir($outputr) ;
   }
   $outputecp = $document_root.'/oceanerp/modules/exams/barcodes/examcodes/'.$program.'/'; 
    
   if (!is_dir($outputecp)) {
        mkdir($outputecp) ;
   }
   $outputecps = $document_root.'/oceanerp/modules/exams/barcodes/examcodes/'.$program.'/'.$etmy.'/'; 
   if (!is_dir($outputecps)) {
        mkdir($outputecps) ;
   }
   $outputecpsfrom = '/oceanerp/modules/exams/barcodes/examcodes/'.$program.'/'.$etmy.'/';
   
   $branchesData=$this->db->getRecords( "select * from tblbranch where  program='".$program."' and  course in  ($courseList) ");
    
   for( $i=0;$i<count($branchesData);$i++) {

        $hallTicketDataExists= $this->db->getRecords("select * from tblexamseatingrollnos where timetableid in( select timetableid from tblexamtimetable where exambatchid='$exambatchid' and  branch='".$branchesData[$i]['branch']."'  )  ");

        if(!isset($hallTicketDataExists))    
        { 

        $subjectsDatawithDates=$this->db->getRecords("select * from tblexamtimetable where exambatchid='$exambatchid' and  branch='".$branchesData[$i]['branch']."'  and fromdate!='0000-00-00' order by fromdate ");

        
        $studentsData=$this->db->getRecords("select tblstudents.rollno,tblstudents.program,studentname,fathername,mothername, photo,tblfeemaster.remarks,tblfeemaster.feebatch from tblstudents, tblfeereceipt ,tblfeemaster ,tblextstudents where   tblstudents.rollno= tblextstudents.studentno and tblfeemaster.rollno= tblstudents.rollno and tblfeemaster.rollno= tblfeereceipt.rollno and program='".$program."' and course='".$branchesData[$i]['course']."' and  branch='".$branchesData[$i]['branch']."' and tblfeereceipt.feebatch=tblfeemaster.feebatch and  tblfeereceipt.feebatch in (select feebatch from tblfeebatch where exambatchid='$exambatchid'  ) group by rollno order by tblstudents.rollno  ");
        
        $allotSubjectsData=$this->db->getRecords("select subjectname,tblexamallottedsubjects.subjectcode,rollno from tblexamallottedsubjects,tblexamsubjects where     tblexamsubjects.studyyear='".$studyyear."' and tblexamsubjects.semester='".$semester."'  and tblexamallottedsubjects.subjectcode=tblexamsubjects.subjectcode and course='".$branchesData[$i]['course']."' and    program='".$program."' and  branch='".$branchesData[$i]['branch']."'");
        
        if(isset($studentsData) and count($studentsData)>0)
        { 
        $subdatanum=$this->db->getRecord("select max(numberseed) as numberseed from tblexamnumbercodes where  program='".$program."' ");
        $numbercode=$subdatanum['numberseed']+1; 
        for($k=0; $k< count($studentsData); $k++)
        {   
        $rollno=$studentsData[$k]['rollno'];  
        if($examtype!="REGULAR") { 
         $remarks=$studata['remarks']; 
	     $subjectCodes= explode(",",$remarks);
        }
        for($l=0;  $l<count($subjectsDatawithDates);$l++)
        {
            $subjectname="";
            if($examtype=="REGULAR") { 
            for($si=0; $si<count($allotSubjectsData);$si++)
            {
            if($allotSubjectsData[$si]['rollno'] ==$rollno and $allotSubjectsData[$si]['subjectcode']==$subjectsDatawithDates[$l]['subjectcode'] ) 
            {
                $subjectname=$allotSubjectsData[$si]['subjectname'];
                break;
            }  
            } 
           }
           else{
            $subjectName=$this->db->getRecord("select * from tblexamsubjects where  subjectcode='".$subjectsDatawithDates[$l]['subjectcode'] ."' ");
            
            foreach($subjectCodes as $subjectcode) 
            {
            if($subjectcode==$subjectsDatawithDates[$l]['subjectcode'] ) 
            {
                $subjectname=$subjectName[0]['subjectname'];
                break;
            }  
            } 

           }
        
        if($subjectname!="")
        {
            $randno="" ;   
            $random_number = rand(100000, 999999);
            for ($i=0; $i<3; $i++)
                {
                    $d=rand(1,30)%2;
                    $d=$d ? chr(rand(65,90)) : chr(rand(48,57));
                    $randno=$randno.$d;
                }  
            $random_string = $randno.$random_number;    
            
                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                $imgpath=  $outputecps.$random_string.".png";
                $imgpathrelpath=$outputecpsfrom.$random_string.".png";
                $img=$random_string.".png";
                file_put_contents($imgpath, $generator->getBarcode($random_string, $generator::TYPE_CODE_128, 3, 50, $blackColor)); 
            
            $subdataBarcode=$this->db->getRecords("select * from tblexamseatingrollnos where  timetableid='".$subjectsDatawithDates[$l]['timetableid']."' and rollno='".$rollno."' ");
            if ( !isset($subdataBarcode))
                {   
                    $result = $this->db->directInsert("insert into tblexamseatingrollnos(timetableid,rollno,numbercode,barcode,barcodevalue) values('".$subjectsDatawithDates[$l]['timetableid']."','". $rollno."','".$numbercode."','".$imgpathrelpath."','".$random_string."')");
                    $numbercode++;
                }
                else{
                    $result = $this->db->directUpdate("update tblexamseatingrollnos set  numbercode='".$numbercode."'  ,barcode='".$imgpathrelpath."',barcodevalue='".$random_string."'  where  timetableid='".$subjectsDatawithDates[$l]['timetableid']."' and rollno='".$rollno."' ");   
                }
            
        }

        }
        
        }   
        $numbercode--;
        $result = $this->db->directUpdate("update tblexamnumbercodes  set numberseed='".$numbercode."' where  program='".$program."' ");
            
        }
        
         

        }

}
}
function generateSeatingPlan($leftarray,$rightarray,$total_strength,$selected_rooms,$program, $examdate,)
{
    $acoursesl=array();
	$i=0;
	foreach($leftarray as $ec){
		$acoursesl[$i]= $ec;
		$i++;
	}
     $acoursesr=array();
	$i=0;
	if(isset($rightarray)){
	foreach($rightarray as $ec){
		$acoursesr[$i]= $ec;
		$i++;
	}
	}
    $arooms=array();
    $rno=0;
	foreach($rooms as $room){
		$arooms[$rno]= $room;
		$rno++;
	}
    $ucount=0;$icount=0;
    $ml=0; $mr=0;
    $leftarr = array();
    $rightarr = array();

    $subjectTimeTable = $this->db->getRecords("select   *  from  tblexamtimetable where exambatchid  =(select exambatchid from tblexambatch  where  program='".$program."'   and fromdate='".$examdate."' and examsession='".$examsession."'      and  exammonthyear='".$exammonthyear."')   "); 
    
    while ($ml < sizeof($acoursesl) )
       {   
       $courseright=array();
       $courseleft=  explode("-",$acoursesl[$ml]);
       if(count($acoursesr)>0)
       $courseright=  explode("-",$acoursesr[$mr]);   
       
	   $rleft =$this->db->getRecords( "select timetableid, rollno from tblexamseatingrollnos  where timetableid in (select timetableid from tblexamtimetable where exambatchid  =(select exambatchid from tblexambatch  where program='".$program."'   and fromdate='".$examdate."' and examsession='".$examsession."'      and  exammonthyear='".$exammonthyear."' and course='".$courseleft[2]."'  order by course ) and branch='".$courseleft[3]."' and subjectcode='".$courseleft[4]."' order by  branch) order by rollno  ");
	  	 
	   
	   
	for ($left=0; $left<count($rleft );$left++  )
	   	{
	   	   
	   	$courselArray = array(
	   	 "program" => $courseleft[0],
        "regulation" => $courseleft[1],   
        "course" => $courseleft[2],
        "branch" => $courseleft[3],
        "subjectcode"=> $courseleft[4],
        "rollno" => $rleft[$left]['rollno']
         );
        $leftarr[] = $courselArray;
          
	   	}
	    
	   $ml++;  
	    
       }
       
       while ($mr < sizeof($acoursesr) )
       {   
      
   
       $courseright=  explode("-",$acoursesr[$mr]);   
       $rright =$this->db->getRecords( "select timetableid, rollno from tblexamseatingrollnos  where timetableid in (select timetableid from tblexamtimetable where exambatchid  =(select exambatchid from tblexambatch  where program='".$program."'   and fromdate='".$examdate."' and examsession='".$examsession."'      and  exammonthyear='".$exammonthyear."' and course='".$courseright[2]."'  order by course ) and branch='".$courseright[3]."' and subjectcode='".$courseright[4]."' order by  branch) order by rollno  ");
	   
	   
       for ($right=0; $right<count($rright );$right++  )
	   	{
	   	   
	   	$courserArray = array(
	   	  "program" => $courseright[0],
        "regulation" => $courseright[1],   
        "course" => $courseright[2],
        "branch" => $courseright[3],
         "subjectcode"=> $courseright[4],
        "rollno" => $rright[$right]['rollno']
         );
        $rightarr[] = $courserArray;
       	}
	   $mr++;  
	   }
        $stdyear= $subjectTimeTable[0]['studyyear'];
        $sem= $subjectTimeTable[0]['semester'];
         
       $leftRollNos=array();
      $rightRollNos=array();
       $leftcourse=array();
      $rightcourse=array();
       $leftbranch=array();
      $rightbranch=array();
       $leftreg=array();
      $rightreg=array();
      $ml=0;
       
       while (  $ml < sizeof($leftarr))
       { 
        $leftRollNos[$ml] =$leftarr[$ml]['rollno']  ;
        $leftcourse[$ml] =$leftarr[$ml]['course']  ;
        $leftbranch[$ml] =$leftarr[$ml]['branch']  ;
        $leftreg[$ml] =$leftarr[$ml]['regulation']  ;
        $ml++;
        
       }
      $mr=0;
       while (  $mr < sizeof($rightarr))
       { 
        $rightRollNos[$mr] =$rightarr[$mr]['rollno']  ;
        $rightcourse[$mr] =$rightarr[$mr]['course']  ;
        $rightbranch[$mr] =$rightarr[$mr]['branch']  ;
        $rightreg[$mr] =$rightarr[$mr]['regulation']  ;
       
        $mr++;
       } 
     

}

function selectRooms($rooms, $total_strength) {
   
    $selected_rooms = [];
    $current_capacity = 0;

    
    foreach ($rooms as $room) {
     
        preg_match('/_(\d+)$/', $room, $matches);
        $capacity = (int)$matches[1];
        
        $selected_rooms[] = $room;
        $current_capacity += $capacity;
       
        if ($current_capacity >= $total_strength) {
            break;
        }
    }
 
    if ($current_capacity < $total_strength) {
        return "Error: No rooms with sufficient capacity found.";
    }

    return $selected_rooms;
}

function roomsAllotment( $program, $total_strength)
{
  $roomsStrength= $this->db->getRecords("select * from tblexamrooms  where   program='".$program."'   ");
   if(isset($roomsStrength) )
  {
  $i=1; $rooms =array();
  for($i=0; count($roomsStrength);$i++)
   {
   $rooms[] = $roomsStrength[$i]['blockname']."-".$roomsStrength[$i]['floorname']."-RoomNo:".$roomsStrength[$i]["roomno"]."-".$roomsStrength[$i]['roomrows']."-".$roomsStrength[$i]['roomcolumns']."-".$roomsStrength[$i]["roomstrength"]; 
   }
  }
  $selected_rooms= selectRooms($rooms, $total_strength);
  return $selected_rooms;
}

function divide_L_R_courses($coursebranchstrength) 
{
    $courses = [];
    foreach ($coursebranchstrength as $item) {
        preg_match('/_(\d+)$/', $item, $matches);
        $strength = (int)$matches[1];
        $courses[] = ['course' => $item, 'strength' => $strength];
    }
    usort($courses, function($a, $b) {
        return $b['strength'] - $a['strength'];
    });
    $leftarray = [];    $rightarray = [];    $left_strength = 0;    $right_strength = 0;
      
    foreach ($courses as $course) {
        if ($left_strength <= $right_strength) {
            $leftarray[] = $course['course'];
            $left_strength += $course['strength'];
        } else {
            $rightarray[] = $course['course'];
            $right_strength += $course['strength'];
        }
    }
    return [$leftarray, $rightarray, $left_strength ,$right_strength];
 }


 function  seatingAllotment($exambatchid , $examdate,$examsession)
    {
    $studentExamStrength= $this->db->getRecords("select timetableid, count(rollno) as cnt from tblexamseatingrollnos  where timetableid in (select timetableid from tblexamtimetable where rexambatchid ='".$exambatchid."'  ) group by timetableid ");
    if(isset($studentExamStrength))
    {
    $j=1;
    for ($i=0; $i<count($studentExamStrength);$i++) 
    {
        $timeTableData= $this->db->getRecord("select * from tblexamtimetable  where timetableid ='".$studentExamStrength[$i]['timetableid']."' ");
                                            
        $coursebranchstrength= $timeTableData['exambatchid']."-".$timeTableData['branch']."-".$timeTableData['subjectcode']."-".$r["cnt"]; 
        $j++;
    }
    list($leftarray, $rightarray,$left_strength ,$right_strength)= divide_L_R_courses($coursebranchstrength);  

    $selected_rooms =roomsAllotment($program, $left_strength+$right_strength);

    generateSeatingPlan($leftarray,$rightarray,$left_strength +$right_strength,$selected_rooms);
    }


    }  	


 }
  

 
//function arguments
//prepareExamSchedule($program,$regulation,$courses ,$studyyear,$semester,$examtype,$examfromdate, $examtodate,$theoryexamtime,$examfee,$feestartdate,$feeenddate,$username)
//function call
//$result=$exam_handler->prepareExamSchedule("UGDEG","UGR23","BSC(Honours)","1","1" ,"REGULAR","2024-01-01" , "2024-01-31","5.00am TO 9am", 6000,"2024-01-01" , "2024-01-05","RAMU" );
 //print_r($exam_handler->getExamSchedule(10)) ;

?>