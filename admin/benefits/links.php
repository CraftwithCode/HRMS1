<?php
	$object = new myconn;
	try {
		$empdata=[];
		$con = $object->connection();
		if(isset($_GET['id'])){
			$empid = $_GET['id'];
			$emp = $con->prepare('SELECT * from benefit_links where emp_id=:empid');
			$emp->bindParam(':empid',$empid);
			$emp->execute();
			$empcount= $emp->rowCount();
			if($empcount){
				$data = $emp->fetch(PDO::FETCH_ASSOC);
				// var_dump($empdata);
			}
		}

	} catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
?>
<div class="box">
    <div class="box-header">
     	<h3 class="box-title">Additional Links</h3>
     	<?php if(!$data){ ?><div class="pull-right box-title"><a href="/hrms/admin/benefit-link.php<?=(isset($_GET['id']))?'?id='.$_GET["id"]:''?>" class="">Add New</a></div><?php } else { ?><div class="pull-right box-title"><a href="/hrms/admin/benefit-link.php?id=<?=$_GET['id']?>&edit=<?=$data['id']?>">Edit</a> | <a href="#" data-id="<?=$data['id']?>" data-type="benefit-links" class="ar-del">Delete</a></div><?php } ?>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    	<div class="">
    		<?php if($data){ ?>
    			<?=$data['additional']?>
    		<?php } ?>
    	</div>
     	
    </div>
    <!-- /.box-body -->
</div>