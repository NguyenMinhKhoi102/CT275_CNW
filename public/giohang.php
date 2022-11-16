<?php
require_once "../bootstrap.php";
session_start();

use CT275\Labs\GioHang;
use CT275\Labs\SanPham;
use CT275\Labs\HoaDon;
use CT275\Labs\ChiTietHoaDon;


$giohang = new GioHang($PDO);
$ds = $giohang->findKH($_SESSION["userID"]);

$sanpham = new SanPham($PDO);
$hoadon = new HoaDon($PDO);
$chitiethoadon = new ChiTietHoaDon($PDO);

$dshd = $hoadon->findKH($_SESSION["userID"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel="stylesheet">
    <link href="<?= BASE_URL_PATH . "css/style-nav.css" ?>" rel="stylesheet">
    <link href="<?= BASE_URL_PATH . "css/style-main.css" ?>" rel="stylesheet">
    <title>Giỏ hàng</title>
</head>

<body>
    <div class="container-fluid">
        <?php include '../partials/header.php' ?>

        <main class="row">

            <div class="col-12 col-lg-8 m-3 border p-2">
                <h4 class="text-center font-weight-bold">Danh mục</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá tiền</th>
                            <th scope="col">Tạm tính</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= empty($ds) ? "<tr class='text-center'><td colspan='7'>Hiện tại bạn không có đơn hàng nào !</td></tr>" : "" ?>
                        <?php $i = 1;
                        foreach ($ds as $giohang) : ?>
                            <tr>
                                <th scope="row"><?= $i++ ?></th>
                                <td>
                                    <img src="<?= "./quantri/uploads/" . $sanpham->find($giohang->sp_id)->hinhanh ?>" alt="" style="width:100px; height: 100px;">
                                </td>
                                <td>
                                    <p>
                                        <?= $sanpham->find($giohang->sp_id)->tensanpham ?>
                                    </p>
                                </td>
                                <form action="xulygiohang.php" onsubmit="return confirm('Bạn có chắc thực hiện thao tác')" name="xulygiohang" method="POST">
                                    <td>

                                        <div class="input-group" style="width: 150px">

                                            <input type="number" class="" min="1" max="100" size="3" value="<?= $giohang->so_luong ?>" name="nbSoLuong" style="width: 60px;">

                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $giasp = $sanpham->find($giohang->sp_id)->gia;
                                        $giamgia = $sanpham->find($giohang->sp_id)->giamgia;
                                        $giakm = ($giasp - ($giasp * $giamgia / 100));
                                        echo currency_format($giakm);
                                        ?> / 1sp
                                    </td>
                                    <td><?= currency_format($giakm * $giohang->so_luong) ?></td>
                                    <td>
                                        <input type="hidden" name="id" value="<?= $giohang->getId() ?>">
                                        <button type="submit" name="edit" class="btn btn-warning mr-1"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                        <button type="submit" name="delete" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h4 class="text-center font-weight-bold">Lịch sử đặt hàng</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Ngày lập</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= empty($dshd) ? "<tr class='text-center'><td colspan='7'>Lịch sử đặt hàng trống !</td></tr>" : "" ?>
                        <?php $i = 1;
                        foreach ($dshd as $hoadon) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td>
                                    <?php
                                    $dsct = $chitiethoadon->findIdHD($hoadon->getId());
                                    foreach ($dsct as $chitiethoadon) :
                                        echo $sanpham->find($chitiethoadon->sp_id)->tensanpham;
                                        echo " x" . $chitiethoadon->so_luong . ", ";
                                    endforeach;
                                    ?>
                                </td>
                                <td><?= $hoadon->ngaylap ?></td>
                                <td><?= currency_format($hoadon->thanhtien) ?></td>
                                <td><?= $hoadon->trangthai == 0 ? '<i class="text-secondary">Chờ xử lý...</i>' : '<i class="text-success font-weight-bold">Đã xác nhận</i>' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-12 col-lg-3 mt-3 ">
                <div class="border p-2 ">
                    <h4 class="text-center font-weight-bold text-info">Đơn hàng</h4>
                    <table class="table">
                        <thead>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Thành tiền</th>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $sum = 0;
                            foreach ($ds as $giohang) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $sanpham->find($giohang->sp_id)->tensanpham ?>
                                        <span class="font-weight-bold font-italic">
                                            <?= "x" . $giohang->so_luong ?>
                                        </span>
                                    </td>
                                    <td class="text-right font-weight-bold">
                                        <?php
                                        $giasp = $sanpham->find($giohang->sp_id)->gia;
                                        $giamgia = $sanpham->find($giohang->sp_id)->giamgia;
                                        $giakm = ($giasp - ($giasp * $giamgia / 100));
                                        echo currency_format($giakm);
                                        ?></td>
                                </tr>
                            <?php
                                $sum += $giakm * $giohang->so_luong;
                            endforeach; ?>
                        </tbody>
                    </table>
                    <h5>Tổng tiền: <span class="font-weight-bold"><?= currency_format($sum) ?></span> </h5>
                    <form action="thanhtoansanpham.php" method="post" onsubmit="return confirm('Bạn có chắc muốn đặt tất cả sảnp phẩm')">
                        <input type="hidden" name="thanhtien" value="<?= $sum ?>">
                        <button class="btn btn-primary w-75 mx-auto d-block" <?= empty($giohang->findKH($_SESSION["userID"])) ? "disabled" : "" ?>>Xác nhận</button>
                    </form>
                </div>
            </div>
        </main>
        <?php include '../partials/footer.php' ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL_PATH . "js/jquery-3.6.1.min.js" ?>"></script>
</body>

</html>