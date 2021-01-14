<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_hire_contact';
	} else {
		$key = 'default_hire_contact';
	}
	$defaultKey = 'default_hire_contact';

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
				$hconField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$hconField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="hire-con-form">
	<div class="form-group">
		<label>City</label>
		<input class="form-control" type="text" name="city[title]" placeholder="Title" value="<?=$hconField['city']['title']?>">
	</div>
	<div class="form-group">
		<label>Country</label>
		<input class="form-control" type="text" name="country[title]" placeholder="Title" value="<?=$hconField['country']['title']?>">
		<textarea class="form-control" name="country[options]" placeholder="Dropdown (separated by comma)"><?=$hconField['country']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Province/State</label>
		<input class="form-control" type="text" name="state[title]" placeholder="Title" value="<?=$hconField['state']['title']?>">
		<textarea class="form-control" name="state[options]" placeholder="Dropdown (separated by comma)"><?=$hconField['state']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Work Phone</label>
		<input class="form-control" type="text" name="workphn[title]" placeholder="Title" value="<?=$hconField['workphn']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Phone Ext</label>
		<input class="form-control" type="text" name="workphnext[title]" placeholder="Title" value="<?=$hconField['workphnext']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Email</label>
		<input class="form-control" type="text" name="wemail[title]" placeholder="Title" value="<?=$hconField['wemail']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" value="Update Fields">
	</div>
</form>