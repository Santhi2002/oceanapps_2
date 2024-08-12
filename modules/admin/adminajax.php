<?php
include_once(__DIR__ . "/../../includes/common.php");
include_once(__DIR__ . "/../../includes/session.php"); 
if(isset($_POST["optprogram"]) && !empty($_POST["optprogram"])){
     
    $metaroles=$func_handler->db->getRecords("select distinct program, prole  from  tblprogramrolefunctions  where program='".$_POST["optprogram"]."' order by program,prole");
    
    if(isset($metaroles) && count($metaroles)!=0)
	{ 	 
	for($m=0;$m<count($metaroles);$m++)
	{
     
     echo ' 
         <label class="form-check" style="margin-left:4px;">
             <input type="checkbox"  style="border-color:blue;" name="chkroles[]" id="'.$metaroles[$m]['prole'].'" value="'. $metaroles[$m]['prole'].'" class="form-check-input">
             <span class="form-check-label ">'.$metaroles[$m]['prole'].'</span>
         </label>
       ';
     
    } 
	
}
}
if(isset($_POST["optuserids"]) && !empty($_POST["optuserids"])){
     
     $userids=explode(",",$_POST["optuserids"]);
         
    $metaroles=$func_handler->db->getRecords("select * from tblprogramroles where userid ='".$userids[0]."' and program= '".$_POST["assoptprogram"]."'");
    
    if(isset($metaroles) && count($metaroles)!=0)
	{ 
    
	for($m=0;$m<count($metaroles);$m++)
	{
     
     echo ' 
         <label class="form-check" style="margin-left:4px;">
             <input type="checkbox" style="border-color:blue;" checked name="revokeroles[]" id="'.$metaroles[$m]['prole'].'" value="'. $metaroles[$m]['prole'].'" class="form-check-input ">
             <span class="form-check-label ">'.$metaroles[$m]['prole'].'</span>
         </label>
       ';
     
    }
  }
 
}
?>