<form method="post" id="">
	<input type="hidden" name="formType" value="contact-form">
	<div class="form-group">
		<label>Employee</label>
		<input type="text" class="form-control" name="employee[title]" placeholder="Title" value="<?=$contField['employee']['title']?>">
		<!-- <textarea class="form-control" name="employee[options]" placeholder="Dropdown (separated by comma)"><?=$contField['employee']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Status</label>
		<input type="text" class="form-control" name="status[title]" placeholder="Title" value="<?=$contField['status']['title']?>">
		<textarea name="status[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$contField['status']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Type</label>
		<input type="text" class="form-control" name="type[title]" placeholder="Title" value="<?=$contField['type']['title']?>">
		<textarea name="type[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$contField['type']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>First Name</label>
		<input type="text" name="fname[title]" class="form-control" placeholder="Title" value="<?=$contField['fname']['title']?>">
	</div>
	<div class="form-group">
		<label>Middle Name</label>
		<input type="text" name="mname[title]" class="form-control" placeholder="Title" value="<?=$contField['mname']['title']?>">
	</div>
	<div class="form-group">
		<label>Last Name</label>
		<input type="text" name="lname[title]" class="form-control" placeholder="Title" value="<?=$contField['lname']['title']?>">
	</div>
	<div class="form-group">
		<label>Gender</label>
		<input type="text" name="gender[title]" class="form-control" placeholder="Title" value="<?=$contField['gender']['title']?>">
		<textarea name="gender[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$contField['gender']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Ethnicity</label>
		<input type="text" name="ethnicity[title]" class="form-control" placeholder="Title" value="<?=$contField['ethnicity']['title']?>">
		<!-- <textarea name="ethnicity[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$contField['ethnicity']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Home Address(Line 1)</label>
		<input type="text" name="address1[title]" class="form-control" placeholder="Title" value="<?=$contField['address1']['title']?>">
	</div>
	<div class="form-group">
		<label>Home Address(Line 2)</label>
		<input type="text" name="address2[title]" class="form-control" placeholder="Title" value="<?=$contField['address2']['title']?>">
	</div>
	<div class="form-group">
		<label>City</label>
		<input type="text" name="city[title]" class="form-control" placeholder="Title" value="<?=$contField['city']['title']?>">
	</div>
	<div class="form-group">
		<label>Country</label>
		<input type="text" name="country[title]" class="form-control" placeholder="Title" value="<?=$contField['country']['title']?>">
		<textarea name="country[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$contField['country']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Province/State</label>
		<input type="text" name="state[title]" class="form-control" placeholder="Title" value="<?=$contField['state']['title']?>">
		<textarea name="state[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$contField['state']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Postal/ZIP Code</label>
		<input type="text" name="zip[title]" class="form-control" placeholder="Title" value="<?=$contField['zip']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Phone</label>
		<input type="text" name="workphn[title]" class="form-control" placeholder="Title" value="<?=$contField['workphn']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Phone Ext</label>
		<input type="text" name="workphnext[title]" class="form-control" placeholder="Title" value="<?=$contField['workphnext']['title']?>">
	</div>
	<div class="form-group">
		<label>Home Phone</label>
		<input type="text" name="homephn[title]" class="form-control" placeholder="Title" value="<?=$contField['homephn']['title']?>">
	</div>
	<div class="form-group">
		<label>Mobile Phone</label>
		<input type="text" name="mobphn[title]" class="form-control" placeholder="Title" value="<?=$contField['mobphn']['title']?>">
	</div>
	<div class="form-group">
		<label>Fax</label>
		<input type="text" name="fax[title]" class="form-control" placeholder="Title" value="<?=$contField['fax']['title']?>">
	</div>
	<div class="form-group">
		<label>Work Email</label>
		<input type="text" name="wemail[title]" class="form-control" placeholder="Title" value="<?=$contField['wemail']['title']?>">
	</div>
	<div class="form-group">
		<label>Home Email</label>
		<input type="text" name="hemail[title]" class="form-control" placeholder="Title" value="<?=$contField['hemail']['title']?>">
	</div>
	<div class="form-group">
		<label>Birth Date</label>
		<input type="text" name="dob[title]" class="form-control" placeholder="Title" value="<?=$contField['dob']['title']?>">
	</div>
	<div class="form-group">
		<label>SIN/SSN</label>
		<input type="text" name="ssn[title]" class="form-control" placeholder="Title" value="<?=$contField['ssn']['title']?>">
	</div>
	<div class="form-group">
		<label>Note</label>
		<input type="text" name="note[title]" class="form-control" placeholder="Title" value="<?=$contField['note']['title']?>">
	</div>
	<div class="form-group">
		<label>Tags</label>
		<input type="text" name="tags[title]" class="form-control" placeholder="Title" value="<?=$contField['tags']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="form-control">
	</div>
</form>