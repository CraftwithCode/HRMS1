<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_review';
	} else {
		$key = 'default_review';
	}
	$defaultKey = 'default_review';

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
				$revField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$revField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="review-form">
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$revField['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Reviewer</label>
		<input type="text" name="reviewer[title]" placeholder="Title" value="<?=$revField['reviewer']['title']?>" class="form-control">
		<!-- <textarea name="skill[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$revField['skill']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Status</label>
		<input type="text" class="form-control" name="status[title]" placeholder="Title" value="<?=$revField['status']['title']?>">
		<textarea name="status[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$revField['status']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Type</label>
		<input type="text" name="type[title]" class="form-control" placeholder="Title" value="<?=$revField['type']['title']?>">
		<textarea name="type[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$revField['type']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Terms</label>
		<input type="text" name="terms[title]" class="form-control" placeholder="Title" value="<?=$revField['terms']['title']?>">
	</div>
	<div class="form-group">
		<label>Rating</label>
		<input type="text" name="rating[title]" class="form-control" placeholder="Title" value="<?=$revField['rating']['title']?>">
	</div>
	<div class="form-group">
		<label>Notes</label>
		<input type="text" name="notes[title]" class="form-control" placeholder="Title" value="<?=$revField['notes']['title']?>">
	</div>
	<div class="form-group">
		<label>Add KPI's from Group</label>
		<input type="text" name="kpi[title]" class="form-control" placeholder="Title" value="<?=$revField['kpi']['title']?>">
	</div>
	<div class="form-group">
		<label>Severity</label>
		<input type="text" name="severity[title]" class="form-control" placeholder="Title" value="<?=$revField['severity']['title']?>">
		<textarea name="severity[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$revField['severity']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Start Date</label>
		<input type="text" name="startdt[title]" class="form-control" placeholder="Title" value="<?=$revField['startdt']['title']?>">
	</div>
	<div class="form-group">
		<label>End Date</label>
		<input type="text" name="enddt[title]" class="form-control" placeholder="Title" value="<?=$revField['enddt']['title']?>">
	</div>
	<div class="form-group">
		<label>Due Date</label>
		<input type="text" name="duedt[title]" class="form-control" placeholder="Title" value="<?=$revField['duedt']['title']?>">
	</div>
	<div class="form-group">
		<label>Tags</label>
		<input type="text" name="tag[title]" class="form-control" placeholder="Title" value="<?=$revField['tag']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>

</form>