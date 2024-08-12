<?php 
include("../../includes/head.php");
$_SESSION['page']="modules/fees/cashreceipt.php"; 
$action = "addsection";
$errormsg="";
$d=date('Y-m-d-H:i:s');
$d1=date('Y-m-d');
$rcptdate = date("d-m-Y", strtotime($d)); 
?>
 <script src="js/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
     function printTable() {
        var tableContent = document.getElementById('data').outerHTML;
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Fee Receipt</title>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(tableContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script> 
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../plugins/PHPMailer/src/Exception.php';
require '../../plugins/PHPMailer/src/PHPMailer.php';
require '../../plugins/PHPMailer/src/SMTP.php';
   
  //Insert into DB
    $feebatch= $_POST['feebatch'];
    $program= $_POST['program'];
    $branch= $_POST['branch'];
    $batch= $_POST['batch'];
    $rollno= $_POST['mrollno'];
    $paidamt= $_POST['paidamt'];
    $studentname= $_POST['studentname'];
    $course= $_POST['course'];
    $email= $_POST['email'];
    $phone= $_POST['phone'];
    $balamt= $_POST['balamt'];
    $ye= $_POST['ye'];
    $rem=$_POST['remarks'];
    date_default_timezone_set('Asia/Kolkata');
    $d=date('Y-m-d-H:i:s');
    $receiptdate= date('Y-m-d');
    $mode="CASH";
    
    try {	 
    $func_handler->db->beginTrans();
    
    $rcptsno=$wpr_handler->getMaxValueofColumn("tblfeereceipt", "receiptno");
    if(count($rcptsno)>0 )
     $rno =$rcptsno['rno']+1;
    else
     $rno=1;  
    $rptno="";$flag=0; 
    $sql="SELECT distinct(feecategory) as fc from tblfeetypes where  feetype = (select feetype from tblfeebatch where feebatch='".$feebatch."' ) and feecategory in (select pubfeecat from tblpubfeecat ) ";
    $feecatdata=$wpr_handler->getMultiRowDataWithSQL($sql);    
 
    if(count($feecatdata)>0)
     {  
       
		$colnames=" firstchar "; 
        $orderbycols=" firstchar ";
        $criteria=" pubfeecat='".$feecatdata[0]['fc']."'   ";
        $paytypefirstchar=$wpr_handler->getSpecificColumnsDataWithCriteria("tblpubfeecat",$colnames,$criteria ,$orderbycols);  
		$cate= substr($paytypefirstchar[0]['firstchar'],0,1);
        $mtype=substr($mode,0,2);
	   if($branch!="") 
	    {
        $colnames=" distinct(coursetype) as coursetype   "; 
        $orderbycols=" program";
        $criteria=" program='$program'  and branch='$branch'  ";
        $coursetypedata=$wpr_handler->getSpecificColumnsDataWithCriteria("tblcourses",$colnames,$criteria ,$orderbycols);
       }  
       else
	    {
        $colnames=" distinct(coursetype) as coursetype   "; 
        $orderbycols=" program";
        $criteria=" program='$program' and coursecode='$course' ";
        $coursetypedata=$wpr_handler->getSpecificColumnsDataWithCriteria("tblcourses",$colnames,$criteria ,$orderbycols);

       }
	    $coursetype=$coursetypedata[0]['coursetype'];
	 	
		$rptno= $coursetype."-".date("Y")."-";
		$criteria=" mreceiptno like '$coursetype%'  and mreceiptno like '%$cate%'  ";
		$tercptsno=$wpr_handler->getMaxValueofColumnWithCriteria("tblfeereceiptnos", "CONVERT(substring(mreceiptno,14),UNSIGNED)",$criteria );  	
			if(count($tercptsno)>0)
				$rptno= $coursetype."-".$mtype."-".$cate."-".date("Y")."-". ($tercptsno[0]['sno']+1);
			else
				$rptno= $coursetype."-".$mtype."-".$cate."-".date("Y")."-". "1";
			 
        $flag=1;
	
	 }
     $refno="";    
     
	 $sql="insert into tblfeereceipt(receiptno,receiptdate,rollno,feebatch,amount,mode,remarks,createdon,createdby,modifiedon,modifiedby,printdate,qrtno,trrefno,trrefdate) values('$rno','$receiptdate','$rollno','$feebatch','$paidamt','$mode','$rem','$d','".$_SESSION['email']."','$d','0','','','$refno','$receiptdate')";
    
   
   if(  $func_handler->db->directInsert($sql) ==1)
   {
    
    if($flag==1)    
    {
       	$sql = "INSERT INTO tblfeereceiptnos(receiptno,mreceiptno) VALUES ('".$rno."','".$rptno."')"; 
           $func_handler->db->directInsert($sql);
    }
    $bamount=$balamt-$paidamt;   

	if ($bamount==0 or $bamount==0.0)
	{
		$sql= "update tblfeemaster set status='paid' where rollno = '$rollno' AND feebatch='$feebatch'   ";
        $func_handler->db->directUpdate($sql);
    // on 13-07-23	
  	   $finesql=$func_handler->db->query("select * from tblfinecron where rollno = '$rollno' and onfeebatch='".$feebatch."'  and status=0 ");
      
      if($finedata = $finesql->fetch_assoc())
      {
          $id=$finedata['id'];
		$sql = "update tblfinecron set status = 2   where id = '".$id."'    ";
        $func_handler->db->directUpdate($sql);
      }
      
      
	} 
 
    $sql= "update tbldiscount set status='$rno' where rollno = '$rollno' and feebatch='$feebatch'   ";
    $func_handler->db->directUpdate($sql);
     
    $func_handler->db->commitTrans();
    
	$rcptnumber=$rptno=="" ?  $rno:  $rptno ;
?>
 
 <body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
<div class="wrapper">
    <?php include("../../includes/sidebar.php"); ?>
	<div class="main">
	     <?php include("../../includes/menubar.php"); ?>
         <main class="content">
         <div class="container-fluid p-0">
                 <a class="btn btn-danger float-end mt-n1" href="/oceanerp/modules/fees/collectfee.php"   class="btn btn-danger btn-sm pull-right"> Close </a>   			
                 <button class="btn btn-primary float-end mt-n1" type="submit" name="submit"  onclick="printTable()"><i class="fas fa-plus"></i>Print Receipt</button>
                <?php	
                $receiptHTML="";
                
                    $receiptHTML.='<page size="A4">
                        <br>
                        <table border = "0px" width="595px" height="442px" align="center" id="data">
                            <tr>
                <td>';
                 $copy="(Student Copy)";
                        
                    
                    $receiptHTML.='<table height="280px" width="592px" border=1> 
                            <tr>';
						  if($program=="UGDEG"){
								 
                              $receiptHTML.=  '<td align="center" colspan="2"><img src="https://vsm.edu.in/student/main.jpg" alt="VSM GROUP OF INSTITUTIONS" height="50px">

                                </td>';
						 
							}
							else
							{ 
					$receiptHTML.='<td align="center" colspan="2"><img src="https://vsm.edu.in/student/logo.png" alt="VSM GROUP OF INSTITUTIONS" height="50px">

                                </td>';
					 
							}
						 

                           $receiptHTML.='</tr><tr>
                                <td  align="center" colspan="2">';
                               $receiptHTML.=  ucwords(substr($feebatch,10)) ." Receipt";  
                               $receiptHTML.= $copy;  
                          $receiptHTML.= '</td>
                           </tr>
                            <tr>'; 
                          
                           $receiptHTML.='<td>Date:'. date("d-m-Y", strtotime($receiptdate)).'</td>
                                <td align="right">RollNo: '. $rollno.'</td>
                            </tr>';
                            $receiptHTML.='<tr >
                                <td colspan="2">
                                    <table width="100%" style="padding-left:20px" border=0>
                                        <tr>
                                            <td>Name:'. $studentname.' </td>

                                            <td>Phone No.:'. $phone.'</td>
                                        </tr>
                                        <tr>
                                         <td>Course:'.$course." ".$branch.'</td>
                                          <td>Batch:'. $batch.',Ac.Year:'. $ye.'</td>
                                        </tr>
                                       
                                    </table>
                                </td>

                            </tr>';
                             
                            $receiptHTML.='<tr><td colspan="2">
                                    <table border="1"  width="100%" >
                                        <tr class="td_data">
                                           <th>ReceiptNo.</th>
                                            <th>Date</th>
                                            <th>FeeBatch</th>
                                            <th>PayMode</th>
                                            <th>Memo</th>
                                            <th>Amount</th>
                                        </tr>';
                            $receiptHTML.='<tr class="td_data"> 
                                           <td>'.  $rcptnumber.'</td>
                                            <td>'. date("d-m-Y", strtotime($receiptdate)).'</td>
                                            <td>'.substr($feebatch,10).'</td>
                                            <td>'. $mode.'</td>
                                            <td>'. $rem.'</td>
                                            <td>'. $paidamt.".00".'</td>
                                        </tr>
                                    </table>
                             In Words: '. $func_handler->rtw($paidamt);    
						 
                             $receiptHTML.='</td></tr><tr>';
                             $receiptHTML.='<td colspan="2">
                                    <table   width="100%">
                                	<tr>
									        <td><span style="font-size:8px;">This is computer generated receipt, no signature is required</span></td>
                                            <td align="right"></td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                        </table>';
        $receiptHTML.='</td></tr></table></div></div></div>';
	echo $receiptHTML;
   
    
    $mail = new PHPMailer(true);
    try {
    $mail->isSMTP();
    $mail->Host       = 'sg2nlvphout-v01.shr.prod.sin2.secureserver.net';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth   = true;
    $mail->Username   = 'vsmerpsupport@vsm.edu.in';
    $mail->Password   = 'Techsupport321!'; 
    $mail->Port = 465; 
    $mail->SMTPDebug = 0;
    $mail->setFrom('vsmerpsupport@vsm.edu.in', 'VSMERP');
    $mail->addAddress($email, $studentname);
    $mail->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,]
     ];
    $mail->isHTML(true);
    $mail->Subject = "Fee Receipt";
    $mail->Body ="Dear ".$studentname.", Please find the below  fee receipt.<br>".$receiptHTML;
    //$mail->addStringAttachment($pdfContent, 'FeeReceipt.pdf', 'base64', 'application/pdf');
    //$mail->addStringAttachment($pdfContent, $filename, 'base64', 'application/pdf');
    $mail->send();
     $msg= 'Email sent successfully';
    } catch (Exception $e) {
    $msg= 'Error sending email: ' . $mail->ErrorInfo;
    }   
     
        
   } 
   } catch (Exception $e) {
    $func_handler->db->rollbackTrans();
      echo "Error:";
   } 
   finally
     {
        $func_handler->db->closeConnection();
     }
    
  //End
	 
   
 ?>
 
    
  <?php include("../../includes/footer.php"); ?>
 <?php include("../../includes/footerjs.php"); ?>
</body>
</html>
<?php
 
//echo "<script>window.location.href='collectfee.php';</script>";
?>