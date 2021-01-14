<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_hire_tax';
	} else {
		$key = 'default_hire_tax';
	}
	$defaultKey = 'default_hire_tax';

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
				$htaxField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$htaxField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="hire-tax-form">
	<div class="form-group">
		<label>Tax / Deductions</label>
		<input type="text" name="tax[title]" placeholder="Title" value="<?=$htaxField['tax']['title']?>" class="form-control">
		<textarea class="form-control" name="tax[options]" placeholder="Dropdown (separated by comma)"><?=$htaxField['tax']['options']?></textarea>
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>
</form>