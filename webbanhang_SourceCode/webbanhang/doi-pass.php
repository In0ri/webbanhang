<?php 
	require_once __DIR__. "/autoload/autoload.php";

	$id = intval($_SESSION['name_id']);
	$user = $db->fetchID("users",$id);
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$data=
		[
			"password" => postInput('new_password')
		];
		$error=[];
		if (postInput('old_password') == '') {
            # code...
			$error['old_password'] = "Nhập mật khẩu cũ";
		}else{
			if(md5(postInput("old_password")) != $user['password']){
				$error['old_password'] = "Mật khẩu cũ không chính xác. Mời bạn nhập lại!";
			}
		}
		if (postInput('new_password') == '') {
            # code...
			$error['new_password'] = "Nhập mật khẩu mới";
		}
		if (postInput('re_password') == '') {
            # code...
			$error['re_password'] = "Nhập lại mật khẩu";
		}else{
            if(postInput('re_password') != postInput('new_password')){
                $error['re_password'] = "Mật khẩu không khớp. Mời bạn nhập lại!";
            }else{
                $data['password'] = md5(postInput("new_password"));
            }
        }

		if(empty($error)){

			$id_update = $db->update("users",$data,array("id" => $id));
			if($id_update>0){
				$_SESSION['success'] = "Đổi mật khẩu thành công";
				header("location: index.php");
			}else{
				$_SESSION['error'] = "Đổi mật khẩu thất bại";
				header("location: index.php");
			}
		}

	}
 ?>
 <?php require_once __DIR__. "/layouts/header.php";
 ?>
 

 <div class="col-md-9 bor">
    
    <section class="box-main1">
        <h3 class="title-main"><a href=""> Đổi mật khẩu</a> </h3>
        <!--Nội dung-->
        <form action="" method="POST" class="form-horizontal formcustome" role="form" style="margin-top: 20px;">
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Mật khẩu cũ</label>  
        		<div class="col-md-8">
        			<input type="password" name="old_password" placeholder="**************" class="form-control">
        			<?php if(isset($error['old_password'])): ?>
                        <p class="text-danger"> <?php echo $error['old_password']; ?></p>
                    <?php endif ?>
        		</div>      	
        	</div>

        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Mật khẩu mới</label>  
        		<div class="col-md-8">
        			<input type="password" name="new_password" placeholder="**************" class="form-control">
        			<?php if(isset($error['new_password'])): ?>
                        <p class="text-danger"> <?php echo $error['new_password']; ?></p>
                    <?php endif ?>
        		</div>      	
        	</div>

        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Nhập lại mật khẩu</label>  
        		<div class="col-md-8">
        			<input type="password" name="re_password" placeholder="**************" class="form-control">
        			<?php if(isset($error['re_password'])): ?>
                        <p class="text-danger"> <?php echo $error['re_password']; ?></p>
                    <?php endif ?>
        		</div>      	
        	</div>
        	<button type="submit" class="btn btn-success col-md-2 col-md-offset-6" style="margin-bottom: 20px">Đổi mật khẩu</button>
        </form>
    </section>
</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
 ?>