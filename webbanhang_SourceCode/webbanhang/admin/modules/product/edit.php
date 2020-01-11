<?php 
$open = "product";
    require_once __DIR__. "/../../autoload/autoload.php";

    /**
     *  Danh sách danh mục sản phẩm
     */
    $id = intval(getInput('id'));
    $Editproduct = $db->fetchID("product",$id);
    if(empty($Editproduct)){
        $_SESSION['error']="Dữ liệu không tồn tại";
        redirectAdmin("product");
    }
    $category = $db->fetchAll("category");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data=
        [
            "name" => postInput('name'),
            "slug" => to_slug(postInput("name")),
            "category_id" => postInput("category_id"),
            "price" => postInput("price"),
            "content" => postInput("content"),
            "number" => postInput("number"),
            "sale" => postInput("sale")
        ];

        $error =[];
        if (postInput('name') == '') {
            # code...
            $error['name'] = "Mời bạn nhập tên sản phẩm";
        }
        if (postInput('category_id') == '') {
            # code...
            $error['category_id'] = "Mời bạn chọn danh mục sảm phẩm";
        }
        if (postInput('price') == '') {
            # code...
            $error['price'] = "Mời bạn nhập giá sản phẩm";
        }
        if (postInput('content') == '') {
            # code...
            $error['content'] = "Nội dung còn trống";
        }
        if (postInput('number') == '') {
            # code...
            $error['number'] = "Mời bạn nhập số lượng sản phẩm";
        }

        if(empty($error)){
            if( isset($_FILES['thunbar'])){
                $file_name = $_FILES['thunbar']['name'];
                $file_tmp = $_FILES['thunbar']['tmp_name'];
                $file_type = $_FILES['thunbar']['type'];
                $file_erro = $_FILES['thunbar']['error'];

                if($file_erro == 0){
                    $part = ROOT."product/";
                    $data['thunbar'] = $file_name;
                }
            }
            $update = $db->update("product",$data, array("id"=>$id));
            if($update > 0){
                move_uploaded_file($file_tmp, $part.$file_name);
                $_SESSION['success'] = "Cập nhật thành công";
                redirectAdmin("product");
            }else{
                $_SESSION['error'] = "Cập nhật thất bại";
                redirectAdmin("product");
            }
            

        }
    }
?>
<?php 
    require_once __DIR__. "/../../layouts/header.php";
?>
<!-- Page Heading Nội dung -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Sửa thông tin sản phẩm
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i></i> <a href="index.php">Sản phẩm</a>
            </li>
            <li>
                <i class="fa fa-file"></i>  Sửa
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Danh mục sản phẩm</label>
                <div class="col-sm-8">
                    <select class="form-control col-md-8" name="category_id" id="">
                        <option value="">--Mời bạn chọn danh mục sản phẩm--</option>
                        <?php foreach($category as $item): ?>
                        <option value="<?php echo $item['id'] ?>"<?php echo $Editproduct['category_id'] == $item['id'] ? "selected = 'selected'" : '' ?>><?php echo $item['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if(isset($error['category_id'])): ?>
                        <p class="text-danger"> <?php echo $error['category_id']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Tên sản phẩm</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="Tên sản phẩm" name="name" value="<?php echo $Editproduct['name'] ?>">
                    <?php if(isset($error['name'])): ?>
                        <p class="text-danger"> <?php echo $error['name']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Giá</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="inputEmail3" placeholder="VND" name="price" value="<?php echo $Editproduct['price'] ?>">
                    <!--Thông báo lỗi-->
                    <?php if(isset($error['price'])): ?>
                        <p class="text-danger"> <?php echo $error['price']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Số lượng sản phẩm</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="inputEmail3" placeholder="0" name="number" value="<?php echo $Editproduct['number'] ?>">
                    <!--Thông báo lỗi-->
                    <?php if(isset($error['number'])): ?>
                        <p class="text-danger"> <?php echo $error['number']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label" value="<?php echo $Editproduct['sale'] ?>">Giảm giá</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="inputEmail3" placeholder="%" name="sale" value="<?php echo $Editproduct['sale'] ?>">
                </div>

                <label for="inputEmail3" class="col-sm-1 control-label">Hình ảnh</label>
                <div class="col-sm-3">
                    <input type="file" class="form-control" id="inputEmail3" placeholder="%" name="thunbar">
                    <?php if(isset($error['thunbar'])): ?>
                        <p class="text-danger"> <?php echo $error['thunbar']; ?></p>
                    <?php endif ?>
                    <img src="<?php echo uploads(); ?>product/<?php echo $Editproduct['thunbar'] ?>"  width="50px" height="50px">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label" >Nội dung</label>
                <div class="col-sm-3">
                    <textarea class="form-control" name="content" id="" cols="40" rows="4" ><?php echo $Editproduct['content']; ?></textarea>
                </div>
                <?php if(isset($error['content'])): ?>
                        <p class="text-danger"> <?php echo $error['content']; ?></p>
                    <?php endif ?>
            </div>
            </div>
            
            <!-- <div class="form-group row">
                <div class="col-sm-2">Checkbox</div>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck1">
                        <label class="form-check-label" for="gridCheck1">
                            Example checkbox
                        </label>
                    </div>
                </div>
            </div> -->
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Lưu</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.row -->
<?php 
require_once __DIR__. "/../../layouts/footer.php";
?>