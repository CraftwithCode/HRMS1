<?php
	include('../includes/connection.php');

	if(!isset($_SESSION['main']['uname'])){
		header('Location: ./login.php');
	}

	$groupArray = [];
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
	
	$obj1 = new myconn;
	try {
		$conn1=$obj1->connection();
		if($_SESSION['main']['role'] == 'group-admin'){
		    $gid = $_SESSION['main']['gid'];
		    $employees = $conn1->prepare("Select * from employee where groupid=:gid");
		    $employees->bindParam(':gid', $gid);
		} else {
		    $employees = $conn1->prepare("Select * from employee");
		}
    		
		$employees->execute();
		$count = $employees->rowCount();
		if($count>0) {
			while($empl = $employees->fetch(PDO::FETCH_BOTH)){
				$employee[$empl['id']] = $empl['fname'].' | '.$empl['lname'].' | '.$empl['status'];
			}
		}
	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}

?>

<?php include_once('admin-header.php'); ?>
<style type="text/css">
	.bootstrap-datetimepicker-widget ul{
		padding: 0;
	}
</style>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee Benefits</h1>
			<ol class="breadcrumb">
				<li><a href="/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Employee Benefits</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
					    <?php if($_SESSION['main']['role'] == 'group-admin'){ ?>
					        <i class="fa fa-user"></i> <h3 class="box-title"><?=ucwords($groupArray[$_SESSION['main']['gid']])?></h3>
					    <?php } else { ?>
						    <i class="fa fa-user"></i> <h3 class="box-title">Select Employee</h3>
						<?php } ?>
						
					</div>
					<div class="box-body">
						<form id="form1" name="form1" method="get" action="/hrms/admin/employee-benefits.php">
						    <?php 
						        $display = '';
						        $selected = '';
						        if($_SESSION['main']['role'] == 'group-admin'){
						            $display = 'style="display:none;"';
						            $selected = $_SESSION['main']['gid'];
						        }
						    ?>	
							<div class="form-group">
								<select required class="form-control sel-company" <?=$display?>>
									<option value="">Select Company</option>
									<?php foreach($groupArray as $key=>$g) { ?>
										<option value="<?=$key?>" <?=($selected==$key)?'selected="selected"':''?>><?=$g?></option>
									<?php } ?>
								</select>		  		
						  	</div>
						  	<div class="form-group">
								<select name="id" required class="form-control ar-employee">
									<option value="">Select Employee</option>
									<?php if($_SESSION['main']['role'] == 'group-admin'){ ?>
										<?php foreach($employee as $key=>$emp) { ?>
											<option value="<?=$key?>"><?=$emp?></option>
										<?php } ?>
									<?php } ?>
								</select>		  		
						  	</div>
						  	<div class="form-group">
						  		<input type="submit" value="View Benefits" class="btn btn-primary" />
						  	</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	
<?php include_once('admin-footer.php'); ?>