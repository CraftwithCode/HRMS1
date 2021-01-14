<?php
	include('../includes/connection.php');
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);
	if(!isset($_SESSION['main']['uname'])){
		header('Location: ../index.php');
	}
	$object = new myconn;
	try {
		$empdata=[];
		$con = $object->connection();
		// if(isset($_GET['id'])){
		// 	$empid = $_GET['id'];
		if($_SESSION['main']['role'] == 'group-admin'){
			$company = $_SESSION['main']['gid'];
			$emp = $con->prepare('SELECT * from emp_pay_methods where legal_entity=:company');
			$emp->bindParam(':company', $company);
		} else {
			$emp = $con->prepare('SELECT * from emp_pay_methods');
		}
			// $emp->bindParam(':empid',$empid);
			$emp->execute();
			$empcount= $emp->rowCount();
			if($empcount){
				while($data = $emp->fetch(PDO::FETCH_ASSOC)){
					$empdata[] = $data;
				}
			}
		// }
		$company = $con->prepare("Select * from company");
		$company->execute();
		$count = $company->rowCount();
		if($count>0) {
			while($grp = $company->fetch(PDO::FETCH_ASSOC)){
				$companyArray[$grp['id']] = $grp['groupname'];
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
		<h1>Payment Methods</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<!-- <li><a href="https://terraorb.xyz/hrms/admin/"> Contacts</a></li> -->
				<li class="active">Payment Methods</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Payment Methods</h3>
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
						     	<h3 class="box-title">Payment Methods</h3>
						     	<div class="pull-right box-title"><a href="/hrms/admin/pay-methods.php" class="">Add New</a></div>
						    </div>
						    <!-- /.box-header -->
						    <div class="box-body">
						     	<table id="contact-list" class="table table-bordered table-striped ar-table">
						            <thead>
										<tr>
											<th>#</th>
											<?php if($_SESSION['main']['role'] =='super-admin'){ ?>
												<th>Company</th>
											<?php } ?>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Status</th>
											<th>Type</th>
											<th>Priority</th>
										</tr>
						            </thead>
						            <tbody>
						            	<?php 
						            		$i=1; 
						            		foreach($empdata as $arcon){ 
						            			$empid = $arcon['emp_id'];
						            			$employee = $con->prepare('Select * from employee where id=:empid');
												$employee->bindParam(':empid', $empid);
												$employee->execute();
												$empcount = $employee->rowCount();
												if($empcount == 0){
													// die('<h3>Employee not exist</h3>');
												} else {
													$aremp = $employee->fetch(PDO::FETCH_ASSOC);											
							            			?>
								            		<tr>
								            			<td><a href="/hrms/admin/pay-methods.php?edit=<?=$arcon['id']?>"><?=$i?></a></td>
								            			<?php if($_SESSION['main']['role'] =='super-admin'){ ?>
															<td><?=$companyArray[$arcon['legal_entity']]?></td>
														<?php } ?>
								            			<td><?=$aremp['fname']?></td>
								            			<td><?=$aremp['lname']?></td>
								            			<td><?=$arcon['status']?></td>
								            			<td><?=$arcon['type']?></td>
								            			<td><?=$arcon['priority']?></td>
								            		</tr>
							            			<?php 
							            			$i++;
						            			} 
						            		} 
						            	?>
						            </tbody>
						            <tfoot>
										<tr>
											<th>#</th>
											<?php if($_SESSION['main']['role'] =='super-admin'){ ?>
												<th>Company</th>
											<?php } ?>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Status</th>
											<th>Type</th>
											<th>Priority</th>
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