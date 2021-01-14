
<?php

	include('../includes/connection.php');

	if(isset($_SESSION['main']['uname'])){
		header('Location: /hrms/admin/index.php');
	}

	if(isset($_POST['submit']))
	{
		$usernm=$_POST['usernm'];
		$pass=$_POST['pass'];
		
		if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0) {  
			$msg="The Validation code does not match!";
		}
		else{
			// Captcha verification is Correct. Final Code Execute here!
			$obj=new myconn;
			try
			{
				$conn=$obj->connection();
				$q=$conn->prepare("Select * from mainusers where username=:em and password=SHA(:pass)");
				$q->bindParam(':em', $usernm);
				$q->bindParam(':pass', $pass);
				$q->execute();
				$count = $q->rowCount();
				print $count."-";
				
				if($count==1)
				{
					$x = $q->fetch(PDO::FETCH_ASSOC);
					$_SESSION['main']['user_id']=$x['id'];
					$_SESSION['main']['fname']=$x['first_name'];
					$_SESSION['main']['lname']=$x['last_name'];
					$_SESSION['main']['uname']=$x['username'];
					$_SESSION['main']['role']=$x['role'];
					$_SESSION['main']['add']=$x['address'];
					$_SESSION['main']['phn']=$x['phone'];
					$_SESSION['main']['pass']=$pass;
					if($x['role'] == 'group-admin'){
						$_SESSION['main']['gid'] = $x['groupid'];
					}

					$email = getChatUser($x['username']);
					$_SESSION['id'] = $email['id'];
					$_SESSION['username'] = $email['username'];

					$res = $conn->prepare("UPDATE `chat_userdata` SET online=1, last_active_timestamp = NOW() WHERE id = {$_SESSION['id']};");
					$res->execute();

					if(isset($_POST["keep"]))
					{
						setcookie("uname",$x['username'],time()+7*24*60*60);
					}
					header('location:index.php');
				}
				else
				{
					$msg1="Incorrect Username or Password";	
				}
			}
			catch(PDOException $e)
			{
				echo "Error: " . $e->getMessage();
			}
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
            <p class="login-box-msg">Sign in to start your session</p>
            <form id="form1" name="form1" method="post" action="" class="">
                <div class="form-group has-feedback">
                    <input name="usernm" type="text" id="usernm" size="30" class="form-control" placeholder="Email" />
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
            		<input name="pass" type="password" id="pass" size="30" class="form-control" placeholder="Password" />
            		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
            	</div>
                <?php if(isset($msg)){?>
            	    <div class="form-group">
              			<p><?php echo $msg;?></p>
              		</div>
            	<?php } ?> 
              	<div class="form-group">
            	  	<label>Captcha Code</label>
            	  	<img src="captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg'><br><br>
            	    <input id="6_letters_code" name="6_letters_code" type="text" placeholder="Enter the code" class="form-control">
            	    <br>
            	    Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh
              	</div>
            	<div class="form-group">
            		<input type="submit" name="submit" id="submit" onclick="return validate();" value="Login" class="btn btn-primary" />
            		<?php 
            			if(isset($msg1))
            			{
            				print $msg1;
            			} 
            		 ?>
            	</div>
            </form>
            <a href="/hrms/admin/forgot-password.php">I forgot my password</a><br>
        </div>
    <!-- /.login-box-body -->
    </div>
<script>
	function refreshCaptcha()
	{
	    var img = document.images['captchaimg'];
	    img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
	}
</script>
<?php include('admin-footer.php'); ?>