<?php
	$key = $defaultKey = $allFields = '';
	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_employee';
	} else {
		$key = 'default_employee';
	}
	$defaultKey = 'default_employee';	

	$object = new myconn;
	try {

		$con = $object->connection();
    if(isset($_GET['id'])){
      $empid = $_GET['id'];
      $emp = $con->prepare('SELECT * from employee where id=:empid');
      $emp->bindParam(':empid',$empid);
      $emp->execute();
      $empcount= $emp->rowCount();
      if($empcount){
        $empdata = $emp->fetch(PDO::FETCH_ASSOC);
        // var_dump($empdata);
      }
    }
    if($_SESSION['main']['role']=='group-admin'){
      $gid = $_SESSION['main']['gid'];
      $groups = $con->prepare('SELECT * FROM `groups` where company = :company');
      $groups->bindParam(':company', $gid);
    }elseif(isset($_GET['id'])){
      $id = $_GET['id'];
      $groups = $con->prepare('SELECT * FROM `groups` where company = (Select groupid from employee where id=:empid)');
      $groups->bindParam(':empid', $id);
    } else {
      $groups = $con->prepare('SELECT * FROM `groups`');
    }
    $groups->execute();
    $groupcount = $groups->rowCount();
    if($groupcount){
      $groupArr = [];
      while($group = $groups->fetch(PDO::FETCH_ASSOC)){
        $groupArr[$group['id']] = $group['name'];
      }
    }

    if($_SESSION['main']['role']=='group-admin'){
      $gid = $_SESSION['main']['gid'];
      $ethgroups = $con->prepare('SELECT * FROM `ethnic_groups` where company = :company');
      $ethgroups->bindParam(':company', $gid);
    }elseif(isset($_GET['id'])){
      $id = $_GET['id'];
      $ethgroups = $con->prepare('SELECT * FROM `ethnic_groups` where company = (Select groupid from employee where id=:empid)');
      $ethgroups->bindParam(':empid', $id);
    } else {
      $ethgroups = $con->prepare('SELECT * FROM `ethnic_groups`');
    }
    $ethgroups->execute();
    $ethgroupcount = $ethgroups->rowCount();
    // var_dump($ethgroupcount);
    if($ethgroupcount){
      $ethgroupArr = [];
      while($ethgroup = $ethgroups->fetch(PDO::FETCH_ASSOC)){
        $ethgroupArr[$ethgroup['id']] = $ethgroup['name'];
      }
    }
		
		$fields = $con->prepare('SELECT * from fields_data where meta_key IN (:key)');
		$fields->bindParam(':key', $key);
		$fields->execute();
		$count = $fields->rowCount();
		if($count == 0) {
			$con = $object->connection();
			$fields = $con->prepare('SELECT * from fields_data where meta_key IN (:key)');
			$fields->bindParam(':key', $defaultKey);
			$fields->execute();
			$count = $fields->rowCount();
			if($count){
				while($field = $fields->fetch(PDO::FETCH_ASSOC)){
					$keyn = explode('_', $field['meta_key']);
					$keyn = $keyn[1];

					$allFields = unserialize($field['meta_value']);
				}
			}
		} else {
			while($field = $fields->fetch(PDO::FETCH_ASSOC)){
				$keyn = explode('_', $field['meta_key']);
				$keyn = $keyn[1];
				$allFields = unserialize($field['meta_value']);
			}
		}

		// $empField = $allfields['employee'];
		// $coninfoField = $allfields['contactinfo'];
		// $conField = $allfields['contact'];

	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
  
?>

<form id="employee" name="employee" method="post" action="" class="emp-steps emp_step_1">	
  <input type="hidden" name="formtype" value="employee">
	<div class="form-group">		
		<?php if($_SESSION['main']['role'] == 'super-admin'){ ?>
			<label><?=$allFields['company']['title']?></label>
			<select name="company" required class="form-control sel-company">
				<option value="">Select Company</option>
				<?php foreach($groupArray as $key=>$g) { ?>
					<option value="<?=$key?>" <?=($empdata['groupid']==$key)?'selected="selected"':''?>><?=$g?></option>
				<?php } ?>
			</select>
		<?php } else { ?>
			<input type="hidden" name="company" class="form-control" value="<?=$_SESSION['main']['gid']?>">
		<?php } ?>				
  	</div>
  	<!-- <div class="form-group">
  		<label><?=$allFields['legal']['title']?></label>
  		<?php $legaloption = explode(',', $allFields['legal']['options']); ?>
  		<select name="legal" class="form-control">
  			<?php foreach($legaloption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['legal']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  				
  			<?php } ?>
  		</select>
  	</div> -->
  	<div class="form-group">
  		<label><?=$allFields['status']['title']?></label>
  		<?php $statusoption = explode(',', $allFields['status']['options']); ?>
  		<select name="status" class="form-control">
  			<?php foreach($statusoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['status']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['permission']['title']?></label>
  		<?php $permissionoption = explode(',', $allFields['permission']['options']); ?>
  		<select name="permission" class="form-control">
  			<?php foreach($permissionoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['permission']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['pay_schedule']['title']?></label>
  		<?php $pay_scheduleoption = explode(',', $allFields['pay_schedule']['options']); ?>
  		<select name="pay_schedule" class="form-control">
  			<?php foreach($pay_scheduleoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['pay_schedule']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['policy']['title']?></label>
  		<?php $policyoption = explode(',', $allFields['policy']['options']); ?>
  		<select name="policy" class="form-control">
  			<?php foreach($policyoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['policy']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['currency']['title']?></label>
  		<?php $currencyoption = explode(',', $allFields['currency']['options']); ?>
  		<select name="currency" class="form-control">
  			<?php foreach($currencyoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['currency']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['username']['title']?></label>
  		<input type="email" name="username" class="form-control" value="<?=$empdata['username']?>" <?=(isset($empdata))?'readonly':''?>>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['password']['title']?></label>
  		<input type="password" name="password" class="form-control" <?=(isset($empdata))?'readonly':''?>>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['cpassword']['title']?></label>
  		<input type="password" name="cpassword" class="form-control" <?=(isset($empdata))?'readonly':''?>>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['empNo']['title']?></label>
  		<input type="number" name="empno" class="form-control" value="<?=$empdata['emp_no']?>">
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['title']['title']?></label>
  		<?php $titleoption = explode(',', $allFields['title']['options']); ?>
  		<select name="title" class="form-control">
  			<?php foreach($titleoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['title']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['firstName']['title']?></label>
  		<input type="text" name="fname" class="form-control" value="<?=$empdata['fname']?>">
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['lastName']['title']?></label>
  		<input type="text" name="lname" class="form-control" value="<?=$empdata['lname']?>">
  	</div>
  	<!-- <div class="form-group">
  		<label><?=$allFields['punchId']['title']?></label>
  		<input type="text" name="punchid" class="form-control" value="<?=$empdata['punchid']?>">
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['punchPassword']['title']?></label>
  		<input type="password" name="punchpassword" class="form-control" value="" <?=(isset($empdata))?'readonly':''?>>
  	</div> -->
  	<div class="form-group">
  		<label><?=$allFields['branch']['title']?></label>
  		<?php $branchoption = explode(',', $allFields['branch']['options']); ?>
  		<select name="branch" class="form-control">
  			<?php foreach($branchoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['branch']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['department']['title']?></label>
  		<?php $departmentoption = explode(',', $allFields['department']['options']); ?>
  		<select name="department" class="form-control">
  			<?php foreach($departmentoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['department']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['group']['title']?></label>
  		<?php //$groupoption = explode(',', $allFields['group']['options']); ?>
  		<select name="group" class="form-control ar-group">
  			<?php foreach($groupArr as $key=>$option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$key?>" <?=($empdata['groupcol']==$key)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['ethnicity']['title']?></label>
  		<?php //$ethnicityoption = explode(',', $allFields['ethnicity']['options']); ?>
  		<select name="ethnicity" class="form-control ar-ethnic">
  			<?php foreach($ethgroupArr as $key=>$option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$key?>" <?=($empdata['ethnicity']==$key)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>
  			<?php } ?>
  		</select>
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['hireDt']['title']?></label>
  		<input name="hireDt" type="text" id="" size="30" placeholder="dd-mm-yyyy" class="form-control datepicker" value="<?=$empdata['hiredt']?>" />
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['terminationDt']['title']?></label>
  		<input name="terminationDt" type="text" id="" placeholder="dd-mm-yyyy" size="30" class="form-control datepicker" value="<?=$empdata['terminationdt']?>" />
  	</div>
  	<div class="form-group">
  		<label><?=$allFields['tags']['title']?></label>
  		<input name="tags" type="text" class="form-control" value="<?=$empdata['tags']?>" />
  	</div>


  	<input type="hidden" name="role" value="employee">
  	<div class="form-group">
  		<input type="submit" value="Save" class="btn btn-primary " />
  	</div>			  	
</form>