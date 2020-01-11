<?php 
$open = "admin";
    require_once __DIR__. "/../../autoload/autoload.php";

    $id = intval(getInput('id'));
    $EditAdmin = $db->fetchID("admin",$id);
    if(empty($EditAdmin)){
        $_SESSION['error']="Dữ liệu không tồn tại";
        redirectAdmin("admin");
    }
    /**
     *  Danh sách danh mục sản phẩm
     */

    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $data=
        [
            "name" => postInput('name'),
            "email" => to_slugEmail(postInput("email")),
            "phone" => postInput("phone"),
            "password" => md5(postInput("password")),
            "address" => postInput("address"),
            "level" => postInput("level")
        ];

        $error =[];
        if (postInput('name') == '') {
            # code...
            $error['name'] = "Mời bạn nhập họ và tên";
        }
        if (postInput('phone') == '') {
            # code...
            $error['phone'] = "Mời bạn nhập SĐT";
        }
         if (postInput('password') == '') {
            # code...
            $error['password'] = "Mời bạn nhập Password";
        }
        if (postInput('address') == '') {
            # code...
            $error['address'] = "Mời bạn nhập địa chỉ";
        }
        if (postInput('email') == '') {
            # code...
            $error['email'] = "Bạn chưa nhập Email";
        }else{
            if(postInput("email") != $EditAdmin['email']){
                $is_check = $db->fetchOne("admin","email = '".$data['email']."' ");
                if($is_check != null){
                    $error['email'] = "Email này đã tồn tại";
                }
            }
            
        }
        if(postInput('password') != NULL && postInput('re_password') != NULL){
            if(postInput('password') != postInput('re_password')){
                $error['password'] = "Mật khẩu không khớp";
            }else{
                $data['password'] = md5(postInput("password"));
            }

        }
        

        if(empty($error)){
           
           $id_update = $db->update("admin",$data,array("id" => $id));
           if($id_update>0){
            move_uploaded_file($file_tmp, $part.$file_name);
            $_SESSION['success'] = "Cập nhật thành công";
            redirectAdmin("admin");
           }else{
            $_SESSION['error'] = "Cập nhật thất bại";
            redirectAdmin("admin");
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
            Cập nhật thông tin Admin
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i></i> <a href="index.php">Danh sách Admin</a>
            </li>
            <li>
                <i class="fa fa-file"></i> Sửa
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
            

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Full Name </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="Nhập tên" name="name" value="<?php echo $EditAdmin['name'] ?>">
                    <?php if(isset($error['name'])): ?>
                        <p class="text-danger"> <?php echo $error['name']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Address </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="Xã - Huyện - Tỉnh" name="address" value="<?php echo $EditAdmin['address'] ?>">
                    <?php if(isset($error['address'])): ?>
                        <p class="text-danger"> <?php echo $error['address']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Email </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="@gmail.com" name="email" value="<?php echo $EditAdmin['email'] ?>">
                    <!--Thông báo lỗi-->
                    <?php if(isset($error['email'])): ?>
                        <p class="text-danger"> <?php echo $error['email']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Phone number </label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="inputEmail3" placeholder="+84 " name="phone" value="<?php echo $EditAdmin['phone'] ?>">
                    <!--Thông báo lỗi-->
                    <?php if(isset($error['phone'])): ?>
                        <p class="text-danger"> <?php echo $error['phone']; ?></p>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Password </label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="inputEmail3" placeholder="******** " name="password">
                    <!--Thông báo lỗi-->
                    <?php if(isset($error['password'])): ?>
                        <p class="text-danger"> <?php echo $error['password']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">ConfigPassword </label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="inputEmail3" placeholder="******** " name="re_password">
                    <!--Thông báo lỗi-->
                    <?php if(isset($error['re_password'])): ?>
                        <p class="text-danger"> <?php echo $error['re_password']; ?></p>
                    <?php endif ?>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Level </label>
                <div class="col-sm-8">
                    <select class="form-control" name="level">
                        <option value="1" <?php echo isset($data['level']) && $data['level'] == 1 ? "selected = 'selected' " : ''; ?>>CTV</option>
                        <option value="2" <?php echo isset($data['level']) && $data['level'] == 2 ? "selected = 'selected' " : ''; ?>>Admin</option>
                    </select>
                    <?php if(isset($error['level'])): ?>
                        <p class="text-danger"> <?php echo $error['level']; ?></p>
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