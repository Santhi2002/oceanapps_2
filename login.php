<?php
	session_start();
	 include 'includes/conn.php';
define('DB_HOST','localhost');
define('DB_USER','vsmgroup66_vsmdashboard');
define('DB_PASS','vsmgroup66_vsmdashboard');
define('DB_NAME','vsmgroup66_vsmdashboard');

try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}	
	if(isset($_POST['login'])){
	 
		$username = $_POST['username'];
		$password = $_POST['password'];
		 
     	
		$sql = "SELECT * FROM tblemp WHERE delete_status=0  and email = :id LIMIT 1";
		$query = $dbh -> prepare($sql);
		$query->bindParam(':id', $username);
		 $query->execute();
		 $results=$query->fetchAll(PDO::FETCH_OBJ);
		 if($query->rowCount() <0)
		 {
			$_SESSION['error'] = 'Cannot find account with the username';
			 
		  }
		else{
		    
		$sql = "SELECT * FROM tblemp WHERE delete_status=0 and email = :id  and password = :pwd LIMIT 1";
		            $query = $dbh -> prepare($sql);
		$query->bindParam(':id', $username);  
		$query->bindParam(':pwd', MD5($password));
		 $query->execute();
			
			if($row = $query->fetch(PDO::FETCH_ASSOC))
			
			{
				 
			   $_SESSION['empid'] = $row['empid'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['program'] = $row['program'];
				$_SESSION['user'] = $row['username'];
				$_SESSION['emprole'] = $row['emprole'];
				$_SESSION['deptcode'] = $row['deptcode'];
				$_SESSION['phone']= $row['phone'];
				$_SESSION['alogin']= $row['email'];
				$_SESSION['id']=$row['id'];
				$sql2 = "SELECT * FROM tblCourses WHERE program = '".$row['program']."'";
		        $query2 = $conn->query($sql2);
			
			if($row2 = $query2->fetch_assoc())
			{
				$_SESSION['programcode'] =$row2['programcode']; 
				 
			}
			
				if($row['emprole']==12) 
				{
				$sql1 = "SELECT rollno FROM tblstudents WHERE email = '$username'  ";
		        $query1 = $conn->query($sql1);
			
			      $row1 = $query1->fetch_assoc();
			     $_SESSION['rollno']= $row1['rollno'];
				 $_SESSION['memberid']= $row1['rollno'];
				}
				if($row['emprole']==11 or $row['emprole']==17 or $row['emprole']==5 or $row['emprole']==20 or  $row['emprole']==3 or  $row['emprole']==33 or  $row['emprole']==1 or  $row['emprole']==9 or  $row['emprole']==2 or $row['emprole']==6 or $row['emprole']==15 or $row['emprole']==7 )
				{
				$sql1 = "SELECT * FROM tblempmaster WHERE emailid = '$username'  ";
		        $query1 = $conn->query($sql1);
			
			      $row1 = $query1->fetch_assoc();
			     $_SESSION['empcode']= $row1['empcode'];
				 $_SESSION['memberid']= $row1['empcode'];
				  $_SESSION['phoneno']= $row1['phoneno'];
				   $_SESSION['deptcode2']= $row1['deptcode'];
				    $_SESSION['designation']= $row1['designation'];
				}
			setcookie("email", $row['email'], time() + (86400 * 30), "/"); // 86400 = 1 day
			setcookie("program", $program, time() + (86400 * 30), "/"); // 86400 = 1 day
			setcookie("user", $row['username'], time() + (86400 * 30), "/"); // 86400 = 1 day
			unset($_COOKIE['error']);
			setcookie("error",  null, time()-55600,'/');
			 
			}
			else{
				$_SESSION['error'] = 'Incorrect password';
			 
			}
		}
		
	}
	else{
		$_SESSION['error'] = 'Input admin credentials first';
		 
	}

	header('location: index.php');

?>