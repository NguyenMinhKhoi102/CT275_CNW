<?php

use CT275\Labs\KhachHang;
use CT275\Labs\LoaiSanPham;
use CT275\Labs\SanPham;

require_once "../../bootstrap.php";
session_start();
if (isset($_SESSION["adminID"])) {
    $admin = new KhachHang($PDO);
    $admin->find($_SESSION["adminID"]);
} else {
    redirect("/quantri/dangnhap.php");
}
$loaisanpham = new LoaiSanPham($PDO);
$sp = new SanPham($PDO);


if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['id'])
    && ($loaisanpham->find($_POST['id'])) !== null
) {
    if(!empty($sp->findLoaiSP($loaisanpham->getId()))){
        echo "<script>alert('Không thể xóa loại sản phẩm này! Một số sản phẩm đang thuộc loại sản phẩm bạn đang muốn xóa')</script>";
        echo "<script>window.location.href = 'hienthiloaisanpham.php'</script>";
    }
    $loaisanpham->delete();
    redirect(BASE_URL_PATH . "quantri/hienthiloaisanpham.php");
}


$id = isset($_REQUEST['id']) ?
    filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;
if ($id > 0)
    $loaisanpham->find($id);
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loaisanpham->fill($_POST);
    if ($loaisanpham->validate()) {
        $loaisanpham->save();
        redirect(BASE_URL_PATH . "quantri/hienthiloaisanpham.php");
    }

    $errors = $loaisanpham->getValidationErrors();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="container-fluid">
    <header class="row">
        <div>
            <i class="fa fa-bars" id="control-bars"></i>
            <div class="logo pl-5">Bán Mắt Kính</div>
        </div>
        <div class="dropdown">
            <div class="dropdown-select">
                <span class="dropdown-value">
                    <div>
                        <img class="avatar" src="https://live.staticflickr.com/491/31818797506_41e52a8b36.jpg" alt="">
                        Nguyễn Minh Khôi
                    </div>
                    <i class="fa fa-caret-down ml-2"></i>
                </span>
            </div>
            <div class="dropdown-list">
                <div class="arrow-up"></div>
                <a class="dropdown-item" href="./hienthitaikhoan.php"><i class="fa fa-user"></i> Tài khoản</a>
                <a class="dropdown-item" href="./xulytaikhoan.php?dangxuat=1"><i class="fa fa-sign-out"></i> Đăng xuất</a>
            </div>
        </div>
    </header>
    <main>
        <h1 class="text-center"><?= $id < 0 ? "Thêm" : "Sửa" ?> loại sản phẩm</h1>
        <div class="row">
            <div class="col-4"></div>
            <form name="frm" id="frm" action="" method="post" class="col m-auto text-dark" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="name" class="font-weight-bold">Tên loại sản phẩm: </label>
                    <input type="text" name="txtTenLoai" class="form-control" maxlen="255" id="name" placeholder="Nhập vào tên loại" value="<?= isset($loaisanpham->tenloai) ? $loaisanpham->tenloai : ''; ?>" />
                    <span>
                        <?= isset($errors["tenloai"]) ? $errors["tenloai"] : "" ?>
                    </span>
                </div>


                <a href="hienthiloaisanpham.php" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Trở về</a>
                <button type="submit" name="btnSubmit" id="submit" class="btn btn-primary float-right"><?= ($id < 0) ? "Thêm" : "Sửa" ?> loại sản phẩm</button>
            </form>
            <div class="col-4"></div>
        </div>

    </main>

</body>

</html>