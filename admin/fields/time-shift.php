<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_timeshift';
	} else {
		$key = 'default_timeshift';
	}
	$defaultKey = 'default_timeshift';

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
				$timeshift = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_ASSOC);
			$timeshift = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<form method="post" id="">
	<input type="hidden" name="formType" value="timeshift-form">
	<!-- <div class="form-group">
		<label>Company</label>
		<input type="text" name="company[title]" placeholder="Title" value="<?=$timeshift['company']['title']?>" class="form-control">
	</div> -->
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$timeshift['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Status</label>
		<input class="form-control" type="text" name="status[title]" placeholder="Title" value="<?=$timeshift['status']['title']?>">
		<textarea class="form-control" name="status[options]" placeholder="Dropdown (separated by comma)"><?=$timeshift['status']['options']?></textarea>
	</div>
	<!-- <div class="form-group">
		<label>Type</label>
		<input class="form-control" type="text" name="type[title]" placeholder="Title" value="<?=$timeshift['type']['title']?>">
		<textarea class="form-control" name="type[options]" placeholder="Dropdown (separated by comma)"><?=$timeshift['type']['options']?></textarea>
	</div> -->
	<div class="form-group">
		<label>Date</label>
		<input class="form-control" type="text" name="date[title]" placeholder="Title" value="<?=$timeshift['date']['title']?>">
	</div>
	<div class="form-group">
		<label>Start Time</label>
		<input class="form-control" type="text" name="start_time[title]" placeholder="Title" value="<?=$timeshift['start_time']['title']?>">
	</div>
	<div class="form-group">
		<label>End Time</label>
		<input class="form-control" type="text" name="end_time[title]" placeholder="Title" value="<?=$timeshift['end_time']['title']?>">
	</div>
	<div class="form-group">
		<label>Total Time</label>
		<input class="form-control" type="text" name="total[title]" placeholder="Title" value="<?=$timeshift['total']['title']?>">
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Update Fields">
	</div>
</form>