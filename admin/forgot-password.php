<?php

	include('../includes/connection.php');
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	if(isset($_POST['usernm'])) {
		$usernm=$_POST['usernm'];	

		try {
			$obj=new myconn;
			$conn=$obj->connection();
			$q=$conn->prepare("Select * from users where username=:em");
			$q->bindParam(':em', $usernm);
			$q->execute();
			$count = $q->rowCount();
			
			if($count==1) {
				$x = $q->fetch(PDO::FETCH_BOTH);
				$to = $x['username'];
				$nm = str_replace(' ', '', $x['name']);
				$pass = $nm.'123456';
				$subject = 'HRMS - New Password Request';
				$message = 'Temporary password for your account is '.$pass.'<br><br> You can change your password after login by clicking on following link or select change password from menu <br><br> https://terraorb.xyz/hrms/admin/change-password.php/';

				$obj1=new myconn;
				$connn = $obj1->connection();
				$q1 = $connn->prepare("update users set password=SHA1(:pass) where username=:uname");
				$q1->bindParam(':pass', $pass);
				$q1->bindParam(':uname', $usernm);
				$q1->execute();
				$count = $q1->rowCount();				

	            $headers = "MIME-Version: 1.0" . "\r\n"; 
	            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	            $headers .= 'From: HRMS <noreply@hrms.com>' . "\r\n"; 
	            $headers .= 'Bcc: 26rinky@gmail.com' . "\r\n";
				
				if(mail($to, $subject, $message, $headers)){
					$msg = 'Temporary Password is sent to your email. <a href="/hrms/admin/login.php">Click here</a> to login';
				}
			} else {
				$msg1="Email not exist";
			}
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}


?>

<?php include('admin-header.php'); ?>
<style>
    body {
        background-color: #f1f1f1 !important;
    }
</style>
<div class="login-box">
    <div class="login-logo">
        <a href="http://terraorb.xyz/hrms"><b>Terra</b>ORB</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Forget Password</p>
		<form id="form1" name="form1" method="post" action="" class="">
			<!-- <h2>Forget Password</h2> -->

			<div class="form-group">
				<input name="usernm" type="text" id="usernm" size="30" class="form-control" placeholder="Email" />
			</div>
			
		  	<div class="form-group">
				<input type="submit" name="submit" id="submit" onclick="return validate();" value="Submit" class="btn btn-primary" />
				<?php 
					if(isset($msg1))
					{
						print $msg1;
					} 
				?>
				<?php if(isset($msg)){?>
				    <div class="form-group">
			  			<p><?php echo $msg;?></p>
			  		</div>
				<?php } ?> 
			</div>
		</form>
	</div>
</div>
<?php include('admin-footer.php'); ?>