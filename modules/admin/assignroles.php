<?php
ob_start();
include_once(__DIR__ . "/../../includes/common.php");
include_once(__DIR__ . "/../../includes/session.php");
extract($_REQUEST);
$view_url="vw_assignroles.php";
$ctrl_url="assignroles.php";
 
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
if(isset($_POST['submit']))
$action="addsection";
$rprograms=$func_handler->db->getRecords("select distinct(tblprogramrolefunctions.program) as program, collegename  from  tblprogramrolefunctions, tblprogram where tblprogramrolefunctions.program= tblprogram.program  order by program");
$roles=$func_handler->db->getRecords("select distinct program, prole  from  tblprogramrolefunctions order by program,prole");
$functions=$func_handler->db->getRecords("select program, prole, rfunction  from  tblprogramrolefunctions order by program,prole,rfunction");
$metaprograms=$func_handler->db->getRecords("select distinct program, collegename  from tblprogram  where program!=''  and collegename!='' order by program ");
$mstremps=$func_handler->db->getRecords("select distinct empcode, emailid,empname,program  from tblempmaster  where status='WORKING'  order by empname");
if($optprogram!='')  
$metaroles=$func_handler->db->getRecords("select distinct program, prole  from  tblprogramrolefunctions  where program='".$optprogram."' order by program,prole");
$metadesign=$func_handler->db->getRecords("select distinct designation  from  tbldesignations order by designation");

switch($action)
{
	case 'show':
    //header("location:".$ctrl_url);
	break;
	case 'addsection':
	 
	if(isset($_POST['submit']) && ($_POST['submit'] == "Add" || $_POST['submit'] = "Edit"))
	{
	$error = '';

	if ($error == '')
	{
		if (isset($_POST['submit']) && $_POST['submit'] == "Add")
		{
			$x=$func_handler->db->addProgramRolesToDb("tblprogramroles");
			 header("location:".$ctrl_url."?act=3"); 
		}
		 
 	exit;
	}
	}
	break;
}
include_once("views/".$view_url);
 ?>
