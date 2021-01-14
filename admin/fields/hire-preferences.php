<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_hire_preferences';
	} else {
		$key = 'default_hire_preferences';
	}
	$defaultKey = 'default_hire_preferences';

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
				$hpreField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$hpreField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="hire-preferences-form">
	<div class="form-group">
		<label>Language</label>
		<input type="text" name="lang[title]" placeholder="Title" value="<?=$hpreField['lang']['title']?>" class="form-control">
		<textarea class="form-control" name="lang[options]" placeholder="Dropdown (separated by comma)"><?=$hpreField['lang']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Date Format</label>
		<input class="form-control" type="text" name="date[title]" placeholder="Title" value="<?=$hpreField['date']['title']?>">
		<textarea class="form-control" name="date[options]" placeholder="Dropdown (separated by comma)"><?=$hpreField['date']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Time Format</label>
		<input class="form-control" type="text" name="time[title]" placeholder="Title" value="<?=$hpreField['time']['title']?>">
		<textarea class="form-control" name="time[options]" placeholder="Dropdown (separated by comma)"><?=$hpreField['time']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Time Units</label>
		<input class="form-control" type="text" name="timeu[title]" placeholder="Title" value="<?=$hpreField['timeu']['title']?>">
		<textarea class="form-control" name="timeu[options]" placeholder="Dropdown (separated by comma)"><?=$hpreField['timeu']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Distance Units</label>
		<input class="form-control" type="text" name="distance[title]" placeholder="Title" value="<?=$hpreField['distance']['title']?>">
		<textarea class="form-control" name="distance[options]" placeholder="Dropdown (separated by comma)"><?=$hpreField['distance']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Time Zone</label>
		<input class="form-control" type="text" name="zone[title]" placeholder="Title" value="<?=$hpreField['zone']['title']?>">
		<textarea class="form-control" name="zone[options]" placeholder="Dropdown (separated by comma)"><?=$hpreField['zone']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Calendar Starts On</label>
		<input class="form-control" type="text" name="calendar[title]" placeholder="Title" value="<?=$hpreField['calendar']['title']?>">
		<textarea class="form-control" name="calendar[options]" placeholder="Dropdown (separated by comma)"><?=$hpreField['calendar']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Rows per page</label>
		<input class="form-control" type="text" name="rows[title]" placeholder="Title" value="<?=$hpreField['rows']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>
</form>