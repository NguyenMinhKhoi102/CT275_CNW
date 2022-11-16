<?php

use CT275\Labs\KhachHang;

require_once "../../bootstrap.php";
session_start();
if (isset($_SESSION["adminID"])) {
    $admin = new KhachHang($PDO);
    $admin->find($_SESSION["adminID"]);
} else {
    redirect("/quantri/dangnhap.php");
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
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <title>Trang quản trị</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/index.css">
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
                        <?= $admin->hoten ?>
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
    <div class="row">
        <nav class="col-2 p-0">
            <div class="home active-item"><i class="fa fa-home m-3"></i>Trang chủ</div>

            <div class="dropdown">
                <div class="dropdown-select">
                    <span class="dropdown-value"><i class="fa fa-product-hunt m-3"></i>Sản phẩm</span>
                    <i class="fa fa-caret-down mr-3"></i>
                </div>
                <div class="dropdown-list">
                    <a href="./hienthisanpham.php" class="dropdown-item">
                        <div class="pl-2">Quản lý sản phẩm</div>
                    </a>
                    <a href="./hienthiloaisanpham.php" class="dropdown-item">
                        <div class="pl-2">Quản lý loại sản phẩm</div>
                    </a>
                    <a href="./hienthihoadon.php" class="dropdown-item">
                        <div class="pl-2">Quản lý hoá đơn</div>
                    </a>
                </div>
            </div>
            <div class="dropdown">
                <div class="dropdown-select">
                    <span class="dropdown-value"><i class="fa fa-users m-3"></i>Khách hàng</span>
                    <i class="fa fa-caret-down mr-3"></i>
                </div>
                <div class="dropdown-list">
                    <a href="./hienthitaikhoan.php" class="dropdown-item">
                        <div class="pl-2">Quản lý tài khoản</div>
                    </a>
                </div>
            </div>

        </nav>
        <main class="col-10">
            <h1 class="text-center">Quản trị viên</h1>
            <div class="info-container">
                <div class="info">
                    <div class="info-container">
                        <div class="avatar"></div>
                        <table>
                            <tr>
                                <td><b>Họ tên: </b></td>
                                <td><?= $admin->hoten ?></td>
                            </tr>
                            <tr>
                                <td><b>Giới tính: </b></td>
                                <td><?= $admin->gioitinh ?></td>
                            </tr>
                            <tr>
                                <td><b>Ngày sinh: </b></td>
                                <td><?= $admin->ngaysinh ?></td>
                            </tr>
                            <tr>
                                <td><b>Địa chỉ: </b></td>
                                <td><?= $admin->diachi ?></td>
                            </tr>
                        </table>
                    </div>
                    <div><i class="fa fa-envelope"></i> <?= $admin->email ?></div>
                    <div><i class="fa fa-mobile"></i> <?= $admin->sdt ?></div>
                </div>
            </div>

        </main>
    </div>

    <footer class="row mt-1">
        &copy; Bản quyền thuộc về Nguyễn Minh Khôi, Đỗ Thái Gia Huy
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>