<form method="post" id="">
	<input type="hidden" name="formType" value="emp-form">
	<div class="form-group">
		<label>Company</label>
		<input type="text" class="form-control" name="company[title]" placeholder="Title" value="<?=$empField['company']['title']?>">
	</div>
	<div class="form-group">
		<label>Legal Entity</label>
		<input type="text" class="form-control" name="legal[title]" placeholder="Title" value="<?=$empField['legal']['title']?>">
		<textarea name="legal[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['legal']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Status</label>
		<input type="text" class="form-control" name="status[title]" placeholder="Title" value="<?=$empField['status']['title']?>">
		<textarea name="status[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['status']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Permission Group</label>
		<input type="text" class="form-control" name="permission[title]" placeholder="Title" value="<?=$empField['permission']['title']?>">
		<textarea name="permission[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['permission']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Pay Period Schedule</label>
		<input type="text" class="form-control" name="pay_schedule[title]" placeholder="Title" value="<?=$empField['pay_schedule']['title']?>">
		<textarea name="pay_schedule[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['pay_schedule']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Policy Group</label>
		<input type="text" name="policy[title]" class="form-control" placeholder="Title" value="<?=$empField['policy']['title']?>">
		<textarea name="policy[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['policy']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Currency</label>
		<input type="text" class="form-control" name="currency[title]" placeholder="Title" value="<?=$empField['currency']['title']?>">
		<textarea name="currency[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['currency']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Username</label>
		<input type="text" name="username[title]" class="form-control" placeholder="Title" value="<?=$empField['username']['title']?>">
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type="text" name="password[title]" class="form-control" placeholder="Title" value="<?=$empField['password']['title']?>">
	</div>
	<div class="form-group">
		<label>Confirm Password</label>
		<input type="text" name="cpassword[title]" class="form-control" placeholder="Title" value="<?=$empField['cpassword']['title']?>">
	</div>
	<div class="form-group">
		<label>Employee Number</label>
		<input type="text" name="empNo[title]" class="form-control" placeholder="Title" value="<?=$empField['empNo']['title']?>">
	</div>
	<div class="form-group">
		<label>Title</label>
		<input type="text" name="title[title]" class="form-control" placeholder="Title" value="<?=$empField['title']['title']?>">
		<textarea name="title[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['title']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>First Name</label>
		<input type="text" name="firstName[title]" class="form-control" placeholder="Title" value="<?=$empField['firstName']['title']?>">
	</div>
	<div class="form-group">
		<label>Last Name</label>
		<input type="text" name="lastName[title]" class="form-control" placeholder="Title" value="<?=$empField['lastName']['title']?>">
	</div>
	<div class="form-group">
		<label>Quick Punch Id</label>
		<input type="text" name="punchId[title]" class="form-control" placeholder="Title" value="<?=$empField['punchId']['title']?>">
	</div>
	<div class="form-group">
		<label>Quick Punch Password</label>
		<input type="text" name="punchPassword[title]" class="form-control" placeholder="Title" value="<?=$empField['punchPassword']['title']?>">
	</div>
	<div class="form-group">
		<label>Default Branch</label>
		<input type="text" name="branch[title]" class="form-control" placeholder="Title" value="<?=$empField['branch']['title']?>">
		<textarea name="branch[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['branch']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Default Department</label>
		<input type="text" name="department[title]" class="form-control" placeholder="Title" value="<?=$empField['department']['title']?>">
		<textarea name="department[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['department']['options']?></textarea>
	</div>
	<div class="form-group">
		<label>Group</label>
		<input type="text" name="group[title]" class="form-control" placeholder="Title" value="<?=$empField['group']['title']?>">
		<!-- <textarea name="group[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['group']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Ethnicity</label>
		<input type="text" name="ethnicity[title]" class="form-control" placeholder="Title" value="<?=$empField['ethnicity']['title']?>">
		<!-- <textarea name="ethnicity[options]" class="form-control" placeholder="Dropdown (separated by comma)"><?=$empField['ethnicity']['options']?></textarea> -->
	</div>
	<div class="form-group">
		<label>Hire Date</label>
		<input type="text" name="hireDt[title]" class="form-control" placeholder="Title" value="<?=$empField['hireDt']['title']?>">
	</div>
	<div class="form-group">
		<label>Termination Date</label>
		<input type="text" name="terminationDt[title]" class="form-control" placeholder="Title" value="<?=$empField['terminationDt']['title']?>">
	</div>
	<div class="form-group">
		<label>Tags</label>
		<input type="text" name="tags[title]" class="form-control" placeholder="Title" value="<?=$empField['tags']['title']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Update Fields" class="btn btn-primary">
	</div>

</form>