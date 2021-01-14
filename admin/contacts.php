<?php
	include('../includes/connection.php');
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);
	if(!isset($_SESSION['main']['uname'])){
		header('Location: ../index.php');
	}
	$previous = explode('/', $_SERVER['HTTP_REFERER']);
	// var_dump($previous[count($previous)-1]);
	if($previous[count($previous)-1] == 'employee-contacts.php'){
		$commonContact = true;
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
		$key = $_SESSION['main']['gid'].'_contact';
	} else {
		$key = 'default_contact';
	}
	$defaultKey = 'default_contact';

	$object = new myconn;
	try {
		// $empdata=[];
		$con = $object->connection();
		if(isset($_GET['edit'])){
			$edit = $_GET['edit'];

			$emp = $con->prepare('SELECT * from emp_contacts where id=:edit');
			$emp->bindParam(':edit',$edit);
			$emp->execute();
			$empcount= $emp->rowCount();
			if($empcount){
				$data = $emp->fetch(PDO::FETCH_ASSOC);
				$empdata = $data;
				
				// var_dump($empdata);
			}
		}
		if($_SESSION['main']['role']=='group-admin'){
			$gid = $_SESSION['main']['gid'];
			$ethgroups = $con->prepare('SELECT * FROM `ethnic_groups` where company = :company');
			$ethgroups->bindParam(':company', $gid);
		}elseif(isset($_GET['id'])){
			$id = $_GET['id'];
			$ethgroups = $con->prepare('SELECT * FROM `ethnic_groups` where company = (Select groupid from employee where id=:empid)');
			$ethgroups->bindParam(':empid', $id);
		}elseif(isset($_GET['edit'])){
			$id = $empdata['company'];
			$ethgroups = $con->prepare('SELECT * FROM `ethnic_groups` where company = :company');
			$ethgroups->bindParam(':company', $id);
		} else {
			$ethgroups = $con->prepare('SELECT * FROM `ethnic_groups`');
		}
	    $ethgroups->execute();
	    $ethgroupcount = $ethgroups->rowCount();
	    if($ethgroupcount){
			$ethnicityoption = [];
			while($ethgroup = $ethgroups->fetch(PDO::FETCH_ASSOC)){
				$ethnicityoption[$ethgroup['id']] = $ethgroup['name'];
			}
	    }
		if($_SESSION['main']['role'] == 'group-admin'){
			$gid = $_SESSION['main']['gid'];
			$employee = $conn1->prepare('Select * from employee where groupid=:gid');
			$employee->bindParam(':gid',$gid);
		}elseif(isset($_GET['edit'])){
			$id = $empdata['company'];
			$employee = $conn1->prepare('Select * from employee where groupid=:gid');
			$employee->bindParam(':gid', $id);
		} else {
			$employee = $conn1->prepare('Select * from employee');
		}
		// $employee->bindParam(':empid', $empid);
		$employee->execute();
		$empcount = $employee->rowCount();
		if($empcount == 0){
			die('<h3>Employees not exist</h3>');
		} else {
			if(isset($_GET['id'])){
				$empid = $_GET['id'];
			} elseif(isset($_GET['edit'])){
				$empid = $empdata['emp_id'];
			}
			$emp_select[] = '<option value="">-None-</option>';
			while($getemp = $employee->fetch(PDO::FETCH_ASSOC)){
				$selected = ($empid == $getemp['id']) ? 'selected="selected"' : '';
				$emp_select[] = '<option value="'.$getemp['id'].'" '.$selected.'>'.$getemp['fname'].'|'.$getemp['lname'].'|'.$getemp['status'].'</option>';
				if(isset($_GET['id']) && ($empid == $getemp['id'])){
					$companySelect = $getemp['groupid'];
				}
			}
			$emp_select = implode('', $emp_select);
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
<?php if(isset($commonContact)){ ?>
	<input type="hidden" id="ar-common-contact" value="true">
<?php } ?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Emergency Contacts</h1>
		<ol class="breadcrumb">
			<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
			<!-- <li><a href="https://terraorb.xyz/hrms/admin/"> Contacts</a></li> -->
			<li class="active">Emergency Contacts</li>
		</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Emergency Contacts</h3>
						<!-- tools box -->
						<div class="pull-right box-tools">
							<a href="<?=(isset($_GET['edit'])) ? ((isset($_GET['id']) && isset($_GET['edit'])) ? '/hrms/admin/update-employee.php?id='.$_GET['id'] : '/hrms/admin/employee-contacts.php' ) : $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Go Back</a>
							<!-- <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button> -->
						</div>
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<div class="col-sm-12">
							<form id="contact" name="contact" method="post" action="" class="emp-steps emp_step_3">
								<input type="hidden" name="formtype" value="contacts">
								<div class="form-group" <?=($_SESSION['main']['role']!='super-admin')?'style="display:none;"':''?>>
									<label>Company</label>
									<?php if($_SESSION['main']['role']=='super-admin'){ ?>
										<select name="company" class="form-control sel-company" <?=(isset($_GET['id']))?'readonly':''?> >
											<option value="">Select Company</option>
											<?php 
												if(isset($groupArray)){
													foreach($groupArray as $key=>$value){ ?>
														<?php 
															if(isset($companySelect)){
																$selected = ($key==$companySelect)?'selected="selected"':'' ;
															} else {
																$selected = ($key==$empdata['company'])?'selected="selected"':'' ;
															}
														?>
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
								<div class="form-group" >
									<label><?=$allFields['employee']['title']?></label>
									<select name="employee" class="form-control ar-employee" <?=(isset($_GET['id']))?'readonly':''?>>
										<?php if(isset($emp_select)){ echo $emp_select;}else { ?>
											<option></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label><?=$allFields['status']['title']?></label>
									<?php $statusoption = explode(',', $allFields['status']['options']); ?>
							  		<select name="status" class="form-control">
							  			<?php foreach($statusoption as $option){ ?>
							  				<?php if(empty($option)){ ?>
							  					<option value="">None</option>
							  				<?php } else { ?>
							  					<?php $selected = ($option==$empdata['status'])?'selected="selected"':'' ;?>
							  					<option value="<?=$option?>" <?=$selected?>><?=$option?></option>
							  				<?php } ?>
							  				
							  			<?php } ?>
							  		</select>
								</div>
								<div class="form-group">
									<label><?=$allFields['type']['title']?></label>
									<?php $typeoption = explode(',', $allFields['type']['options']); ?>
							  		<select name="type" class="form-control">
							  			<?php foreach($typeoption as $option){ ?>
							  				<?php if(empty($option)){ ?>
							  					<option value="">None</option>
							  				<?php } else { ?>
							  					<?php $selected = ($option==$empdata['type'])?'selected="selected"':'' ;?>
							  					<option value="<?=$option?>" <?=$selected?>><?=$option?></option>
							  				<?php } ?>
							  				
							  			<?php } ?>
							  		</select>
								</div>
								<div class="form-group">
									<label><?=$allFields['fname']['title']?></label>
									<input type="text" name="fname" class="form-control" value="<?=$empdata['fname']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['mname']['title']?></label>
									<input type="text" name="mname" class="form-control" value="<?=$empdata['mname']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['lname']['title']?></label>
									<input type="text" name="lname" class="form-control" value="<?=$empdata['lname']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['gender']['title']?></label>
									<?php $genderoption = explode(',', $allFields['gender']['options']); ?>
							  		<select name="gender" class="form-control">
							  			<?php foreach($genderoption as $option){ ?>
							  				<?php if(empty($option)){ ?>
							  					<option value="">None</option>
							  				<?php } else { ?>
							  					<?php $selected = ($option==$empdata['gender'])?'selected="selected"':'' ;?>
							  					<option value="<?=$option?>" <?=$selected?>><?=$option?></option>
							  				<?php } ?>
							  				
							  			<?php } ?>
							  		</select>
								</div>
								<div class="form-group">
									<label><?=$allFields['ethnicity']['title']?></label>
									<?php //$ethnicityoption = explode(',', $allFields['ethnicity']['options']); ?>
							  		<select name="ethnicity" class="form-control ar-ethnic">
							  			<?php foreach($ethnicityoption as $key=>$option){ ?>
							  				<?php if(empty($option)){ ?>
							  					<option value="">None</option>
							  				<?php } else { ?>
							  					<?php $selected = ($key==$empdata['ethnicity'])?'selected="selected"':'' ;?>
							  					<option value="<?=$key?>" <?=$selected?>><?=$option?></option>
							  				<?php } ?>
							  				
							  			<?php } ?>
							  		</select>
								</div>
								<div class="form-group">
									<label><?=$allFields['address1']['title']?></label>
									<input type="text" name="address1" class="form-control" value="<?=$empdata['address1']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['address2']['title']?></label>
									<input type="text" name="address2" class="form-control" value="<?=$empdata['address2']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['city']['title']?></label>
									<input type="text" name="city" class="form-control" value="<?=$empdata['city']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['country']['title']?></label>
									<?php $countryoption = explode(',', $allFields['country']['options']); ?>
							  		<select name="country" class="form-control">
							  			<?php foreach($countryoption as $option){ ?>
							  				<?php if(empty($option)){ ?>
							  					<option value="">None</option>
							  				<?php } else { ?>
							  					<?php $selected = ($option==$empdata['country'])?'selected="selected"':'' ;?>
							  					<option value="<?=$option?>" <?=$selected?>><?=$option?></option>
							  				<?php } ?>
							  				
							  			<?php } ?>
							  		</select>
								</div>
								<div class="form-group">
									<label><?=$allFields['state']['title']?></label>
									<?php $stateoption = explode(',', $allFields['state']['options']); ?>
							  		<select name="state" class="form-control">
							  			<?php foreach($stateoption as $option){ ?>
							  				<?php if(empty($option)){ ?>
							  					<option value="">None</option>
							  				<?php } else { ?>
							  					<?php $selected = ($option==$empdata['state'])?'selected="selected"':'' ;?>
							  					<option value="<?=$option?>" <?=$selected?>><?=$option?></option>
							  				<?php } ?>
							  				
							  			<?php } ?>
							  		</select>
								</div>
								<div class="form-group">
									<label><?=$allFields['zip']['title']?></label>
									<input type="number" name="zip" class="form-control" value="<?=$empdata['zip']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['workphn']['title']?></label>
									<input type="number" name="workphn" class="form-control" value="<?=$empdata['work_phn']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['workphnext']['title']?></label>
									<input type="text" name="workphnext" class="form-control" value="<?=$empdata['work_phn_ext']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['homephn']['title']?></label>
									<input type="number" name="homephn" class="form-control" value="<?=$empdata['home_phn']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['mobphn']['title']?></label>
									<input type="number" name="mobphn" class="form-control" value="<?=$empdata['mob_phn']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['fax']['title']?></label>
									<input type="text" name="fax" class="form-control" value="<?=$empdata['fax']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['wemail']['title']?></label>
									<input type="email" name="wemail" class="form-control" value="<?=$empdata['work_email']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['hemail']['title']?></label>
									<input type="email" name="hemail" class="form-control" value="<?=$empdata['home_email']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['dob']['title']?></label>
									<input type="text" name="dob" class="form-control datepicker" value="<?=$empdata['dob']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['ssn']['title']?></label>
									<input type="text" name="ssn" class="form-control" value="<?=$empdata['ssn']?>">
								</div>
								<div class="form-group">
									<label><?=$allFields['note']['title']?></label>
									<textarea name="note" class="form-control"><?=$empdata['notes']?></textarea>
								</div>
								<div class="form-group">
									<label><?=$allFields['tags']['title']?></label>
									<input type="text" name="tags" class="form-control" value="<?=$empdata['tags']?>">
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