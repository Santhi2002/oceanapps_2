<?php 
include("../../includes/head.php");
$_SESSION['page']="modules/exams/examscheduleshow.php"; 
   
?>
<!DOCTYPE html>
<html lang="en">
 
<script src="../../assets/js/jquery.min.js"></script> 
  
<script type="text/javascript">
$(document).ready(function(){
$('#program').on('change',function(){
 
  		 var program = $('#program').val();
		  
        if(program){
          	$.ajax({
                type:'POST',
                url:'examajax.php',
                data:'tprogram='+program,
                success:function(html){     
        
                    $('#regulation').html(html);
                }
            });	
            $.ajax({
                type:'POST',
                url:'examajax.php',
                data:'sesprogram='+program,
                success:function(html){     
        
                    $('#examsession').html(html);
                }
            });			
        }else{
            $('#examsession').html('<option value="">Select Program first </option>');
        }
        
    });
    $('#regulation').on('change',function(){
        var  regulation= $(this).val();
       var program = $('#program').val();
	    
        if(regulation){
            $.ajax({
                type:'POST',
                url:'examajax.php',
                data:'prgregulation='+regulation+'&prgprogram='+program,
                success:function(html){   
		                $('#course').html(html);
                }
            });
        }
     }); 
     
    });
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
                                <h1 class="h3 align-middle">EXAM BATCHES</h1> 
                </div>
                <div class="mb-3"> 
                <?php
                if($msg!="")
                echo $msg;
                
                ?>
                </div>
                <div class="row" >
                <div class="col-md-12" >   
            	<form  method="post" id="frmprogram" class="form-horizontal" enctype="multipart/form-data">
                <div class="row mb-3">
                <div class="col-md-4"> 
						 <label class="form-label" for="program">Program</label>
				  
					  <select  class="form-control" class="selecttag"  id="program" name="program" >
					<option value=""> Select Program</option>
                        <?php 
                           if ( isset($_POST['program'] ))  
                            $program=$_POST['program'];
                            else
                            $program="";
                        
                           $programsData=$meta_handler->getPrograms($program);
                           foreach($programsData as $data ) { 
                          ?>
                              <option  
                              <?php
                              if ( $program==$data['program'] ) echo 'selected' ;
                              ?>  value='<?php echo $data['program'];?>'><?php echo $data['program'];?></option>
                          <?php
                          }
                        ?>
  
                      </select>
                     
                      </div> 
                      <div class="col-md-4"> 
					 <label for="regulation" class="form-label "><span  >Regulation</span></label>
                    
                       <select class="form-control" id="regulation" name="regulation"     required>
                        <option value="">Select Regulation</option> 
                          
                              <?php
                              if ( isset($_POST['regulation'] )) {?>   
                              <option selected  value='<?php echo $_POST['regulation'];?>'> <?php echo $_POST['regulation'];?> </option>
                              <?php }?>
                      </select>
                      </select>
                    </div>
                 	</div>
                     <div class="row mb-3">
                     <div class="col-md-4"> 
						 <label class="form-label" for="course">Course </label>
				      
					  <select  class="form-control" class="selecttag"  id="course" name="course"        >
				           	<option value=""> Select Course</option>
                              <?php
                              if ( isset($_POST['course'] )) {?>   
                              <option  selected  value='<?php echo $_POST['course'];?>'> <?php echo $_POST['course'];?> </option>
                              <?php }?>
                         </select>
					</div>  
                    <div class="col-md-4"> 
			           
					  <label class="form-label" for="program">ExamType</label>
				     
					  <select  class="form-control" class="selecttag"  id="examtype" name="examtype" >
					<option value="">Exam Type</option>
                   <?php
                           if ( isset($_POST['examtype'] ))  
                           $examtype=$_POST['examtype'];
                           else
                           $examtype="";  
                            $examTypesData=$meta_handler->getExamTypes();
                           foreach($examTypesData as $data ) { 
                          ?>
                              <option  
                              <?php
                              if ( $examtype==$data['examtype'] ) echo 'selected' ;
                              ?>  value='<?php echo $data['examtype'];?>'><?php echo $data['examtype'];?></option>
                          <?php
                          }
                        ?>
   
                     </select>
					</div> 
					</div>
				     
                     
					<input type="submit" name="showbatches" class="btn btn-success btn-sm" value="Show Exam Batches" />
				  </div>	
			 	</div> 				 
			   </div> 
                    <?php 
                    if(isset($_POST['showbatches'])){
                    $program=$_POST['program'];
                    $regulation=$_POST['regulation'];
                    $course=$_POST['course'];
                    $examtype=$_POST['examtype'];
                    $ExamBatchesData=$exam_handler->getExamBatches($program, $regulation , $course, $examtype);
                    if(count($ExamBatchesData)>0){
                    ?>

                    <div class="row">
                        <table class="table" >
                           <tr> 
                            <th> SNo</th> <th>Program </th><th>Regulation </th><th> Course </th> <th>StudyYear </th><th>Semester </th><th>ExamMonth </th><th>FromDate </th> <th>Action </th>
                           </tr> 
                       <?php
                        for($i=0;$i<count($ExamBatchesData);$i++)
                         {?>
                            <tr> 
                            <td><?php echo $i+1;?></td> <td><?php echo $ExamBatchesData[$i]['program'];?> </td><td><?php echo $ExamBatchesData[$i]['regulation'];?> </td><td><?php echo $ExamBatchesData[$i]['course'];?> </td> <td> <?php echo $ExamBatchesData[$i]['studyyear'];?> </td><td><?php echo $ExamBatchesData[$i]['semester'];?> </td> <td><?php echo $ExamBatchesData[$i]['exammonthyear'];?> </td>
                            <td><?php echo date("d-m-Y",strtotime($ExamBatchesData[$i]['fromdate']));?> </td>
                             
                            <?php
                             echo '<td>
                            <a href="examschedulebranch.php?action=show&exambatchid='.$ExamBatchesData[$i]['exambatchid'].'"  target="_blank" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-edit">Show BranchWise</span></a></td>';
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
 
            </div>
  
    
  
  <?php include("../../includes/footer.php"); ?>
  <?php include("../../includes/footerjs.php"); ?>
</body>

</html>
 