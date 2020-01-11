<?php 
	require_once __DIR__. "/autoload/autoload.php";

    if (isset($_SESSION['name_id'])) {
        # code...
        echo "<script>alert('Bạn đã có tài khoản!');location.href='index.php'</script>";
    }
     $data=
        [
            "name" => postInput('name'),
            "email" => to_slugEmail(postInput("email")),
            "phone" => postInput("phone"),
            "address" => postInput("address"),
            "password" => (postInput("password"))
        ];
    //Xử lý
   
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $error=[];
        if($data['name'] == ''){
            $error['name'] = "Tên không được để trống";
        }

        if($data['email'] == ''){
            $error['email'] = "Email không được để trống";
        }else{
            $is_check = $db->fetchOne("users","email = '".$data['email']."' ");
            if($is_check != null){
                $error['email'] = "Email này đã tồn tại";
            }
        }


        if($data['address'] == ''){
            $error['address'] = "Địa chỉ không được để trống";
        }

        if($data['phone'] == ''){
            $error['phone'] = "Số điện thoại không được để trống";
        }

        if($data['password'] == ''){
            $error['password'] = "Mật khẩu không được để trống";
        }else{
            $data['password'] = md5(postInput("password"));
        }

        //Kiểm tra mảng error

        if(empty($error)){
            $idinsert = $db->insert("users",$data);
            if($idinsert > 0){
                $_SESSION['success'] = "Đăng kí thành công";
               header("location: dang-nhap.php");
            }else{
                $_SESSION['error'] = "Đăng kí thất bại";
            }
        }   
        echo $data['email'];
    }
 ?>
 <?php require_once __DIR__. "/layouts/header.php";
 ?>
 

 <div class="col-md-9 bor">
    
    <section class="box-main1">
        <h3 class="title-main"><a href=""> Đăng kí thành viên</a> </h3>
        <form action="" method="POST" class="form-horizontal formcustome" role="form" style="margin-top: 20px;">
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Tên thành viên</label>  
        		<div class="col-md-8">
        			<input type="text" name="name" placeholder="Họ và tên" class="form-control" value="<?php echo $data['name'] ?>">
                    <?php if(isset($error['name'])) :?>
                        <p class="text-danger" style="color: red;"><?php echo $error['name']; ?></p>
                    <?php endif; ?>
        		</div>      	
        	</div>
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
        		<label class="col-md-2 col-md-offset-1">Địa chỉ</label>  
        		<div class="col-md-8">
        			<input type="text" name="address" placeholder="xã - huyện - tỉnh" class="form-control" value="<?php echo $data['address'] ?>">
                    <?php if(isset($error['address'])) :?>
                        <p class="text-danger" style="color: red;"><?php echo $error['address']; ?></p>
                    <?php endif; ?>
        		</div>      	
        	</div>
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Số điện thoại</label>  
        		<div class="col-md-8">
        			<input type="number" name="phone" placeholder="+84" class="form-control" value="<?php echo $data['phone'] ?>">
                    <?php if(isset($error['phone'])) :?>
                        <p class="text-danger" style="color: red;"><?php echo $error['phone']; ?></p>
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
        	<button type="submit" class="btn btn-success col-md-2 col-md-offset-6" style="margin-bottom: 20px">Đăng kí</button>
        </form>
        
        <!--Nội dung-->
    </section>
</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
 ?>