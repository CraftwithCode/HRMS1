<?php
	include('../includes/connection.php');

	if(!isset($_SESSION['main']['uname'])){
		header('Location: ./login.php');
	}

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
	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<?php include_once('admin-header.php'); ?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Accrual Balance</h1>
		<ol class="breadcrumb">
			<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
			<!-- <li><a href="https://terraorb.xyz/hrms/admin/"> Contacts</a></li> -->
			<li class="active">Accrual Balance</li>
		</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Accrual Balance</h3>
						<div class="pull-right box-title"><a href="/hrms/admin/accrual_bal.php" class="">Add New</a></div>
						<!-- tools box -->
						<div class="pull-right box-tools">
							<!-- <a href="<?=(isset($_GET['edit'])) ? ((isset($_GET['id']) && isset($_GET['edit'])) ? '/hrms/admin/update-employee.php?id='.$_GET['id'] : '/hrms/admin/employee-contacts.php' ) : $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Go Back</a> -->
							<!-- <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button> -->
						</div>
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<div class="col-sm-12">
							<form class="filter-accrualbal" method="post">
								<div class="form-group row">
									<?php if($_SESSION['main']['role'] == 'super-admin'){ ?>
										<div class="col-sm-6">
											<select name="company" class="form-control sel-company" >
												<option value="">Select Company</option>
												<?php foreach($companyArray as $id=>$company){ ?>
													<option value="<?=$id?>"><?=$company?></option>
												<?php } ?>
											</select>
										</div>
									<?php } ?>
									<div class="col-sm-6">
										<select name="employee" class="form-control ar-employee" required>
											<option value="">Select Employee</option>
											<?php if(isset($_SESSION['main']['gid'])){ ?>
												<?php foreach($userArray as $id=>$emp){ ?>
													<option value="<?=$id?>"><?=$emp?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
									<!--<div class="col-sm-2">-->
									<!--	<input type="submit" value="View" class="btn btn-primary form-control">-->
									<!--</div>-->
								</div>
							</form>
						</div>
						<div class="col-sm-12 view-iframe-div">
							<iframe src="/hrms/admin/accrualbal-listview.php" class="view-iframe" style="width: 100%"></iframe>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
	
<?php include_once('admin-footer.php'); ?>