<?php

session_start();

if(isset($_SESSION['USERID']))
{
	$welcome = "Welcome ".$_SESSION['UNAME'];
}
else
{
	header("Location: index.php");
}

?>