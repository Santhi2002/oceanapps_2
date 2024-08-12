<?php
ob_start();
include_once(__DIR__ . "/../../includes/common.php");
include_once(__DIR__ . "/../../includes/session.php");
extract($_REQUEST);
$view_url="vw_cashreceipt.php";
$ctrl_url="cashreceipt.php";
 
 
 
include_once("views/".$view_url);
 ?>
