<?php 
include("../../includes/head.php");
$_SESSION['page']="modules/fees/collectfee.php"; 
$action = "addsection";
$errormsg="";
$stucount=0;
$d=date('Y-m-d-H:i:s');
$d1=date('Y-m-d');
$rcptdate = date("d-m-Y", strtotime($d)); 
$y=date("Y");
$m=date("m");
if($m<=6)
$acyear=($y-1) ."-".$y;
else
$acyear=($y) ."-".($y+1);
?>
<!DOCTYPE html>
<html lang="en">
<script src="js/jquery.min.js"></script> 
<script type="text/javascript">
function SamesetFormAction(action) {
		var p=document.getElementById('programs').value;
		if(p=="")
		alert("Please select program");
	else{
		document.getElementById('frmchangeprogram').target = '_self';
      	document.getElementById('frmchangeprogram').action = action;
      	document.getElementById('frmchangeprogram').submit(); 
    	}
}

</script>

  
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
<div class="wrapper">
    <?php include("../../includes/sidebar.php"); ?>
	<div class="main">
	     <?php include("../../includes/menubar.php"); ?>
         <main class="content">
         <div class="container-fluid p-0">
         <a class="btn btn-danger float-end mt-n1" href="/oceanerp/home.php"   class="btn btn-danger btn-sm pull-right"> Close </a>   			
                 
          <div class="mb-3">
						<h1 class="h3 d-inline align-middle">FEE COLLECTION</h1> 
		 </div>
                 
    	<?php
		echo $errormsg;
		 
		?>

<div class="row" style="margin-bottom:5px;">
   <div class="col-md-5">
   <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  name="searchform" class="form-inline" role="form" >
 	 <input type="text" name="rollnoname" id="Search"   class="form-control" placeholder="Type RollNo/StudentName" required  >
   </div>
   <div class="col-md-2">   
   <button type="submit" class="btn btn-primary" id="find" name="Search"> Find<i class="fa fa-search"></i> </button>
  </div> 
 </form>    
</div>
<?php if(isset($_POST['Search']))
{
$name=$_POST['rollnoname'];
$students=$wpr_handler->getAllColumnsDataWithLike("tblstudents", "studentname", $name);

$stucount = count($students);
$sno=1;
if($stucount>0){
    ?>
    <div class="row" style="margin-bottom:5px;">
    <div class="col-md-12">
    <form name="namesearch" class="form-inline" role="form"  method="GET" action="">
    <div class="table-sorting table-responsive"> 
      <table id="example1" class="table table-bordered">
            <thead>
		   <tr>
                <th>S.No</th>
               
                <th>Course</th>
				 <th>Branch</th>
				 <th>Batch</th>
				 <th>RollNo</th>
				  <th>Name</th>
                 
                <th>Action</th>
            </tr>
			 </thead>
           <tbody>
            <?php
            for($i=0;$i<count($students) ;$i++)
            {
                ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
					 <td><?php echo $students[$i]['course']; ?></td>
					 <td><?php echo $students[$i]['branch']; ?></td>
					 <td><?php echo $students[$i]['batch']; ?></td>
					 <td><?php echo $students[$i]['rollno']; ?></td>
                    <td><?php echo $students[$i]['studentname']; ?></td>
                    

                    <td><a href="collectfee.php?rollnoname=<?php echo $students[$i]['rollno']; ?>"  ><button type="button" class="btn btn-success btn-sm" id="find" name="search"> <i class="fa fa-search"></i> </button></a></td>

                </tr>
            <?php } ?>
          </tbody>
        </table>
        </div>
    </form>
  </div>
  </div>
<?php }
 
}
?>

<?php if($stucount ==0 and (isset($_POST['Search']) or   isset($_GET['rollnoname'])))
{    
    $rollno=$_REQUEST['rollnoname'];  
	$criteria=" rollno='".$rollno."'  and delete_status='0' ";
    $orderbycols=" rollno ";
    $studata=$wpr_handler->getSpecificColumnsDataWithCriteria("tblstudents", " * " ,$criteria ,$orderbycols);
    $sno=1;
   if( count($studata)>0)
   {
    ?>
  	<div class="row">
     
    <div class="table-sorting table-responsive"> 
    <table class="table" border="2" class="table table-striped table-bordered table-hover" >
        <tr> 
            <td  colspan=4 ><?php echo $studata[0]['rollno']; ?></td>
            <td colspan=3  ><?php echo $studata[0]['studentname']; ?> <?php echo $studata[0]['course']." ".$studata[0]['branch']; ?> Status:<?php echo $studata[0]['status']." "; ?> Remarks:<?php echo $studata[0]['remarks']; ?><br></td>
			<td colspan=3  > <span style="color:white;"> Caste:<?php echo $studata[0]['caste']; ?> Seat type:<?php echo $studata[0]['seattype']; ?> Phone:<?php echo $studata[0]['phone']; ?></span></td>
         
            <input type="hidden" id="rollno" name="rollno" value="<?php echo $rollno; ?>">
			 
			<input type="hidden" id="sname"  name="sname" value="<?php echo $studata[0]['studentname']; ?>"> 
        </tr>
    </table>
   </div>
   <div class="row">
        <div class="col-12 col-lg-12">
        <div class="tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" href="#primary-tab-1" data-bs-toggle="tab" role="tab">TUITIONFEE</a></li>
                <li class="nav-item"><a class="nav-link" href="#primary-tab-2" data-bs-toggle="tab" role="tab">EXAMFEE</a></li>
                <li class="nav-item"><a class="nav-link" href="#primary-tab-3" data-bs-toggle="tab" role="tab">OTHERFEE</a></li>
            </ul>
	<div class="tab-content">
	<div class="tab-pane active" id="primary-tab-1" role="tabpanel">
    <div class="table-sorting table-responsive"> 								 
     
        <?php
        $totalpending=0; 
		$rollno=$studata[0]['rollno'] ;
		$feemaster = $wpr_handler->getMultiRowDataWithSQL("select * from tblfeemaster where rollno='".$studata[0]['rollno']."' and  substring(feebatch,1,9)<='".$acyear."' and feebatch in (select feebatch from tblfeebatch where (feetype='TUITIONFEE' or  feetype='DEG_FEE')) and status='notpaid' order by  feebatch  ");
        $fmcount = count($feemaster);
		$feebatch="";
		$refno="";$refdate=""; $rmode="";$qrtno="";
        if( $fmcount >0){?>
            <table class="table" border="2" class="table table-striped table-bordered table-hover" >
                <thead>    
                <tr >
                    <th>S.No</th>
                    <th>FeeBatchName</th>
                    <th>TotalFee</th>
                    <th>Concession</th>
                    <th>Paid</th>
                    <th>FeeDue</th>   
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </thead> 
            <?php    
        for($fm=0;$fm<$fmcount;$fm++) 
        { 
            $rollno=$feemaster[$fm]['rollno'];
            $remarks=$feemaster[$fm]['remarks'];
                    
            $fbfine=0; 
            $colnames=" paytype,feetype "; 
            $orderbycols=" paytype,feetype ";
            $criteria=" feebatch='".$feemaster[$fm]['feebatch']."'   ";
            $paytypepaid=$wpr_handler->getSpecificColumnsDataWithCriteria("tblfeebatch",$colnames,$criteria ,$orderbycols);

            
            $colnames=" * "; 
            $orderbycols=" rollno ";
            $criteria=" rollno = '$rollno' and onfeebatch='".$feemaster[$fm]["feebatch"]."'  and status=0   ";
            $finedata=$wpr_handler->getSpecificColumnsDataWithCriteria("tblfinecron",$colnames,$criteria ,$orderbycols);
        
             ?>
            <tbody>
			
                
					<?php 
						 
                        
                        $criteria = " rollno = '$rollno' and feebatch='".$feemaster[$fm]['feebatch']."'"  ;                                        
                        $studenttfee=$wpr_handler->getSumWithCriterias("tblfeemaster", "amount", $criteria);
					    if(count($studenttfee)>0)
                        {
                         $tdueamount= $studenttfee['sum(amount)'];
						}
                         
                        
						$criteria = " rollno = '$rollno' and feebatch='".$feemaster[$fm]['feebatch']."'";                                        
                        $totalamountpaid=$wpr_handler->getSumWithCriterias("tblfeereceipt", "amount", $criteria);
					    if(count($totalamountpaid)>0)
                        $totalpaid=$totalamountpaid['sum(amount)'];
						
						 
					 	$criteria = " rollno = '$rollno' and feebatch='".$feemaster[$fm]['feebatch']."'";                                        
                        $discountgiven=$wpr_handler->getSumWithCriterias("tbldiscount", "discount", $criteria);
                         if(count($discountgiven)>0)
						{
						$tdisamount= $discountgiven['sum(discount)'];
						
						}
					    $tduesamount = $tdueamount- $totalpaid- $tdisamount ;
					  
                        
                        $colnames=" feebatch,amount "; 
                        $orderbycols=" feebatch ";
                        $criteria=" rollno = '$rollno' and feebatch='".$feemaster[$fm]["feebatch"]."'  ";
                        $studentfee=$wpr_handler->getSpecificColumnsDataWithCriteria("tblfeemaster",$colnames,$criteria ,$orderbycols);
                        if(count($studentfee)>0)
                        {
                        $feebatch=$studentfee[0]['feebatch'];
                        $dueamount=$studentfee[0]['amount'];
                        }
                       
						$duesamount = $dueamount- $totalpaid;
						 $colnames=" * "; 
                         $orderbycols=" feebatch ";
                         $criteria=" rollno = '$rollno' and feebatch='".$feemaster[$fm]["feebatch"]."' ";
                         $onediscount=$wpr_handler->getSpecificColumnsDataWithCriteria("tbldiscount",$colnames,$criteria ,$orderbycols);
                        

						$disval=0;
						$status=-1;
						$disamount=0;
						if(count($onediscount) > 0)
						{

						for ($row=0; $row<count($onediscount);$row++)
						{
						$disamount= $onediscount[$row]['discount'];
						$status=$onediscount[$row]['status'];
						}
						}
					if($status==0)
					{
					$pendingamount=$dueamount- $totalpaid-$disamount;
					$disval=$disamount;
					$dueamount= $dueamount- $totalpaid-$disamount  ;
					}
					else
					{
						$pendingamount=$dueamount- $totalpaid-$disamount;
						$disval=$disamount;
						$dueamount= $dueamount- $totalpaid -$disamount;
					}
					    $totalpending +=  $pendingamount;  
						$pamtname='p'.$feemaster[$fm]['feebatch'];
						$rcptno='r'.$feemaster[$fm]['feebatch'];
						$stunameid='s'.$feemaster[$fm]['feebatch'];
						
						 
						$batchid='b'.$rollno;
						
						$pamtid='m'.$feemaster[$fm]['feebatch'];
						$chkid='c'.$feemaster[$fm]['feebatch'];
						 
						$payid='y'.$feemaster[$fm]['feebatch'];
                        $fval=$dueamount;
					$adm=0;
			     
                 if($pendingamount!=0)
                 {
                 ?> 
			    <tr>
		         <td><?php echo $sno++; ?></td>
                 <td id=a   ><?php echo $feemaster[$fm]['feebatch']; ?><br>
                  <?php if($fbfine!=0) 
                      echo "<span style='color:red;'>Fine Rs.". $finedata[0]['fine'] ." is scheduled on ".date('d-m-Y',strtotime($finedata[0]['finedate']))." </span>"; ?> 
                </td>
                <td>
				<div style='width: 30px;'  ><?php echo $tdueamount;?>	
				</div></td>
				<td   ><strong><?php echo $disval; ?></strong></td>
				<td  ><strong><?php echo $totalpaid; ?></strong></td>	
				<td > <input  readonly class="form-control" min="0" size="8"    type="text" name=<?php echo $pamtname;?> id=<?php echo $pamtname;?> value=<?php echo $pendingamount;?>  readonly> </td>
				 
                <td >
				 
               <?php  
                 
               if($paytypepaid[0]['paytype']!="onetime") {?>  
                    <input type="number" name=<?php echo $feebatch;?> id=<?php echo $feebatch;?> onkeyup=testamount(this) size=8   class="form-control"        value= <?php echo $fval  ;?>>
                 <?php } 
                 else
                 {?>
                  <input type="number" name=<?php echo $feebatch;?> id=<?php echo $feebatch;?> onkeyup=testamount(this) size=8  readonly  class="form-control"        value= <?php echo $fval  ;?>     >
                 
                  <?php 
                  } 
                  ?>   
                  </td>
 
                     <input type="hidden" id=<?php echo $stunameid;?>  name=<?php echo $stunameid;?> value="<?php echo $stname; ?>"> 
                    <input type="hidden" name=feebatchs[] id=<?php echo $batchid; ?> value=<?php echo $feebatch; ?>     > 
                    <input type="hidden" name=pendamt[] id=<?php echo $pamtid; ?> value=<?php echo $pendingamount  ;?>  > 
			        <input type="hidden" name=payamt[] id=<?php echo $payid;?> value=0 >
                <td >

               <?php
            if($pendingamount!=0)  {

              $sessid=session_id();
                $ye= substr($feemaster[$fm]['feebatch'],0,9);  
	           	$row=  ['id' => $sno,'rollno' =>$studata[0]['rollno'],'feebatch' => $feemaster[$fm]["feebatch"], 'balamt' =>$pendingamount,'studentname' => $studata[0]['studentname'], 'program' =>$studata[0]['program'],'batch' => $studata[0]['batch'],'course' =>$studata[0]['course'], 'branch' =>$studata[0]['branch'], 'phone' =>$studata[0]['phone'], 'email' =>$studata[0]['email'], 'sessid' =>$sessid, 'ye' =>$ye] ; 
                
               echo "	<button class='btn btn-primary' type='button' onclick='openCashModal(" . json_encode($row) . ",$sno)'>PayCash</button>";} ?> 
               
               </td>

               </tr>
              <?php  
             }
            }
           if($fmcount==0)
           {
                
                $criteria = " rollno = '$rollno'";                                        
                $totalamountpaidall=$wpr_handler->getSumWithCriterias("tblfeereceipt", "amount", $criteria);
                if(count($totalamountpaidall)>0)
                $totalpaidall=$totalamountpaidall['sum(amount)'];
                if($totalpaidall!=0)
                {
                     echo "<center><h1> Contact VSMERP :  </h1></center>";
                }
           }     
		    ?>
       </tbody>
     </table>
     <?php }
     else {?>
    <table class="table" border="2" class="table table-striped table-bordered table-hover" >
            <thead>    
            <tr >
             <td colspan=8 align="center"> NO EXAM FEE DUE</td>
            </tr>   
            </thead>
     </table>
     <?php 
     }
     ?>
    </div>
   </div>
    <div class="tab-pane" id="primary-tab-2" role="tabpanel">
    <div class="table-sorting table-responsive"> 								 
    
    <?php
        $totalpending=0; 
		$rollno=$studata[0]['rollno'] ;
		$feemaster = $wpr_handler->getMultiRowDataWithSQL("select * from tblfeemaster where rollno='".$studata[0]['rollno']."' and  substring(feebatch,1,9)<='".$acyear."' and feebatch in (select feebatch from tblfeebatch where (feetype='EXAMFEE' )) and status='notpaid' order by  feebatch  ");
        $fmcount = count($feemaster);
		$feebatch="";
		$refno="";$refdate=""; $rmode="";$qrtno="";
        if( $fmcount >0){?>
            <table class="table" border="2" class="table table-striped table-bordered table-hover" >
                <thead>    
                <tr >
                    <th>S.No</th>
                    <th>FeeBatchName</th>
                    <th>TotalFee</th>
                    <th>Concession</th>
                    <th>Paid</th>
                    <th>FeeDue</th>   
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </thead> 
            <?php    
        for($fm=0;$fm<$fmcount;$fm++) 
        { 
            $rollno=$feemaster[$fm]['rollno'];
            $remarks=$feemaster[$fm]['remarks'];
                    
            $fbfine=0; 
            $colnames=" paytype,feetype "; 
            $orderbycols=" paytype,feetype ";
            $criteria=" feebatch='".$feemaster[$fm]['feebatch']."'   ";
            $paytypepaid=$wpr_handler->getSpecificColumnsDataWithCriteria("tblfeebatch",$colnames,$criteria ,$orderbycols);

            
            $colnames=" * "; 
            $orderbycols=" rollno ";
            $criteria=" rollno = '$rollno' and onfeebatch='".$feemaster[$fm]["feebatch"]."'  and status=0   ";
            $finedata=$wpr_handler->getSpecificColumnsDataWithCriteria("tblfinecron",$colnames,$criteria ,$orderbycols);
        
             ?>
            <tbody>
			
                
					<?php 
						 
                        
                        $criteria = " rollno = '$rollno' and feebatch='".$feemaster[$fm]['feebatch']."'"  ;                                        
                        $studenttfee=$wpr_handler->getSumWithCriterias("tblfeemaster", "amount", $criteria);
					    if(count($studenttfee)>0)
                        {
                         $tdueamount= $studenttfee['sum(amount)'];
						}
                         
                        
						$criteria = " rollno = '$rollno' and feebatch='".$feemaster[$fm]['feebatch']."'";                                        
                        $totalamountpaid=$wpr_handler->getSumWithCriterias("tblfeereceipt", "amount", $criteria);
					    if(count($totalamountpaid)>0)
                        $totalpaid=$totalamountpaid['sum(amount)'];
						
						 
					 	$criteria = " rollno = '$rollno' and feebatch='".$feemaster[$fm]['feebatch']."'";                                        
                        $discountgiven=$wpr_handler->getSumWithCriterias("tbldiscount", "discount", $criteria);
                         if(count($discountgiven)>0)
						{
						$tdisamount= $discountgiven['sum(discount)'];
						
						}
					    $tduesamount = $tdueamount- $totalpaid- $tdisamount ;
					  
                        
                        $colnames=" feebatch,amount "; 
                        $orderbycols=" feebatch ";
                        $criteria=" rollno = '$rollno' and feebatch='".$feemaster[$fm]["feebatch"]."'    ";
                        $studentfee=$wpr_handler->getSpecificColumnsDataWithCriteria("tblfeemaster",$colnames,$criteria ,$orderbycols);
                        if(count($studentfee)>0)
                        {
                        $feebatch=$studentfee[0]['feebatch'];
                        $dueamount=$studentfee[0]['amount'];
                        }
                       
						$duesamount = $dueamount- $totalpaid;
						 $colnames=" * "; 
                         $orderbycols=" feebatch ";
                         $criteria=" rollno = '$rollno' and feebatch='".$feemaster[$fm]["feebatch"]."' ";
                         $onediscount=$wpr_handler->getSpecificColumnsDataWithCriteria("tbldiscount",$colnames,$criteria ,$orderbycols);
                        

						$disval=0;
						$status=-1;
						$disamount=0;
						if(count($onediscount) > 0)
						{

						for ($row=0; $row<count($onediscount);$row++)
						{
						$disamount= $onediscount[$row]['discount'];
						$status=$onediscount[$row]['status'];
						}
						}
					if($status==0)
					{
					$pendingamount=$dueamount- $totalpaid-$disamount;
					$disval=$disamount;
					$dueamount= $dueamount- $totalpaid-$disamount  ;
					}
					else
					{
						$pendingamount=$dueamount- $totalpaid-$disamount;
						$disval=$disamount;
						$dueamount= $dueamount- $totalpaid -$disamount;
					}
					    $totalpending +=  $pendingamount;  
						$pamtname='p'.$feemaster[$fm]['feebatch'];
						$rcptno='r'.$feemaster[$fm]['feebatch'];
						$stunameid='s'.$feemaster[$fm]['feebatch'];
						
						 
						$batchid='b'.$rollno;
						
						$pamtid='m'.$feemaster[$fm]['feebatch'];
						$chkid='c'.$feemaster[$fm]['feebatch'];
						 
						$payid='y'.$feemaster[$fm]['feebatch'];
                        $fval=$dueamount;
					$adm=0;
			     
                 if($pendingamount!=0)
                 {
                 ?> 
			    <tr>
		         <td><?php echo $sno++; ?></td>
                 <td id=a   ><?php echo $feemaster[$fm]['feebatch']; ?><br>
                  <?php if($fbfine!=0) 
                      echo "<span style='color:red;'>Fine Rs.". $finedata[0]['fine'] ." is scheduled on ".date('d-m-Y',strtotime($finedata[0]['finedate']))." </span>"; ?> 
                </td>
                <td>
				<div style='width: 30px;'  ><?php echo $tdueamount;?>	
				</div></td>
				<td   ><strong><?php echo $disval; ?></strong></td>
				<td  ><strong><?php echo $totalpaid; ?></strong></td>	
				<td > <input  readonly class="form-control" min="0" size="8"    type="text" name=<?php echo $pamtname;?> id=<?php echo $pamtname;?> value=<?php echo $pendingamount;?>  readonly> </td>
				 
                <td >
				 
               <?php  
                 
               if($paytypepaid[0]['paytype']!="onetime") {?>  
                    <input type="number" name=<?php echo $feebatch;?> id=<?php echo $feebatch;?> onkeyup=testamount(this) size=8   class="form-control"        value= <?php echo $fval  ;?>>
                 <?php } 
                 else
                 {?>
                  <input type="number" name=<?php echo $feebatch;?> id=<?php echo $feebatch;?> onkeyup=testamount(this) size=8  readonly  class="form-control"        value= <?php echo $fval  ;?>     >
                 
                  <?php 
                  } 
                  ?>   
                  </td>
 
                     <input type="hidden" id=<?php echo $stunameid;?>  name=<?php echo $stunameid;?> value="<?php echo $stname; ?>"> 
                    <input type="hidden" name=feebatchs[] id=<?php echo $batchid; ?> value=<?php echo $feebatch; ?>     > 
                    <input type="hidden" name=pendamt[] id=<?php echo $pamtid; ?> value=<?php echo $pendingamount  ;?>  > 
			        <input type="hidden" name=payamt[] id=<?php echo $payid;?> value=0 >
                <td >

               <?php
            if($pendingamount!=0)  {

              $sessid=session_id();
                $ye= substr($feemaster[$fm]['feebatch'],0,9);  
	           	$row=  ['id' => $sno,'rollno' =>$studata[0]['rollno'],'feebatch' => $feemaster[$fm]["feebatch"], 'balamt' =>$pendingamount,'studentname' => $studata[0]['studentname'], 'program' =>$studata[0]['program'],'batch' => $studata[0]['batch'],'course' =>$studata[0]['course'], 'branch' =>$studata[0]['branch'], 'phone' =>$studata[0]['phone'], 'email' =>$studata[0]['email'], 'sessid' =>$sessid, 'ye' =>$ye] ; 
                
               echo "	<button class='btn btn-primary' type='button' onclick='openCashModal(" . json_encode($row) . ",$sno)'>PayCash</button>";} ?> 
               
               </td>

               </tr>
              <?php  
             }
            }
           if($fmcount==0)
           {
                
                $criteria = " rollno = '$rollno'";                                        
                $totalamountpaidall=$wpr_handler->getSumWithCriterias("tblfeereceipt", "amount", $criteria);
                if(count($totalamountpaidall)>0)
                $totalpaidall=$totalamountpaidall['sum(amount)'];
                if($totalpaidall!=0)
                {
                     echo "<center><h1> Contact VSMERP :  </h1></center>";
                }
           }     
		    ?>
       </tbody>
     </table>
     <?php }
     else {?>
    <table class="table" border="2" class="table table-striped table-bordered table-hover" >
            <thead>    
            <tr >
             <td colspan=8 align="center"> NO EXAM FEE DUE</td>
            </tr>   
            </thead>
     </table>
     <?php 
     }
     ?>
     </div>      
    </div>
    <div class="tab-pane" id="primary-tab-3" role="tabpanel">
    <div class="table-sorting table-responsive"> 								 
     
    <?php
        $totalpending=0; 
		$rollno=$studata[0]['rollno'] ;
		$feemaster = $wpr_handler->getMultiRowDataWithSQL("select * from tblfeemaster where rollno='".$studata[0]['rollno']."' and  substring(feebatch,1,9)<='".$acyear."' and feebatch in (select feebatch from tblfeebatch where (feetype!='TUITIONFEE' and  feetype!='DEG_FEE' and  feetype!='EXAMFEE')) and status='notpaid' order by  feebatch  ");
        $fmcount = count($feemaster);
		$feebatch="";
		$refno="";$refdate=""; $rmode="";$qrtno="";
        if( $fmcount >0){?>
            <table class="table" border="2" class="table table-striped table-bordered table-hover" >
                <thead>    
                <tr >
                    <th>S.No</th>
                    <th>FeeBatchName</th>
                    <th>TotalFee</th>
                    <th>Concession</th>
                    <th>Paid</th>
                    <th>FeeDue</th>   
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </thead> 
            <?php    
        for($fm=0;$fm<$fmcount;$fm++) 
        { 
            $rollno=$feemaster[$fm]['rollno'];
            $remarks=$feemaster[$fm]['remarks'];
                    
            $fbfine=0; 
            $colnames=" paytype,feetype "; 
            $orderbycols=" paytype,feetype ";
            $criteria=" feebatch='".$feemaster[$fm]['feebatch']."'   ";
            $paytypepaid=$wpr_handler->getSpecificColumnsDataWithCriteria("tblfeebatch",$colnames,$criteria ,$orderbycols);

            
            $colnames=" * "; 
            $orderbycols=" rollno ";
            $criteria=" rollno = '$rollno' and onfeebatch='".$feemaster[$fm]["feebatch"]."'  and status=0   ";
            $finedata=$wpr_handler->getSpecificColumnsDataWithCriteria("tblfinecron",$colnames,$criteria ,$orderbycols);
        
             ?>
            <tbody>
			
                
					<?php 
						 
                        
                        $criteria = " rollno = '$rollno' and feebatch='".$feemaster[$fm]['feebatch']."'"  ;                                        
                        $studenttfee=$wpr_handler->getSumWithCriterias("tblfeemaster", "amount", $criteria);
					    if(count($studenttfee)>0)
                        {
                         $tdueamount= $studenttfee['sum(amount)'];
						}
                         
                        
						$criteria = " rollno = '$rollno' and feebatch='".$feemaster[$fm]['feebatch']."'";                                        
                        $totalamountpaid=$wpr_handler->getSumWithCriterias("tblfeereceipt", "amount", $criteria);
					    if(count($totalamountpaid)>0)
                        $totalpaid=$totalamountpaid['sum(amount)'];
						
						 
					 	$criteria = " rollno = '$rollno' and feebatch='".$feemaster[$fm]['feebatch']."'";                                        
                        $discountgiven=$wpr_handler->getSumWithCriterias("tbldiscount", "discount", $criteria);
                         if(count($discountgiven)>0)
						{
						$tdisamount= $discountgiven['sum(discount)'];
						
						}
					    $tduesamount = $tdueamount- $totalpaid- $tdisamount ;
					  
                        
                        $colnames=" feebatch,amount "; 
                        $orderbycols=" feebatch ";
                        $criteria=" rollno = '$rollno' and feebatch='".$feemaster[$fm]["feebatch"]."'    ";
                        $studentfee=$wpr_handler->getSpecificColumnsDataWithCriteria("tblfeemaster",$colnames,$criteria ,$orderbycols);
                        if(count($studentfee)>0)
                        {
                        $feebatch=$studentfee[0]['feebatch'];
                        $dueamount=$studentfee[0]['amount'];
                        }
                       
						$duesamount = $dueamount- $totalpaid;
						 $colnames=" * "; 
                         $orderbycols=" feebatch ";
                         $criteria=" rollno = '$rollno' and feebatch='".$feemaster[$fm]["feebatch"]."' ";
                         $onediscount=$wpr_handler->getSpecificColumnsDataWithCriteria("tbldiscount",$colnames,$criteria ,$orderbycols);
                        

						$disval=0;
						$status=-1;
						$disamount=0;
						if(count($onediscount) > 0)
						{

						for ($row=0; $row<count($onediscount);$row++)
						{
						$disamount= $onediscount[$row]['discount'];
						$status=$onediscount[$row]['status'];
						}
						}
					if($status==0)
					{
					$pendingamount=$dueamount- $totalpaid-$disamount;
					$disval=$disamount;
					$dueamount= $dueamount- $totalpaid-$disamount  ;
					}
					else
					{
						$pendingamount=$dueamount- $totalpaid-$disamount;
						$disval=$disamount;
						$dueamount= $dueamount- $totalpaid -$disamount;
					}
					    $totalpending +=  $pendingamount;  
						$pamtname='p'.$feemaster[$fm]['feebatch'];
						$rcptno='r'.$feemaster[$fm]['feebatch'];
						$stunameid='s'.$feemaster[$fm]['feebatch'];
						
						 
						$batchid='b'.$rollno;
						
						$pamtid='m'.$feemaster[$fm]['feebatch'];
						$chkid='c'.$feemaster[$fm]['feebatch'];
						 
						$payid='y'.$feemaster[$fm]['feebatch'];
                        $fval=$dueamount;
					$adm=0;
			     
                 if($pendingamount!=0)
                 {
                 ?> 
			    <tr>
		         <td><?php echo $sno++; ?></td>
                 <td id=a   ><?php echo $feemaster[$fm]['feebatch']; ?><br>
                  <?php if($fbfine!=0) 
                      echo "<span style='color:red;'>Fine Rs.". $finedata[0]['fine'] ." is scheduled on ".date('d-m-Y',strtotime($finedata[0]['finedate']))." </span>"; ?> 
                </td>
                <td>
				<div style='width: 30px;'  ><?php echo $tdueamount;?>	
				</div></td>
				<td   ><strong><?php echo $disval; ?></strong></td>
				<td  ><strong><?php echo $totalpaid; ?></strong></td>	
				<td > <input  readonly class="form-control" min="0" size="8"    type="text" name=<?php echo $pamtname;?> id=<?php echo $pamtname;?> value=<?php echo $pendingamount;?>  readonly> </td>
				 
                <td >
				 
               <?php  
                 
               if($paytypepaid[0]['paytype']!="onetime") {?>  
                    <input type="number" name=<?php echo $feebatch;?> id=<?php echo $feebatch;?> onkeyup=testamount(this) size=8   class="form-control"        value= <?php echo $fval  ;?>>
                 <?php } 
                 else
                 {?>
                  <input type="number" name=<?php echo $feebatch;?> id=<?php echo $feebatch;?> onkeyup=testamount(this) size=8  readonly  class="form-control"        value= <?php echo $fval  ;?>     >
                 
                  <?php 
                  } 
                  ?>   
                  </td>
 
                     <input type="hidden" id=<?php echo $stunameid;?>  name=<?php echo $stunameid;?> value="<?php echo $stname; ?>"> 
                    <input type="hidden" name=feebatchs[] id=<?php echo $batchid; ?> value=<?php echo $feebatch; ?>     > 
                    <input type="hidden" name=pendamt[] id=<?php echo $pamtid; ?> value=<?php echo $pendingamount  ;?>  > 
			        <input type="hidden" name=payamt[] id=<?php echo $payid;?> value=0 >
                <td >

               <?php
            if($pendingamount!=0)  {

              $sessid=session_id();
                $ye= substr($feemaster[$fm]['feebatch'],0,9);  
	           	$row=  ['id' => $sno,'rollno' =>$studata[0]['rollno'],'feebatch' => $feemaster[$fm]["feebatch"], 'balamt' =>$pendingamount,'studentname' => $studata[0]['studentname'], 'program' =>$studata[0]['program'],'batch' => $studata[0]['batch'],'course' =>$studata[0]['course'], 'branch' =>$studata[0]['branch'], 'phone' =>$studata[0]['phone'], 'email' =>$studata[0]['email'], 'sessid' =>$sessid, 'ye' =>$ye] ; 
                
               echo "	<button class='btn btn-primary' type='button' onclick='openCashModal(" . json_encode($row) . ",$sno)'>PayCash</button>";} ?> 
               
               </td>

               </tr>
              <?php  
             }
            }
           if($fmcount==0)
           {
                
                $criteria = " rollno = '$rollno'";                                        
                $totalamountpaidall=$wpr_handler->getSumWithCriterias("tblfeereceipt", "amount", $criteria);
                if(count($totalamountpaidall)>0)
                $totalpaidall=$totalamountpaidall['sum(amount)'];
                if($totalpaidall!=0)
                {
                     echo "<center><h1> Contact VSMERP :  </h1></center>";
                }
           }     
		    ?>
       </tbody>
     </table>
     <?php }
     else {?>
    <table class="table" border="2" class="table table-striped table-bordered table-hover" >
            <thead>    
            <tr >
             <td colspan=8 align="center"> NO EXAM FEE DUE</td>
            </tr>   
            </thead>
     </table>
     <?php 
     }
     ?>
     </div>      
    </div>
            </div>
        </div>
    </div>
        </div>
   </div>
   
    </form>

 
<?php }
}
?>
</div>
</div>

</div>
 
  
<!-- start Modal  -->

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <form action="cashreceipt.php" method="post"  >   
        <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="paymentModalLabel">Payment Details(ఫీజు కట్టిన తర్వాత,రశీదు(Receipt) వచ్చేవరకు wait చేయవలెను.)</h4>
        <button type="button" class="close modal-close-btn" data-bs-dismiss="modal">&times;</button>
      
        </div>
        <div class="modal-body" >
          <span style="font-size:15px;" id="paymentModalBody"></span> 
          <input type="hidden" class="form-control" id="feedue" name="feedue">
          <input type="hidden" class="form-control" id="mrollno" name="mrollno">
          <input type="hidden" class="form-control" id="feebatch" name="feebatch">
          <input type="hidden" class="form-control" id="studentname" name="studentname">
          <input type="hidden" class="form-control" id="email" name="email">
          <input type="hidden" class="form-control" id="phone" name="phone">
          <input type="hidden" class="form-control" id="branch" name="branch">
          <input type="hidden" class="form-control" id="program" name="program">
          <input type="hidden" class="form-control" id="course" name="course">
          <input type="hidden" class="form-control" id="feedue" name="feedue">
          <input type="hidden" class="form-control" id="balamt" name="balamt">
          <input type="hidden" class="form-control" id="batch" name="batch">
          <input type="hidden" class="form-control" id="ye" name="ye">
         <input type="hidden" name="EncryptTrans" id="EncryptTrans" />
         <input type="hidden" name="merchIdVal" id="merchIdVal" /> 
          <div class="mb-3">
            <label for="paidamt" class="form-label">Payment Amount:</label>
            <input type="number" class="form-control" id="paidamt" name="paidamt" style="height:40px;width:150px;font-size:18px;color:red;font-weight:bold;">
          </div>
          <div class="mb-3">
            <label for="remarks" class="form-label">Remarks</label>
            <input type="text" class="form-control" id="remarks" name="remarks"  style="width:400px;fontsize:14px;">
          </div>
        </div>
        <div class="modal-footer">
            <label for="termsCheckbox">
             <input type="checkbox" id="termsCheckbox" name="terms"  required>
            I accept the terms and conditions
         </label> 
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Confirm Payment</button>
        </div>
      </div>
      </form>
    </div>
  </div>

<script>
document.getElementById('paidamt').addEventListener('keyup', function() {
  var paidamt = parseFloat(this.value);
  var feedue=document.getElementById('feedue').value;
   if (paidamt<0) {
    alert('Please enter a valid amount.');
     this.value="";
    this.focus(); 
    
  } else  if(paidamt>feedue){
        alert('Please enter a valid amount.');
        this.value="";
        this.focus();
  }
});
  
function openCashModal(rowData,sno) {
    
    var pblamt = $('#p' + rowData.feebatch).val();  
    
    var modalContent = `<p>StudentName: ${rowData.studentname}</p>
    <p>RollNo: ${rowData.rollno}</p>
    <p>Year: ${rowData.ye}</p>
        <p>Feebatch: ${rowData.feebatch.substring(10)}</p>
        <p>Amount:₹. ${pblamt}</p>`;
    var rollno=rowData.rollno;
     
    var feebatch=rowData.feebatch;
    var balamt=rowData.balamt;
    var program=rowData.program;
    var batch=rowData.batch;
    var course=rowData.course;
    var branch=rowData.branch;
    var phone=rowData.phone;
    var studentname=rowData.studentname;
    var email=rowData.email;
    var sessid=rowData.sessid;
    var ye=rowData.ye;
    var res="";
    $("#mrollno").val(rowData.rollno);
    $("#feebatch").val(rowData.feebatch);
    $("#studentname").val(rowData.studentname);
    $("#branch").val(rowData.branch);
    $("#batch").val(rowData.batch);
    $("#phone").val(rowData.phone); 
    $("#balamt").val(rowData.balamt); 
    $("#feedue").val(pblamt);
    $("#ye").val(ye);
    $("#program").val(rowData.program);
    $("#course").val(rowData.course); 
    
     $("#paymentModalBody").html(modalContent);
     var myModal = new bootstrap.Modal(document.getElementById('paymentModal'));
     myModal.show();
      
    }
  
</script>
  <?php include("../../includes/footer.php"); ?>
  <?php include("../../includes/footerjs.php"); ?>
</body>

</html>
 