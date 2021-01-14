<?php if(isset($_GET['employee'])){ ?>
	<?php
		include('../includes/connection.php');

		$obj = new myconn;

		$employee = $_GET['employee'];
		try {
			$con = $obj->connection();
			$q = $con->prepare("Select * from accruals where emp_id=:emp");
			$q->bindParam(':emp', $employee);
			$q->execute();
			$count = $q->rowCount();
			if($count>0) {
				while($x = $q->fetch(PDO::FETCH_ASSOC)){
					$shifts[]= $x;
				}
			}
		} catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}

		// var_dump($max);
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<title>HRMS</title>
			<!-- Latest compiled and minified CSS -->
			<!-- Bootstrap 3.3.7 -->
		    <link rel="stylesheet" href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
		    <!-- Font Awesome -->
		    <link rel="stylesheet" href="../assets/bower_components/font-awesome/css/font-awesome.min.css">
		    <!-- Ionicons -->
		    <link rel="stylesheet" href="../assets/bower_components/Ionicons/css/ionicons.min.css">
		    <!-- Theme style -->
		    <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
		    <!-- iCheck -->
		    <!-- <link rel="stylesheet" href="../assets/plugins/iCheck/square/blue.css"> -->
		    
		    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		    <!--[if lt IE 9]>
		    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		    <![endif]-->
		    <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
		    <!-- Google Font -->
		    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
			<!-- jQuery library -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
			<!-- Latest compiled JavaScript -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
			<!-- <script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script> -->
			<!-- <script src="../js/custom.js"></script>
			<script src="../js/moment.min.js"></script>
			<script src="../js/pikaday.js"></script> --> 

			<!-- <link rel="stylesheet" href="../assets/plugins/timepicker/bootstrap-timepicker.min.css"> -->

			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />
			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

			<!-- DataTables -->
			<link rel="stylesheet" href="../assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
			<script src="../assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
			<script src="../assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

		</head>
		<body>
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover table-condensed" >
						<thead>
							<tr>
								<th></th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Accrual Account</th>
								<th>Type</th>
								<th>Amount</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($shifts as $key=>$shift){
								$emp = getEmployee($shift['emp_id']);
								?>
								<tr>
									<td><?=$key+1?></td>
									<td><?=$emp['fname']?></td>
									<td><?=$emp['lname']?></td>
									<td><?=$shift['accrual_account']?></td>
									<td><?=$shift['type']?></td>
									<td><?=$shift['amount']?></td>
									<td><?=$shift['date']?></td>
								</tr>
							<?php } ?>
						</tbody>

					</table>
				</div>
			</div>
		</body>
	</html>
<?php } ?>