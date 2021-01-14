<?php
	include('../includes/connection.php');

	if(!isset($_SESSION['main']['uname'])){
		header('Location: ../index.php');
	}

	$groupArray = [];
	$userArray = [];
	$obj1 = new myconn;
	try {
		$conn1=$obj1->connection();
		$group = $conn1->prepare("Select * from company");
		$group->execute();
		$count = $group->rowCount();
		if($count>0) {
			while($grp = $group->fetch(PDO::FETCH_BOTH)){
				$groupArray[$grp['id']] = $grp['groupname'];
			}
		}
	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}


	$obj = new myconn;
	$currRole = 'employee';
	try {
		$conn=$obj->connection();
		if(isset($_GET['g'])){
			$company = $_GET['g'];
		} elseif(isset($_SESSION['main']['gid'])){
			$company = $_SESSION['main']['gid'];
		}
		$q = $conn->prepare("Select * from employee where groupid=:gid");
		$q->bindParam(':gid', $company);
		$q->execute();
		$count = $q->rowCount();
		if($count>0) {
			while($x = $q->fetch(PDO::FETCH_BOTH)){
				$userArray[] = $x;
			}
		}
	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	// var_dump($groupArray);
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
		<h1>Employees</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<!-- <li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li> -->
				<li class="active">Employees</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Manage Employees</h3>
						<!-- tools box -->
						<!-- <div class="pull-right box-tools">
							<button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button>
						</div> -->
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<div class="box">
						    <div class="box-header">
						     	<h3 class="box-title">Employees</h3>
						     	<div class="pull-right box-title"><a href="/hrms/admin/add-employee.php" class="">Add New</a></div>
						    </div>
						    <!-- /.box-header -->
						    <div class="box-body">
						     	<table id="employees-list" class="table table-bordered table-striped ar-table">
						            <thead>
										<tr>
							    			<th>Status</th>
							    			<th>Employee #</th>
							    			<th>First Name</th>
							    			<th>Last Name</th>
							    			<th>Home Phone</th>
							    			<th></th>
							    		</tr>
						            </thead>
						            <tbody>
						            	<?php 
							            	foreach($userArray as $key=>$user) {
							            		$eid=$user['id'];
							            		$q1 = $conn->prepare("Select * from emp_contact_info where emp_id=:eid");
												$q1->bindParam(':eid', $eid);
												$q1->execute();
												$count = $q1->rowCount();
												if($count>0) {
													$emp = $q1->fetch(PDO::FETCH_BOTH);
													// var_dump($emp);
												}
							            		?>
								    			<tr>
								    				<td><?=$user['status']?></td>
								    				<td><a href="/hrms/admin/update-employee.php?id=<?=$user['id']?>"><?=$key+1?></a></td>
								    				<td><?=$user['fname']?></td>
								    				<td><?=$user['lname']?></td>
								    				<td><?=($emp['homephone'])?$emp['homephone']:'-'?></td>
								    				<td><a href="/hrms/admin/employee-benefits.php?id=<?=$user['id']?>">Employee Benefits</a> | <a href="/hrms/TCPDF/examples/ar-profile.php?id=<?=$user['id']?>&section=all&action=download" title="Master pdf" ><i class="fa fa-file"></i></a> | <a href="/hrms/admin/storage-tabs.php?id=<?=$user['id']?>" title="Document Storage"><i class="fa fa-folder"></i></a></td>
								    			</tr>
						            			<?php
						            		} 
						            	?>
						            </tbody>
						            <tfoot>
										<tr>
							    			<th>Status</th>
							    			<th>Employee #</th>
							    			<th>First Name</th>
							    			<th>Last Name</th>
							    			<th>Home Phone</th>
							    			<th></th>
							    		</tr>
						            </tfoot>
						      	</table>
						    </div>
						    <!-- /.box-body -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php include_once('admin-footer.php'); ?>
