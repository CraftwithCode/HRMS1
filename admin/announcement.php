<?php
	include('../includes/connection.php');

	if(!isset($_SESSION['main']['uname'])){
		header('Location: ./login.php');
	}

	$companyArray = [];
	$userArray = [];
	$obj = new myconn;
	try {
		$con = $obj->connection();
		$co = $con->prepare("Select * from company");
		$co->execute();
		$count = $co->rowCount();
		if($count>0) {
			while($com = $co->fetch(PDO::FETCH_ASSOC)){
				$companyArray[$com['id']] = $com['groupname'];
			}
		}

		if(isset($_SESSION['main']['gid'])){
			$q = $con->prepare("Select * from employee where groupid=:gid");
			$company = $_SESSION['main']['gid'];
			$q->bindParam(':gid', $company);
		} else{
			$q = $con->prepare("Select * from employee");
		}
		$q->execute();
		$count = $q->rowCount();
		if($count>0) {
			while($x = $q->fetch(PDO::FETCH_ASSOC)){
				$userArray[$x['id']] = $x['fname'].' | '.$x['lname'].' | '.$x['status'];
			}
		}
	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}


?>
<?php include_once('admin-header.php'); ?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Announcement</h1>
		<ol class="breadcrumb">
			<li><a href="/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Announcement</li>
		</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-bullhorn"></i> <h3 class="box-title">Announcement</h3>
						<!-- tools box -->
						<div class="pull-right box-tools">
							<!-- <a href="<?=(isset($_GET['edit'])) ? ((isset($_GET['id']) && isset($_GET['edit'])) ? '/hrms/admin/update-employee.php?id='.$_GET['id'] : '/hrms/admin/employee-contacts.php' ) : $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Go Back</a> -->
							<!-- <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button> -->
						</div>
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<div class="col-sm-12">
							<form id="punches" name="punches" method="post" action="" class="ar-forms ">
								<input type="hidden" name="formtype" value="announcement">
								<?php if($role == 'super-admin') { ?>
									<div class="form-group" <?=($role == 'group-admin')?'style="display:none;"':''?>>
										<label>Company</label>
										<select name="company" class="sel-company form-control" required>
											<option value="">Select Company</option>
											<option value="all">All</option>
											<?php foreach($companyArray as $id=>$company){ ?>
												<option value="<?=$id?>" <?=($_SESSION['main']['role']=='group-admin' && $_SESSION['main']['gid']==$id)?'selected="selected"':''?>><?=$company?></option>
											<?php } ?>
										</select>
									</div>
								<?php } ?>
								<div class="form-group">
									<label>Employee</label>
									<select name="emp[]" class="ar-employee ar-announcement form-control" <?=($_SESSION['main']['role'] != 'super-admin')?'multiple':''?>>
										<option value="all">All</option>
										<?php if($_SESSION['main']['role'] != 'super-admin'){ ?>
											<?php foreach($userArray as $id=>$user){ ?>
												<option value="<?=$id?>"><?=$user?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
				                <div class="form-group">
									<label>Announcement Title</label>
									<input type="text" name="title" class="form-control"  value="" required>
				                </div>
								<div class="form-group">
									<label>Announcement Description</label>
									<textarea name="description" class="form-control" placeholder="" required></textarea> 
								</div>
								<div class="form-group">
									<label>Status</label>
									<select name="status" class="form-control">
										<option value="Active">Active</option>
										<option value="Inactive">Inactive</option>
									</select>
								</div>
								<div class="form-group">
									<input type="submit" name="" class="btn btn-primary" value="Save">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php include_once('admin-footer.php'); ?>