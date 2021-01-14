<?php
	// $key = $defaultKey = $allFields = '';

	// if(isset($_SESSION['gid'])){
	// 	$key = $_SESSION['gid'].'_education';
	// } else {
	// 	$key = 'default_education';
	// }
	// $defaultKey = 'default_education';

	$object = new myconn;
	try {
		$empdata=[];
		$con = $object->connection();
		if(isset($_GET['id'])){
			$empid = $_GET['id'];
			$emp = $con->prepare('SELECT * from emp_education where emp_id=:empid');
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
     	<h3 class="box-title">Education</h3>
     	<div class="pull-right box-title"><a href="/hrms/admin/education.php<?=(isset($_GET['id']))?'?id='.$_GET["id"]:''?>" class="">Add New</a></div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
     	<table id="education-list" class="table table-bordered table-striped ar-table">
            <thead>
				<tr>
					<th>#</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Course</th>
					<th>Institute</th>
					<th>Major/Specification</th>
					<th>Minor</th>
					<th>Graduation Date</th>
					<th>Grade/Score</th>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>
            </thead>
            <tbody>
            	<?php 
	            	$i=1; 
	            	foreach($empdata as $arcon){
	            		?>
	            		<tr>
	            			<td><a href="/hrms/admin/education.php?id=<?=$_GET['id']?>&edit=<?=$arcon['id']?>"><?=$i?></a></td>
	            			<td><?=$empfname?></td>
	            			<td><?=$emplname?></td>
	            			<td><?=$arcon['course']?></td>
	            			<td><?=$arcon['institute']?></td>
	            			<td><?=$arcon['major']?></td>
	            			<td><?=$arcon['minor']?></td>
	            			<td><?=$arcon['graduation_date']?></td>
	            			<td><?=$arcon['grade']?></td>
	            			<td><?=date('d/m/Y', strtotime($arcon['start_date']))?></td>
	            			<td><?=date('d/m/Y', strtotime($arcon['end_date']))?></td>

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
					<th>Course</th>
					<th>Institute</th>
					<th>Major/Specification</th>
					<th>Minor</th>
					<th>Graduation Date</th>
					<th>Grade/Score</th>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>
            </tfoot>
      	</table>
    </div>
    <!-- /.box-body -->
</div>
<!-- <div class="col-sm-12">
	<form id="education" name="education" method="post" action="" class="emp-steps emp_step_42">
		<input type="hidden" name="formtype" value="education">
		<div class="form-group" >
			<label><?=$allFields['employee']['title']?></label>
			<select name="employee" class="form-control" disabled>
				<?php if(isset($emp_select)){ echo $emp_select;}else { ?>
					<option></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label><?=$allFields['course']['title']?></label>
			<input type="text" name="course" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['inst']['title']?></label>
			<input type="text" name="inst" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['major']['title']?></label>
			<input type="text" name="major" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['minor']['title']?></label>
			<input type="text" name="minor" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['graddt']['title']?></label>
			<input type="text" name="graddt" class="form-control datepicker">
		</div>
		<div class="form-group">
			<label><?=$allFields['grade']['title']?></label>
			<input type="text" name="grade" class="form-control">
		</div>
		<div class="form-group">
			<label><?=$allFields['startdt']['title']?></label>
			<input type="text" name="startdt" class="form-control datepicker">
		</div>
		<div class="form-group">
			<label><?=$allFields['enddt']['title']?></label>
			<input type="text" name="enddt" class="form-control datepicker">
		</div>
		<div class="form-group">
			<input type="submit" value="Save" class="btn btn-primary">
		</div>	
	</form>
</div> -->