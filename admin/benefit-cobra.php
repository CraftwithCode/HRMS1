<?php
	include('../includes/connection.php');
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);
	if(!isset($_SESSION['main']['uname'])){
		header('Location: ./login.php');
	}

	$key = $defaultKey = $allFields = '';
	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_cobra';
	} else {
		$key = 'default_cobra';
	}
	$defaultKey = 'default_cobra';	

	$companyArray = [];
	$userArray = [];
	$obj = new myconn;

	try {
		$con = $obj->connection();

		if(isset($_GET['edit'])){
			$edit = $_GET['edit'];
			$emp = $con->prepare('SELECT * from benefit_cobra where id=:edit');
			$emp->bindParam(':edit',$edit);
			$emp->execute();
			$empcount= $emp->rowCount();
			if($empcount){
				$data = $emp->fetch(PDO::FETCH_ASSOC);				
			}
		}

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

		$fields = $con->prepare('SELECT * from fields_data where meta_key IN (:key)');
		$fields->bindParam(':key', $key);
		$fields->execute();
		$count = $fields->rowCount();
		if($count == 0) {
			$con = $obj->connection();
			$fields = $con->prepare('SELECT * from fields_data where meta_key IN (:key)');
			$fields->bindParam(':key', $defaultKey);
			$fields->execute();
			$count = $fields->rowCount();
			if($count){
				while($field = $fields->fetch(PDO::FETCH_ASSOC)){
					$keyn = explode('_', $field['meta_key']);
					$keyn = $keyn[1];

					$allFields = unserialize($field['meta_value']);
				}
			}
		} else {
			while($field = $fields->fetch(PDO::FETCH_ASSOC)){
				$keyn = explode('_', $field['meta_key']);
				$keyn = $keyn[1];
				$allFields = unserialize($field['meta_value']);
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
		<h1>COBRA</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">COBRA</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<?php $curremp = getEmployee($_GET['id']); ?>
						<i class="fa fa-user"></i> <h3 class="box-title"><?=ucwords($curremp['fname']).' '.ucwords($curremp['lname'])?></h3>
						<!-- tools box -->
						<div class="pull-right box-tools">
							<a href="<?=(isset($_GET['id'])) ? '/hrms/admin/employee-benefits.php?id='.$_GET['id'] : $_SERVER['HTTP_REFERER']?>" class="btn btn-primary">Go Back</a>
							<!-- <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button> -->
						</div>
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<form id="ben-links" name="ben_links" method="post" action="" class="benefit-steps">	
						  	<input type="hidden" name="formtype" value="benefit-cobra">
							<?php if($role == 'super-admin') { ?>
								<!-- <div class="form-group">
									<label>Company</label>
									<select name="company" class="sel-company form-control" required>
										<option value="">Select Company</option>
										<?php foreach($companyArray as $id=>$company){ ?>
											<option value="<?=$id?>"><?=$company?></option>
										<?php } ?>
									</select>
								</div> -->
							<?php } ?>
							<div class="form-group" style="display: none;">
								<label>Employee</label>
								<select name="emp" class="ar-employee form-control" required>
									<option value="">Select Employee</option>
									<?php foreach($userArray as $id=>$user){ ?>
										<option value="<?=$id?>" <?=($id==$_GET['id'])?'selected="selected"':''?>><?=$user?></option>
									<?php } ?>
								</select>
							</div>
						  	<div class="form-group">
						  		<label><?=$allFields['bname']['title']?></label>
						  		<input type="text" name="bname" class="form-control " value="<?=(isset($data))?$data['name']:''?>">
						  	</div>
						  	<div class="form-group">
						  		<label><?=$allFields['dependent']['title']?></label>
						  		<select name="dependent" class="form-control">
						  			<option value="Yes" <?=(isset($data) && $data['dependent']=="Yes")?'seleceted="seleceted"':''?>>Yes</option>
						  			<option value="No" <?=(isset($data) && $data['dependent']=="No")?'seleceted="seleceted"':''?>>No</option>
						  		</select>
						  	</div>
						  	<div class="form-group">
						  		<label><?=$allFields['doe']['title']?></label>
						  		<input type="text" name="doe" class="form-control datepicker " readonly  value="<?=(isset($data))?$data['doe']:''?>">
						  	</div>
						  	<div class="form-group">
						  		<label><?=$allFields['reason']['title']?></label>
						  		<input type="text" name="reason" class="form-control "  value="<?=(isset($data))?$data['reason']:''?>">
						  	</div>
						  	<div class="form-group">
						  		<label><?=$allFields['datesent']['title']?></label>
						  		<input type="text" name="datesent" class="form-control datepicker " readonly  value="<?=(isset($data))?$data['datesent']:''?>">
						  	</div>
						  	<div class="form-group">
						  		<label><?=$allFields['status']['title']?></label>
						  		<input type="text" name="status" class="form-control "  value="<?=(isset($data))?$data['status']:''?>">
						  	</div>
						  	<div class="form-group">
						  		<label><?=$allFields['statusdt']['title']?></label>
						  		<input type="text" name="statusdt" class="form-control datepicker" readonly  value="<?=(isset($data))?$data['statusdt']:''?>">
						  	</div>
						  	<div class="form-group">
						  		<input type="submit" value="Save" class="btn btn-primary " />
						  	</div>			  	
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>

<?php include_once('admin-footer.php'); ?>