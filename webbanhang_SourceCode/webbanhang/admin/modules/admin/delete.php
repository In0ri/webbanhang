<?php 
$open = "admin";
    require_once __DIR__. "/../../autoload/autoload.php";
    $id = intval(getInput('id'));

    $Editproduct = $db->fetchID("admin",$id);
    if(empty($Editproduct)){
        $_SESSION['error']="Dữ liệu không tồn tại";
        redirectAdmin("admin");
    }
    /**
     * Kiểm tra danh mục có sản phẩm chưa
     */
    $num = $db->delete("admin",$id);
    if($num > 0){
        $_SESSION['success']="Xóa dữ liệu thành công";
                redirectAdmin("admin");
    }else{
        $_SESSION['error']="Xóa dữ liệu thất bại";
                redirectAdmin("admin");
    }
?>
<?php 
    require_once __DIR__. "/../../layouts/header.php";
?>
