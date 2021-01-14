<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_timeexception';
	} else {
		$key = 'default_timeexception';
	}
	$defaultKey = 'default_timeexception';

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
				$field = $fields->fetch(PDO::FETCH_ASSOC);
				$timeexception = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_ASSOC);
			$timeexception = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<form method="post" id="">
	<input type="hidden" name="formType" value="timeexception-form">
	<!-- <div class="form-group">
		<label>Company</label>
		<input type="text" name="company[title]" placeholder="Title" value="<?=$timeexception['company']['title']?>" class="form-control">
	</div> -->
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$timeexception['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Date</label>
		<input class="form-control" type="text" name="date[title]" placeholder="Title" value="<?=$timeexception['date']['title']?>">
	</div>
	<div class="form-group">
		<label>Severity</label>
		<input class="form-control" type="text" name="severity[title]" placeholder="Title" value="<?=$timeexception['severity']['title']?>">
	</div>
	<div class="form-group">
		<label>Exception</label>
		<input class="form-control" type="text" name="exp[title]" placeholder="Title" value="<?=$timeexception['exp']['title']?>">
	</div>
	<div class="form-group">
		<label>Code</label>
		<input class="form-control" type="text" name="code[title]" placeholder="Title" value="<?=$timeexception['code']['title']?>">
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Update Fields">
	</div>
</form>