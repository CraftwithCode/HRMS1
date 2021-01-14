<?php
	$key = $defaultKey = $allFields = '';
	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_hire_preferences';
	} else {
		$key = 'default_hire_preferences';
	}
	$defaultKey = 'default_hire_preferences';

	$object = new myconn;
	try {
		
		$con = $object->connection();
		$type = 'hire-preferences';
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
		// var_dump($allFields);
		// $empField = $allfields['employee'];
		// $coninfoField = $allfields['contactinfo'];
		// $conField = $allfields['contact'];

	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>

<form id="preference" name="preference" method="post" action="" enctype="multipart/form-data" class="hire-steps">
	<input type="hidden" name="formtype" value="hire-preferences">
	
	<div class="form-group">
		<label><?=$allFields['lang']['title']?></label>
		<?php $langoption = explode(',', $allFields['lang']['options']); ?>
  		<select name="lang" class="form-control">
  			<?php foreach($langoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['lang']==$key)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>			  				
  			<?php } ?>
  		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['date']['title']?></label>
		<?php $dateoption = explode(',', $allFields['date']['options']); ?>
  		<select name="date" class="form-control">
  			<?php foreach($dateoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['date']==$key)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>			  				
  			<?php } ?>
  		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['time']['title']?></label>
		<?php $timeoption = explode(',', $allFields['time']['options']); ?>
  		<select name="time" class="form-control">
  			<?php foreach($timeoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['time']==$key)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>			  				
  			<?php } ?>
  		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['timeu']['title']?></label>
		<?php $timeuoption = explode(',', $allFields['timeu']['options']); ?>
  		<select name="timeu" class="form-control">
  			<?php foreach($timeuoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['timeu']==$key)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>			  				
  			<?php } ?>
  		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['distance']['title']?></label>
		<?php $distanceoption = explode(',', $allFields['distance']['options']); ?>
  		<select name="distance" class="form-control">
  			<?php foreach($distanceoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['distance']==$key)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>			  				
  			<?php } ?>
  		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['zone']['title']?></label>
		<?php $zoneoption = explode(',', $allFields['zone']['options']); ?>
  		<select name="zone" class="form-control">
  			<?php foreach($zoneoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['zone']==$key)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>			  				
  			<?php } ?>
  		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['calendar']['title']?></label>
		<?php $calendaroption = explode(',', $allFields['calendar']['options']); ?>
  		<select name="timeu" class="form-control">
  			<?php foreach($calendaroption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['calendar']==$key)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>			  				
  			<?php } ?>
  		</select>
	</div>
	<div class="form-group">
		<label><?=$allFields['rows']['title']?></label>
		<input type="text" name="rows" class="form-control" value="<?=$empdata['rows']?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Save" class="btn btn-primary">
	</div>				
</form>