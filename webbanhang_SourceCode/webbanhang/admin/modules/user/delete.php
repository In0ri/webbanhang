<?php 
$open = "user";
    require_once __DIR__. "/../../autoload/autoload.php";
    $id = intval(getInput('id'));

    $Editproduct = $db->fetchID("users",$id);
    if(empty($Editproduct)){
        $_SESSION['error']="Dữ liệu không tồn tại";
        redirectAdmin("user");
    }
    /**
     * Kiểm tra danh mục có sản phẩm chưa
     */
    $num = $db->delete("users",$id);
    if($num > 0){
        $_SESSION['success']="Xóa dữ liệu thành công";
                redirectAdmin("user");
    }else{
        $_SESSION['error']="Xóa dữ liệu thất bại";
                redirectAdmin("user");
    }?>
<?php 
    require_once __DIR__. "/../../layouts/header.php";
?>
