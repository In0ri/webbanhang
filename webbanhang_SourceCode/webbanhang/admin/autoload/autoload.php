<?php 
session_start();
    require_once __DIR__. "/../../libraries/Database.php";
     require_once __DIR__. "/../../libraries/Funtion.php";
    $db=new Database;

define("ROOT",$_SERVER['DOCUMENT_ROOT']."/webbanhang/public/uploads/");

 ?>