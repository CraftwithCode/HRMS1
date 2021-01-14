<?php
	include('../includes/connection.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
	if(!isset($_SESSION['main']['uname'])){
		header('Location: ./login.php');
	}

	$groupArray = [];
	$userArray = [];
	$obj1 = new myconn;
	try {
		$conn1=$obj1->connection();
		$group = $conn1->prepare("Select * from company");
		$group->execute();
		$count = $group->rowCount();
		if($count>0) {
			while($grp = $group->fetch(PDO::FETCH_BOTH)){
				$groupArray[$grp['id']] = $grp['groupname'];
			}
		}
	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}


	$obj = new myconn;
	$currRole = 'group-admin';
	try {
		if($_SESSION['main']['role'] == 'group-admin'){
			$group = $_SESSION['main']['gid'];	
		} else {
			$group = $_GET['g'];
		}
		$conn=$obj->connection();
		$q = $conn->prepare("Select * from mainusers where role LIKE :role and groupid=:gid");
		$q->bindParam(':role', $currRole);
		$q->bindParam(':gid', $group);
		$q->execute();
		$count = $q->rowCount();
		if($count>0) {
			while($x = $q->fetch(PDO::FETCH_ASSOC)){
				$empdata[] = $x;
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
		<h1>Admin List</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Admin List</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user"></i> <h3 class="box-title"><?=$groupArray[$group]?></h3>
						<div class="pull-right box-title"><a href="/hrms/admin/add-admin.php" class="">Add New</a></div>
					</div>
					<div class="box-body">
						<div class="col-sm-12">
							<table id="admin" class="table table-bordered table-striped ar-table">
					            <thead>
									<tr>
										<th>#</th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Username / Email</th>
										<th>Action</th>
									</tr>
					            </thead>
					            <tbody>
					            	<?php 
					            		foreach($empdata as $key=>$arcon){
					            			?>
						            		<tr>
						            			<td><?=$key+1?></td>
						            			<td><?=ucwords($arcon['first_name'])?></td>
						            			<td><?=ucwords($arcon['last_name'])?></td>
						            			<td><?=$arcon['username']?></td>
						            			<td>
						            				<a href="/hrms/admin/reset-password.php?edit=<?=$arcon['id']?>">Reset Password</a> | 
						            				<a href="#" data-id="<?=$arcon['id']?>" data-type="admin" class="ar-del">Delete</a>
						            			</td>
						            		</tr>
					            			<?php
					            		} 
					            	?>
					            </tbody>
					            <tfoot>
									<tr>
										<th>#</th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Username / Email</th>
										<th>Action</th>
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