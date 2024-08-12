<?php
ob_start();
include_once(__DIR__ . "/../../includes/common.php");
include_once(__DIR__ . "/../../includes/session.php");
extract($_REQUEST);
$view_url="vw_examschedulebranch.php";
$ctrl_url="ExamScheduleBranch.php";
 
if(isset($_POST["optprogram"]))
	$optprogram=$_POST["optprogram"];
else
	$optprogram="";
	if(isset($_POST["optuserids"]))
	$optuserids=$_POST["optuserids"];
else
	$optuserids="";
if(!isset($action))
$action="show";
$msg="";

$action="addsection";
//$rprograms=$func_handler->db->getRecords("select distinct(tblprogramrolefunctions.program) as program, collegename  from  tblprogramrolefunctions, tblprogram where tblprogramrolefunctions.program= tblprogram.program  order by program");
$colnames=" distinct(tblprogramrolefunctions.program) as program, collegename  ";
$rprograms=$wpr_handler->getColumnsDataWithJoin("tblprogramrolefunctions","tblprogram", "program" ,$colnames);


//$roles=$func_handler->db->getRecords("select distinct program, prole  from  tblprogramrolefunctions order by program,prole");
$colnames=" distinct program, prole "; 
$orderbycols=" program,prole ";
$roles=$wpr_handler->getSpecificColumnsData("tblprogramrolefunctions",$colnames, $orderbycols);

//$functions=$func_handler->db->getRecords("select program, prole, rfunction  from  tblprogramrolefunctions order by program,prole,rfunction");
$colnames=" distinct program, prole, rfunction "; 
$orderbycols=" program, prole, rfunction ";
$functions=$wpr_handler->getSpecificColumnsData("tblprogramrolefunctions",$colnames, $orderbycols);

//$metaprograms=$func_handler->db->getRecords("select distinct program, collegename  from tblprogram  where program!=''  and collegename!='' order by program ");
$colnames=" distinct program, collegename "; 
$orderbycols=" program ";
$criteria=" program!=''  and collegename!='' ";
$metaprograms=$wpr_handler->getSpecificColumnsDataWithCriteria("tblprogram",$colnames,$criteria ,$orderbycols);

//$mstremps=$func_handler->db->getRecords("select distinct empcode, emailid,empname,program  from tblempmaster  where status='WORKING'  order by empname");
$colnames=" distinct empcode, emailid,empname,program "; 
$orderbycols=" empname ";
$criteria=" status='WORKING' ";
$metaprograms=$wpr_handler->getSpecificColumnsDataWithCriteria("tblempmaster",$colnames,$criteria ,$orderbycols);

if($optprogram!='')  
//$metaroles=$func_handler->db->getRecords("select distinct program, prole  from  tblprogramrolefunctions  where program='".$optprogram."' order by program,prole");
{
$colnames=" distinct program, prole "; 
$orderbycols=" program,prole ";
$criteria=" program='".$optprogram."' ";
$metaroles=$wpr_handler->getSpecificColumnsDataWithCriteria("tblprogramrolefunctions",$colnames,$criteria ,$orderbycols);
}
$colnames=" distinct designation "; 
$orderbycols="designation ";
$metadesign=$wpr_handler->getSpecificColumnsData("tbldesignation", $colnames ,$orderbycols);

include_once("views/".$view_url);
 ?>
