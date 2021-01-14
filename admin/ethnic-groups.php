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

		
	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$key = $defaultKey = $allFields = '';

	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_ethnic';
	} else {
		$key = 'default_ethnic';
	}
	$defaultKey = 'default_ethnic';

	$object = new myconn;
	try {
		// $empdata=[];
		$con = $object->connection();
		if(isset($_GET['edit'])){
			$edit = $_GET['edit'];
			$emp = $con->prepare('SELECT * from ethnic_groups where id=:edit');
			$emp->bindParam(':edit',$edit);
			$emp->execute();
			$empcount= $emp->rowCount();
			if($empcount){
				$data = $emp->fetch(PDO::FETCH_ASSOC);
				$empdata = $data;
				
				// var_dump($empdata);
			}
		}
		// $employee = $conn1->prepare('Select * from employee');
		// // $employee->bindParam(':empid', $empid);
		// $employee->execute();
		// $empcount = $employee->rowCount();
		// if($empcount == 0){
		// 	die('<h3>Employees not exist</h3>');
		// } else {
		// 	if(isset($_GET['id'])){
		// 		$empid = $_GET['id'];
		// 	} elseif(isset($_GET['edit'])){
		// 		$empid = $empdata['emp_id'];
		// 	}
		// 	$emp_select[] = '<option value="">-None-</option>';
		// 	while($getemp = $employee->fetch(PDO::FETCH_ASSOC)){
		// 		$selected = ($empid == $getemp['id']) ? 'selected="selected"' : '';
		// 		$emp_select[] = '<option value="'.$getemp['id'].'" '.$selected.'>'.$getemp['fname'].'|'.$getemp['lname'].'|'.$getemp['status'].'</option>';
		// 	}
		// 	$emp_select = implode('', $emp_select);
		// }
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
		<h1>Ethnic Groups</h1>
		<ol class="breadcrumb">
			<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
			<!-- <li><a href="https://terraorb.xyz/hrms/admin/"> Contacts</a></li> -->
			<li class="active">Ethnic Groups</li>
		</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Ethnic Groups</h3>
						<!-- tools box -->
						<div class="pull-right box-tools">
							<a href="<?='/hrms/admin/manage-ethnic-groups.php'?>" class="btn btn-primary">Go Back</a>
							<!-- <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button> -->
						</div>
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<div class="col-sm-12">
							<form id="ethnic-groups" name="ethnic_groups" method="post" action="" class="ethnic-groups ar-forms">
								<input type="hidden" name="formtype" value="ethnic-groups">
								<div class="form-group" <?=($_SESSION['main']['role']!='super-admin')?'style="display:none;"':''?>>
									<label>Company</label>
									<?php if($_SESSION['main']['role']=='super-admin'){ ?>
										<select name="company" class="form-control" >
											<option value="">Select Company</option>
											<?php 
												if(isset($groupArray)){
													foreach($groupArray as $key=>$value){ ?>
														<?php $selected = ($key==$empdata['company'])?'selected="selected"':'' ;?>
														<option value="<?=$key?>" <?=$selected?>><?=$value?></option>
														<?php 
													}
												}else { ?>
													<option></option>
											<?php } ?>
										</select>
									<?php } else { ?>
										<input type="hidden" name="company" value="<?=$_SESSION['main']['gid']?>">
									<?php } ?>
								</div>
								<div class="form-group">
									<label><?=$allFields['name']['title']?></label>
									<input type="text" name="sname" class="form-control" value="<?=$empdata['name']?>">
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