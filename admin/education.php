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
			}
		}
		$empid = $_GET['id'];
		$employee = $conn1->prepare('Select * from employee');
		// $employee->bindParam(':empid', $empid);
		$employee->execute();
		$empcount = $employee->rowCount();
		if($empcount == 0){
			die('<h3>Employees not exist</h3>');
		} else {
			while($getemp = $employee->fetch(PDO::FETCH_ASSOC)){
				$selected = ($empid == $getemp['id'])?'selected="selected"':'';
				$emp_select[] = '<option value="'.$getemp['id'].'" '.$selected.'>'.$getemp['fname'].'|'.$getemp['lname'].'|'.$getemp['status'].'</option>';
			}
			$emp_select = implode('', $emp_select);
		}
	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}


	$key = $defaultKey = $allFields = '';

	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_education';
	} else {
		$key = 'default_education';
	}
	$defaultKey = 'default_education';

	$object = new myconn;
	try {
		// $empdata=[];
		$con = $object->connection();
		if(isset($_GET['edit'])){
			$edit = $_GET['edit'];
			$emp = $con->prepare('SELECT * from emp_education where id=:edit');
			$emp->bindParam(':edit',$edit);
			$emp->execute();
			$empcount= $emp->rowCount();
			if($empcount){
				$data = $emp->fetch(PDO::FETCH_ASSOC);
				$empdata = $data;
				
				var_dump($empdata);
			}
		}
		$fields = $con->prepare('SELECT * from fields_data where meta_key IN (:key)');
		$fields->bindParam(':key', $key);
		$fields->execute();
		$count = $fields->rowCount();
		if($count == 0) {
			$con = $object->connection();
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
		// var_dump($allFields);
		// $empField = $allfields['employee'];
		// $coninfoField = $allfields['contactinfo'];
		// $conField = $allfields['contact'];

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
		<h1>Manage Education</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<!-- <li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li> -->
				<li class="active">Manage Education</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Manage Education</h3>
						<!-- tools box -->
						<div class="pull-right box-tools">
							<a href="<?=(isset($_GET['id']) && isset($_GET['edit'])) ? '/hrms/admin/update-employee.php?id='.$_GET['id'] : $_SERVER['HTTP_REFERER']?>" class="btn btn-primary">Go Back</a>
							<!-- <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button> -->
						</div>
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<div class="col-sm-12">
							<form id="education" name="education" method="post" action="" class="emp-steps emp_step_42">
								<input type="hidden" name="formtype" value="education">
								<div class="form-group" >
									<label><?=$allFields['employee']['title']?></label>
									<select name="employee" class="form-control" disabled>
										<?php if(isset($emp_select)){ echo $emp_select;}else { ?>
											<option></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label><?=$allFields['course']['title']?></label>
									<input type="text" name="course" class="form-control" value="<?=$empdata['course']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['inst']['title']?></label>
									<input type="text" name="inst" class="form-control" value="<?=$empdata['institute']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['major']['title']?></label>
									<input type="text" name="major" class="form-control" value="<?=$empdata['major']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['minor']['title']?></label>
									<input type="text" name="minor" class="form-control" value="<?=$empdata['minor']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['graddt']['title']?></label>
									<input type="text" name="graddt" class="form-control datepicker" value="<?=$empdata['graduation_date']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['grade']['title']?></label>
									<input type="text" name="grade" class="form-control" value="<?=$empdata['grade']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['startdt']['title']?></label>
									<input type="text" name="startdt" class="form-control datepicker" value="<?=$empdata['start_date']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['enddt']['title']?></label>
									<input type="text" name="enddt" class="form-control datepicker" value="<?=$empdata['end_date']?>">
								</div>
								<div class="form-group">
									<input type="submit" value="Save" class="btn btn-primary">
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