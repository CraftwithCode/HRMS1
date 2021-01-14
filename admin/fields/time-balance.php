<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_timebalance';
	} else {
		$key = 'default_timebalance';
	}
	$defaultKey = 'default_timebalance';

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
				$timebalance = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_ASSOC);
			$timebalance = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<form method="post" id="">
	<input type="hidden" name="formType" value="timebalance-form">
	<!-- <div class="form-group">
		<label>Company</label>
		<input type="text" name="company[title]" placeholder="Title" value="<?=$timebalance['company']['title']?>" class="form-control">
	</div> -->
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$timebalance['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Accrual Account</label>
		<input class="form-control" type="text" name="account[title]" placeholder="Title" value="<?=$timebalance['account']['title']?>">
		<textarea class="form-control" name="account[options]" placeholder="Dropdown (separated by comma)"><?=$timebalance['account']['options']?></textarea>
	</div>
	<!-- <div class="form-group">
		<label>Type</label>
		<input class="form-control" type="text" name="type[title]" placeholder="Title" value="<?=$timebalance['type']['title']?>">
		<textarea class="form-control" name="type[options]" placeholder="Dropdown (separated by comma)"><?=$timebalance['type']['options']?></textarea>
	</div> -->
	<div class="form-group">
		<label>Balance</label>
		<input class="form-control" type="text" name="balance[title]" placeholder="Title" value="<?=$timebalance['balance']['title']?>">
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Update Fields">
	</div>
</form>