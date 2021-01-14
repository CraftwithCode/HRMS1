<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_skill';
	} else {
		$key = 'default_skill';
	}
	$defaultKey = 'default_skill';

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
				$skillField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$skillField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="skill-form">
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$skillField['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Skill</label>
		<input type="text" name="skill[title]" placeholder="Title" value="<?=$skillField['skill']['title']?>" class="form-control">
		<textarea name="skill[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$skillField['skill']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Proficiency</label>
		<input type="text" class="form-control" name="proficiency[title]" placeholder="Title" value="<?=$skillField['proficiency']['title']?>">
		<textarea name="proficiency[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$skillField['proficiency']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>First Used Date</label>
		<input type="text" name="firstdt[title]" class="form-control" placeholder="Title" value="<?=$skillField['firstdt']['title']?>">
	</div>
	<div class="form-group">
		<label>Last Used Date</label>
		<input type="text" name="lastdt[title]" class="form-control" placeholder="Title" value="<?=$skillField['lastdt']['title']?>">
	</div>
	<div class="form-group">
		<label>Years Experience</label>
		<input type="text" name="exp[title]" class="form-control" placeholder="Title" value="<?=$skillField['exp']['title']?>">
	</div>
	<div class="form-group">
		<label>Expiry Date</label>
		<input type="text" name="expdt[title]" class="form-control" placeholder="Title" value="<?=$skillField['expdt']['title']?>">
	</div>
	<div class="form-group">
		<label>Description</label>
		<input type="text" name="desc[title]" class="form-control" placeholder="Title" value="<?=$skillField['desc']['title']?>">
	</div>
	<div class="form-group">
		<label>Tags</label>
		<input type="text" name="tags[title]" class="form-control" placeholder="Title" value="<?=$skillField['tags']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>

</form>