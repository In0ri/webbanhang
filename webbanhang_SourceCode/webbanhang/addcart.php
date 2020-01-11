<?php 
	require_once __DIR__. "/autoload/autoload.php";

    if ( !isset($_SESSION['name_id'])) {
        # code...
        echo "<script>alert('Bạn chưa đăng nhập!');location.href='index.php'</script>";
    }


    $id = intval(getInput('id'));
    $product = $db->fetchID("product",$id);
    if(!isset($_SESSION['cart'][$id])){
    	$_SESSION['cart'][$id]['name'] = $product['name'];
    	$_SESSION['cart'][$id]['thunbar'] = $product['thunbar'];
    	$_SESSION['cart'][$id]['price'] = ((100 - $product['sale']) * $product['price']) / 100;
    	$_SESSION['cart'][$id]['qty'] = 1;
    		
    }else{
    	$_SESSION['cart'][$id]['qty'] +=1;
    }
    echo "<script>alert('Đã thêm vào giỏ hàng!');location.href='gio-hang.php'</script>";
 ?>