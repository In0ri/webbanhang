<?php 
require_once __DIR__. "/autoload/autoload.php";
$id = intval(getInput('id'));

//chi tiết sản phẩm
$product = $db->fetchID("product",$id);
//Lấy danh mục sản phẩm
$cateid = $product['category_id'];
$sql = "select * from product where category_id = $cateid order by ID desc limit 4";
$sanphamkemtheo = $db->fetchsql($sql);

?>
<?php require_once __DIR__. "/layouts/header.php";
?>


<div class="col-md-9 bor">

	<section class="box-main1" >
		<div class="col-md-6 text-center">
			<img src="<?php echo uploads() ?>product/<?php echo $product['thunbar'] ?>" class="img-responsive bor" id="imgmain" width="100%" height="370" data-zoom-image="images/16-270x270.png">

		</div>
		<div class="col-md-6 bor" style="margin-top: 20px;padding: 30px;">
			<ul id="right">
				<li><h3> <?php echo $product['name'] ?> </h3></li>
				<?php if($product['sale'] > 0) :?>
					<li><p> Giảm giá <?php echo $product['sale'] ?>% </p></li>
					<li><p><strike class="sale"><?php echo formatPrice( $item['price']) ?> đ</strike> 
						<b class="price"><?php echo formatPriceSale($item['price'],$item['sale']) ?> đ</b>
					</li>
					<?php else: ?>
						<li>
							<b class="price"><?php echo formatPriceSale($item['price'],$item['sale']) ?> đ</b>
						</li>
						<?php $idsp = $item['id'] ?>
					<?php endif ?>

					<li><a href="addcart.php?id=<?php echo $product['id'] ?>" class="btn btn-default"> <i class="fa fa-shopping-basket"></i>Add TO Cart</a></li>
				</ul>
			</div>

		</section>
		<div class="col-md-12" id="tabdetail">
			<div class="row">

				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#home">Mô tả sản phẩm </a></li>
					<li><a data-toggle="tab" href="#menu1">Thông tin khác </a></li>
				</ul>
				<div class="tab-content">
					<div id="home" class="tab-pane fade in active">
						<h3>Nội dung</h3>
						<p><?php echo $product['content'] ?></p>
					</div>
					<div id="menu1" class="tab-pane fade">
						<h3> Thông tin khác </h3>
						<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					</div>
					
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="row">
				<h3 class="title-main" style="color: blue"><?php echo "Sảm phẩm tương tự"; ?></h3>
                <?php foreach ($sanphamkemtheo as $item): ?>
                    <div class="col-md-3 item-product bor">
                        <a href="chi-tiet-san-pham.php?id=<?php echo $item['id'] ?>">
                            <img src="<?php echo uploads() ?>product/<?php echo $item['thunbar'] ?>" class="" width="100%" height="180">
                        </a>
                        <div class="info-item">
                            <a href=""><?php echo $item['name'] ?></a>
                            <p><strike class="sale"><?php echo formatPrice( $item['price']) ?> đ</strike> <b class="price">
                                <?php echo formatPriceSale($item['price'],$item['sale']) ?> đ</b></p>
                            </div>
                            <div class="hidenitem">
                                <p><a href=""><i class="fa fa-search"></i></a></p>
                                <p><a href=""><i class="fa fa-heart"></i></a></p>
                                <p><a href=""><i class="fa fa-shopping-basket"></i></a></p>
                            </div>
                            <br>
                        </div>
                    <?php endforeach; ?>
                </div>
		</div>
	</div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
?>