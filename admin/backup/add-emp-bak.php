<?php
	include('../includes/connection.php');

	if(!isset($_SESSION['uname'])){
		header('Location: ../index.php');
	}
	// $userroles = ['super-admin'=>'Super Admin', 'group-admin' => 'Admin', 'employee'=>'Employee'];
	// if(isset($_SESSION['role'])){
	// 	if($_SESSION['role'] == 'super-admin')
	// 		$userroles = ['super-admin'=>'Super Admin', 'group-admin' => 'Admin', 'employee'=>'Employee'];
	// 	if($_SESSION['role'] == 'group-admin')
	// 		$userroles = ['employee'=>'Employee'];
	// }

	$groupArray = [];
	$obj1 = new myconn;
	try {
		$conn1=$obj1->connection();
		$group = $conn1->prepare("Select * from groups");
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
	
	if(isset($_POST['signup'])) {
		// var_dump($_POST);


		// array(10) { ["nm"]=> string(4) "test" ["phn"]=> string(10) "7896541230" ["gen"]=> string(6) "female" ["datepicker"]=> string(10) "01/26/1992" ["usernm"]=> string(13) "test@test.com" ["pass"]=> string(6) "123456" ["cpass"]=> string(6) "123456" ["add"]=> string(7) "testing" ["role"]=> string(11) "super-admin" ["signup"]=> string(8) "Register" }

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
				try
				{
					$conn=$obj->connection();
					$check=$conn->prepare("Select * from users where username=:em");
					
					$check->bindParam(':em', $usernm);
					$check->execute();
					$count = $check->rowCount();
					if($count==0)
					{
						$q=$conn->prepare("insert into users (first_name,last_name,phone,gender,dob,username,password,address,added_dt,role) values(:fname,:lname,:phone,:gen,:dob,:usernm,SHA(:pass),:add, :dt, :role)");
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
						}
						else {
							$msg="Register Unsuccessfully, please try again later";	
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
		<h2>Add Employee</h2>
		<form id="form1" name="form1" method="post" action="">	
			<div class="form-group">
				<select name="group" required class="form-control">
					<option value="">Select Group</option>
					<?php foreach($groupArray as $key=>$g) { ?>
						<option value="<?=$key?>"><?=$g?></option>
					<?php } ?>
				</select>		  		
		  	</div>	  	
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
		  		<input name="datepicker" type="text" id="datepicker" size="30" placeholder="Date of Birth" class="form-control" />
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
		  	<input type="hidden" name="role" value="employee">
		  	<!-- <div class="form-group"> -->
		  		<!-- <select name="role" class="form-control">
		  			<option value="">User Role</option> -->
		  			<?php //foreach($userroles as $key=>$role){ ?>
		  				<!-- <option value="<?=$key?>"><?=$role?></option> -->
		  			<?php //} ?>
		  		<!-- </select> -->
		  	<!-- </div> -->
		  	<div class="form-group">
		  		<input type="submit" name="signup" id="signup" value="Add Employee" class="btn btn-primary" />
		  	</div>
		  	<div class="form-group">
		  		<?php 
					if(isset($msg)) {
						print $msg;
					} 
				 ?>
		  	</div>
		</form>
	
<?php include_once('admin-footer.php'); ?>