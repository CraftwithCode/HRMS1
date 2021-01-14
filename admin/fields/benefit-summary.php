<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_bsumm';
	} else {
		$key = 'default_bsumm';
	}
	$defaultKey = 'default_bsumm';

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
				$bsumField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$bsumField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form method="post" id="">
	<input type="hidden" name="formType" value="bsumm-form">
	<div class="form-group">
		<label>Benefit</label>
		<input type="text" name="benefit[title]" placeholder="Title" value="<?=$bsumField['benefit']['title']?>" class="form-control">
		<textarea name="benefit[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$bsumField['benefit']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Plan</label>
		<input type="text" name="plan[title]" placeholder="Title" value="<?=$bsumField['plan']['title']?>" class="form-control">
		<textarea name="plan[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$bsumField['plan']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Benefit Status</label>
		<input type="text" class="form-control" name="status[title]" placeholder="Title" value="<?=$bsumField['status']['title']?>">
		<textarea name="status[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$bsumField['status']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Benefit Status Start</label>
		<input type="text" name="statusstart[title]" class="form-control" placeholder="Title" value="<?=$bsumField['statusstart']['title']?>">
	</div>
	<div class="form-group">
		<label>Benefit Status Stop</label>
		<input type="text" name="statusstop[title]" class="form-control" placeholder="Title" value="<?=$bsumField['statusstop']['title']?>">
	</div>
	<div class="form-group">
		<label>Coverage</label>
		<input type="text" name="coverage[title]" class="form-control" placeholder="Title" value="<?=$bsumField['coverage']['title']?>">
		<!-- <textarea name="coverage[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$bsumField['coverage']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Coverage Start</label>
		<input type="text" name="cstart[title]" class="form-control" placeholder="Title" value="<?=$bsumField['cstart']['title']?>">
	</div>
	<div class="form-group">
		<label>Coverage Stop</label>
		<input type="text" name="cstop[title]" class="form-control" placeholder="Title" value="<?=$bsumField['cstop']['title']?>">
	</div>
	<div class="form-group">
		<label>Employee Last</label>
		<input type="text" name="emplast[title]" class="form-control" placeholder="Title" value="<?=$bsumField['emplast']['title']?>">
	</div>
	<div class="form-group">
		<label>Employee YTD</label>
		<input type="text" name="empytd[title]" class="form-control" placeholder="Title" value="<?=$bsumField['empytd']['title']?>">
	</div>
	<div class="form-group">
		<label>Employer Last</label>
		<input type="text" name="emprlast[title]" class="form-control" placeholder="Title" value="<?=$bsumField['emprlast']['title']?>">
	</div>
	<div class="form-group">
		<label>Employer YTD</label>
		<input type="text" name="emprytd[title]" class="form-control" placeholder="Title" value="<?=$bsumField['emprytd']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>

</form>