<?php
include_once(__DIR__ . "/../../includes/common.php");
include_once(__DIR__ . "/../../includes/session.php"); 
 
 
if(isset($_POST["tprogram"]) && !empty($_POST["tprogram"])){
     
              
    $regulationData=$meta_handler->db->getRecords("select distinct(regulation) from tblregulations where program ='".$_POST["tprogram"]."' order by regulation desc ");
    
   
    if(isset($regulationData) && count($regulationData)!=0)
	{ 
    echo '<option value="">Select Regulation</option>'; 
	for($m=0;$m<count($regulationData);$m++)
	{
         echo '<option value="'.$regulationData[$m]['regulation'].'">'.$regulationData[$m]['regulation'].'</option>';
     
    }
  }
  
}
if(isset($_POST["sesprogram"]) && !empty($_POST["sesprogram"])){
     
              
    $examSessionData=$meta_handler->db->getRecords("SELECT distinct(examtiming) FROM  tblexamsession  where program='".$_POST['sesprogram']."' order by examtiming desc ");
    
   
    if(isset($examSessionData) && count($examSessionData)!=0)
	{ 
    echo '<option value="">Select Exam Session</option>'; 
	for($m=0;$m<count($examSessionData);$m++)
	{
         echo '<option value="'.$examSessionData[$m]['examtiming'].'">'.$examSessionData[$m]['examtiming'].'</option>';
     
    }
  }
  
}
if(isset($_POST["prgprogram"]) && !empty($_POST["prgprogram"]) and isset($_POST["prgregulation"]) && !empty($_POST["prgregulation"]) ){
     
              
    $courseData=$meta_handler->db->getRecords("select distinct(course) from tblbatchstrength where program ='".$_POST["prgprogram"]."'  and regulation='".$_POST["prgregulation"]."' order by course desc ");
    
    
    if(isset($courseData) && count($courseData)!=0)
	{ 
    echo '<option value="">Select Course</option>';
	for($m=0;$m<count($courseData);$m++)
	{
         echo '<option value="'.$courseData[$m]['course'].'">'.$courseData[$m]['course'].'</option>';
     
    }
  }
 
}
?>