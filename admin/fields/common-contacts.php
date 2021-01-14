<?php
	if(isset($_SESSION['gid'])){
		$key = $_SESSION['gid'].'_comcontact';
	} else {
		$key = 'default_comcontact';
	}
	$defaultKey = 'default_comcontact';

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
				$comcontField = unserialize($field['meta_value']);
			}
		} else {
			$field = $fields->fetch(PDO::FETCH_BOTH);
			$comcontField = unserialize($field['meta_value']);
		}
	} catch (PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<form method="post" id="">
	<input type="hidden" name="formType" value="common-contact-form">
	<div class="form-group">
		<label>Employee</label>
		<input type="text" name="employee[title]" placeholder="Title" value="<?=$comcontField['employee']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Status</label>
		<input class="form-control" type="text" name="status[title]" placeholder="Title" value="<?=$comcontField['status']['title']?>">
		<textarea class="form-control" name="status[options]" placeholder="Dropdown (separated by comma)"><?=$comcontField['status']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Type</label>
		<input class="form-control" type="text" name="type[title]" placeholder="Title" value="<?=$comcontField['type']['title']?>">
		<textarea class="form-control" name="type[options]" placeholder="Dropdown (separated by comma)"><?=$comcontField['type']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>First Name</label>
		<input class="form-control" type="text" name="fname[title]" placeholder="Title" value="<?=$comcontField['fname']['title']?>">
	</div>
	<div class="form-group">
		<label>Middle Name</label>
		<input class="form-control" type="text" name="mname[title]" placeholder="Title" value="<?=$comcontField['mname']['title']?>">
	</div>
	<div class="form-group">
		<label>Last Name</label>
		<input class="form-control" type="text" name="lname[title]" placeholder="Title" value="<?=$comcontField['lname']['title']?>">
	</div>
	<div class="form-group">
		<label>Gender</label>
		<input class="form-control" type="text" name="gender[title]" placeholder="Title" value="<?=$comcontField['gender']['title']?>">
		<textarea class="form-control" name="gender[options]" placeholder="Dropdown (separated by comma)"><?=$comcontField['gender']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Ethnicity</label>
		<input class="form-control" type="text" name="ethnicity[title]" placeholder="Title" value="<?=$comcontField['ethnicity']['title']?>">
		<!-- <textarea class="form-control" name="ethnicity[options]" placeholder="Dropdown (separated by comma)"><?=$comcontField['ethnicity']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Home Address(Line 1)</label>
		<input class="form-control" type="text" name="address1[title]" placeholder="Title" value="<?=$comcontField['address1']['title']?>">
	</div>
	<div class="form-group">
		<label>Home Address(Line 2)</label>
		<input class="form-control" type="text" name="address2[title]" placeholder="Title" value="<?=$comcontField['address2']['title']?>">
	</div>
	<div class="form-group">
		<label>City</label>
		<input class="form-control" type="text" name="city[title]" placeholder="Title" value="<?=$comcontField['city']['title']?>">
	</div>
	<div class="form-group">
		<label>Country</label>
		<input class="form-control" type="text" name="country[title]" placeholder="Title" value="<?=$comcontField['country']['title']?>">
		<textarea class="form-control" name="country[options]" placeholder="Dropdown (separated by comma)"><?=$comcontField['country']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Province/State</label>
		<input class="form-control" type="text" name="state[title]" placeholder="Title" value="<?=$comcontField['state']['title']?>">
		<textarea class="form-control" name="state[options]" placeholder="Dropdown (separated by comma)"><?=$comcontField['state']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Postal/ZIP Code</label>
		<input class="form-control" type="text" name="zip[title]" placeholder="Title" value="<?=$comcontField['zip']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Phone</label>
		<input class="form-control" type="text" name="workphn[title]" placeholder="Title" value="<?=$comcontField['workphn']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Phone Ext</label>
		<input class="form-control" type="text" name="workphnext[title]" placeholder="Title" value="<?=$comcontField['workphnext']['title']?>">
	</div>
	<div class="form-group">
		<label>Home Phone</label>
		<input class="form-control" type="text" name="homephn[title]" placeholder="Title" value="<?=$comcontField['homephn']['title']?>">
	</div>
	<div class="form-group">
		<label>Mobile Phone</label>
		<input class="form-control" type="text" name="mobphn[title]" placeholder="Title" value="<?=$comcontField['mobphn']['title']?>">
	</div>
	<div class="form-group">
		<label>Fax</label>
		<input class="form-control" type="text" name="fax[title]" placeholder="Title" value="<?=$comcontField['fax']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Email</label>
		<input class="form-control" type="text" name="wemail[title]" placeholder="Title" value="<?=$comcontField['wemail']['title']?>">
	</div>
	<div class="form-group">
		<label>Home Email</label>
		<input class="form-control" type="text" name="hemail[title]" placeholder="Title" value="<?=$comcontField['hemail']['title']?>">
	</div>
	<div class="form-group">
		<label>Birth Date</label>
		<input class="form-control" type="text" name="dob[title]" placeholder="Title" value="<?=$comcontField['dob']['title']?>">
	</div>
	<div class="form-group">
		<label>SIN/SSN</label>
		<input class="form-control" type="text" name="ssn[title]" placeholder="Title" value="<?=$comcontField['ssn']['title']?>">
	</div>
	<div class="form-group">
		<label>Note</label>
		<input class="form-control" type="text" name="note[title]" placeholder="Title" value="<?=$comcontField['note']['title']?>">
	</div>
	<div class="form-group">
		<label>Tags</label>
		<input class="form-control" type="text" name="tags[title]" placeholder="Title" value="<?=$comcontField['tags']['title']?>">
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Update Fields">
	</div>
</form>