<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_cobra';
	} else {
		$key = 'default_cobra';
	}
	$defaultKey = 'default_cobra';

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
				$cobraField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$cobraField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="cobra-form">
	<div class="form-group">
		<label>Name</label>
		<input type="text" name="bname[title]" placeholder="Title" value="<?=$cobraField['bname']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Dependent</label>
		<input type="text" name="dependent[title]" placeholder="Title" value="<?=$cobraField['dependent']['title']?>" class="form-control">
		<!-- <textarea name="course[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$cobraField['course']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Date Of Event</label>
		<input type="text" class="form-control" name="doe[title]" placeholder="Title" value="<?=$cobraField['doe']['title']?>">
	</div>
	<div class="form-group">
		<label>Reason</label>
		<input type="text" name="reason[title]" class="form-control" placeholder="Title" value="<?=$cobraField['reason']['title']?>">
	</div>
	<div class="form-group">
		<label>Date Letter Sent</label>
		<input type="text" name="datesent[title]" class="form-control" placeholder="Title" value="<?=$cobraField['datesent']['title']?>">
	</div>
	<div class="form-group">
		<label>COBRA Status</label>
		<input type="text" name="status[title]" class="form-control" placeholder="Title" value="<?=$cobraField['status']['title']?>">
	</div>
	<div class="form-group">
		<label>Status Date</label>
		<input type="text" name="statusdt[title]" class="form-control" placeholder="Title" value="<?=$cobraField['statusdt']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>

</form>