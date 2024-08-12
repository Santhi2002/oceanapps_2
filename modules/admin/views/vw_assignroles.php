<?php 
include("../../includes/head.php");
$_SESSION['page']="modules/admin/assignroles.php"; 
$action = "addsection";
?>
<!DOCTYPE html>
<html lang="en">
<script type="text/javascript">
	checkRolesAssigned();
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
function handleprogram(program) {
            var optprogram = program.value;
			var userids = $('#optuserids').val();
			 
			var rolesfound = $('#rolesfound');
			if(optprogram){
            $.ajax({
                type:'POST',
                url:'adminajax.php',
                data:'optprogram='+optprogram,
                success:function(html){   
					 
                    $('#rolesfound').html(html);
                }
            });
			$.ajax({
                type:'POST',
                url:'adminajax.php',
                data:'optuserids='+userids+'&assoptprogram='+optprogram,
                success:function(html){   
					 
                    $('#rolesassigned').html(html);
                }
            });
        }
}
	 
function assignclick() {
         
        var selectedValues = [];
        $('input[name="chkroles[]"]:checked').each(function() {
            var roleId = $(this).val();
           
            if ($('#rolesassigned').find('#' + roleId).length === 0) {
                var clone = $(this).parent().clone();
                clone.find(".form-check-input").attr('id',  roleId);
                clone.find(".form-check-input").attr('name', 'revokeroles[]');
                $('#rolesassigned').append(clone);
            }
        });
		checkRolesAssigned();
}
function revokeclick() {
         
		$('#rolesassigned').find('input[name="revokeroles[]"]:not(:checked)').each(function() {
            $(this).parent().remove();
        });
		checkRolesAssigned();
}
function checkRolesAssigned() {
	var checkboxesCount = $('#rolesassigned').find('input[type="checkbox"]').length;
    
    if (checkboxesCount === 0) {
        $('#hideroles').hide();
    } else {
        $('#hideroles').show();
    }
}
</script>
 
<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
<div class="wrapper">
    <?php include("../../includes/sidebar.php"); ?>
	<div class="main">
	     <?php include("../../includes/menubar.php"); ?>
         <main class="content">
				<div class="container-fluid p-0">
				<form  name="frmroles" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo((isset($id) && $id!='')?$id:'');?>"/>
               	<button class="btn btn-primary float-end mt-n1" type="submit" name="submit" value="<?php echo ((isset($action) && $action == "addsection") ? "Add" : "Edit"); ?>"><i class="fas fa-plus"></i>SAVE ROLES</button>
		 			<div class="mb-3">
						<h1 class="h3 d-inline align-middle">MANAGEMENT OF ROLES</h1><a class="badge bg-primary ms-2" href="https://adminkit.io/pricing/" target="_blank">
							Confidential <i class="fas fa-fw fa-external-link-alt"></i></a>
					</div>
					<div class="row">
        			<div class="col-12 col-lg-6 col-xl-6">
						<?php	
						$errormsg="";
						if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1")
						{
						$errormsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong>Success!</strong> Subject exists. Unable to Delete Subject
					</div>';
						}else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="2")
						{
						$errormsg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong>Success!</strong> Subject exists. Unable to Delete Subject
					</div>';
						} 
						else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="3")
						{
						$errormsg = '<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<div class="alert-message">
							<strong>Success!</strong> Roles are assigned!
						</div>
					</div>';
						} 
				 		 echo $errormsg;
						?>
						</div>
					</div>
					<div class="row">
					 <div class="col-12 col-lg-6 col-xl-6">
						<div class="card">
						<div class="card-body">
						<?php	
						if(isset($mstremps) && count($mstremps)!=0)
								{ ?>	 
								<select class="form-select" id="optuserids" name="optuserids[]"  required multiple>
								<option  value=""> Select User ID </option> 
								<?php	for($k=0;$k<count($mstremps) ;$k++)
			  						 {
									?>
								   <option   value="<?php echo $mstremps[$k]['emailid'];?>"><?php echo $mstremps[$k]['empname']."-".$mstremps[$k]['empcode'];?></option> 
									 
								<?php } ?>
								</select>
								<?php
								}
						?>
						</div>
						</div>
					 </div>
					 <div class="col-12 col-lg-6 col-xl-3">
						<div class="card">
							<div class="card-body">
							<?php	
							if(isset($metadesign) && count($metadesign)!=0)
								{ ?>	 
								<select class="form-select" id="optdesign" name="optdesign"  onchange="handleprogram(this)"	 required >
									<option  value=""> Select Designation</option> 
								<?php	for($k=0;$k<count($metadesign) ;$k++)
			  						 {
									?>
								   <option <?php if( $metadesign[$k]['designation']== $optdesign) echo 'selected';?> value="<?php echo $metadesign[$k]['designation'];?>"><?php echo $metadesign[$k]['designation'];?></option> 
									 
								<?php } ?>
								</select>
								<?php
								}
							?>
							</div>
						</div>
					   </div>
					 <div class="col-12 col-lg-6 col-xl-3">
						<div class="card">
							<div class="card-body">
							<?php	
							if(isset($metaprograms) && count($metaprograms)!=0)
								{ ?>	 
								<select class="form-select" id="optprogram" name="optprogram"  onchange="handleprogram(this)"	 required >
									<option  value=""> Select Program </option> 
								<?php	for($k=0;$k<count($metaprograms) ;$k++)
			  						 {
									?>
								   <option <?php if( $metaprograms[$k]['program']== $optprogram) echo 'selected';?> value="<?php echo $metaprograms[$k]['program'];?>"><?php echo $metaprograms[$k]['program']."-".$metaprograms[$k]['collegename'];?></option> 
									 
								<?php } ?>
								</select>
								<?php
								}
							?>
							</div>
						</div>
					   </div>
					</div>
				    
					<div class="row">			
						<div class="col-12 col-lg-6 col-xl-3">
							<div class="card">
							<div  class="card-header">
							<span class="badge bg-primary ms-3">AVAILABLE ROLES</span>
							</div>
							 	<div class="card-body">
							   		<div class="card mb-3 bg-white cursor-grab border">
							   			<div  id="rolesfound">
										    NO ROLES FOUND 
        					   			</div>
									</div>
								</div>
							   <button type="button" class="btn btn-primary" id="showassignBtn" onclick="assignclick()">Assign Roles</button>
											
							</div>
						</div>
							 
						 <div class="col-12 col-lg-6 col-xl-3" id="hideroles" >
							<div class="card">
							<div class="card-header">
							<span class="badge bg-primary ms-3">ASSIGNED ROLES</span>
							</div>
								<div class="card-body">
							   		<div class="card mb-3 bg-white cursor-grab border">
							   			<div id="rolesassigned" >.</div>
									</div>
								</div>
							   <button type="button" class="btn btn-danger" id="showrevokeBtn" onclick="revokeclick()">Revoke Roles</button>
											
							</div>
							
						</div>
					</div>

				</div>
				</form>
			</main>
     
    <?php include("../../includes/footer.php"); ?>
	</div>
	</div>
     <?php include("../../includes/footerjs.php"); ?>
	</body>

</html>
 