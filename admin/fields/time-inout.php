<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_timeinout';
	} else {
		$key = 'default_timeinout';
	}
	$defaultKey = 'default_timeinout';

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
				$timeinout = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_ASSOC);
			$timeinout = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<form method="post" id="">
	<input type="hidden" name="formType" value="timeinout-form">
	<!-- <div class="form-group">
		<label>Company</label>
		<input type="text" name="company[title]" placeholder="Title" value="<?=$timeinout['company']['title']?>" class="form-control">
	</div> -->
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$timeinout['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Time</label>
		<input class="form-control" type="text" name="time[title]" placeholder="Title" value="<?=$timeinout['time']['title']?>">
	</div>
	<div class="form-group">
		<label>Date</label>
		<input class="form-control" type="text" name="date[title]" placeholder="Title" value="<?=$timeinout['date']['title']?>">
	</div>
	<div class="form-group">
		<label>In/Out (Type)</label>
		<input class="form-control" type="text" name="type[title]" placeholder="Title" value="<?=$timeinout['type']['title']?>">
		<textarea class="form-control" name="type[options]" placeholder="Dropdown (separated by comma)"><?=$timeinout['type']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Note</label>
		<input class="form-control" type="text" name="note[title]" placeholder="Title" value="<?=$timeinout['note']['title']?>">
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Update Fields">
	</div>
</form>