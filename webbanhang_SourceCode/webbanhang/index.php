<?php 
require_once __DIR__. "/autoload/autoload.php";
//unset($_SESSION['cart']);
$sqlHomecate = "SELECT name, id FROM category WHERE home = 1 ORDER BY update_at ";
$categoryHome = $db->fetchsql($sqlHomecate);
$data = [];

foreach ($categoryHome as $item) {
        # code...
    $cateId = intval(($item['id']));
    $sql = " SELECT * FROM product WHERE category_id = $cateId ";
    $productHome = $db->fetchsql($sql);
    $data[$item['name']] = $productHome;
}
?>
<?php require_once __DIR__. "/layouts/header.php";
?>


<div class="col-md-9 bor">
    <section id="slide" class="text-center" >
        <img src="<?php echo base_url() ?>public/frontend/images/banner.jpg" class="img-thumbnail">
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
    </section>
    <section class="box-main1">

        <?php foreach ($data as $key => $value): ?>
            <div class="row">
                <h3 class="title-main"><a href="danh-muc-san-pham.php"> <?php echo $key ?></a> </h3>
                <?php foreach ($value as $item): ?>
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
                                <p><a href="addcart.php?id=<?php echo $item['id']; ?>"><i class="fa fa-shopping-basket"></i></a></p>
                            </div>
                            <br>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

        </section>
    </div>
</div>
<?php require_once __DIR__. "/layouts/footer.php";
?>all