<?php
	// $key = $defaultKey = $allFields = '';

	// if(isset($_SESSION['gid'])){
	// 	$key = $_SESSION['gid'].'_contact';
	// } else {
	// 	$key = 'default_contact';
	// }
	// $defaultKey = 'default_contact';

	$object = new myconn;
	try {
		$empdata=[];
		$con = $object->connection();
		if(isset($_GET['id'])){
			$empid = $_GET['id'];
			$emp = $con->prepare('SELECT * from emp_contacts where emp_id=:empid');
			$emp->bindParam(':empid',$empid);
			$emp->execute();
			$empcount= $emp->rowCount();
			if($empcount){
				while($data = $emp->fetch(PDO::FETCH_ASSOC)){
					$empdata[] = $data;
				}
				// var_dump($empdata);
			}
		}
		// $fields = $con->prepare('SELECT * from fields_data where meta_key IN (:key)');
		// $fields->bindParam(':key', $key);
		// $fields->execute();
		// $count = $fields->rowCount();
		// if($count == 0) {
		// 	$con = $object->connection();
		// 	$fields = $con->prepare('SELECT * from fields_data where meta_key IN (:key)');
		// 	$fields->bindParam(':key', $defaultKey);
		// 	$fields->execute();
		// 	$count = $fields->rowCount();
		// 	if($count){
		// 		while($field = $fields->fetch(PDO::FETCH_ASSOC)){
		// 			$keyn = explode('_', $field['meta_key']);
		// 			$keyn = $keyn[1];

		// 			$allFields = unserialize($field['meta_value']);
		// 		}
		// 	}
		// } else {
		// 	while($field = $fields->fetch(PDO::FETCH_ASSOC)){
		// 		$keyn = explode('_', $field['meta_key']);
		// 		$keyn = $keyn[1];
		// 		$allFields = unserialize($field['meta_value']);
		// 	}
		// }
		// var_dump($allFields);
		// $empField = $allfields['employee'];
		// $coninfoField = $allfields['contactinfo'];
		// $conField = $allfields['contact'];

	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<div class="box">
    <div class="box-header">
     	<h3 class="box-title">Contacts</h3>
     	<div class="pull-right box-title"><a href="/hrms/admin/contacts.php<?=(isset($_GET['id']))?'?id='.$_GET["id"]:''?>" class="">Add New</a></div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
     	<table id="contact-list" class="table table-bordered table-striped ar-table">
            <thead>
				<tr>
					<th>#</th>
					<th>Type</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Home Phone</th>
				</tr>
            </thead>
            <tbody>
            	<?php $i=1; foreach($empdata as $arcon){ ?>
            		<tr>
            			<td><a href="/hrms/admin/contacts.php?id=<?=$_GET['id']?>&edit=<?=$arcon['id']?>"><?=$i?></a></td>
            			<td><?=$arcon['type']?></td>
            			<td><?=$arcon['fname']?></td>
            			<td><?=$arcon['lname']?></td>
            			<td><?=$arcon['home_phn']?></td>
            		</tr>
            	<?php $i++; } ?>
            </tbody>
            <tfoot>
				<tr>
					<th>#</th>
					<th>Type</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Home Phone</th>
				</tr>
            </tfoot>
      	</table>
    </div>
    <!-- /.box-body -->
</div>
<!-- <div class="col-sm-12">
	<form id="contact" name="contact" method="post" action="" class="emp-steps emp_step_3">
		<input type="hidden" name="formtype" value="contacts">
		<div class="form-group" >
			<label><?=$allFields['employee']['title']?></label>
			<select name="employee" class="form-control" <?=(isset($_GET['id']))?'disabled':''?>>
				<?php if(isset($emp_select)){ echo $emp_select;}else { ?>
					<option></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label><?=$allFields['status']['title']?></label>
			<?php $statusoption = explode(',', $allFields['status']['options']); ?>
	  		<select name="status" class="form-control">
	  			<?php foreach($statusoption as $option){ ?>
	  				<?php if(empty($option)){ ?>
	  					<option value="">None</option>
	  				<?php } else { ?>
	  					<option value="<?=$option?>"><?=$option?></option>
	  				<?php } ?>
	  				
	  			<?php } ?>
	  		</select>
		</div>
		<div class="form-group">
			<label><?=$allFields['type']['title']?></label>
			<?php $typeoption = explode(',', $allFields['type']['options']); ?>
	  		<select name="type" class="form-control">
	  			<?php foreach($typeoption as $option){ ?>
	  				<?php if(empty($option)){ ?>
	  					<option value="">None</option>
	  				<?php } else { ?>
	  					<option value="<?=$option?>"><?=$option?></option>
	  				<?php } ?>
	  				
	  			<?php } ?>
	  		</select>
		</div>
		<div class="form-group">
			<label><?=$allFields['fname']['title']?></label>
			<input type="text" name="fname" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['mname']['title']?></label>
			<input type="text" name="mname" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['lname']['title']?></label>
			<input type="text" name="lname" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['gender']['title']?></label>
			<?php $genderoption = explode(',', $allFields['gender']['options']); ?>
	  		<select name="gender" class="form-control">
	  			<?php foreach($genderoption as $option){ ?>
	  				<?php if(empty($option)){ ?>
	  					<option value="">None</option>
	  				<?php } else { ?>
	  					<option value="<?=$option?>"><?=$option?></option>
	  				<?php } ?>
	  				
	  			<?php } ?>
	  		</select>
		</div>
		<div class="form-group">
			<label><?=$allFields['ethnicity']['title']?></label>
			<?php $ethnicityoption = explode(',', $allFields['ethnicity']['options']); ?>
	  		<select name="ethnicity" class="form-control">
	  			<?php foreach($ethnicityoption as $option){ ?>
	  				<?php if(empty($option)){ ?>
	  					<option value="">None</option>
	  				<?php } else { ?>
	  					<option value="<?=$option?>"><?=$option?></option>
	  				<?php } ?>
	  				
	  			<?php } ?>
	  		</select>
		</div>
		<div class="form-group">
			<label><?=$allFields['address1']['title']?></label>
			<input type="text" name="address1" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['address2']['title']?></label>
			<input type="text" name="address2" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['city']['title']?></label>
			<input type="text" name="city" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['country']['title']?></label>
			<?php $countryoption = explode(',', $allFields['country']['options']); ?>
	  		<select name="country" class="form-control">
	  			<?php foreach($countryoption as $option){ ?>
	  				<?php if(empty($option)){ ?>
	  					<option value="">None</option>
	  				<?php } else { ?>
	  					<option value="<?=$option?>"><?=$option?></option>
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
	  					<option value="<?=$option?>"><?=$option?></option>
	  				<?php } ?>
	  				
	  			<?php } ?>
	  		</select>
		</div>
		<div class="form-group">
			<label><?=$allFields['zip']['title']?></label>
			<input type="number" name="zip" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['workphn']['title']?></label>
			<input type="number" name="workphn" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['workphnext']['title']?></label>
			<input type="text" name="workphnext" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['homephn']['title']?></label>
			<input type="number" name="homephn" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['mobphn']['title']?></label>
			<input type="number" name="mobphn" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['fax']['title']?></label>
			<input type="text" name="fax" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['wemail']['title']?></label>
			<input type="email" name="wemail" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['hemail']['title']?></label>
			<input type="email" name="hemail" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['dob']['title']?></label>
			<input type="text" name="dob" class="form-control datepicker">
		</div>
		<div class="form-group">
			<label><?=$allFields['ssn']['title']?></label>
			<input type="text" name="ssn" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['note']['title']?></label>
			<textarea name="note" class="form-control"></textarea>
		</div>
		<div class="form-group">
			<label><?=$allFields['tags']['title']?></label>
			<input type="text" name="tags" class="form-control">
		</div>
		<div class="form-group">
			<input type="submit" value="Save" class="btn btn-primary">
		</div>	
		
	</form>
</div> -->