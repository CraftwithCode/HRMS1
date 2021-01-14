<?php
	$key = $defaultKey = $allFields = '';
	if(isset($_SESSION['main']['gid'])){
		$key = $_SESSION['main']['gid'].'_hire_tax';
	} else {
		$key = 'default_hire_tax';
	}
	$defaultKey = 'default_hire_tax';

	$object = new myconn;
	try {
		
		$con = $object->connection();
		$type = 'hire-tax';
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

<form id="tax" name="tax" method="post" action="" enctype="multipart/form-data" class="hire-steps">
	<input type="hidden" name="formtype" value="hire-tax">
	
	<div class="form-group">
		<label> <?=$allFields['tax']['title']?> </label> 
		<?php $langoption = explode(',', $allFields['tax']['options']); ?>
  		<select name="tax" class="form-control">
  			<?php foreach($langoption as $option){ ?>
  				<?php if(empty($option)){ ?>
  					<option value="">None</option>
  				<?php } else { ?>
  					<option value="<?=$option?>" <?=($empdata['tax']==$option)?'selected="selected"':''?>><?=$option?></option>
  				<?php } ?>			  				
  			<?php } ?>
  		</select>
		
	</div>
	<div class="form-group">
		<input type="submit" value="Save" class="btn btn-primary">
	</div>				
</form>