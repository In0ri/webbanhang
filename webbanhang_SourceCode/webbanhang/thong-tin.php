<?php 
	require_once __DIR__. "/autoload/autoload.php";
	$id = intval($_SESSION['name_id']);
	$user = $db->fetchID("users",$id);
	$EditUser = $db->fetchID("users",$id);
	if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $data=
        [
            "name" => postInput('name'),
            "email" => to_slugEmail(postInput("email")),
            "phone" => postInput("phone"),
            "address" => postInput("address")
        ];
        $error=[];
        if(postInput("email") != $user['email']){
        	if(postInput("email") != $EditUser['email']){
        		$is_check = $db->fetchOne("users","email = '".$data['email']."' ");
        		if($is_check != null){
        			$error['email'] = "Email này đã tồn tại";
        		}
        	}
        }
        if (postInput('password') == '') {
            # code...
            $error['password'] = "Bạn cần nhập mật khẩu để thực hiện chức năng này";
        }else{
        	if(md5(postInput("password")) != $user['password']){
        		$error['password'] = "Mật khẩu không chính xác. Mời bạn nhập lại!";
        	}
        }

        if(empty($error)){
           
           $id_update = $db->update("users",$data,array("id" => $id));
           if($id_update>0){
            $_SESSION['success'] = "Cập nhật thành công";
            header("location: index.php");
           }else{
            $_SESSION['error'] = "Cập nhật thất bại";
            header("location: index.php");
           }
        }

    }
        
 ?>
 <?php require_once __DIR__. "/layouts/header.php";
 ?>
 

 <div class="col-md-9 bor">
    
    <section class="box-main1">
        <h3 class="title-main"><a href=""> Thông tin cá nhân</a> </h3>
        <!--Nội dung-->
        <form action="" method="POST" class="form-horizontal formcustome" role="form" style="margin-top: 20px;">
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Tên thành viên</label>  
        		<div class="col-md-8">
        			<input type="text" name="name" placeholder="Họ và tên" class="form-control" value="<?php echo $user['name'] ?>">
                   
        		</div>      	
        	</div>
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Email</label>  
        		<div class="col-md-8">
        			<input type="text" name="email" placeholder="@gmail.com" class="form-control" value="<?php echo $user['email'] ?>">
                    <?php if(isset($error['email'])): ?>
                        <p class="text-danger"> <?php echo $error['email']; ?></p>
                    <?php endif ?>
        		</div>      	
        	</div>
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Địa chỉ</label>  
        		<div class="col-md-8">
        			<input type="text" name="address" placeholder="xã - huyện - tỉnh" class="form-control" value="<?php echo $user['address'] ?>">
                    
        		</div>      	
        	</div>
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Số điện thoại</label>  
        		<div class="col-md-8">
        			<input type="number" name="phone" placeholder="+84" class="form-control" value="<?php echo $user['phone'] ?>">
                    
        		</div> 

        	</div>
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Mật khẩu</label>  
        		<div class="col-md-8">
        			<input type="password" name="password" placeholder="**************" class="form-control">
        			<?php if(isset($error['password'])): ?>
                        <p class="text-danger"> <?php echo $error['password']; ?></p>
                    <?php endif ?>
        		</div>      	
        	</div>
        	<button type="submit" class="btn btn-success col-md-2 col-md-offset-6" style="margin-bottom: 20px">Cập nhật thông tin</button>
        </form>
    </section>
</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
 ?>