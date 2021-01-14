<?php
	$key = $defaultKey = $allFields = '';

	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_chain';
	} else {
		$key = 'default_chain';
	}
	$defaultKey = 'default_chain';

	$object = new myconn;
	try {

		$con = $object->connection();
	    if(isset($_GET['id'])){
			$empid = $_GET['id'];
			$emp = $con->prepare('SELECT * from emp_chain where emp_id=:empid');
			$emp->bindParam(':empid',$empid);
			$emp->execute();
			$empcount= $emp->rowCount();
			if($empcount){
				$empdata = $emp->fetch(PDO::FETCH_ASSOC);
				// var_dump($empdata);
			}
	    }
		
		// $con = $object->connection();
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
		if(isset($_GET['id'])) {
			$employee = $conn1->prepare('Select * from employee where id <> :empid and groupid = (Select groupid from employee where id=:empid)');
			$employee->bindParam(':empid',$empid);
			// $employee->bindParam(':gid',$gid);
		} else {
			$employee = $conn1->prepare('Select * from employee');
		}
		$employee->execute();
		$empcount = $employee->rowCount();
		if($empcount == 0){
			// die('<h3>Employees not exist</h3>');
		} else {
			while($getemp = $employee->fetch(PDO::FETCH_ASSOC)){
				// $selected = ($empid == $getemp['id'])?'selected="selected"':'';
				$allemp[] = $getemp;
			}			
		}
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$groups = $con->prepare('SELECT * FROM `groups` where company = (Select groupid from employee where id=:empid)');
			$groups->bindParam(':empid', $id);
		} else {
			$groups = $con->prepare('SELECT * FROM `groups`');
		}
	    $groups->execute();
	    $groupcount = $groups->rowCount();
	    if($groupcount){
			$groupArr = [];
			while($group = $groups->fetch(PDO::FETCH_ASSOC)){
				$groupArr[$group['id']] = $group['name'];
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
<form id="chain" name="chain" method="post" action="" class="emp-steps emp_step_3">
	<input type="hidden" name="formtype" value="chain">
	<div class="form-group" >
		<label><?=$allFields['employee']['title']?></label>
		<select name="employee" class="form-control" disabled>
			<?php if(isset($emp_select)){ echo $emp_select;}else { ?>
				<option></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['group']['title']?></label>
		<select name="group" class="form-control">
  			<?php foreach($groupArr as $key=>$option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$key?>" <?=($empdata['groupid']==$key)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>		
  		</select>
	</div>
	<div class="form-group" >
		<label><?=$allFields['manager']['title']?></label>
		<select name="manager" class="form-control">
			<?php if(isset($allemp)){ 
				foreach($allemp as $all){ 
  					$selected = (isset($empdata) && $all['id']==$empdata['manager'])?'selected="selected"':''; ?>
  					<option value="<?=$all['id']?>" <?=$selected?>><?=$all['fname'].'|'.$all['lname'].'|'.$all['status']?></option>
  				<?php }
			}else { ?>
				<option></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['supervisor']['title']?></label>
		<select name="supervisor" class="form-control">
  			<?php if(isset($allemp)){ 
  				foreach($allemp as $all){ 
  					$selected = (isset($empdata) && $all['id']==$empdata['supervisor'])?'selected="selected"':''; ?>
  					<option value="<?=$all['id']?>" <?=$selected?>><?=$all['fname'].'|'.$all['lname'].'|'.$all['status']?></option>
  				<?php }
  			}else { ?>
				<option></option>
			<?php } ?>
  		</select>
	</div>
	<div class="form-group">
		<input type="submit" value="Save" class="btn btn-primary">
	</div>
</form>