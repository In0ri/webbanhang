<?php 
require_once __DIR__. "/autoload/autoload.php";
$id = intval($_SESSION['name_id']);
$user = $db->fetchID("users",$id);


if($_SERVER["REQUEST_METHOD"] == "POST"){
	$error=[];
	if ( isset( $_POST['g-recaptcha-response'] ) && ! empty( $_POST['g-recaptcha-response'] ) ):
		$secretKey = "6LcRZ5AUAAAAAM_WvJM54rKQ9fDYER_r5Z6o4J6L";
	$responsenKey = $_POST['g-recaptcha-response'];
	$userIP = $_SERVER['REMOTE_ADDR'];

	$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responsenKey&remoteip=$userIP";
	$response = file_get_contents($url);
	$response = json_decode($response);
	if($response->success){
//////////////////////////////////////////////////////////
		if(postInput('password')){
			$password = postInput('password');
			if($user['password'] != md5($password)){
				$_SESSION['error'] ="Mật khẩu không chính xác";
				redirect('chuyen-tien.php');
			}
		}else{
			$error['password'] = "Nhập mật khẩu";
		}

		$Email=to_slugEmail(postInput('email'));
		$Money=postInput('money');
		if(postInput('money')){
			if($user['account'] < $Money){
				$error['money'] = "Bạn không đủ tiền!";
				
			}else{
				$error['money'] = "Nhập số tiền cần chuyển";
			}

			if(postInput('email')){

				$sql = "SELECT email,account FROM users WHERE email= '$Email'";
				$check = $db->fetchsql($sql);
				if($check!=null){
					foreach ($check as $item) {
							# code...
							///Cộng tiền
						$taikhoan = $item['account'] + $Money;
						$up_pro = $db->update("users",array("account" => $taikhoan),array("email" => $Email));
							////Trừ tiền
						$money = $user['account'] - $Money;
						$up = $db->update("users",array("account" => $money),array("id" => $id));
						if($up_pro != null){
							$_SESSION['success'] = "Chuyển tiền thành công!";
							redirect('chuyen-tien.php');
						}else{
							$_SESSION['error'] = "Có lỗi gì đó";
							redirect('chuyen-tien.php');
						}
					}

				}else{
					$error['email'] = "Không tìm thấy email. Mời bạn nhập lại!";
				}
			}else{
				$error['email'] ="Nhập email người nhận";
			}
		}
		
//////////////////////////////////////////////////////////////////////////////////
	} else {
		$_SESSION['error'] = "Robot verification failed, please try again.";
	}
else:
	$_SESSION['error'] = "Please click on the reCAPTCHA box.";
endif;


}
?>
<?php require_once __DIR__. "/layouts/header.php";
?>


<div class="col-md-9 bor">

	<section class="box-main1">
		<h3 class="title-main"><a href=""> Chuyển tiền Online</a> </h3>
		<?php if(isset($_SESSION['success'])) :?>
			<div class="alert alert-success" role="alert">
				<?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
			</div>
		<?php endif; ?>
		<?php if(isset($_SESSION['error'])) :?>
			<div class="alert alert-danger" role="alert">
				<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
			</div>
		<?php endif; ?>
		<!--Nội dung-->
		<form action="" method="POST" class="form-horizontal formcustome" role="form" style="margin-top: 20px;">
			<div class="form-group">
				<label class="col-md-2 col-md-offset-1">Nhập số tiền</label>  
				<div class="col-md-8">
					<input type="number" name="money" placeholder="VND" class="form-control" value="">
					<?php if(isset($error['money'])) :?>
						<p class="text-danger" style="color: red;"><?php echo $error['money']; ?></p>
					<?php endif; ?>
				</div>      	
			</div>
			<div class="form-group">
				<label class="col-md-2 col-md-offset-1">Email người nhận</label>  
				<div class="col-md-8">
					<input type="text" name="email" placeholder="@gmail.com" class="form-control" value="">
					<?php if(isset($error['email'])) :?>
						<p class="text-danger" style="color: red;"><?php echo $error['email']; ?></p>
					<?php endif; ?>

				</div>      	
			</div>
			<div class="form-group">
				<label class="col-md-2 col-md-offset-1">Mật khẩu</label>  
				<div class="col-md-8">
					<input type="password" name="password" placeholder="**************" class="form-control">
					<?php if(isset($error['password'])) :?>
						<p class="text-danger" style="color: red;"><?php echo $error['password']; ?></p>
					<?php endif; ?>
					<div class="g-recaptcha" data-sitekey="6LcRZ5AUAAAAAGadG0-ctBTo9150vVzE3VZJdAbx"></div>
					<button type="submit" class="btn btn-success" name="check">Chuyển tiền</button> 
				</div>

			</div>
		</form>
	</section>
</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
?>