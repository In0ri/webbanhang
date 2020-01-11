<?php 
	require_once __DIR__. "/autoload/autoload.php";
    $id = intval($_SESSION['name_id']);
    $user = $db->fetchID("users",$id);
	$sum=0;

    if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
        echo "<script>alert('Không có sản phẩm nào trong giỏ hàng');location.href='index.php';</script>";
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
        <h3 class="title-main"><a href=""> Giỏ hàng của bạn</a> </h3>
        <table class="table table-hover">
        	<thead>
        		<tr>
        			<th>STT</th>
        			<th>Tên sản phẩm</th>
        			<th>Hình ảnh</th>
        			<td>Số lượng</td>
        			<th>Đơn giá</th>
        			<td>Thành tiền</td>
        			<td>Thao tác</td>
        		</tr>
        	</thead>
        	<tbody>
        		<?php $stt=1; foreach ($_SESSION['cart'] as $key => $value) :?>
        				<tr>
        					<td><?php echo $stt ?></td>
        					<td><?php echo $value['name'] ?></td>
        					<td>
        						<img src="<?php echo uploads() ?>product/<?php echo $value['thunbar'] ?>" alt="" width="80px" height="80px">
        					</td>
        					<td>
        						<input type="number" name="qty" value="<?php echo $value['qty'] ?>" class="form-control" min=0 style="width: 70px">
        					</td>
        					<td><?php echo formatPrice($value['price']) ?> đ</td>
        					<td><?php echo formatPrice($value['price']*$value['qty']) ?> đ</td>
        					<td>
        						<a href="remove.php?key=<?php echo $key ?>" class="btn btn-xs btn-danger"> <i class="fa fa-trash" aria-hidden="true"> Xóa</i> </a>
        						<a href="" class="btn btn-xs btn-info updatecart" data-key=<?php echo $key ?>> <i class="fa fa-refresh" aria-hidden="true"> Cập nhật</i></a>
        					</td>
        				</tr> 
        				<?php $sum += $value['price']*$value['qty']; $_SESSION['tongtien'] = $sum; ?>
        			<?php $stt++; endforeach; ?>
        	</tbody>
        </table>
        <div class="col-md-5 pull-right">
        	<ul class="list-group">
        		<li class="list-group-item">
        			<h3> Thông tin đơn hàng</h3>
        		</li>
        		<li class="list-group-item">
        			<span class="badge"> <?php echo formatPrice($_SESSION['tongtien']); ?></span>
        			Số tiền
        		</li>
        		<li class="list-group-item">
        			<span class="badge">10 %</span>
        			Thuế VAT
        		</li>
                
                <li class="list-group-item">
                    <span class="badge">
                        <?php if($user['vip'] !=0 ) :?>
                            <span class="badge">30 %</span>
                            <?php else: ?>
                                <span class="badge">0 %</span>
                    <?php endif; ?>
                    </span>
                    VIP
                </li>
        		<li class="list-group-item">
        			<span class="badge">
                    <?php if($user['vip'] !=0 ) :?>
                            <?php $_SESSION['total'] = ($_SESSION['tongtien'] * 110/100)*0.7 ; ?>
                            <?php else: ?>
                                <?php $_SESSION['total'] = $_SESSION['tongtien'] * 110/100; ?>
                    <?php endif; ?>
                     <?php  echo formatPrice($_SESSION['total']); ?>
                        
                    </span>
        			Tổng tiền thanh toán
        			
        		</li>
        		<li class="list-group-item">
        			<a href="index.php" class="btn btn-success"> Tiếp tục mua hàng</a>
        			<a href="thanh-toan.php" class="btn btn-success" > Thanh toán</a>
        		</li>
        	</ul>
        	
        </div>

        <!--Nội dung-->
    </section>
</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
 ?>