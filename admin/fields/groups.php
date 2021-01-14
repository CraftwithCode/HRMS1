<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_groups';
	} else {
		$key = 'default_groups';
	}
	$defaultKey = 'default_groups';

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
				$groupField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$groupField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<form method="post" id="">
	<input type="hidden" name="formType" value="group-form">
	<div class="form-group">
		<label>Name</label>
		<input type="text" name="name[title]" placeholder="Title" value="<?=$groupField['name']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Update Fields">
	</div>
</form>