<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_wages';
	} else {
		$key = 'default_wages';
	}
	$defaultKey = 'default_wages';

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
				$wageField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$wageField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<form method="post" id="">
	<input type="hidden" name="formType" value="wages-form">
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$wageField['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Wage Group</label>
		<input class="form-control" type="text" name="wageg[title]" placeholder="Title" value="<?=$wageField['wageg']['title']?>">
		<textarea class="form-control" name="wageg[options]" placeholder="Dropdown (separated by comma)"><?=$wageField['wageg']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Type</label>
		<input class="form-control" type="text" name="type[title]" placeholder="Title" value="<?=$wageField['type']['title']?>">
		<textarea class="form-control" name="type[options]" placeholder="Dropdown (separated by comma)"><?=$wageField['type']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Wage</label>
		<input class="form-control" type="text" name="wage[title]" placeholder="Title" value="<?=$wageField['wage']['title']?>">
	</div>
	<div class="form-group">
		<label>Labor Burden Percent</label>
		<input class="form-control" type="text" name="labor[title]" placeholder="Title" value="<?=$wageField['labor']['title']?>">
	</div>
	<div class="form-group">
		<label>Effective Date</label>
		<input class="form-control" type="text" name="eff[title]" placeholder="Title" value="<?=$wageField['eff']['title']?>">
	</div>
	<div class="form-group">
		<label>Note</label>
		<input class="form-control" type="text" name="note[title]" placeholder="Title" value="<?=$wageField['note']['title']?>">
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Update Fields">
	</div>
</form>