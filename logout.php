<?php
session_start();
?>
<html>
<body>
        
<script>
//function myFunction() {
   //document.location.href = "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=https://oceanapps.in/oceanerp";
   // document.location.href = "https://www.google.com/accounts/Logout";
   
//}
//myFunction();
</script>

</body>
</html>

<?php
include("config/google_config.php");
if(isset($_SESSION['rollno']))
unset($_SESSION['rollno']);
if(isset($_SESSION['student']))
unset($_SESSION['student']);
if(isset($_SESSION['admin']))
unset($_SESSION['admin']);
if(isset($_SESSION['email']))
unset($_SESSION['email']);
if(isset($_SESSION['emprole']))
unset($_SESSION['emprole']);
if(isset($_SESSION['alogin']))
unset($_SESSION['alogin']);
if(isset($_SESSION['id']))
unset($_SESSION['id']);
if(isset($_SESSION['deptcode']))
unset($_SESSION['deptcode']);
if(isset($_SESSION['username']))
unset($_SESSION['username']);
if(isset($_SESSION['empcode']))
unset($_SESSION['empcode']);
if(isset($_SESSION['designation']))
unset($_SESSION['designation']);
if(isset($_SESSION['memberid']))
unset($_SESSION['memberid']);
if(isset($_SESSION['deptcode2']))
unset($_SESSION['deptcode2']);
// Include configuration file
 
$_SESSION['email']="";
$_SESSION['rollno']="";
$_SESSION['empcode']="";
 
$_SESSION = array();
// Remove token and user data from the session
unset($_SESSION['token']);
unset($_SESSION['userData']);
 
// Reset OAuth access token
 $gClient->revokeToken();  

// Destroy entire session data 
session_destroy(); 

// Redirect to homepage 
header("Expires: Tue, 01 Jan 2010 00:00:00 GMT");
//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
 
unset($_SESSION['access_token']);
unset($_SESSION['name']);
$session_data=array('sess_logged_in'=>0);
setcookie("student", null, time()-55600,'/');
setcookie("admin", null, time()-55600,'/');
   //header('location: https://vsmerp.vsm.edu.in');
	//header('location: http://18.224.73.193/erpsign/logout.php');
    // header('location: https://vsm.edu.in/VSMERP/indexlogin.php');
 // header('location: https://oceanapps.in/oceanerp/index.php');
 //  header('location: https://www.google.com/accounts/Logout');
  echo "<script>window.location.href='https://www.google.com/accounts/Logout';</script>";
  exit;
?>