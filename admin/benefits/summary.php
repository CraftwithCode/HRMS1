<?php
	$object = new myconn;
	try {
		$empdata=[];
		$con = $object->connection();
		if(isset($_GET['id'])){
			$empid = $_GET['id'];
			$emp = $con->prepare('SELECT * from benefit_summary where emp_id=:empid');
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
     	<h3 class="box-title">Benefit Summary</h3>
     	<div class="pull-right box-title"><a href="/hrms/admin/benefit-summary.php<?=(isset($_GET['id']))?'?id='.$_GET["id"]:''?>" class="">Add New</a></div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
     	<table id="summary-list" class="table table-bordered table-striped ar-table">
            <thead>
            	<tr>
					<th colspan="4"></th>
					<th colspan="2" style="text-align: center;">Deduction</th>
					<th></th>
					<th colspan="2" style="text-align: center;">Coverage</th>
					<th colspan="2" style="text-align: center;">Employee</th>
					<th colspan="2" style="text-align: center;">Employer</th>
					<th></th>
				</tr>
				<tr>
					<th>#</th>
					<th>Benefit</th>
					<th>Plan</th>
					<th>Benefit Status</th>
					<th>Start</th>
					<th>Stop</th>
					<th>Coverage</th>
					<th>Start</th>
					<th>Stop</th>
					<th>Last</th>
					<th>YTD</th>
					<th>Last</th>
					<th>YTD</th>
					<th></th>
				</tr>
            </thead>
            <tbody>
            	<?php $i=1; foreach($empdata as $arcon){ ?>
            		<tr>
            			<td><a href="/hrms/admin/benefit-summary.php?id=<?=$_GET['id']?>&edit=<?=$arcon['id']?>"><?=$i?></a></td>
            			<td><?=$arcon['benefit']?></td>
            			<td><?=$arcon['plan']?></td>
            			<td><?=$arcon['status']?></td>
            			<td><?=$arcon['statusstart']?></td>
            			<td><?=$arcon['statusstop']?></td>
            			<td><?=$arcon['coverage']?></td>
            			<td><?=$arcon['cstart']?></td>
            			<td><?=$arcon['cstop']?></td>
            			<td><?=$arcon['emplast']?></td>
            			<td><?=$arcon['empytd']?></td>
            			<td><?=$arcon['emprlast']?></td>
            			<td><?=$arcon['emprytd']?></td>
            			<td><a href="#" data-id="<?=$arcon['id']?>" data-type="benefit-summary" class="ar-del">Delete</a></td>
            		</tr>
            	<?php $i++; } ?>
            </tbody>
            <tfoot>
				<tr>
					<th>#</th>
					<th>Benefit</th>
					<th>Plan</th>
					<th>Benefit Status</th>
					<th>Start</th>
					<th>Stop</th>
					<th>Coverage</th>
					<th>Start</th>
					<th>Stop</th>
					<th>Last</th>
					<th>YTD</th>
					<th>Last</th>
					<th>YTD</th>
					<th></th>
				</tr>
            </tfoot>
      	</table>
    </div>
    <!-- /.box-body -->
</div>