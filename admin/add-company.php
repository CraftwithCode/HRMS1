<?php
	include('../includes/connection.php');

	if(!isset($_SESSION['main']['uname']) || $_SESSION['main']['role']!='super-admin'){
		header('Location: ../index.php');
	}

	
	if(isset($_POST['signup'])) {
		$name=$_POST['groupname'];
		$total=$_POST['total'];
		$legal = $_POST['legal'];
		
		$obj=new myconn;
		try
		{
			$conn=$obj->connection();
			$check=$conn->prepare("Select * from company where groupname=:em");
			
			$check->bindParam(':em', $name);
			$check->execute();
			$count = $check->rowCount();
			if($count==0)
			{
				$q=$conn->prepare("insert into company (groupname, legal_entity, total) values(:name,:legal,:total)");
				$q->bindParam(':name', $name);
				$q->bindParam(':legal', $legal);
				$q->bindParam(':total', $total);
				$q->execute();
				$count = $q->rowCount();
				if($count==1) {
					/*print "<script> alert('Sign Up Successful')</script>";*/
					//header('location:index.php');
					$msg = 'Added Successfully';
				}
				else {
					$msg="Unable to add company, please try again later";	
				}
			} else {
				$msg="Company already exist";
			}
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
			
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
		<h1>Add Company</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Add Company</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Add Company</h3>
						<!-- tools box -->
						<!-- <div class="pull-right box-tools">
							<button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button>
						</div> -->
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<form id="form1" name="form1" method="post" action="">		  	
						  	<div class="form-group">
						  		<input name="groupname" type="text" id="nm" size="30" placeholder="Name" class="form-control" required />
						  	</div>
						  	<div class="form-group">
				  		  		<select name="legal" class="form-control" required>
				  		  			<option value="">Select Legal Entity</option>
				  		  			<option value="Conglomerate (company)">Conglomerate (company)</option>
				  		  			<option value=" Holding company"> Holding company</option>
				  		  			<option value=" Cooperative"> Cooperative</option>
				  		  			<option value=" Corporation"> Corporation</option>
				  		  			<option value=" Joint-stock company"> Joint-stock company</option>
				  		  			<option value=" Limited liability company"> Limited liability company</option>
				  		  			<option value=" Partnership"> Partnership</option>
				  		  			<option value=" Privately held company"> Privately held company</option>
				  		  			<option value="and Sole proprietorship">and Sole proprietorship</option>
				  		  		</select>
						  	</div>
						  	<div class="form-group">
						  		<input name="total" type="number" id="count" size="30" placeholder="Number of Employees" class="form-control" />
						  	</div>
						  	
						  	<div class="form-group">
						  		<input type="submit" name="signup" id="signup" value="Add Company" class="btn btn-primary" />
						  	</div>
						  	<div class="form-group">
						  		<?php 
									if(isset($msg)) {
										print $msg;
									} 
								 ?>
						  	</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
					
<?php include_once('admin-footer.php'); ?>