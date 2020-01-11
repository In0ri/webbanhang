<?php 
	require_once __DIR__. "/autoload/autoload.php";
	unset($_SESSION['cart']);
	unset($_SESSION['total']);
    _debug($_SESSION['error']);
 ?>
 <?php require_once __DIR__. "/layouts/header.php";
 unset($_SESSION['cart']);
 unset($_SESSION['total']);
 ?>
 

 <div class="col-md-9 bor">
    
    <section class="box-main1">
        <h3 class="title-main"><a href=""> Thông báo thanh toán</a> </h3>
        <?php if(isset($_SESSION['success'])) :?>
 			<div class="alert alert-success">
 				<?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
 			</div>
 			<?php elseif (isset($_SESSION['error'])) :?>
 				<div class="alert alert-danger">
 				<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
 			</div>
    	<?php endif; ?>
    	<a href="index.php" class="btn btn-success"> Trở về trang chủ</a>
        
        <!--Nội dung-->
    </section>
</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
 ?>