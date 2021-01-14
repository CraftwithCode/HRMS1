<?php
	// $key = $defaultKey = $allFields = '';

	// if(isset($_SESSION['main']['gid'])){
	// 	$key = $_SESSION['main']['gid'].'_review';
	// } else {
	// 	$key = 'default_review';
	// }
	// $defaultKey = 'default_review';

	$object = new myconn;
	try {
		$empdata=[];
		$con = $object->connection();
		if(isset($_GET['id'])){
			$empid = $_GET['id'];
			$emp = $con->prepare('SELECT * from emp_review where emp_id=:empid');
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
		if(isset($_GET['id'])){
			$employee = $conn1->prepare('Select * from employee where id <> :empid and groupid = (Select groupid from employee where id=:empid)');
			$employee->bindParam(':empid',$empid);
		} else {
			$employee = $conn1->prepare('Select * from employee');
		}
		$employee->execute();
		$empcount = $employee->rowCount();
		if($empcount == 0){
			// die('<h3>Employees not exist</h3>');
		} else {
			$allemp = [];
			while($getemp = $employee->fetch(PDO::FETCH_ASSOC)){
				// $selected = ($empid == $getemp['id'])?'selected="selected"':'';
				$allemp[] = $getemp;
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

<div class="box">
    <div class="box-header">
     	<h3 class="box-title">Reviews</h3>
     	<div class="pull-right box-title"><a href="/hrms/admin/review.php<?=(isset($_GET['id']))?'?id='.$_GET["id"]:''?>" class="">Add New</a></div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
     	<table id="review-list" class="table table-bordered table-striped ar-table">
            <thead>
				<tr>
					<th>#</th>
					<th>Reviewer</th>
					<th>Status</th>
					<th>Type</th>
					<th>Rating</th>
				</tr>
            </thead>
            <tbody>
            	<?php 
	            	$i=1; 
	            	foreach($empdata as $arcon){
	            		$empl = $con->prepare('SELECT * from employee where id=:empid');
						$empl->bindParam(':empid',$arcon['reviewer']);
						$empl->execute();
						$empcount= $empl->rowCount();
						if($empcount){
							$data = $empl->fetch(PDO::FETCH_ASSOC);
							$empfname = $data['fname'];
							$emplname = $data['lname'];
						}
	            		?>
	            		<tr>
	            			<td><a href="/hrms/admin/review.php?id=<?=$_GET['id']?>&edit=<?=$arcon['id']?>"><?=$i?></a></td>
	            			<td><?=$empfname.' '.$emplname?></td>
	            			<td><?=$arcon['status']?></td>
	            			<td><?=$arcon['type']?></td>
	            			<td><?=$arcon['rating']?></td>
	            		</tr>
            			<?php 
            			$i++; 
            		} 
            	?>
            </tbody>
            <tfoot>
				<tr>
					<th>#</th>
					<th>Reviewer</th>
					<th>Status</th>
					<th>Type</th>
					<th>Rating</th>
				</tr>
            </tfoot>
      	</table>
    </div>
    <!-- /.box-body -->
</div>
