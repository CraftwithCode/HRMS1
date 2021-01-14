<form method="post" id="">
	<input type="hidden" name="formType" value="contact-info-form">
	<div class="form-group">
		<label>Photo</label>
		<input type="text" name="photo[title]" placeholder="Title" value="<?=$conField['photo']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>First Name</label>
		<input type="text" name="fname[title]" placeholder="Title" value="<?=$conField['fname']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Middle Name</label>
		<input type="text" name="mname[title]" placeholder="Title" value="<?=$conField['mname']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Last Name</label>
		<input type="text" name="lname[title]" placeholder="Title" value="<?=$conField['lname']['title']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Gender</label>
		<input type="text" name="gender[title]" placeholder="Title" value="<?=$conField['gender']['title']?>" class="form-control">
		<textarea name="gender[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$conField['gender']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Home Address(Line 1)</label>
		<input type="text" name="address1[title]" class="form-control" placeholder="Title" value="<?=$conField['address1']['title']?>">
	</div>
	<div class="form-group">
		<label>Home Address(Line 2)</label>
		<input type="text" name="address2[title]" class="form-control" placeholder="Title" value="<?=$conField['address2']['title']?>">
	</div>
	<div class="form-group">
		<label>City</label>
		<input type="text" name="city[title]" class="form-control" placeholder="Title" value="<?=$conField['city']['title']?>">
	</div>
	<div class="form-group">
		<label>Country</label>
		<input type="text" name="country[title]" class="form-control" placeholder="Title" value="<?=$conField['country']['title']?>">
		<textarea name="country[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$conField['country']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Province/State</label>
		<input type="text" class="form-control" name="state[title]" placeholder="Title" value="<?=$conField['state']['title']?>">
		<textarea name="state[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$conField['state']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Postal/ZIP Code</label>
		<input type="text" name="zip[title]" class="form-control" placeholder="Title" value="<?=$conField['zip']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Phone</label>
		<input type="text" name="workphn[title]" class="form-control" placeholder="Title" value="<?=$conField['workphn']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Phone Ext</label>
		<input type="text" name="workphnext[title]" class="form-control" placeholder="Title" value="<?=$conField['workphnext']['title']?>">
	</div>
	<div class="form-group">
		<label>Home Phone</label>
		<input type="text" name="homephn[title]" class="form-control" placeholder="Title" value="<?=$conField['homephn']['title']?>">
	</div>
	<div class="form-group">
		<label>Mobile Phone</label>
		<input type="text" name="mobphn[title]" class="form-control" placeholder="Title" value="<?=$conField['mobphn']['title']?>">
	</div>
	<div class="form-group">
		<label>Fax</label>
		<input type="text" name="fax[title]" class="form-control" placeholder="Title" value="<?=$conField['fax']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Email</label>
		<input type="text" name="wemail[title]" class="form-control" placeholder="Title" value="<?=$conField['wemail']['title']?>">
	</div>
	<div class="form-group">
		<label>Home Email</label>
		<input type="text" name="hemail[title]" class="form-control" placeholder="Title" value="<?=$conField['hemail']['title']?>">
	</div>
	<div class="form-group">
		<label>Birth Date</label>
		<input type="text" name="dob[title]" class="form-control" placeholder="Title" value="<?=$conField['dob']['title']?>">
	</div>
	<div class="form-group">
		<label>SIN/SSN</label>
		<input type="text" name="ssn[title]" class="form-control" placeholder="Title" value="<?=$conField['ssn']['title']?>">
	</div>
	<div class="form-group">
		<label>Note</label>
		<input type="text" name="note[title]" class="form-control" placeholder="Title" value="<?=$conField['note']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>
</form>