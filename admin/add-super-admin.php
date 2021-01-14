<?php
	include('../includes/connection.php');

	if(!isset($_SESSION['main']['uname'])){
		header('Location: ./login.php');
	}
	
	if(isset($_POST['signup'])) {
		
		if(isset($_POST['gen'])) {
			$fname=$_POST['fnm'];
			$lname=$_POST['lnm'];
			$phone=$_POST['phn'];
			$gen=$_POST['gen'];
			$dob=$_POST['datepicker'];
			$usernm=$_POST['usernm'];
			$pass=$_POST['pass'];
			$cpass=$_POST['cpass'];
			$add=$_POST['add'];
			$role=$_POST['role'];
			// date_default_timezone_set('Asia/Kolkata');
			$dt=date('Y-m-d H-i-s');
			// 	$type= 'normal';
			
			if($pass==$cpass)
			{				
				$obj=new myconn;
				$obj4=new myconn;

				$pm = new pm;
				$pmCon = $pm->connection();

				try
				{
					$conn=$obj->connection();
					$check=$conn->prepare("Select * from mainusers where username=:em");
					
					$check->bindParam(':em', $usernm);
					$check->execute();
					$count = $check->rowCount();
					if($count==0) {
						$conn=$obj4->connection();
						$check=$conn->prepare("Select * from employee where username=:em");				
						$check->bindParam(':em', $username);
						$check->execute();
						$count = $check->rowCount();
						if($count==0)
						{
							$q=$conn->prepare("insert into mainusers (first_name,last_name,phone,gender,dob,username,password,address,added_dt,role) values(:fname,:lname,:phone,:gen,:dob,:usernm,SHA(:pass),:add, :dt, :role)");
							$q->bindParam(':fname', $fname);
							$q->bindParam(':lname', $lname);
							$q->bindParam(':phone', $phone);
							$q->bindParam(':gen', $gen);
							$q->bindParam(':dob', $dob);
							$q->bindParam(':usernm', $usernm);
							$q->bindParam(':pass', $pass);
							$q->bindParam(':add', $add);
							$q->bindParam(':dt', $dt);
							$q->bindParam(':role', $role);
							$q->execute();
							$count = $q->rowCount();
							if($count==1) {
								/*print "<script> alert('Sign Up Successful')</script>";*/
								//header('location:index.php');
								$msg = 'Register Successfully';

								$headers = 'From: HRMS <noreply@hrms.com>'."\r\n";
								$headers .= 'Bcc: 26rinky@gmail.com'."\r\n";
								$headers .= "MIME-Version: 1.0\r\n";
								$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
								mail($usernm, 'HRMS - Registered as Super Admin', 'Your email registered as super admin <br>Username: '.$usernm.'<br>Password: '.$pass, $headers);

								$lms=$conn->prepare("INSERT INTO `users`( `first_name`, `last_name`, `email`, `password`, `role_id`, `status`) VALUES (:fname, :lname,:username, SHA(:password),1,1)");
								
								$lms->bindParam(':username', $usernm);
								$lms->bindParam(':password', $pass);
								$lms->bindParam(':fname', $fname);
								$lms->bindParam(':lname', $lname);
								$lms->execute();
								updatechatuser($usernm);

								$pm=$pmCon->prepare("INSERT INTO `users`(`users_first_name`, `users_last_name`, `users_email`, `users_password`, `users_active`, `company`) VALUES (:fname, :lname,:username, SHA(:password),1,:groupid)");
								$pm->bindParam(':groupid', $groupid);
								$pm->bindParam(':username', $username);
								$pm->bindParam(':password', $password);
								$pm->bindParam(':fname', $fname);
								$pm->bindParam(':lname', $lname);
								$pm->execute();

							}
							else {
								$msg="Register Unsuccessfully, please try again later";	
							}
						} else {
							$msg="Username already exist";
						}
					} else {
						$msg="Username already exist";
					}
				} catch(PDOException $e) {
					echo "Error: " . $e->getMessage();
				}
			} else {
				$msg="Password Not Matched";	
			}
		} else {
			$msg="Please Select Gender";	
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
		<h1>Add Super Admin</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Add Super Admin</li>
			</ol>
	</section>
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info">
					<div class="box-header">
						<i class="fa fa-user-plus"></i> <h3 class="box-title">Add Super Admin</h3>
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
						  		<input name="fnm" type="text" id="nm" size="30" placeholder="First Name" class="form-control" />
						  	</div>
						  	<div class="form-group">
						  		<input name="lnm" type="text" id="nm" size="30" placeholder="Last Name" class="form-control" />
						  	</div>
						  	<div class="form-group">
						  		<input name="phn" type="number" id="phn" size="30" placeholder="Contact Number" class="form-control" />
						  	</div>
						  	<div class="form-group">
						  		<label>Gender</label>
						  		<label><input type="radio" name="gen" id="male" value="male" />Male </label>
						  		<label><input type="radio" name="gen" id="female" value="female" />Female </label>
						  	</div>
						  	<div class="form-group">
						  		<input name="datepicker" type="text" id="" size="30" placeholder="Date of Birth" class="form-control datepicker-dob" />
						  	</div>
						  	<div class="form-group">
						  		<input name="usernm" type="email" id="usernm" size="30" class="form-control" placeholder="Email" />
						  	</div>
						  	<div class="form-group">
						  		<input name="pass" type="password" id="pass" size="30" class="form-control" placeholder="Password" />
						  	</div>
						  	<div class="form-group">
						  		<input name="cpass" type="password" id="cpass" size="30" class="form-control" placeholder="Confirm Password" />
						  	</div>
						  	<div class="form-group">
						  		<textarea name="add" cols="25" rows="5" id="add" placeholder="Address" class="form-control"></textarea>
						  	</div>
						  	<input type="hidden" name="role" value="super-admin">
						  	<div class="form-group">
						  		<input type="submit" name="signup" id="signup" value="Add Super Admin" class="btn btn-primary" />
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