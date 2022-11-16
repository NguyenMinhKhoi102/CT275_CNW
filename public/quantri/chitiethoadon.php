<?php


use CT275\Labs\ChiTietHoaDon;
use CT275\Labs\HoaDon;
use CT275\Labs\KhachHang;
use CT275\Labs\SanPham;

require_once "../../bootstrap.php";
session_start();
if (isset($_SESSION["adminID"])) {
    $admin = new KhachHang($PDO);
    $admin->find($_SESSION["adminID"]);
} else {
    redirect("/quantri/dangnhap.php");
}


$chitiethoadon = new ChiTietHoaDon($PDO);
$khachhang = new KhachHang($PDO);
$sanpham = new SanPham($PDO);
$hoadon = new HoaDon($PDO);

$id = isset($_REQUEST['id']) ?
    filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;
if ($id < 0)
    redirect(BASE_URL_PATH . "quantri/hienthihoadon.php");

$ds = $chitiethoadon->findIdHD($id);



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
    <div class="row">
        <nav class="col-2 p-0">
            <a class="home" href="index.php"><i class="fa fa-home m-3"></i>Trang chủ</a>
            <div class="dropdown">
                <div class="dropdown-select">
                    <span class="dropdown-value"><i class="fa fa-product-hunt m-3"></i>Sản phẩm</span>
                    <i class="fa fa-caret-down mr-3"></i>
                </div>
                <div class="dropdown-list drop">
                    <a href="./hienthiloaisanpham.php" class="dropdown-item">
                        <div class="pl-2">Quản lý sản phẩm</div>
                    </a>
                    <a href="./hienthiloaisanpham.php" class="dropdown-item">
                        <div class="pl-2">Quản lý loại sản phẩm</div>
                    </a>
                    <a href="./hienthihoadon.php" class="dropdown-item active-item">
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
        <main class="col-10 mb-5">
            <h1>Chi tiết hoá đơn</h1>
            <div class="nav row">
                <a href="index.php" class="nav-item"><i class="fa fa-home"> Home</i></a>
                <span class="nav-item"><i class="fa fa-angle-right"></i></span>
                <a href="./hienthiloaisanpham.php" class="nav-item">Sản phẩm</a>
                <span class="nav-item"><i class="fa fa-angle-right"></i></span>
                <a href="./hienthihoadon.php" class="nav-item">Quản lý hoá đơn</a>
                <span class="nav-item"><i class="fa fa-angle-right"></i></span>
                <a href="#" class="nav-item">Chi tiết hoá đơn</a>
            </div>
            <h2 class="text-center my-4" style="color: #003366">Thông tin người đặt</h2>
            <table class="table table-bordered table-striped bg-light w-50 mx-auto">
                <tbody>
                    <tr>
                        <th scope="col">Họ tên:</th>
                        <td scope="col"><?= $khachhang->find($hoadon->find($id)->kh_id)->hoten ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Ngày sinh:</th>
                        <td scope="col"><?= $khachhang->find($hoadon->find($id)->kh_id)->ngaysinh ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Giới tính:</th>
                        <td scope="col"><?= $khachhang->find($hoadon->find($id)->kh_id)->gioitinh ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Email:</th>
                        <td scope="col"><?= $khachhang->find($hoadon->find($id)->kh_id)->email ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Số điện thoại:</th>
                        <td scope="col"><?= $khachhang->find($hoadon->find($id)->kh_id)->sdt ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Địa chỉ:</th>
                        <td scope="col"><?= $khachhang->find($hoadon->find($id)->kh_id)->diachi ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Ngày lập hoá đơn:</th>
                        <td scope="col"><?= $hoadon->find($id)->ngaylap ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Trạng thái:</th>
                        <td scope="col"><?= $hoadon->find($id)->trangthai == 0 ? '<i class="text-secondary">Chờ xử lý...</i>' : '<i class="text-success font-weight-bold">Đã xác nhận</i>' ?></td>
                    </tr>
                </tbody>
            </table>
            <h2 class="text-center my-4" style="color: #003366">Thông tin sản phẩm</h2>
            <table class="table table-bordered table-striped bg-light">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $sum = 0;
                    $discount = 0;
                    foreach ($ds as $chitiethoadon) :
                        $giasp = $sanpham->find($chitiethoadon->sp_id)->gia;
                        $giamgia = $sanpham->find($chitiethoadon->sp_id)->giamgia;
                        $giakm = ($giasp - ($giasp * $giamgia / 100)); ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><img src="<?= "./uploads/" . $sanpham->find($chitiethoadon->sp_id)->hinhanh ?>" alt="" style="width:100px; height: 100px;"></td>
                            <td><?= $sanpham->find($chitiethoadon->sp_id)->tensanpham ?></td>
                            <td><?= $chitiethoadon->so_luong ?></td>
                            <td><?= currency_format($giakm * $chitiethoadon->so_luong) ?></td>
                        </tr>
                    <?php
                        $sum += ($chitiethoadon->so_luong * $sanpham->find($chitiethoadon->sp_id)->gia);
                        $discount += ($chitiethoadon->so_luong * $giasp * $giamgia / 100);
                    endforeach ?>
                </tbody>
            </table>
            <div class="text-dark ml-auto my-5" style="font-size: 20px; width:30%;">
                <div class="d-flex justify-content-between"><b>Tổng giá sản phẩm:</b><?= currency_format($sum) ?></div>
                <div class="d-flex justify-content-between"><b>Tổng khuyến mãi:</b><?= currency_format(-$discount) ?></div>
                <div class="d-flex justify-content-between"><b>Thành tiền:</b><?= currency_format($hoadon->thanhtien) ?></div>
            </div>
            <div class="text-right">
                <?php if ($hoadon->find($id)->trangthai == 0) : ?>
                    <form class="delete" action="./hienthihoadon.php" method="POST" onsubmit="return allow()" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $hoadon->getId() ?>">
                        <button type="submit" class="btn btn-primary px-5 py-3">
                            Xác nhận đơn hàng</button>
                    </form>
                <?php else : ?>
                    <a href="./hienthihoadon.php" class="btn btn-primary px-5 py-3">Trở về</a>
                <?php endif; ?>
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
    <script>
        function allow() {
            return confirm("Bạn có chắc muốn xác nhận đơn hàng");
        }
    </script>
</body>

</html>