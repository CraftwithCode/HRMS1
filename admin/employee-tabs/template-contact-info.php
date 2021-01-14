<?php
	$key = $defaultKey = $allFields = '';
	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_contactinfo';
	} else {
		$key = 'default_contactinfo';
	}
	$defaultKey = 'default_contactinfo';

	$object = new myconn;
	try {
		
		$con = $object->connection();
		if(isset($_GET['id'])){
			$empid = $_GET['id'];
			$emp = $con->prepare('SELECT * from emp_contact_info where emp_id=:empid');
			$emp->bindParam(':empid',$empid);
			$emp->execute();
			$empcount= $emp->rowCount();
			if($empcount){
				$empdata = $emp->fetch(PDO::FETCH_ASSOC);
				// var_dump($empdata);
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

		// $empField = $allfields['employee'];
		// $coninfoField = $allfields['contactinfo'];
		// $conField = $allfields['contact'];

	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form id="contactinfo" name="contactinfo" method="post" action="" enctype="multipart/form-data" class="emp-steps emp_step_2">
	<input type="hidden" name="formtype" value="contactinfo">
	<div class="form-group">
		<label><?=$allFields['photo']['title']?></label>
		<input type="file" name="pic" class="form-control">
		<img src="<?=($empdata['pic'])?'/hrms/uploads/'.$empdata['pic']:'#'?>" id="display-img" style="width: 75px;height: auto; <?=($empdata['pic'])?'':'display: none;'?>">
	</div>

	<div class="form-group">
		<label><?=$allFields['fname']['title']?></label>
		<input type="text" name="fname" class="form-control" value="<?=$empdata['first_name']?>" required>
	</div>
	<div class="form-group">
		<label><?=$allFields['mname']['title']?></label>
		<input type="text" name="mname" class="form-control" value="<?=$empdata['middle_name']?>">
	</div>
	<div class="form-group">
		<label><?=$allFields['lname']['title']?></label>
		<input type="text" name="lname" class="form-control" value="<?=$empdata['last_name']?>">
	</div>
	<div class="form-group">
		<label><?=$allFields['gender']['title']?></label>
		<?php $genderoption = explode(',', $allFields['gender']['options']); ?>
  		<select name="gender" class="form-control">
  			<?php foreach($genderoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['gender']==$option)?'selected="selected"':''?>><?=$option?></option>
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
  					<option value="<?=$option?>" <?=($empdata['country']==$option)?'selected="selected"':''?>><?=$option?></option>
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
  					<option value="<?=$option?>" <?=($empdata['state']==$option)?'selected="selected"':''?>><?=$option?></option>
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
		<input type="text" name="workphn" class="form-control" value="<?=$empdata['work_phone']?>">
	</div>
	<div class="form-group">
		<label><?=$allFields['workphnext']['title']?></label>
		<input type="text" name="workphnext" class="form-control" value="<?=$empdata['work_phn_ext']?>">
	</div>
	<div class="form-group">
		<label><?=$allFields['homephn']['title']?></label>
		<input type="text" name="homephn" class="form-control" value="<?=$empdata['homephone']?>">
	</div>
	<div class="form-group">
		<label><?=$allFields['mobphn']['title']?></label>
		<input type="text" name="mobphn" class="form-control" value="<?=$empdata['mobphone']?>">
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
		<input type="text" name="note" class="form-control" value="<?=$empdata['note']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Save" class="btn btn-primary">
	</div>				
</form>