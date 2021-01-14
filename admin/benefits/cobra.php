<?php
	$object = new myconn;
	try {
		$empdata=[];
		$con = $object->connection();
		if(isset($_GET['id'])){
			$empid = $_GET['id'];
			$emp = $con->prepare('SELECT * from benefit_cobra where emp_id=:empid');
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
     	<h3 class="box-title">COBRA</h3>
     	<div class="pull-right box-title"><a href="/hrms/admin/benefit-cobra.php<?=(isset($_GET['id']))?'?id='.$_GET["id"]:''?>" class="">Add New</a></div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
     	<table id="cobra-list" class="table table-bordered table-striped ar-table">
            <thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Dependent</th>
					<th>Date Of Event</th>
					<th>Reason</th>
					<th>Date Letter Sent</th>
					<th>COBRA Status</th>
					<th>Status Date</th>
					<th></th>
				</tr>
            </thead>
            <tbody>
            	<?php $i=1; foreach($empdata as $arcon){ ?>
            		<tr>
            			<td><a href="/hrms/admin/benefit-cobra.php?id=<?=$_GET['id']?>&edit=<?=$arcon['id']?>"><?=$i?></a></td>
            			<td><?=$arcon['name']?></td>
            			<td><input type="checkbox" disabled <?=($arcon['dependent']=='Yes')?' checked ':''?>></td>
            			<td><?=$arcon['doe']?></td>
            			<td><?=$arcon['reason']?></td>
            			<td><?=$arcon['datesent']?></td>
            			<td><?=$arcon['status']?></td>
            			<td><?=$arcon['statusdt']?></td>
            			<td><a href="#" data-id="<?=$arcon['id']?>" data-type="benefit-cobra" class="ar-del">Delete</a></td>
            		</tr>
            	<?php $i++; } ?>
            </tbody>
            <tfoot>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Dependent</th>
					<th>Date Of Event</th>
					<th>Reason</th>
					<th>Date Letter Sent</th>
					<th>COBRA Status</th>
					<th>Status Date</th>
					<th></th>
				</tr>
            </tfoot>
      	</table>
    </div>
    <!-- /.box-body -->
</div>