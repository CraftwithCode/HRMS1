<?php
	$key = $defaultKey = $allFields = '';
	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_hire_contact';
	} else {
		$key = 'default_hire_contact';
	}
	$defaultKey = 'default_hire_contact';

	$object = new myconn;
	try {
		
		$con = $object->connection();
		$type = 'hire-contact';
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

<form id="contactinfo" name="contactinfo" method="post" action="" enctype="multipart/form-data" class="hire-steps">
	<input type="hidden" name="formtype" value="hire-contact">
	<div class="form-group">
		<label><?=$allFields['city']['title']?></label>
		<input type="text" name="city" class="form-control" value="<?=$empdata['city']?>">
	</div>
	<div class="form-group">
		<label><?=$allFields['country']['title']?></label>
		<?php $countryoption = explode(',', $allFields['country']['options']); ?>
  		<select name="country" class="form-control">
  			<?php foreach($countryoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['country']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>			  				
  			<?php } ?>
  		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['state']['title']?></label>
		<?php $stateoption = explode(',', $allFields['state']['options']); ?>
  		<select name="state" class="form-control">
  			<?php foreach($stateoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['state']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>			  				
  			<?php } ?>
  		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['workphn']['title']?></label>
		<input type="text" name="workphn" class="form-control" value="<?=$empdata['workphn']?>">
	</div>
	<div class="form-group">
		<label><?=$allFields['workphnext']['title']?></label>
		<input type="text" name="workphnext" class="form-control" value="<?=$empdata['workphnext']?>">
	</div>
	<div class="form-group">
		<label><?=$allFields['wemail']['title']?></label>
		<input type="email" name="wemail" class="form-control" value="<?=$empdata['wemail']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Save" class="btn btn-primary">
	</div>				
</form>