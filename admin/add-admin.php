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
	
	if(isset($_POST['signup'])) {
        
        $empid = $_POST['employee'];
        $company = $_POST['company'];
        
        $obj = new myconn;
        $conn = $obj->connection();
		$check = $conn->prepare("Select * from employee where id=:id");				
		$check->bindParam(':id', $empid);
		$check->execute();
		$count = $check->rowCount();
		$empl = $check->fetch(PDO::FETCH_BOTH);
		
		$fname = $empl['fname'];
		$lname = $empl['lname'];
		$usernm = $empl['username'];
		$pass = $empl['password'];
		$role = 'group-admin';
		$group = $_POST['company'];
		$dt=date('Y-m-d H-i-s');
		
		$obj=new myconn;
		try
		{
			$conn=$obj->connection();
			
			$q=$conn->prepare("insert into mainusers (first_name,last_name,username,password,added_dt,role,groupid,empid) values(:fname,:lname,:usernm,:pass, :dt, :role,:group,:empid)");
			$q->bindParam(':fname', $fname);
			$q->bindParam(':lname', $lname);
			$q->bindParam(':usernm', $usernm);
			$q->bindParam(':pass', $pass);
			$q->bindParam(':dt', $dt);
			$q->bindParam(':role', $role);
			$q->bindParam(':group', $group);
			$q->bindParam(':empid', $empid);
			$q->execute();
			$count = $q->rowCount();
			if($count==1) {
				$msg = 'Register Successfully';
				
				$headers = 'From: HRMS <noreply@hrms.com>'."\r\n";
				$headers .= 'Bcc: 26rinky@gmail.com'."\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				mail($usernm, ucwords($groupArray[$group]).' - Registered as Admin', 'Your email registered as admin, you can login as your employee`s credentials', $headers);
			}
			else {
				$msg="Register Unsuccessfully, please try again later";	
			}
				
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
			
	}
    
    $obj1 = new myconn;
	try {
		$conn1=$obj1->connection();
		if($_SESSION['main']['role'] == 'group-admin'){
		    $gid = $_SESSION['main']['gid'];
		    $employees = $conn1->prepare("Select * from employee where groupid=:gid and id NOT IN (Select empid from mainusers where groupid=:gid)");
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
		<h1>Add Company Admin</h1>
			<ol class="breadcrumb">
				<li><a href="https://terraorb.xyz/hrms/admin"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Add Company Admin</li>
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
						    <i class="fa fa-user-plus"></i> <h3 class="box-title">Add Admin</h3>
						<?php } ?>
						
					</div>
					<div class="box-body">
						<form id="form1" name="form1" method="post" action="">
						    <?php 
						        $display = '';
						        $selected = '';
						        if($_SESSION['main']['role'] == 'group-admin'){
						            $display = 'style="display:none;"';
						            $selected = $_SESSION['main']['gid'];
						        }
						    ?>	
							<div class="form-group">
								<select name="company" required class="form-control ar-company" <?=$display?>>
									<option value="">Select Company</option>
									<?php foreach($groupArray as $key=>$g) { ?>
										<option value="<?=$key?>" <?=($selected==$key)?'selected="selected"':''?>><?=$g?></option>
									<?php } ?>
								</select>		  		
						  	</div>
						  	<div class="form-group">
								<select name="employee" required class="form-control ar-employee">
									<option value="">Select Employee</option>
									<?php if($_SESSION['main']['role'] == 'group-admin'){ ?>
										<?php foreach($employee as $key=>$emp) { ?>
											<option value="<?=$key?>"><?=$emp?></option>
										<?php } ?>
									<?php } ?>
								</select>		  		
						  	</div>
						  	<div class="form-group">
						  		<input type="submit" name="signup" id="signup" value="Add Admin" class="btn btn-primary" />
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
	
<?php include_once('admin-footer.php'); ?>