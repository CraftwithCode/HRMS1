<?php
	include('../includes/connection.php');

	if(!isset($_SESSION['main']['uname'])){
		header('Location: ../index.php');
	}

	$groupArray = [];
	$obj1 = new myconn;
	try {
		$conn1=$obj1->connection();
		$group = $conn1->prepare("Select * from company order by id DESC");
		$group->execute();
		$count = $group->rowCount();
		if($count>0) {
			while($grp = $group->fetch(PDO::FETCH_BOTH)){
				$groupArray[] = $grp;
			}

			$importstatus = $conn1->prepare("Select * from import_ethnic_status");
			$importstatus->execute();
			$countstatus = $importstatus->rowCount();
			if($countstatus>0) {
				while($row = $importstatus->fetch(PDO::FETCH_BOTH)){
					$status[$row['company']] = $row['status'];
				}
			}
		}
	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}


?>
<?php include('admin-header.php');?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>All Companies</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">All Companies</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">All Companies</h3>
						<div class="pull-right box-title"><a href="/hrms/admin/add-company.php" class="">Add New</a></div>
					</div>
					<div class="box-body">
						<div class="col-sm-12">
							<table class="table table-bordered table-striped ar-table" >
							    <thead>
    								<tr>
    									<th>S.No.</th>
    									<th>Company Name</th>
    									<th></th>
    									<th></th>
    								</tr>
    							</thead>
    							<tbody>
    							    <?php foreach($groupArray as $key=>$user) { ?>
    									<tr>
    										<td><?=$key+1?></td>
    										<td><?=$user['groupname']?></td>
    										<td><a href="/hrms/admin/all-admins.php?g=<?=$user['id']?>">Admin</a> | <a href="/hrms/admin/all-employees.php?g=<?=$user['id']?>">Employees</a></td>
    										<td>
    											<?php if(array_key_exists($user['id'], $status)){ ?>
    												<a href="#" class="import-ethnic " style="pointer-events: none;">Imported</a>
    											<?php } else { ?>
    												<a href="#" data-id="<?=$user['id']?>" class="import-ethnic">Import Default Ethnic Groups</a>
    											<?php } ?>
    										</td>
    									</tr>
    								<?php } ?>
    							</tbody>
    							<tfoot>
    							    <tr>
    									<th>S.No.</th>
    									<th>Company Name</th>
    									<th></th>
    									<th></th>
    								</tr>
    							</tfoot>
									
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php include('admin-footer.php');?>