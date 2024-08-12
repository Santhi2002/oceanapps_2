<?php
if (!session_start()) {
    session_start();
}
GLOBAL $func_handler;
include("includes/commongc.php");
include("includes/head.php");
$output="";
$username="";
if (isset($_GET['code'])) {
     
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
      header('Location: '.filter_var(GOOGLE_REDIRECT_URL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
    // Get user profile data from google
    $gpUserProfile = $google_oauthV2->userinfo->get();
     
    // Initialize User class
    //$user = new User();
    
    // Getting user profile info
    $gpUserData = array();
    $gpUserData['oauth_uid'] = !empty($gpUserProfile['id'])?$gpUserProfile['id']:'';
    $gpUserData['first_name'] = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:'';
    $gpUserData['last_name'] = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:'';
    $gpUserData['email'] = !empty($gpUserProfile['email'])?$gpUserProfile['email']:'';
    $gpUserData['gender'] = !empty($gpUserProfile['gender'])?$gpUserProfile['gender']:'';
    $gpUserData['locale'] = !empty($gpUserProfile['locale'])?$gpUserProfile['locale']:'';
    $gpUserData['picture'] = !empty($gpUserProfile['picture'])?$gpUserProfile['picture']:'';
    $gpUserData['link'] = !empty($gpUserProfile['link'])?$gpUserProfile['link']:'';
    
    // Insert or update user data to the database
    $gpUserData['oauth_provider'] = 'google';
	 
    $userData = $func_handler->checkUser($gpUserData);
     
    // Storing user data in the session
    $_SESSION['userData'] = $userData;
     $_SESSION['email']=$gpUserData['email'];
    
    // Render user profile data
    if (!empty($userData)) {
        
 	
	if(isset($_SESSION['email'])){
	     
 		$username = $_SESSION['email'];
  	   
  		$empdata=$func_handler->db->getRecords("SELECT * FROM tblemp WHERE delete_status=0  and email = '".$username."' LIMIT 1 ");
		if(isset($empdata) && count($empdata)==0)
		 {
			 
			$_SESSION['error'] = "<h5 style='color:red;background-color:yellow;font-size:18px;'>Invalid Authorization </h5>";
			// Get login url
			 
             $authUrl = $gClient->createAuthUrl();
    
             // Render google login button
             $output = '<center><a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="/oceanerp/assets/img/images/signin.JPG"  width="80%" alt="sign-in-with-google" /></a></center>';

			 $output .=   "<h5 align='center'><span style='color:red;'>Note:</span>Sign in with your personal google email account. If any problem is found, then signout gmail account and close the browser, and again reopen the browser</h5>";
		  }
		else{
		 
		 if(isset($empdata) && count($empdata)!=0)
			
			{
				 
			   $_SESSION['empid'] = $empdata[0]['empid'];
				$_SESSION['email'] = $empdata[0]['email'];
				$_SESSION['program'] = $empdata[0]['program'];
				$_SESSION['emprole'] = $empdata[0]['emprole'];
				$_SESSION['deptcode'] = $empdata[0]['deptcode'];
				$_SESSION['phone']= $empdata[0]['phone'];
				$_SESSION['alogin']= $empdata[0]['email'];
				$_SESSION['id']=$empdata[0]['id'];
				
	      if(isset($_SESSION['email']) and ($_SESSION['emprole']==1))
		 	{
		 	   
		 	    //echo "<script>window.location.href='home.php';</script>";
		 	      header('location: home.php');
		 	}
		}
		else{
				$_SESSION['error'] = 'Incorrect password';
			 
			}
		}
		
	}
	else{
		$_SESSION['error'] = 'Input admin credentials first';
		 
	}

        
        
    } else {
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
} else {
    // Get login url
    $authUrl = $gClient->createAuthUrl();
    
    // Render google login button
    $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"> class="btn btn-success btn-block btn-lg "><i class="fa fa-google" ></i> Google  <b>Sign in</b></a> ';
    $output = '<center><a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"> <img src="/oceanerp/assets/img/images/signin.JPG" height="10%" width="30%" alt="sign-in-with-google" /></a></center>';
    	$output .=   " ";  
}
?>

 
<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
	<div class="wrapper">
  	<div class="main">
 	<main class="content">
	<div class="container-fluid p-0">
       <h2 class="text-center"><img src="/oceanerp/assets/img/images/vsmlogo.png" width="100" height="100" style="border-radius:20px;"> <br> <strong>OceanApps</strong> Sign in</h2>
		<?php 			 
			if(isset($_SESSION['error']) and $_SESSION['error'])
			{?>
	     	<div class="or-seperator"><b><?php echo $_SESSION['error'];
	 	?></b>
		</div>
		<?php 
		}
		?>
    	
        <?php echo $output; ?>
    </div>
    </div>
    
</div>

</body>
</html>