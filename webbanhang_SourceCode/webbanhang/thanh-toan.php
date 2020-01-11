<?php 
	require_once __DIR__. "/autoload/autoload.php";

	$user = $db->fetchID("users",intval($_SESSION['name_id']));
    $id1=intval($_SESSION['name_id']);
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($user['account'] >= $_SESSION['total']){
            $data = [
            'amount' => $_SESSION['total'],
            'users_id' => $_SESSION['name_id'],
            'note' => postInput('note')
        ];

        $idtran = $db->insert("transaction",$data);
        if($idtran > 0){
            foreach($_SESSION['cart'] as $key => $value){
                $data2 = [
                    'transaction_id' => $idtran,
                    'product_id' => $key,
                    'qty' => $value['qty'],
                    'price' => $value['price']
                ];

                $id_insert = $db->insert("orders",$data2);       
            }
            $money = $user['account'] - $_SESSION['total'];
            $up_pro = $db->update("users",array("account" => $money),array("id" => $id1));
        }   

        $_SESSION['success'] = " Lưu thông tin thành công, chúng tôi sẽ liên hệ với bạn sớm nhất";

        }else{
            $_SESSION['error'] = " Tài khoản của bạn không đủ tiền để thực hiện chức năng này!";
        }
        
        header('location: thong-bao.php');
        
    }
 ?>

 <?php require_once __DIR__. "/layouts/header.php";
 ?>
 

 <div class="col-md-9 bor">
    
    <section class="box-main1">
        <h3 class="title-main"><a href=""> Thanh toán giỏ hàng</a> </h3>
        
        <!--Nội dung-->
        <form action="" method="POST" class="form-horizontal formcustome" role="form" style="margin-top: 20px;">
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Tên thành viên</label>  
        		<div class="col-md-8">
        			<input type="text" readonly="" name="name" placeholder="Họ và tên" class="form-control" value="<?php echo $user['name'] ?>">
                   
        		</div>      	
        	</div>
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Email</label>  
        		<div class="col-md-8">
        			<input type="text" readonly="" name="email" placeholder="@gmail.com" class="form-control" value="<?php echo $user['email'] ?>">
                    
        		</div>      	
        	</div>
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Địa chỉ</label>  
        		<div class="col-md-8">
        			<input type="text" readonly="" name="address" placeholder="xã - huyện - tỉnh" class="form-control" value="<?php echo $user['address'] ?>">
                    
        		</div>      	
        	</div>
        	<div class="form-group">
        		<label class="col-md-2 col-md-offset-1">Số điện thoại</label>  
        		<div class="col-md-8">
        			<input type="number" readonly="" name="phone" placeholder="+84" class="form-control" value="<?php echo $user['phone'] ?>">

        		</div> 
        	</div>
            <div class="form-group">
                <label class="col-md-2 col-md-offset-1">Số tiền thanh toán</label>  
                <div class="col-md-8">
                    <input type="text" readonly="" name="phone" placeholder="" class="form-control" value="<?php echo formatPrice($_SESSION['total']) ?> đ">

                </div> 
            </div>
        	<div class="form-group">
                <label class="col-md-2 col-md-offset-1">Ghi chú</label>  
                <div class="col-md-8">
                    <input type="text"  name="note" placeholder="" class="form-control" value="">

                </div>          
            </div>
        	<button type="submit" class="btn btn-success col-md-2 col-md-offset-6" style="margin-bottom: 20px">Xác nhận</button>
        </form>
    </section>
</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
 ?>