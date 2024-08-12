		<?php
		$arprograms=explode(",",$userroles[0]['programs']);
		$arprgroles=explode(":",$userroles[0]['roles']);
		$arprgfunctions=explode(":",$userroles[0]['functions']);
		if(isset($_POST['programs'])){
			$programs=$_POST['programs'];
			$i=0;
			$aractroles="";
			$aractfunctions="";
			foreach($arprograms as $program){
				if($program==$programs){
					$aractroles=$arprgroles[$i];
					$aractfunctions=$arprgfunctions[$i];
					break;
				}
				$i++;
			}
			$actroles= explode(",",$aractroles);
			$roleactfunctions= explode(";",$aractfunctions);
		}else
		{
		$programs=$arprograms[0];
		$i=0;
		$aractroles="";
		$aractfunctions="";
		foreach($arprograms as $program){
			if($program==$programs){
				$aractroles=$arprgroles[$i];
				$aractfunctions=$arprgfunctions[$i];
				break;
			}
			$i++;
		}
		$actroles= explode(",",$aractroles);
		$roleactfunctions= explode(";",$aractfunctions);
		}
		?>
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class='sidebar-brand' href='index.html'>
					<span class="sidebar-brand-text align-middle">
						OceanApps
						<sup><small class="badge bg-primary text-uppercase">ERP</small></sup>
					</span>
					<svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5"
						stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
						<path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
						<path d="M20 12L12 16L4 12"></path>
						<path d="M20 16L12 20L4 16"></path>
					</svg>
				</a>

				<div class="sidebar-user">
					<div class="d-flex justify-content-center">
						<div class="flex-shrink-0">
							<img src="<?php echo $authuser[0]['picture'];?>" class="avatar img-fluid rounded me-1" alt="<?php echo ucwords($authuser[0]['first_name'])." ".ucwords($authuser[0]['last_name']);?>" />
						</div>
						<div class="flex-grow-1 ps-2">
							<a class="sidebar-user-title dropdown-toggle" href="#" data-bs-toggle="dropdown">
							<?php echo ucwords($authuser[0]['first_name'])." ".ucwords($authuser[0]['last_name']);?> 
							</a>
							<div class="dropdown-menu dropdown-menu-start">
								<a class='dropdown-item' href='pages-profile.html'><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class='dropdown-item' href='pages-settings.html'><i class="align-middle me-1" data-feather="settings"></i> Settings &
									Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="/oceanerp/logout.php">Log out</a>
							</div>

							<div class="sidebar-user-subtitle"><?php echo ucwords($erpuser[0]['designation']);?></div>
						</div>
					</div>
				</div>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						MENU
					</li>
					<li class="sidebar-item active">
						
						<?php
						$k=0; 
						$arfunc=array();
						foreach ($actroles as $role)
						{
						?>
						<a data-bs-target="#<?php echo $role;?>" data-bs-toggle="collapse" class="sidebar-link">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle"><?php echo $role;?></span>
						</a>
						<ul id="<?php echo $role;?>" class="sidebar-dropdown list-unstyled collapse show" data-bs-parent="#sidebar">
						 
						<?php
						$arfunc=explode(",",$roleactfunctions[$k]);
						foreach ($arfunc as $func)
						{	
						?>
						<li class="sidebar-item"><a class='sidebar-link' href='/oceanerp/modules/<?php echo strtolower($role)."/";?><?php echo trim($func).".php";?> '>
							<?php echo $func;?>  </a>
						</li>
						
						<?php 
						}?>
						</ul> 
						<?php
							$k++;
						}
						?>
						
					</li>
					<li class="sidebar-header">
						Enginnering Campus
					</li>
					<li class="sidebar-item">
						<a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link collapsed">
							<i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Students Details</span>
						</a>
						<ul id="ui" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
							
							<li class="sidebar-item"><a class='sidebar-link' href='\oceanerp\modules\student\vw_studentdata.php'>Student Registration</a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='\oceanerp\modules\student\student_data.php'>View Students</a></li>

						</ul>
						<a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link collapsed">
							<i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Branch Details</span>
						</a>
						<ul id="ui" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
							
							<li class="sidebar-item"><a class='sidebar-link' href='ui-buttons.html'>Add Branch</a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='ui-buttons.html'>View Branches</a></li>

						</ul>
					</li>			
					 

					<li class="sidebar-header">
						Components
					</li>
					<li class="sidebar-item">
						<a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link collapsed">
							<i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">UI Elements</span>
						</a>
						<ul id="ui" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
							<li class="sidebar-item"><a class='sidebar-link' href='ui-alerts.html'>Alerts <span
										class="sidebar-badge badge bg-primary">Pro</span></a></a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='ui-buttons.html'>Buttons</a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='ui-cards.html'>Cards</a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='ui-general.html'>General</a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='ui-grid.html'>Grid</a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='ui-modals.html'>Modals <span
										class="sidebar-badge badge bg-primary">Pro</span></a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='ui-offcanvas.html'>Offcanvas <span
										class="sidebar-badge badge bg-primary">Pro</span></a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='ui-placeholders.html'>Placeholders <span
										class="sidebar-badge badge bg-primary">Pro</span></a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='ui-tabs.html'>Tabs <span
										class="sidebar-badge badge bg-primary">Pro</span></a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='ui-typography.html'>Typography</a></li>
						</ul>
					</li>

					

					
				</ul>

				<div class="sidebar-cta">
					<div class="sidebar-cta-content">
						<strong class="d-inline-block mb-2">Weekly Sales Report</strong>
						<div class="mb-3 text-sm">
							Your weekly sales report is ready for download!
						</div>

						<div class="d-grid">
							<a href="https:///" class="btn btn-outline-primary" target="_blank">Download</a>
						</div>
					</div>
				</div>
			</div>
		</nav>