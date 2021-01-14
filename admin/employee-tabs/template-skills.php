<?php
	// $key = $defaultKey = $allFields = '';

	// if(isset($_SESSION['gid'])){
	// 	$key = $_SESSION['gid'].'_skill';
	// } else {
	// 	$key = 'default_skill';
	// }
	// $defaultKey = 'default_skill';

	$object = new myconn;
	try {
		$empdata=[];
		$con = $object->connection();
		if(isset($_GET['id'])){
			$empid = $_GET['id'];
			$emp = $con->prepare('SELECT * from emp_skills where emp_id=:empid');
			$emp->bindParam(':empid',$empid);
			$emp->execute();
			$empcount= $emp->rowCount();
			if($empcount){
				while($data = $emp->fetch(PDO::FETCH_ASSOC)){
					$empdata[] = $data;
				}
				// var_dump($empdata);
			}
			$empl = $con->prepare('SELECT * from employee where id=:empid');
			$empl->bindParam(':empid',$empid);
			$empl->execute();
			$empcount= $empl->rowCount();
			if($empcount){
				$data = $empl->fetch(PDO::FETCH_ASSOC);
				$empfname = $data['fname'];
				$emplname = $data['lname'];
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
     	<h3 class="box-title">Skills</h3>
     	<div class="pull-right box-title"><a href="/hrms/admin/skills.php<?=(isset($_GET['id']))?'?id='.$_GET["id"]:''?>" class="">Add New</a></div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
     	<table id="skill-list" class="table table-bordered table-striped ar-table">
            <thead>
				<tr>
					<th>#</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Skill</th>
					<th>Proficiency</th>
					<th>Experience</th>
					<th>First Used Date</th>
					<th>Last Used Date</th>
					<th>Expiry Date</th>
					<th>Description</th>
				</tr>
            </thead>
            <tbody>
            	<?php 
	            	$i=1; 
	            	foreach($empdata as $arcon){
	            		?>
	            		<tr>
	            			<td><a href="/hrms/admin/skills.php?id=<?=$_GET['id']?>&edit=<?=$arcon['id']?>"><?=$i?></a></td>
	            			<td><?=$empfname?></td>
	            			<td><?=$emplname?></td>
	            			<td><?=$arcon['skill']?></td>
	            			<td><?=$arcon['proficiency']?></td>
	            			<td><?=$arcon['experience_yrs']?></td>
	            			<td><?=date('d/m/Y', strtotime($arcon['first_used_date']))?></td>
	            			<td><?=date('d/m/Y', strtotime($arcon['last_used_date']))?></td>
	            			<td><?=date('d/m/Y', strtotime($arcon['exp_date']))?></td>
	            			<td><?=$arcon['description']?></td>	            			
	            		</tr>
            			<?php 
            			$i++; 
            		} 
            	?>
            </tbody>
            <tfoot>
				<tr>
					<th>#</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Skill</th>
					<th>Proficiency</th>
					<th>Experience</th>
					<th>First Used Date</th>
					<th>Last Used Date</th>
					<th>Expiry Date</th>
					<th>Description</th>
				</tr>
            </tfoot>
      	</table>
    </div>
    <!-- /.box-body -->
</div>
<!-- <div class="col-sm-12">
	<form id="skill" name="skill" method="post" action="" class="emp-steps emp_step_41">
		<input type="hidden" name="formtype" value="skill">
		<div class="form-group" >
			<label><?=$allFields['employee']['title']?></label>
			<select name="employee" class="form-control" disabled>
				<?php if(isset($emp_select)){ echo $emp_select;}else { ?>
					<option></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label><?=$allFields['skill']['title']?></label>
			<?php $skilloption = explode(',', $allFields['skill']['options']); ?>
	  		<select name="skill" class="form-control">
	  			<?php foreach($skilloption as $option){ ?>
	  				<?php if(empty($option)){ ?>
	  					<option value="">None</option>
	  				<?php } else { ?>
	  					<option value="<?=$option?>"><?=$option?></option>
	  				<?php } ?>
	  				
	  			<?php } ?>
	  		</select>
		</div>
		<div class="form-group">
			<label><?=$allFields['proficiency']['title']?></label>
			<?php $proficiencyoption = explode(',', $allFields['proficiency']['options']); ?>
	  		<select name="proficiency" class="form-control">
	  			<?php foreach($proficiencyoption as $option){ ?>
	  				<?php if(empty($option)){ ?>
	  					<option value="">None</option>
	  				<?php } else { ?>
	  					<option value="<?=$option?>"><?=$option?></option>
	  				<?php } ?>
	  				
	  			<?php } ?>
	  		</select>
		</div>
		<div class="form-group">
			<label><?=$allFields['firstdt']['title']?></label>
			<input type="text" name="firstdt" class="form-control datepicker">
		</div>
		<div class="form-group">
			<label><?=$allFields['lastdt']['title']?></label>
			<input type="text" name="lastdt" class="form-control datepicker">
		</div>
		<div class="form-group">
			<label><?=$allFields['exp']['title']?></label>
			<input type="text" name="experience" class="form-control">
			<label><input type="checkbox" name="automatic" value="auto">Auto Calculate</label>
		</div>
		<div class="form-group">
			<label><?=$allFields['expdt']['title']?></label>
			<input type="text" name="expdt" class="form-control datepicker">
		</div>
		
		<div class="form-group">
			<label><?=$allFields['desc']['title']?></label>
			<textarea name="desc" class="form-control"></textarea>
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