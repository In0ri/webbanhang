<?php 
	require_once __DIR__. "/autoload/autoload.php";

     $data=
        [
            "email" => to_slugEmail(postInput("email")),
            "password" => (postInput("password"))
        ];
    //Xử lý
   
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $error=[];
///////////////////////////////////////////////////////////////////
        if ( isset( $_POST['g-recaptcha-response'] ) && ! empty( $_POST['g-recaptcha-response'] ) ):
            $secretKey = "6LcRZ5AUAAAAAM_WvJM54rKQ9fDYER_r5Z6o4J6L";
            $responsenKey = $_POST['g-recaptcha-response'];
            $userIP = $_SERVER['REMOTE_ADDR'];

            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responsenKey&remoteip=$userIP";
            $response = file_get_contents($url);
            $response = json_decode($response);
            if($response->success){
                if($data['email'] == ''){
                    $error['email'] = "Email không được để trống";
                }

                if($data['password'] == ''){
                    $error['password'] = "Mật khẩu không được để trống";
                }

        //Kiểm tra mảng error

                if(empty($error)){
                    $is_check = $db->fetchone("users","email = '".$data['email']."' AND password = '".md5($data['password'])."'");
                    if($is_check != NULL){
                        $_SESSION['name_user'] = $is_check['name'];
                        $_SESSION['name_id'] = $is_check['id'];
                        echo "<script>alert('Đăng nhập thành công');location.href='index.php'</script>";
                    }else{
                        $_SESSION['error'] = "Đăng nhập thất bại";
                    }
                }   
            } else {
                $_SESSION['error'] = "Robot verification failed, please try again.";
            }
        else:
            $_SESSION['error'] = "Please click on the reCAPTCHA box.";
        endif;

//////////////////////////////////////////////////////
        
    }
 ?>
 <?php require_once __DIR__. "/layouts/header.php";
 ?>
 

 <div class="col-md-9 bor">
    
 	<section class="box-main1">
 		<?php if(isset($_SESSION['success'])) :?>
 			<div class="alert alert-success">
 				<?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
 			</div>
    	<?php endif; ?>

    	<?php if(isset($_SESSION['error'])) :?>
 			<div class="alert alert-danger" role="alert">
 				<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
 			</div>
    	<?php endif; ?>
        <h3 class="title-main"><a href="">Đăng nhập</a> </h3>
        <form action="" method="POST" class="form-horizontal formcustome" role="form" style="margin-top: 20px">
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Email</label>  
        		<div class="col-md-8">
        			<input type="text" name="email" placeholder="@gmail.com" class="form-control" value="<?php echo $data['email'] ?>">
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
        		</div>      	
        	</div>
            <div class="g-recaptcha col-md-offset-5" data-sitekey="6LcRZ5AUAAAAAGadG0-ctBTo9150vVzE3VZJdAbx"></div>
        	<button type="submit" class="btn btn-success col-md-2 col-md-offset-6" style="margin-bottom: 20px">Đăng nhập</button>
        </form>
        
        <!--Nội dung-->
    </section>
</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
 ?>
 <script></script>