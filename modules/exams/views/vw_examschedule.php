<?php 
include("../../includes/head.php");
$_SESSION['page']="modules/exams/examschedule.php"; 
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
 
<script src="../../assets/js/jquery.min.js"></script> 
 
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
     $('#excludedates').multiDatesPicker({
         dateFormat:"dd-mm-yy",
         //addDates: ['14/10/'+y, '19/02/'+y, '14/01/'+y, '16/11/'+y],
         numberOfMonths: [1,3],
         //defaultDate: '1/1/'+y,
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
                 <h1 class="h3">EXAM SCHEDULES</h1> 
                </div>
                <div class="mb-3"> 
                <?php
                if($msg!="")
                echo $msg;
                
                ?>
                </div>

                <div class="row" >
                <div class="col-sm-12" >   
            	<form  method="post" id="frmprogram" class="form-horizontal" enctype="multipart/form-data">
                <div class="row mb-3">
                <div class="col-md-4"> 
                <label class="form-label" for="program">Program</label>
				   <select  class="form-control" class="selecttag"  id="program" name="program" >
					<option value=""> Select Program</option>
                        <?php  
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
					 
					 <label for="regulation" class="col-sm-2 form-label "><span  >Regulation</span></label>
                     
                       <select class="form-control" id="regulation" name="regulation"     required>
                        <option value="">Select Regulation</option> 
                      </select>
                  
                    </div>
                    <div class="col-md-4">
                    <label class="form-label" for="course">Course </label>
				      
					  <select  class="form-control" class="selecttag"  id="course" name="course"        >
				           	<option value=""> Select Course</option>
                         </select>
                 	</div>
                     </div>
                <div class="row mb-3">
                <div class="col-md-4"> 
                   
				<label class="form-label"   for="studyyear">Year</label>
                 <?php
                 if(isset($_POST['studyyear']))
                 $studyyear=$_POST['studyyear'];
                 else
                 $studyyear="" ;
					echo "<select class='form-control' name='studyyear' id='studyyear'    required>";?>
					 <option <?php if ($studyyear== "" ) echo 'selected' ; ?> value=''>Select Study Year</option>
					  <option <?php if ($studyyear== "1" ) echo 'selected' ; ?> value='1'>I Year</option> 
					 <option <?php if ($studyyear== "2" ) echo 'selected' ; ?> value='2'>II Year</option> 
					  <option <?php if ($studyyear== "3" ) echo 'selected' ; ?>  value='3'>III Year</option> 
                      <option <?php if ($studyyear== "4" ) echo 'selected' ; ?> value='4'>IV Year</option> 
				<?php	echo "</select>"; 
					?>
                 </div>
			 <div class="col-md-4"> 
				<label class="form-label"   for="semester">Semester</label>
                    <?php
                     if(isset($_POST['semester']))
                 $semester=$_POST['semester'];
                 else
                 $semester="" ;
					echo "<select class='form-control' name='semester' id='semester'   required>";?>
				     <option value=''>Select Semester</option> 
				     <option <?php if ($semester== "1" ) echo 'selected' ; ?> value='1'>I Semester</option> 
				     <option <?php if ($semester== "2" ) echo 'selected' ; ?> value='2'>II Semester</option> 
				     <option <?php if ($semester== "3" ) echo 'selected' ; ?> value='3'>III Semester</option> 
				      <option <?php if ($semester== "4" ) echo 'selected' ; ?> value='4'>IV Semester</option> 
				     <option <?php if ($semester== "5" ) echo 'selected' ; ?> value='5'>V Semester</option> 
				     <option <?php if ($semester== "6" ) echo 'selected' ; ?> value='6'>VI Semester</option> 
			 		<?php	echo "</select>";
					?>
			 	</div>
                 <div class="col-md-4"> 
                    <label for="regulation" class="form-label "><span  >Timing</span></label>
 
                       <select class="form-control" id="examsession" name="examsession"     required>
                        <option value="" >Exam Timing</option>
                       
                      </select>
                    </div>
                    </div>

                      <div class="row mb-3">
                    <div class="col-md-4">    
					  <label class="form-label" for="program">ExamType</label>
				   
					  <select  class="form-control" class="selecttag"  id="examtype" name="examtype" >
					<option value="">Exam Type</option>
                   <?php
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
			        <div class="col-md-4"> 
					 <label class="form-label" for="program">Exam FromDate</label>
				     
					  <input  type="date" class="form-control" class="selecttag"  id="examfromdate" name="examfromdate" >
				 	</div> 
                    
                     <div class="col-md-4"> 
					 <label class="form-label" for="program">Exam ToDate</label>
				     
					  <input  type="date" class="form-control" class="selecttag"  id="examtodate" name="examtodate" >
				 	</div>
                     </div>
                 <div class="row mb-3">
                <div class="col-md-4"> 
					 <label class="form-label" for="program">Fee From Date</label>
				       
					  <input  type="date" class="form-control" class="selecttag"  id="feefromdate" name="feefromdate" >
				 	</div> 
                     <div class="col-md-4">
					 <label class="form-label" for="program">Fee ToDate</label>
				      
					  <input  type="date" class="form-control" class="selecttag"  id="feetodate" name="feetodate" >
                     </div>
                     <div class="col-md-4">
					 <label class="form-label" for="program">ExamFee </label>
				      
					  <input  type="number" class="form-control" class="selecttag"  id="examfee" name="examfee" >
                     </div> 
                     </div>
                     <div class="row mb-3">
                     <div class="col-md-8">  
					 <label class="form-label" for="Old">Select Excluded Dates</label>
					 							
			        <input type="text" class="form-control" size=50px style="height:40px;"  id="excludedates" name="excludedates" placeholder="Click here to select exclude dates"  />
					</div>
                    <div class="col-md-4"> 
                    <label class="form-label" for="Old"> . </label>   
                    <input type="submit" name="initiate" class="form-control btn btn-success btn-lg" value="Initiate Exam Schedule" />
  				    </div>
                     
					
				  </div>	
			 	</div> 				 
			 </div> 				 
             </div> 
                </div>
 
            </div>
  
    </div>
    </div>
  
  <?php include("../../includes/footer.php"); ?>
  <?php include("../../includes/footerjs.php"); ?>
</body>

</html>
 