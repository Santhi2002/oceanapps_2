<?php 
include("../../includes/head.php");
$_SESSION['page']="modules/exams/examschedulebranch.php"; 
   
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
         <div class="mb-3">
               <h1 class="h3 ">BRANCH WISE EXAM SCHEDULES</h1> 
          </div>
                
                
                    <?php 
                    if(isset($_GET['action'])){
                    $exambatchid=$_GET['exambatchid'];
                   
                    $ExamBatchesData=$exam_handler->getExamScheduleBranchGroup($exambatchid);
                    $ExamBatchData=$exam_handler->getExamBatch($exambatchid);
                    if(count($ExamBatchesData)>0){
                    ?>

                    <div class="row">
                        <table class="table" >
                           <tr> 
                            <th> SNo</th> <th>Program </th><th>Regulation </th><th> Course </th><th> Branch </th> <th>StudyYear </th><th>Semester </th><th>ExamMonth </th><th>FromDate </th> <th>Sub.Count </th> <th> Status</th><th>Action </th>
                           </tr> 
                       <?php
                        for($i=0;$i<count($ExamBatchesData);$i++)
                         {?>
                            <tr> 
                            <td><?php echo $i+1;?></td> <td><?php echo $ExamBatchData['program'];?> </td><td><?php echo $ExamBatchData['regulation'];?> </td><td><?php echo $ExamBatchData['course'];?> </td>
                            <td><?php echo $ExamBatchesData[$i]['branch'];?> </td> 
                            <td> <?php echo $ExamBatchData['studyyear'];?> </td><td><?php echo $ExamBatchData['semester'];?> </td> <td><?php echo $ExamBatchData['exammonthyear'];?> </td>
                            <td><?php echo date("d-m-Y",strtotime($ExamBatchData['fromdate']));?> </td>
                           
                            <td><?php echo $ExamBatchesData[$i]['subject'];?> </td> 
                            <td><?php 
                            if ($ExamBatchesData[$i]['approvestatus'] ==0)
                            echo "<span style='color:red;'>Not Approved</span>";
                            else
                            if ($ExamBatchesData[$i]['approvestatus'] ==1)
                            echo "<span style='color:green;'>Approved</span>";
                            
                            ?> </td> 
                            <?php
                             echo '<td>
                            <a href="examtimetablebranch.php?action=show&exambatchid='.$ExamBatchData['exambatchid'].'&branch='.$ExamBatchesData[$i]['branch'].'" target="_blank" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit">Show TimeTable</span></a></td>';
                            ?>
                           
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
 