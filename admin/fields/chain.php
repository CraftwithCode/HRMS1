<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_chain';
	} else {
		$key = 'default_chain';
	}
	$defaultKey = 'default_chain';

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
				$chainField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$chainField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="chain-form">
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$chainField['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Group</label>
		<input type="text" name="group[title]" placeholder="Title" value="<?=$chainField['group']['title']?>" class="form-control">		
	</div>
	<div class="form-group">
		<label>Supervisor</label>
		<input type="text" class="form-control" name="supervisor[title]" placeholder="Title" value="<?=$chainField['supervisor']['title']?>">
	</div>
	<div class="form-group">
		<label>Manager</label>
		<input type="text" name="manager[title]" class="form-control" placeholder="Title" value="<?=$chainField['manager']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>
</form>