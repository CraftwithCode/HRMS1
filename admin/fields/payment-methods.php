<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_pay_methods';
	} else {
		$key = 'default_pay_methods';
	}
	$defaultKey = 'default_pay_methods';

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
				$payField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$payField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<form method="post" id="">
	<input type="hidden" name="formType" value="pay-methods-form">
	<div class="form-group">
		<label>Legal Entity</label>
		<input type="text" name="legal[title]" placeholder="Title" value="<?=$payField['legal']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$payField['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Status</label>
		<input class="form-control" type="text" name="status[title]" placeholder="Title" value="<?=$payField['status']['title']?>">
		<textarea class="form-control" name="status[options]" placeholder="Dropdown (separated by comma)"><?=$payField['status']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Name</label>
		<input class="form-control" type="text" name="name[title]" placeholder="Title" value="<?=$payField['name']['title']?>">
	</div>
	<div class="form-group">
		<label>Account Number</label>
		<input class="form-control" type="text" name="accno[title]" placeholder="Title" value="<?=$payField['accno']['title']?>">
	</div>
	<div class="form-group">
		<label>Routing Number</label>
		<input class="form-control" type="text" name="routing[title]" placeholder="Title" value="<?=$payField['routing']['title']?>">
	</div>
	<div class="form-group">
		<label>Description</label>
		<input class="form-control" type="text" name="desc[title]" placeholder="Title" value="<?=$payField['desc']['title']?>">
	</div>
	<div class="form-group">
		<label>Type</label>
		<input class="form-control" type="text" name="type[title]" placeholder="Title" value="<?=$payField['type']['title']?>">
		<textarea class="form-control" name="type[options]" placeholder="Dropdown (separated by comma)"><?=$payField['type']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Remittance Source Account</label>
		<input class="form-control" type="text" name="account[title]" placeholder="Title" value="<?=$payField['account']['title']?>">
		<textarea class="form-control" name="account[options]" placeholder="Dropdown (separated by comma)"><?=$payField['account']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Priority</label>
		<input class="form-control" type="text" name="priority[title]" placeholder="Title" value="<?=$payField['priority']['title']?>">
		<textarea class="form-control" name="priority[options]" placeholder="Dropdown (separated by comma)"><?=$payField['priority']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Amount Type</label>
		<input class="form-control" type="text" name="amt_type[title]" placeholder="Title" value="<?=$payField['amt_type']['title']?>">
		<textarea class="form-control" name="amt_type[options]" placeholder="Dropdown (separated by comma)"><?=$payField['amt_type']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Percent</label>
		<input class="form-control" type="text" name="percent[title]" placeholder="Title" value="<?=$payField['percent']['title']?>">
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Update Fields">
	</div>
</form>