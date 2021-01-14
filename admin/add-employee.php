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
		<h1>Add Employee</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Add Employee</li>
			</ol>
	</section>
	<?php if($pagedisabled) { ?>
		<h3>You are OUT OF LIMIT, contact adminstrator for reference.</h3>
	<?php } ?>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Add Employee</h3>
						<!-- tools box -->
						<!-- <div class="pull-right box-tools">
							<button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button>
						</div> -->
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" id="emp" href="#emp-info">Employee</a></li>
							<li><a data-toggle="tab" id="coninfo" href="#contact-info">Contact Info</a></li>
							<li><a data-toggle="tab" id="chain" href="#hierarcy">Chain</a></li>
							<li><a data-toggle="tab" id="con" href="#contacts">Contacts</a></li>
							<li><a data-toggle="tab" id="qualification" href="#qualifications">Qualifications</a></li>
							<li><a data-toggle="tab" id="review" href="#reviews">Reviews</a></li>
						</ul>
						<div class="tab-content">
						    <div id="emp-info" class="tab-pane fade in active">	  
						    	<div class="col-sm-12">    
									<?php include('employee-tabs/template-employee-info.php'); ?>
								</div>
						    </div>
						    <div id="contact-info" class="tab-pane fade">
								<div class="col-sm-12">
									<?php include('employee-tabs/template-contact-info.php'); ?>
							    </div>
							</div>
						    <div id="hierarcy" class="tab-pane fade">
						    	<div class="col-sm-12">
						    		<?php include('employee-tabs/template-hierarchy.php'); ?>
							    	
							    </div>
							</div>
						    <div id="contacts" class="tab-pane fade">
						    	<div class="col-sm-12">
						    		<?php include('employee-tabs/template-contacts.php'); ?>
						    	</div>
						    </div>
						    <div id="qualifications" class="tab-pane fade">
						    	<div class="col-sm-12">
						    		<?php include('employee-tabs/template-skills.php'); ?>
						    		<?php include('employee-tabs/template-education.php'); ?>
						    	</div>
						    </div>
						    <div id="reviews" class="tab-pane fade">
						     	<div class="col-sm-12">
						    		<?php include('employee-tabs/template-reviews.php'); ?>
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