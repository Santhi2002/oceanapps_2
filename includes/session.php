<?php
session_start();
if(!isset($_SESSION['email']) || trim($_SESSION['email']) == ''){
     header('location: /oceanerp/index.php');
	}
	else{
   	$erpuser=$func_handler->db->getRecords("SELECT * FROM tblemp WHERE delete_status=0  and email = '".$_SESSION['email']."' LIMIT 1 ");
    $authuser=$func_handler->db->getRecords("SELECT * FROM tblssousers WHERE  email = '".$_SESSION['email']."' LIMIT 1 ");
	$userroles=$func_handler->db->getRecords("SELECT * FROM tblroleprogramfunctions WHERE deletestatus=0 and userid = '".$_SESSION['email']."' LIMIT 1 ");
	date_default_timezone_set('Asia/Kolkata');
  	
	
}
?>