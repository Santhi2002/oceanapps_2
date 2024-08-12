<?php 
include("../../includes/head.php");

$_SESSION['page']="modules/exams/examtimetablebranch.php"; 
$msg="";
if(isset($_GET['exambatchid']) or isset($_POST['approve'])){
    $exambatchid=$_GET['exambatchid'];
    $branch=$_GET['branch'];  
    $approveStatus=$exam_handler->approveExamTimeTableStatus($exambatchid, $branch);
   
    if($approveStatus[0]['approvestatus']!=0)
    {
        $msg = '<div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-message">
                        <strong>Success!</strong> Time Table is already Approved!
            </div>
        </div>';   
    }
}
if(isset($_POST['approve'])){
    $exambatchid=$_POST['exambatchid'];
    $branch=$_POST['branch'];  
    $approveStatusv=$exam_handler->approveExamTimeTable($exambatchid, $branch);
     
    if($approveStatusv!=0)
    {
        $msg = '<div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-message">
                        <strong>Success!</strong> Time Table is Approved!
            </div>
        </div>';   
    }
}
?>
<!DOCTYPE html>
<html lang="en">
 <head>   
 <script>
   var myWindow = window.open('', '_self');
    function closeTab() {
    myWindow.close();
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
                 <button id="closeTabBtn" class="btn btn-danger float-end mt-n1" onclick="closeTab();">Close</button>
                 <form name="examtimetable" method="post" >
                 <input type="hidden" name="exambatchid" value="<?php echo $_GET['exambatchid'];?>">
                 <input type="hidden" name="branch" value="<?php echo $_GET['branch'];?>">
                 
                 <input type="submit"  name="approve" value="Approve TimeTable" class="btn btn-danger float-end mt-n1"   class="btn btn-danger btn-sm pull-right" <?php if ($approveStatus[0]['approvestatus']) echo "disabled";?>  > 
                 <?php 
               
                 if ($approveStatus[0]['approvestatus']){?>
                 <input type="button" onclick="generateTimeTable('<?php echo $_GET['exambatchid'];?>','<?php echo $_GET['branch'];?>')" class="btn btn-success float-end mt-n1"   class="btn btn-success btn-sm pull-right"value="TimeTable(PDF)" /> 
                 <?php }?>
                </form>
                <div class="mb-3">
                                <h1 class="h3 ">BRANCH WISE EXAM TIMETABLE</h1> 
                </div>
                <div class="mb-3"> 
                <?php
                if($msg!="")
                echo $msg;
                
                ?>
                </div>
                
                    <?php 
                    if(isset($_GET['action'])){
                    $exambatchid=$_GET['exambatchid'];
                    $branch=$_GET['branch'];
                    $ExamTimeTableData=$exam_handler->getExamTimeTable($exambatchid, $branch);
                    $ExamBatchData=$exam_handler->getExamBatch($exambatchid);
                    if(count($ExamTimeTableData)>0){
                    ?>

                    <div class="row">
                        <table class="table" id="timetable" >
                            
                        <tr> 
                           <th colspan=5><?php echo $ExamBatchData['program']."-";?> <?php echo $ExamBatchData['regulation']."-";?>  <?php echo $ExamBatchData['course']."-";?> <?php echo $branch;?> <?php echo $ExamBatchData['exammonthyear']." - " ;?><?php echo $ExamBatchData['examtype']." - TIME TABLE" ;?>  </th>  
                           </tr> 
                           <tr> 
                           <th>SNo</th><th>SubjectCode</th><th>SubjectName </th><th> Date </th><th>Time </th>  
                        </tr> 
                       <?php
                        for($i=0;$i<count($ExamTimeTableData);$i++)
                         {?>
                            <tr> 
                            <td><?php echo $i+1;?></td> 
                            <td><?php echo $ExamTimeTableData[$i]['subjectcode'];?> </td>
                            <td><?php echo $ExamTimeTableData[$i]['subjectname'];?> </td>
                            <td><?php echo date("d-m-Y",strtotime($ExamTimeTableData[$i]['fromdate']));?> </td>
                            <td><?php echo $ExamTimeTableData[$i]['examtiming'];?> </td> 
                           </tr> 
                        <?php
                         }
                       ?>
                    </div>
                        </table>         
                    <?php 
                    }
                }?>
             </div> 
            </div>
  
  
    
  
  <?php include("../../includes/footer.php"); ?>
  <?php include("../../includes/footerjs.php"); ?>
</body>

</html>
 