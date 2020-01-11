<?php 
	require_once __DIR__. "/autoload/autoload.php";
	$id = intval($_SESSION['name_id']);
	$user = $db->fetchID("users",$id);
	

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['naptien'])){
			$_SESSION['error'] = "Chức năng này đang tạm bảo trì. Chúng tôi sẽ quay trở lại sớm nhất!";
		}else{

		}

		if(isset($_POST['chuyentien'])){
			header('location: chuyen-tien.php');
		}else{

		}
	}
 ?>
 <?php require_once __DIR__. "/layouts/header.php";
 ?>
 

 <div class="col-md-9 bor">
    
    <section class="box-main1">
        <h3 class="title-main"><a href=""> Số tiền trong tài khoản</a> </h3>
        <?php if(isset($_SESSION['error'])) :?>
 			<div class="alert alert-danger" role="alert">
 				<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
 			</div>
    	<?php endif; ?>
        <form action="" method="POST" class="form-horizontal formcustome" role="form" style="margin-top: 20px">
        
        <!--Nội dung-->
        <div class="col-md-5 pull-left">
        	<ul class="list-group">
        		<li class="list-group-item">
        			<h3> Thông tin tài khoản</h3>
        		</li>
        		<li class="list-group-item">
        			<span class="badge"><?php echo $user['name'] ?></span>
        			<h4>Chủ tài khoản: </h4>
        			
        		</li>
        		<li class="list-group-item">
        			<span class="badge"><?php echo $user['account'] == 0 ? "0" : formatPrice($user['account']); ?> đ</span>
        			Số dư
        		</li>
        		<li class="list-group-item">
        			<h4>Thao tác</h4>
                    <button type="submit" class="btn btn-success" name="naptien">Nạp tiền</button>
        		    <button type="submit" class="btn btn-success" name="chuyentien">Chuyển tiền</button>	

        		</li>
        	</ul>
        	
        </div>
    </form>
    </section>
</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
 ?>