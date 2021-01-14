<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_timeaccrual';
	} else {
		$key = 'default_timeaccrual';
	}
	$defaultKey = 'default_timeaccrual';

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
				$timeaccrual = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_ASSOC);
			$timeaccrual = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<form method="post" id="">
	<input type="hidden" name="formType" value="timeaccrual-form">
	<!-- <div class="form-group">
		<label>Company</label>
		<input type="text" name="company[title]" placeholder="Title" value="<?=$timeaccrual['company']['title']?>" class="form-control">
	</div> -->
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$timeaccrual['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Accrual Account</label>
		<input class="form-control" type="text" name="account[title]" placeholder="Title" value="<?=$timeaccrual['account']['title']?>">
		<textarea class="form-control" name="account[options]" placeholder="Dropdown (separated by comma)"><?=$timeaccrual['account']['options']?></textarea>
	</div>
	<!-- <div class="form-group">
		<label>Type</label>
		<input class="form-control" type="text" name="type[title]" placeholder="Title" value="<?=$timeaccrual['type']['title']?>">
		<textarea class="form-control" name="type[options]" placeholder="Dropdown (separated by comma)"><?=$timeaccrual['type']['options']?></textarea>
	</div> -->
	<div class="form-group">
		<label>Type</label>
		<input class="form-control" type="text" name="type[title]" placeholder="Title" value="<?=$timeaccrual['type']['title']?>">
	</div>
	<div class="form-group">
		<label>Amount</label>
		<input class="form-control" type="text" name="amount[title]" placeholder="Title" value="<?=$timeaccrual['amount']['title']?>">
	</div>
	<div class="form-group">
		<label>Date</label>
		<input class="form-control" type="text" name="date[title]" placeholder="Title" value="<?=$timeaccrual['date']['title']?>">
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Update Fields">
	</div>
</form>