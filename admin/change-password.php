<?php

	include('../includes/connection.php');
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);

	if(isset($_POST['submit'])) {
		$pass=$_POST['pass'];
		$cpass=$_POST['cpass'];

		if($pass != $cpass){
			$msg = 'Confirm Password is not match';
		} else {
			$obj=new myconn;
			try {
				$conn=$obj->connection();
				$q=$conn->prepare("UPDATE `mainusers` SET `password`=SHA1(:pass) WHERE username = :uname");
				$q->bindParam(':uname', $_SESSION['main']['uname']);
				$q->bindParam(':pass', $pass);
				$q->execute();
				$count = $q->rowCount();
			
				if($count==1) {
					$to = $_SESSION['main']['uname'];
					
					$subject = 'HRMS - Password changed';
					$message = 'Password changed successfully';
				

		            $headers = "MIME-Version: 1.0" . "\r\n"; 
		            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		            $headers .= 'From: HRMS <noreply@hrms.com>' . "\r\n"; 
		            $headers .= 'Bcc: 26rinky@gmail.com' . "\r\n";
					if(mail($to, $subject, $message, $headers)){
						$msg1 = 'Password changed successfully';
					}
				} 
			} catch(PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
		}			
	}


?>

<?php include('admin-header.php'); ?>


<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Change Password</h1>
			<ol class="breadcrumb">
				<li><a href="/hrms/employee"><i class="fa fa-dashboard"></i> Home</a></li>
				<!-- <li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li> -->
				<li class="active">Change Password</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Change Password</h3>
						<!-- tools box -->
						<!-- <div class="pull-right box-tools">
							<button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
							title="Remove">
							<i class="fa fa-times"></i></button>
						</div> -->
						<!-- /. tools -->
					</div>
					<div class="box-body">
						<div class="box">
						    <div class="box-header">
						     	<h3 class="box-title">Change Password</h3>
						     	<!-- <div class="pull-right box-title"><a href="/hrms/admin/add-employee.php" class="">Add New</a></div> -->
						    </div>
						    <!-- /.box-header -->
						    <div class="box-body">
						    	<form id="form1" name="form1" method="post" action="" class="">

									<div class="form-group">
										<input name="pass" type="text" id="pass" size="30" class="form-control" placeholder="New Password" required />
									</div>
									<div class="form-group">
										<input name="cpass" type="text" id="cpass" size="30" class="form-control" placeholder="Confirm Password" required />
									</div>
									
								  <?php if(isset($msg)){?>
									    <div class="form-group">
								  			<p><?php echo $msg;?></p>
								  		</div>
									<?php } ?> 
								  	
									<div class="form-group">
										<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary" />
										<?php 
											if(isset($msg1))
											{
												print $msg1;
											} 
										 ?>
									</div>
								</form>
						    </div>
						    <!-- /.box-body -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

								
<?php include('admin-footer.php'); ?>