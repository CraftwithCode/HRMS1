<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_dependent';
	} else {
		$key = 'default_dependent';
	}
	$defaultKey = 'default_dependent';

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
				$dependField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$dependField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="dependent-form">
	<div class="form-group">
		<label>Name</label>
		<input type="text" name="bname[title]" placeholder="Title" value="<?=$dependField['bname']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Beneficiary</label>
		<input type="text" name="beneficiary[title]" placeholder="Title" value="<?=$dependField['beneficiary']['title']?>" class="form-control">
		<!-- <textarea name="course[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$dependField['course']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Dependent</label>
		<input type="text" class="form-control" name="dependent[title]" placeholder="Title" value="<?=$dependField['dependent']['title']?>">
	</div>
	<div class="form-group">
		<label>Relationship</label>
		<input type="text" name="relation[title]" class="form-control" placeholder="Title" value="<?=$dependField['relation']['title']?>">
		<textarea name="relation[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$dependField['relation']['options']?></textarea>
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>

</form>