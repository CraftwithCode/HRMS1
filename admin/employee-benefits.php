<?php
	include('../includes/connection.php');
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);
	if(!isset($_SESSION['main']['uname'])){
		header('Location: ../index.php');
	}


	$groupArray = [];
	$obj1 = new myconn;
	$obj2 = new myconn;
	$obj3 = new myconn;
	$obj4 = new myconn;

	try {
		$conn1=$obj1->connection();
		$group = $conn1->prepare("Select * from company");
		$group->execute();
		$count = $group->rowCount();
		if($count>0) {
			while($grp = $group->fetch(PDO::FETCH_ASSOC)){
				$groupArray[$grp['id']] = $grp['groupname'];
				$companycount[$grp['id']] = $grp['total']+3;
			}
		}
		$pagedisabled = false;
		if($_SESSION['main']['role'] =='group-admin'){
			$groupid = $_SESSION['main']['gid'];
			$check = $conn1->prepare("Select count(*) as count from employee where groupid=:gid");
			$check->bindParam(':gid', $groupid);
			$check->execute();
			$count = $check->rowCount();
			if($count){
				$rows = $check->fetch(PDO::FETCH_ASSOC);
				if($companycount[$_SESSION['main']['gid']] <= $rows['count']){
					$pagedisabled = true;
				}
			}
		}

		$curremp = getEmployee($_GET['id']);
	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	
?>
<?php include_once('admin-header.php'); ?>
<style type="text/css">
	.bootstrap-datetimepicker-widget ul{
		padding: 0;
	}
</style>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee Benefits</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Employee Benefits</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user"></i> <h3 class="box-title"><?=$curremp['title'].'. '.ucwords($curremp['fname']).' '.ucwords($curremp['lname'])?> ( <?=$groupArray[$curremp['groupid']]?> )</h3>
						<!-- tools box -->
						<div class="pull-right box-tools">
							<a href="/hrms/admin/benefits-front.php" class="btn btn-primary">Go Back</a>
							<!-- <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
							<i class="fa fa-times"></i></button> -->
						</div>
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" id="ben-summary" href="#summary">Benefit Summary</a></li>
							<li><a data-toggle="tab" id="ben-dependent" href="#dependent">Beneficiaries/Dependents</a></li>
							<li><a data-toggle="tab" id="ben-pto" href="#pto">PTO Plans</a></li>
							<li><a data-toggle="tab" id="ben-cobra" href="#cobra">COBRA</a></li>
							<li><a data-toggle="tab" id="ben-links" href="#links">Links</a></li>
						</ul>
						<div class="tab-content">
						    <div id="summary" class="tab-pane fade in active">	  
						    	<div class="col-sm-12">
									<?php include('benefits/summary.php'); ?>
								</div>
						    </div>
						    <div id="dependent" class="tab-pane fade">
								<div class="col-sm-12">
									<?php include('benefits/dependents.php'); ?>
							    </div>
							</div>
						    <div id="pto" class="tab-pane fade">
						    	<div class="col-sm-12">
						    		<?php include('benefits/pto.php'); ?>							    	
							    </div>
							</div>
						    <div id="cobra" class="tab-pane fade">
						    	<div class="col-sm-12">
						    		<?php include('benefits/cobra.php'); ?>
						    	</div>
						    </div>
						    <div id="links" class="tab-pane fade">
						    	<div class="col-sm-12">
						    		<?php include('benefits/links.php'); ?>
						    	</div>
						    </div>						    
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>
	



<?php include_once('admin-footer.php'); ?>