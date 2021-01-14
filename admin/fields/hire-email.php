<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_hire_email';
	} else {
		$key = 'default_hire_email';
	}
	$defaultKey = 'default_hire_email';

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
				$hemailField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$hemailField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="hire-email-form">
	<div class="form-group">
		<label>Exceptions</label>
		<input type="text" name="exception[title]" placeholder="Title" value="<?=$hemailField['exception']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Messages</label>
		<input class="form-control" type="text" name="msg[title]" placeholder="Title" value="<?=$hemailField['msg']['title']?>">
	</div>
	<div class="form-group">
		<label>Pay Stubs</label>
		<input class="form-control" type="text" name="pay[title]" placeholder="Title" value="<?=$hemailField['pay']['title']?>">
	</div>
	<div class="form-group">
		<label>Send Notifications to Home Email</label>
		<input class="form-control" type="text" name="send[title]" placeholder="Title" value="<?=$hemailField['send']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>
</form>