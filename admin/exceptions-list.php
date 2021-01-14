<?php
	include('../includes/connection.php');

	if(!isset($_SESSION['main']['uname'])){
		header('Location: ../index.php');
	}
	// var_dump($_SESSION['main']);

	$companyArray = [];
	$userArray = [];
	$obj = new myconn;
	try {
		$con = $obj->connection();
		$co = $con->prepare("Select * from company");
		$co->execute();
		$count = $co->rowCount();
		if($count>0) {
			while($com = $co->fetch(PDO::FETCH_ASSOC)){
				$companyArray[$com['id']] = $com['groupname'];
			}
		}

		if(isset($_SESSION['main']['gid'])){
			$q = $con->prepare("Select * from employee where groupid=:gid");
			$company = $_SESSION['main']['gid'];
			$q->bindParam(':gid', $company);
		} else{
			$q = $con->prepare("Select * from employee");
		}
		$q->execute();
		$count = $q->rowCount();
		if($count>0) {
			while($x = $q->fetch(PDO::FETCH_ASSOC)){
				$userArray[$x['id']] = $x['fname'].' | '.$x['lname'].' | '.$x['status'];
			}
		}

		if(isset($_SESSION['main']['gid'])){
			$q = $con->prepare("Select * from exceptions where emp_id IN(Select id from employee where groupid=:gid)");
			$company = $_SESSION['main']['gid'];
			$q->bindParam(':gid', $company);
		} else{
			$q = $con->prepare("Select * from exceptions");
		}
		$q->execute();
		$count = $q->rowCount();
		if($count>0) {
			while($x = $q->fetch(PDO::FETCH_ASSOC)){
				$exceptions[] = $x;
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
		<h1>Exceptions</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<!-- <li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li> -->
				<li class="active">Exceptions</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Exceptions</h3>
						<!-- tools box -->
						<!-- <div class="pull-right box-tools">
							<button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button>
						</div> -->
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<div class="col-sm-12">
							<form class="filter-punches ar-exceptions" method="post">
								<div class="form-group row">
									<?php if($_SESSION['main']['role'] == 'super-admin'){ ?>
										<div class="col-sm-2">
											<select name="company" class="form-control sel-company" >
												<option value="">Select Company</option>
												<?php foreach($companyArray as $id=>$company){ ?>
													<option value="<?=$id?>"><?=$company?></option>
												<?php } ?>
											</select>
										</div>
									<?php } ?>
									<div class="col-sm-3">
										<select name="employee" class="form-control ar-employee" required>
											<option value="">Select Employee</option>
											<?php if(isset($_SESSION['main']['gid'])){ ?>
												<?php foreach($userArray as $id=>$emp){ ?>
													<option value="<?=$id?>"><?=$emp?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-2">
										<select name="year" class="form-control year" onchange="getDateRange();">
											<option value="">Year</option>
											<option value="<?=date('Y', strtotime('-1year'))?>"><?=date('Y', strtotime('-1year'))?></option>
											<option value="<?=date('Y')?>" ><?=date('Y')?></option>
										</select>
									</div>
									<?php $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September','October', 'November', 'December']; 
										$currmon = date('F');
									?>
									<div class="col-sm-2">
										<select name="month" class="form-control month" onchange="getDateRange();">
											<option value="">Month</option>
											<?php foreach($month as $m){ ?>
												<option value="<?=$m?>" ><?=$m?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-3">
										<select name="daterange" class="form-control daterange" >
											<option value="">Select Date Range</option>
											
										</select>
									</div>
									<!-- <div class="col-sm-1">
										<input type="submit" value="View" class="btn btn-primary form-control">
									</div> -->
								</div>
							</form>
						</div>
						<div class="col-sm-12 view-iframe-div">
							<iframe src="/hrms/admin/viewexceptions.php" class="view-iframe" style="width: 100%"></iframe>
						</div>

						<!-- <div class="box">
						    <div class="box-header">
						     	<h3 class="box-title">Exceptions</h3>
						     	<div class="pull-right box-title"><a href="/hrms/admin/exceptions.php" class="">Add New</a></div>
						    </div> -->
						    <!-- /.box-header -->
						    <!-- <div class="box-body">
						     	<table id="employees-list" class="table table-bordered table-striped ar-table">
						            <thead>
										<tr>
							    			<th>First Name</th>
							    			<th>Last Name</th>
							    			<th>Date</th>
							    			<th>Severity</th>
							    			<th>Exception</th>
							    			<th>Code</th>
							    		</tr>
						            </thead>
						            <tbody>
						            	<?php 
							            	foreach($exceptions as $key=>$exception) {
							            		$emp = getEmployee($exception['emp_id']);
							            		?>
								    			<tr>
								    				<td><?=ucwords($emp['fname'])?></td>
								    				<td><?=ucwords($emp['lname'])?></td>
								    				<td><?=$exception['date']?></td>
								    				<td><?=$exception['severity']?></td>
								    				<td><?=$exception['exception']?></td>
								    				<td><?=$exception['code']?></td>
								    			</tr>
						            			<?php
						            		} 
						            	?>
						            </tbody>
						            <tfoot>
										<tr>
							    			<th>First Name</th>
							    			<th>Last Name</th>
							    			<th>Date</th>
							    			<th>Severity</th>
							    			<th>Exception</th>
							    			<th>Code</th>
							    		</tr>
						            </tfoot>
						      	</table>
						    </div> -->
						    <!-- /.box-body -->
						<!-- </div> -->
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php include_once('admin-footer.php'); ?>
