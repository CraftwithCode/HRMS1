<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_pto';
	} else {
		$key = 'default_pto';
	}
	$defaultKey = 'default_pto';

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
				$ptoField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_ASSOC);
			$ptoField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="pto-form">
	<div class="form-group">
		<label>Plan</label>
		<input type="text" name="plan[title]" placeholder="Title" value="<?=$ptoField['plan']['title']?>" class="form-control">
		<textarea name="plan[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$ptoField['plan']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Earned</label>
		<input type="text" name="earned[title]" placeholder="Title" value="<?=$ptoField['earned']['title']?>" class="form-control">
		<!-- <textarea name="course[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$ptoField['course']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Processed</label>
		<input type="text" class="form-control" name="processed[title]" placeholder="Title" value="<?=$ptoField['processed']['title']?>">
	</div>
	<div class="form-group">
		<label>Available</label>
		<input type="text" name="available[title]" class="form-control" placeholder="Title" value="<?=$ptoField['available']['title']?>">
	</div>
	<div class="form-group">
		<label>Last</label>
		<input type="text" name="last[title]" class="form-control" placeholder="Title" value="<?=$ptoField['last']['title']?>">
	</div>
	<div class="form-group">
		<label>Unprocessed Approved</label>
		<input type="text" name="unp[title]" class="form-control" placeholder="Title" value="<?=$ptoField['unp']['title']?>">
	</div>
	<div class="form-group">
		<label>Estimated Total Plan</label>
		<input type="text" name="total[title]" class="form-control" placeholder="Title" value="<?=$ptoField['total']['title']?>">
	</div>
	<div class="form-group">
		<label>Earned Through</label>
		<input type="text" name="earnth[title]" class="form-control" placeholder="Title" value="<?=$ptoField['earnth']['title']?>">
	</div>
	<div class="form-group">
		<label>Reset Date</label>
		<input type="text" name="reset[title]" class="form-control" placeholder="Title" value="<?=$ptoField['reset']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>

</form>