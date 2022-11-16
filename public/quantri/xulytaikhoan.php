<?php

use CT275\Labs\HoaDon;
use CT275\Labs\KhachHang;

require_once "../../bootstrap.php";
$hd = new HoaDon($PDO);
session_start();
if(isset($_SESSION["adminID"])){
      $admin = new KhachHang($PDO);
      $admin->find($_SESSION["adminID"]);
} else {
    redirect("/quantri/dangnhap.php");
}
$khachHang = new KhachHang($PDO);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET["dangxuat"] == 1)
        redirect("/quantri/dangxuat.php");
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['id'])
    && ($khachHang->find($_POST['id'])) !== null
) {
    if(!empty($hd->findKH($khachHang->getId()))){
        echo "<script>alert('Không thể xóa tài khoản')</script>";
        echo "<script>window.location.href = 'hienthitaikhoan.php'</script>";
    }
    $khachHang->delete();
    redirect(BASE_URL_PATH . "quantri/hienthitaikhoan.php");
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $khachHang->fill($_POST);
    if ($khachHang->validate()) {
        $khachHang->save() && redirect(BASE_URL_PATH . "quantri/hienthitaikhoan.php");
    }
    $errors = $khachHang->getValidationErrors();
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
    <style>
        main span {
            color: red;
        }
    </style>
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
        <h1 class="text-center">Thêm tài khoản</h1>
        <div class="row">
            <div class="col-4"></div>
            <form name="frm" id="frm" action="" method="post" class="col m-auto text-dark" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="name" class="font-weight-bold">Họ tên</label>
                    <input type="text" name="txtUserFullName" class="form-control" maxlen="255" id="name" placeholder="Nhập vào họ tên" value="<?= isset($_POST['txtUserFullName']) ? htmlspecialchars($_POST['txtUserFullName']) : '' ?>" />
                    <span>
                        <?= isset($errors["txtUserFullName"]) ? $errors["txtUserFullName"] : "" ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="email" class="font-weight-bold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Nhập vào email..." value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" />
                    <span>
                        <?= isset($errors["email"]) ? $errors["email"] : "" ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="sdt" class="font-weight-bold">Số điện thoại</label>
                    <input type="text" name="sdt" class="form-control" maxlen="10" id="sdt" placeholder="Nhập vào số điện thoại" value="<?= isset($_POST['sdt']) ? htmlspecialchars($_POST['sdt']) : '' ?>" />
                    <span>
                        <?= isset($errors["sdt"]) ? $errors["sdt"] : "" ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="dtBirthday" class="font-weight-bold">Ngày sinh</label>
                    <input type="date" name="dtBirthday" class="form-control" maxlen="255" id="dtBirthday" placeholder="Nhập vào ngày sinh" value="<?= isset($_POST['dtBirthday']) ? htmlspecialchars($_POST['dtBirthday']) : '' ?>" />
                    <span>
                        <?= isset($errors["dtBirthday"]) ? $errors["dtBirthday"] : "" ?>
                    </span>
                </div>

                <label for="" class="font-weight-bold">Giới tính</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rdGender" id="inlineRadio1" value="Nam" <?php echo (isset($_POST['rdGender'])  && $_POST['rdGender']  == "Nam") ? "checked" : '' ?>>
                    <label class="form-check-label" for="inlineRadio1">Nam</label>

                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rdGender" id="inlineRadio2" value="Nữ" <?php echo (isset($_POST['rdGender'])  && $_POST['rdGender']  == "Nữ") ? "checked" : '' ?>>
                    <label class="form-check-label" for="inlineRadio2">Nữ</label>
                </div>
                <br>
                <?php if (isset($errors['rdGender'])) : ?>
                    <span class="help-block">
                        <?= htmlspecialchars($errors['rdGender']) ?>
                    </span>
                    <br>
                <?php endif ?>
                <div class="form-group">
                    <label for="txtAddress" class="font-weight-bold">Địa chỉ </label>
                    <textarea name="txtAddress" id="txtAddress" class="form-control" placeholder="Enter notes (maximum character limit: 255)"><?= isset($_POST['txtAddress']) ? htmlspecialchars($_POST['txtAddress']) : '' ?></textarea>
                    <span>
                        <?= isset($errors["txtAddress"]) ? $errors["txtAddress"] : "" ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="pwdUser" class="font-weight-bold">Mật khẩu</label>
                    <input type="password" name="pwdUser" class="form-control" maxlen="255" id="pwdUser" placeholder="Nhập vào số điện thoại" value="" />
                    <span>
                        <?= isset($errors["pwdUser"]) ? $errors["pwdUser"] : "" ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="re_pwdUser" class="font-weight-bold">Nhập lại mật khẩu</label>
                    <input type="password" name="re_pwdUser" class="form-control" maxlen="255" id="re_pwdUser" placeholder="Nhập vào số điện thoại" value="" />
                    <span>
                        <?= isset($errors["re_pwdUser"]) ? $errors["re_pwdUser"] : "" ?>
                    </span>
                </div>


                <button type="submit" name="btnSubmit" id="submit" class="btn btn-primary my-2">Thêm tài khoản</button>
            </form>
            <div class="col-4"></div>
        </div>

    </main>
    
</body>

</html>