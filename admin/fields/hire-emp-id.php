<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_hire_emp';
	} else {
		$key = 'default_hire_emp';
	}
	$defaultKey = 'default_hire_emp';

	$object = new myconn;

	try{
		$con = $object->connection();
		$fields = $con->prepare('SELECT * from fields_data where meta_key=:key');
		$fields->bindParam(':key', $key);
		$fields->execute();
		$count = $fields->rowCount();
		if($count==0) {
			$con = $obj3->connection();
			$fields = $con->prepare('SELECT * from fields_data where meta_key=:key');
			$fields->bindParam(':key', $defaultKey);
			$fields->execute();
			$count = $fields->rowCount();
			if($count){
				$field = $fields->fetch(PDO::FETCH_BOTH);
				$hempField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$hempField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="hire-emp-form">
	<div class="form-group">
		<label>Legal Entity</label>
		<input class="form-control" type="text" name="legal[title]" placeholder="Title" value="<?=$hempField['legal']['title']?>">
		<textarea class="form-control" name="legal[options]" placeholder="Dropdown (separated by comma)"><?=$hempField['legal']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Permission Group</label>
		<input class="form-control" type="text" name="permission[title]" placeholder="Title" value="<?=$hempField['permission']['title']?>">
		<textarea class="form-control" name="permission[options]" placeholder="Dropdown (separated by comma)"><?=$hempField['permission']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Pay Period Schedule</label>
		<input class="form-control" type="text" name="pay_schedule[title]" placeholder="Title" value="<?=$hempField['pay_schedule']['title']?>">
		<textarea class="form-control" name="pay_schedule[options]" placeholder="Dropdown (separated by comma)"><?=$hempField['pay_schedule']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Policy Group</label>
		<input class="form-control" type="text" name="policy[title]" placeholder="Title" value="<?=$hempField['policy']['title']?>">
		<textarea class="form-control" name="policy[options]" placeholder="Dropdown (separated by comma)"><?=$hempField['policy']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Currency</label>
		<input class="form-control" type="text" name="currency[title]" placeholder="Title" value="<?=$hempField['currency']['title']?>">
		<textarea class="form-control" name="currency[options]" placeholder="Dropdown (separated by comma)"><?=$hempField['currency']['options']?></textarea>
	</div>
	
	<div class="form-group">
		<label>Title</label>
		<input class="form-control" type="text" name="title[title]" placeholder="Title" value="<?=$hempField['title']['title']?>">
		<textarea class="form-control" name="title[options]" placeholder="Dropdown (separated by comma)"><?=$hempField['title']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Employee Number</label>
		<input class="form-control" type="text" name="empNo[title]" placeholder="Title" value="<?=$hempField['empNo']['title']?>">
	</div>
	<div class="form-group">
		<label>Hire Date</label>
		<input class="form-control" type="text" name="hireDt[title]" placeholder="Title" value="<?=$hempField['hireDt']['title']?>">
	</div>
	<div class="form-group">
		<label>Default Branch</label>
		<input class="form-control" type="text" name="branch[title]" placeholder="Title" value="<?=$hempField['branch']['title']?>">
		<textarea class="form-control" name="branch[options]" placeholder="Dropdown (separated by comma)"><?=$hempField['branch']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Default Department</label>
		<input class="form-control" type="text" name="department[title]" placeholder="Title" value="<?=$hempField['department']['title']?>">
		<textarea class="form-control" name="department[options]" placeholder="Dropdown (separated by comma)"><?=$hempField['department']['options']?></textarea>
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>

</form>