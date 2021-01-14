<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_education';
	} else {
		$key = 'default_education';
	}
	$defaultKey = 'default_education';

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
				$eduField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$eduField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="education-form">
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$eduField['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Course</label>
		<input type="text" name="course[title]" placeholder="Title" value="<?=$eduField['course']['title']?>" class="form-control">
		<!-- <textarea name="course[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$eduField['course']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Institute</label>
		<input type="text" class="form-control" name="inst[title]" placeholder="Title" value="<?=$eduField['inst']['title']?>">
	</div>
	<div class="form-group">
		<label>Major/Specialization</label>
		<input type="text" name="major[title]" class="form-control" placeholder="Title" value="<?=$eduField['major']['title']?>">
	</div>
	<div class="form-group">
		<label>Minor</label>
		<input type="text" name="minor[title]" class="form-control" placeholder="Title" value="<?=$eduField['minor']['title']?>">
	</div>
	<div class="form-group">
		<label>Graduation Date</label>
		<input type="text" name="graddt[title]" class="form-control" placeholder="Title" value="<?=$eduField['graddt']['title']?>">
	</div>
	<div class="form-group">
		<label>Grade Score</label>
		<input type="text" name="grade[title]" class="form-control" placeholder="Title" value="<?=$eduField['grade']['title']?>">
	</div>
	<div class="form-group">
		<label>Start Date</label>
		<input type="text" name="startdt[title]" class="form-control" placeholder="Title" value="<?=$eduField['startdt']['title']?>">
	</div>
	<div class="form-group">
		<label>End Date</label>
		<input type="text" name="enddt[title]" class="form-control" placeholder="Title" value="<?=$eduField['enddt']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>

</form>