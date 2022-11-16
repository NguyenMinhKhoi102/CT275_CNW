<?php

use CT275\Labs\KhachHang;
use CT275\Labs\SanPham;
use CT275\Labs\LoaiSanPham;
use CT275\Labs\ChiTietHoaDon;


require_once "../../bootstrap.php";
session_start();
if (isset($_SESSION["adminID"])) {
    $admin = new KhachHang($PDO);
    $admin->find($_SESSION["adminID"]);
} else {
    redirect("/quantri/dangnhap.php");
}

$sanpham = new SanPham($PDO);
$loaisanpham = new LoaiSanPham($PDO);
$chitiethoadon = new ChiTietHoaDon($PDO);

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['id'])
    && ($sanpham->find($_POST['id'])) !== null
) {
    if (!empty($chitiethoadon->findIdSP($_POST["id"]))) {
        echo "<script>alert('Sản phẩm đang tồn tại trong đơn hàng')</script>";
        echo "<script>window.location.href = 'hienthisanpham.php'</script>";
    }
    $sanpham->removeImage();
    $sanpham->delete();
    redirect(BASE_URL_PATH . "quantri/hienthisanpham.php");
}

$ds = $loaisanpham->all();
$id = isset($_REQUEST['id']) ?
    filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;

if ($id > 0)
    $sanpham->find($id);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sanpham->fill($_POST);
    if ($_FILES["img"]["name"] != '') {
        $sanpham->uploadImage($_FILES["img"]["name"], $_FILES["img"]["tmp_name"]);
    }
    if ($sanpham->validate()) {
        $sanpham->save();
        redirect(BASE_URL_PATH . "quantri/hienthisanpham.php");
    }

    $errors = $sanpham->getValidationErrors();
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
        <h1 class="text-center"><?= $id < 0 ? "Thêm" : "Sửa" ?> sản phẩm</h1>
        <div class="row">
            <div class="col-4"></div>
            <form name="frm" id="frm" action="" method="post" class="col m-auto text-dark" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="name" class="font-weight-bold">Tên sản phẩm: </label>
                    <input type="text" name="txtTenSanPham" class="form-control" placeholder="Nhập vào tên mắt kính..." value="<?= isset($sanpham->tensanpham) ? $sanpham->tensanpham : ''; ?>" />
                    <span class="text-danger">
                        <?= isset($errors["tensanpham"]) ? $errors["tensanpham"] : "" ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="phone" class="font-weight-bold">Giá: </label>
                    <input type="number" name="nbGia" class="form-control" min="0" placeholder="Nhập vào giá mắt kính..." value="<?= isset($sanpham->gia) ? $sanpham->gia : ''; ?>" />
                    <span class="text-danger">
                        <?= isset($errors["gia"]) ? $errors["gia"] : "" ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="phone" class="font-weight-bold">Kích thước: </label>
                    <input type="text" name="txtKichThuoc" class="form-control" maxlen="255" id="phone" placeholder="Mắt kính rộng x Cầu kính x Chiều dài gọng" value="<?= isset($sanpham->kichthuoc) ? $sanpham->kichthuoc : ''; ?>" />
                    <span class="text-danger">
                        <?= isset($errors["kichthuoc"]) ? $errors["kichthuoc"] : "" ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="phone" class="font-weight-bold">Nhãn hiệu: </label>
                    <input type="text" name="txtNhanHieu" class="form-control" maxlen="255" id="phone" placeholder="Nhãn hiệu: Rayban, Chanel, ...." value="<?= isset($sanpham->nhanhieu) ? $sanpham->nhanhieu : ''; ?>" />
                    <span class="text-danger">
                        <?= isset($errors["nhanhieu"]) ? $errors["nhanhieu"] : "" ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="phone" class="font-weight-bold">Giảm giá (theo %): </label>
                    <input type="number" name="nbGiamGia" class="form-control" min="0" value="<?= isset($sanpham->giamgia) ? $sanpham->giamgia : '0'; ?>" />
                    <span class="text-danger">
                        <?= isset($errors["giamgia"]) ? $errors["giamgia"] : "" ?>
                    </span>
                </div>


                <div class="form-group">
                    <label for="" class="font-weight-bold">Loại: </label>
                    <select class="custom-select" name="slLoai">
                        <option value="0" selected>--Chọn--</option>
                        <?php foreach ($ds as $loaisanpham) : ?>
                            <option value="<?= $loaisanpham->getId() ?>" <?= $loaisanpham->getId() == $sanpham->getLoai_Id() ? "selected" : ""  ?>><?= $loaisanpham->tenloai ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-danger">
                        <?= isset($errors["loai_id"]) ? $errors["loai_id"] : "" ?>
                    </span>
                </div>

                <label for="" class="font-weight-bold">Giới tính: </label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rdGioiTinh" id="inlineRadio1" value="Nam" <?= $sanpham->gioitinh == "Nam" ? "checked" : ""  ?>>
                    <label class="form-check-label" for="inlineRadio1">Nam</label>

                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rdGioiTinh" id="inlineRadio2" value="Nữ" <?= $sanpham->gioitinh == "Nữ" ? "checked" : ""  ?>>
                    <label class="form-check-label" for="inlineRadio2">Nữ</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rdGioiTinh" id="inlineRadio3" value="Unisex" <?= $sanpham->gioitinh == "Unisex" ? "checked" : ""  ?>>
                    <label class="form-check-label" for="inlineRadio3">Unisex</label>
                </div>
                <br><span class="text-danger">
                    <?= isset($errors["gioitinh"]) ? $errors["gioitinh"] : "" ?>
                </span>
                <div class="form-group">
                    <label for="img" class="font-weight-bold">Ảnh sản phẩm: </label><br>
                    <input type="file" name="img" id="img" value="" />
                    <span class="text-danger">
                        <?= isset($errors["hinhanh"]) ? $errors["hinhanh"] : "" ?>
                    </span>
                </div>


                <div class="form-group">
                    <label for="notes" class="font-weight-bold">Mô tả:</label>
                    <textarea name="txtMoTa" id="txtMoTa" class="form-control" placeholder="Nhập mô tả sản phẩm...."><?= isset($sanpham->mota) ? $sanpham->mota : ''; ?></textarea>
                    <span class="text-danger">
                        <?= isset($errors["mota"]) ? $errors["mota"] : "" ?>
                    </span>
                </div>

                <a href="hienthisanpham.php" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Trở về</a>
                <button type="submit" name="btnSubmit" id="submit" class="btn btn-primary float-right"><?= $id < 0 ? "Thêm" : "Sửa" ?> sản phẩm</button>
            </form>
            <div class="col-4"></div>
        </div>

    </main>


</body>

</html>