<?php
	$key = $defaultKey = $allFields = '';
	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_hire_emp';
	} else {
		$key = 'default_hire_emp';
	}
	$defaultKey = 'default_hire_emp';	

	$object = new myconn;
	try {
		$con = $object->connection();
		$type = 'hire-employee';
		$emp = $con->prepare('SELECT * from hire_defaults where type=:type');
		$emp->bindParam(':type',$type);
		$emp->execute();
		$empcount= $emp->rowCount();
		if($empcount){
			$empdata = $emp->fetch(PDO::FETCH_ASSOC);
			$empdata = unserialize($empdata['options']);
			// var_dump($empdata);
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

<form id="employee" name="employee" method="post" action="" class="hire-steps">	
  	<input type="hidden" name="formtype" value="hire-employee">
	<div class="form-group">
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
		<label><?=$allFields['empNo']['title']?></label>
		<input type="number" name="empno" class="form-control" value="<?=$empdata['empno']?>">
	</div>
  <div class="form-group">
    <label><?=$allFields['hireDt']['title']?></label>
    <input name="hireDt" type="text" id="" size="30" placeholder="dd-mm-yyyy" class="form-control datepicker" value="<?=$empdata['hireDt']?>" />
  </div>
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
		<input type="submit" value="Save" class="btn btn-primary " />
	</div>			  	
</form>