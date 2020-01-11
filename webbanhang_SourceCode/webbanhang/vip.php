<?php 
	require_once __DIR__. "/autoload/autoload.php";

	$id = intval($_SESSION['name_id']);
	$user = $db->fetchID("users",$id);
    //Xử lý
   
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $vipmonth = 200000;
            $vipyear = 1500000;

            if(!postInput('month')){
                if($user['account'] > $vipmonth){
                    $today = date('Y-m-d');
                    $month = strtotime(date("Y-m-d", strtotime($today)) . " +1 month");
                    $month = strftime("%Y-%m-%d", $month);
                    $data=[
                        "vip" => 1,
                        "ngaytaovip" => $today,
                        "hanvip" => $month
                    ];
                    $id_update = $db->update("users",$data,array("id" => $id));
                    
                    if($id_update > 0){
                        $_SESSION['success'] = "Đăng kí thành công";

                        $money = $user['account'] - $vipmonth;
                        $up_pro = $db->update("users",array("account" => $money),array("id" => $id));
                        header("location: vip.php");
                    }
                }else{
                        $_SESSION['error'] = "Đăng kí thất bại. Bạn không đủ tiền";
                    }

            }

            ///////////////////////////////

            if(!postInput('year')){
                if($user['account'] > $vipyear){
                    $today = date('Y-m-d');
                    $year = strtotime(date("Y-m-d", strtotime($today)) . " +1 year");
                    $year = strftime("%Y-%m-%d", $year);
                    $data=[
                        "vip" => 1,
                        "ngaytaovip" => $today,
                        "hanvip" => $year
                    ];
                     $id_update = $db->update("users",$data,array("id" => $id));
                    if($id_update > 0){
                        $_SESSION['success'] = "Đăng kí thành công";
                        $money = $user['account'] - $vipyear;
                        $up_pro = $db->update("users",array("account" => $money),array("id" => $id));
                        header("location: vip.php");
                    }
                }else{
                        $_SESSION['error'] = "Đăng kí thất bại. Bạn không đủ tiền";
                    }
            }
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
        <h3 class="title-main"><a href=""> Thành viên VIP</a> </h3>
        
        <!--Nội dung-->
        <form action="" method="POST" class="form-horizontal formcustome" role="form" style="margin-top: 20px;">
        <?php if($user['vip'] == 0) :?>
        	<div class="col-md-5 pull-left">
        	<ul class="list-group">
        		<li class="list-group-item">
        			<h3> Thông tin VIP</h3>
        		</li>
        		<li class="list-group-item">
        			<h4>Bạn chưa có VIP</h4>	
        		</li>
        		<li class="list-group-item">
        			<h5>Quyền lợi VIP</h5>	
        			<p>Ưu đãi giảm giá 30% tổng đơn hàng khi có VIP</p>
        		</li>
        		<li class="list-group-item">
        			<h4>Gia hạn</h4>
        			<button type="submit" class="btn btn-success" name="month">1 Tháng</button>
                    <button type="submit" class="btn btn-success" name="year">1 Năm</button>

        		</li>
        	</ul>
        	
        </div>
        <?php else: ?>
        	<div class="col-md-5 pull-left">
        	<ul class="list-group">
        		<li class="list-group-item">
        			<h3> Thông tin VIP</h3>
        		</li>
        		<li class="list-group-item">
        			<span class="badge"> <?php echo $user['ngaytaovip'] ?> </span>
        			Ngày đăng kí
        		</li>
                <?php 
                $first_date = strtotime(date('Y-m-d'));
                $second_date = strtotime($user['hanvip']);
                $datediff = abs($first_date - $second_date);
                
                 ?>
        		<li class="list-group-item">
        			<span class="badge"><?php echo floor($datediff / (60*60*24)); ?></span>
        			Còn lại
        		</li>
        		<li class="list-group-item">
        			<h5>Quyền lợi VIP</h5>	
        			<p>Ưu đãi giảm giá 30% tổng đơn hàng khi có VIP</p>
        		</li>
        		<li class="list-group-item">
        			<h4>Gia hạn</h4>
                    <button type="submit" class="btn btn-success" name="month">1 Tháng</button>
        		    <button type="submit" class="btn btn-success" name="year">1 Năm</button>

        		</li>
        	</ul>
        	
        </div>
        	
        <?php endif; ?>
    </form>
    </section>
</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
 ?>