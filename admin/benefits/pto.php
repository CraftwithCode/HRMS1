<?php
	$object = new myconn;
	try {
		$empdata=[];
		$con = $object->connection();
		if(isset($_GET['id'])){
			$empid = $_GET['id'];
			$emp = $con->prepare('SELECT * from benefit_pto where emp_id=:empid');
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

	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<div class="box">
    <div class="box-header">
     	<h3 class="box-title">PTO Plans</h3>
     	<div class="pull-right box-title"><a href="/hrms/admin/benefit-pto.php<?=(isset($_GET['id']))?'?id='.$_GET["id"]:''?>" class="">Add New</a></div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
     	<table id="pto-list" class="table table-bordered table-striped ar-table">
            <thead>
				<tr>
					<th>#</th>
					<th>Plan</th>
					<th>Earned</th>
					<th>Processed</th>
					<th>Available</th>
					<th>Last</th>
					<th>Unprocessed Approved</th>
					<th>Estimated Total Plan</th>
					<th>Earned Through</th>
					<th>Reset Date</th>
					<th></th>
				</tr>
            </thead>
            <tbody>
            	<?php $i=1; foreach($empdata as $arcon){ ?>
            		<tr>
            			<td><a href="/hrms/admin/benefit-pto.php?id=<?=$_GET['id']?>&edit=<?=$arcon['id']?>"><?=$i?></a></td>
            			<td><?=$arcon['plan']?></td>
            			<td><?=$arcon['earned']?></td>
            			<td><?=$arcon['processed']?></td>
            			<td><?=$arcon['available']?></td>
            			<td><?=$arcon['last']?></td>
            			<td><?=$arcon['unp']?></td>
            			<td><?=$arcon['total']?></td>
            			<td><?=$arcon['earnth']?></td>
            			<td><?=$arcon['reset']?></td>
            			<td><a href="#" data-id="<?=$arcon['id']?>" data-type="benefit-pto" class="ar-del">Delete</a></td>
            		</tr>
            	<?php $i++; } ?>
            </tbody>
            <tfoot>
				<tr>
					<th>#</th>
					<th>Plan</th>
					<th>Earned</th>
					<th>Processed</th>
					<th>Available</th>
					<th>Last</th>
					<th>Unprocessed Approved</th>
					<th>Estimated Total Plan</th>
					<th>Earned Through</th>
					<th>Reset Date</th>
					<th></th>
				</tr>
            </tfoot>
      	</table>
    </div>
    <!-- /.box-body -->
</div>