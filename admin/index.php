<?php
	include('../includes/connection.php');
	$role = '';
	if(isset($_SESSION['main']['uname'])){
		$role = $_SESSION['main']['role'];
		
	} else {
		header('Location: ../index.php');
	}

	$groupArray = [];
	$userArray = [];
	if($role == 'group-admin') {

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


		$obj = new myconn;
		$currRole = 'employee';
		try {
			$conn=$obj->connection();
			$q = $conn->prepare("Select * from mainusers where role LIKE :role and groupid=:gid");
			$q->bindParam(':role', $currRole);
			$q->bindParam(':gid', $_SESSION['main']['gid']);
			$q->execute();
			$count = $q->rowCount();
			if($count>0) {
				while($x = $q->fetch(PDO::FETCH_BOTH)){
					$userArray[] = $x;
				}

			}
		} catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}
?>
<?php 
	include('admin-header.php');
	

?>
   
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Welcome <?=$_SESSION['main']['name']?></h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Dashboard</li>
			</ol>
	</section>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
			<div class="inner">
			<h3>150</h3>

			<p>New Orders</p>
			</div>
			<div class="icon">
			<i class="ion ion-bag"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
			<div class="inner">
			<h3>53<sup style="font-size: 20px">%</sup></h3>

			<p>Bounce Rate</p>
			</div>
			<div class="icon">
			<i class="ion ion-stats-bars"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
			<div class="inner">
			<h3>44</h3>

			<p>User Registrations</p>
			</div>
			<div class="icon">
			<i class="ion ion-person-add"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
			<div class="inner">
			<h3>65</h3>

			<p>Unique Visitors</p>
			</div>
			<div class="icon">
			<i class="ion ion-pie-graph"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
			</div>
			<!-- ./col -->
		</div>
		<!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <!-- quick email widget -->
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Quick Email</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="#" method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" placeholder="Subject">
                </div>
                <div>
                  <textarea class="textarea" placeholder="Message"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              </form>
            </div>
            <div class="box-footer clearfix">
              <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>
	

	<?php if(count($userArray)){ ?>
		<div class="employee-list">
			<table width="50%">
				<tr>
					<th>Status</th>
					<th>Employee#</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Contact</th>
				</tr>
				<?php foreach($userArray as $user){ ?>
					<tr>
						<td></td>
						<td><?=$user['id']?></td>
						<td><?=$user['first_name']?></td>
						<td><?=$user['last_name']?></td>
						<td><?=$user['phone']?></td>
					</tr>
				<?php } ?>		
			</table>
		</div>
	<?php } ?>


	
<?php include('admin-footer.php'); ?>
