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

	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_timeinout';
	} else {
		$key = 'default_timeinout';
	}
	$defaultKey = 'default_timeinout';	
	
	$label = getLabels($key, $defaultKey);

?>
<?php include_once('admin-header.php'); ?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>In/Out</h1>
		<ol class="breadcrumb">
			<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">In/Out</li>
		</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">In/Out</h3>
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
							<form id="punches" name="punches" method="post" action="" class="time-steps ">
								<input type="hidden" name="formtype" value="inoutnew">
								<?php if($role == 'super-admin') { ?>
									<div class="form-group">
										<label>Company</label>
										<select name="company" class="sel-company form-control" required>
											<option value="">Select Company</option>
											<?php foreach($companyArray as $id=>$company){ ?>
												<option value="<?=$id?>"><?=$company?></option>
											<?php } ?>
										</select>
									</div>
								<?php } ?>
								<div class="form-group">
									<label><?=$label['employee']['title']?></label>
									<select name="emp" class="ar-employee form-control" required>
										<option value="">Select Employee</option>
										<?php foreach($userArray as $id=>$user){ ?>
											<option value="<?=$id?>"><?=$user?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label><?=$label['date']['title']?></label>
									<input type="text" name="date" class="form-control datepicker" value="<?=date('d-M-Y')?>" placeholder="DD-MM-YYYY" required>
								</div>
				                <div class="form-group">
									<label>Check In Time</label>
									<input type="text" name="check_in" class="form-control timepicker" placeholder="hh:mm" value="<?=date('H:i')?>" required>
				                </div>
				                <div class="form-group">
									<label>Check Out Time</label>
									<input type="text" name="check_out" class="form-control timepicker" placeholder="hh:mm" value="<?=date('H:i')?>" >
				                </div>
								
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" class="form-control" placeholder="Note"></textarea>
								</div>
								<div class="form-group">
									<input type="submit" name="" class="btn btn-primary" value="Save">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php include_once('admin-footer.php'); ?>