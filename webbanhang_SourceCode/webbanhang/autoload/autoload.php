<?php 
session_start();
    require_once __DIR__. "/../libraries/Database.php";
     require_once __DIR__. "/../libraries/Funtion.php";
    $db=new Database;

define("ROOT",$_SERVER['DOCUMENT_ROOT']."/webbanhang/public/uploads/");
$category = $db->fetchAll("category");

//Lấy sản phẩm mới
$sqlNew = "SELECT * FROM product WHERE 1 ORDER BY ID DESC LIMIT 3";
$productNew = $db->fetchsql($sqlNew);
?>
