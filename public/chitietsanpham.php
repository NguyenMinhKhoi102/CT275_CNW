<?php


use CT275\Labs\SanPham;

session_start();

require_once "../bootstrap.php";
$sp = new SanPham($PDO);
if (!isset($_GET["id"]) || !$sp->find($_GET["id"])) {
    redirect("/");
} else {
    $sp->find($_GET["id"]);
}

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
    <title>Chi tiết</title>
</head>

<body>
    <div class="container-fluid">
        <?php include '../partials/header.php' ?>

        <main>
            <div class="row bg-light">
                <div class="container my-2">
                    <div class="row ">
                        <div class="col-12 col-md-5 m-auto">
                            <img src="quantri/uploads/<?= $sp->hinhanh ?>" alt="..." width="400px" height="400px">
                        </div>
                        <div class="col-12 col-md-7">
                            <h3 class="font-weight-bold text-primary"><?= $sp->tensanpham ?></h3>
                            <p>Kích thước: <span class="font-italic font-weight-bold"><?= $sp->kichthuoc ?></span></p>
                            <p>Tình trạng: <span class="font-italic font-weight-bold text-success">Còn hàng</span></p>
                            <p class="font-weight-bold "><?= $sp->mota ?></p>
                            <span class="price"><?= currency_format($sp->gia - $sp->gia * ($sp->giamgia / 100)) ?></span> <span class="old-price"><?= ($sp->giamgia > 0) ? currency_format($sp->gia) : "" ?></span> <br>

                            <form method="POST" action="xulyhoadon.php">
                                <div class="input-group " style="width: 300px; display: flext">
                                    <div class="input-group-prepend ">
                                        <button class="btn btn-light border-dark" id="minus" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                    </div>
                                    <input type="text" name="idKhachHang" id="idKhachHang" value="<?= isset($khachHang) ? $khachHang->getId() : '' ?>" hidden>
                                    <input type="text" name="idSanPham" id="idSanPham" value="<?= $sp->getId() ?>" hidden>
                                    <input type="number" class="" min="1" max="100" size="3" value="1" name="nbSoLuong" style="width: 60px;">
                                    <div class="input-group-append">
                                        <button class="btn btn-light border-dark" id="plus" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                <button class="btn-add-cart" name="btnGioHang">Thêm vào giỏ hàng</button> <br>
                                <button class="btn-buy" name="btnMuaNgay">Mua ngay</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-8 my-auto">
                            <div class="container ">
                                <div class="row my-2">
                                    <div class="col-2">
                                        <img src="./img/shiping.png" alt="..." class="fit-img">
                                    </div>
                                    <div class="col-10 m-auto">
                                        <h5 class="font-weight-bold">Miễn phí giao hàng trên toàn quốc</h5>
                                        <p>Tất cả đơn mới giá trị trên 1000000đ</p>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-2">
                                        <img src="./img/tuvan.png" alt="..." class="fit-img">
                                    </div>
                                    <div class="col-10 m-auto">
                                        <h5 class="font-weight-bold">Hỗ trợ <a href="tel: 0932988029">0932988029</a></h5>
                                        <p>Liên hệ chúng tôi để giải đáp các thắc mắc</p>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-2">
                                        <img src="./img/return-goods.jpg" alt="..." class="fit-img">
                                    </div>
                                    <div class="col-10 m-auto">
                                        <h5 class="font-weight-bold">Chính sách đổi trả dễ dàng</h5>
                                        <p>Bảo hành từ 1 đến 2 năm</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <img src="./img/delivery.webp" alt="" class="fit-img">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <h3 class="row pl-2 font-weight-bold">Sản phẩm liên quan</h3>
                <div class="row d-flex flex-wrap">
                    <?php
                    $gt = $sp->gioitinh;
                    $th = $sp->nhanhieu;
                    $arr = array("chkGioiTinh" => ["'$gt'"], "slThuongHieu" => "'$th'");
                    $tsp = new SanPham($PDO);
                    $splq = $tsp->findByOptions($arr);
                    ?>
                    <?php if (isset($splq) && !empty($splq)) : ?>
                        <?php foreach ($splq as $tsp) : ?>
                            <?php if ($tsp->getId() != $_GET["id"]) : ?>
                                <div class="m-2 product-card">
                                    <a href="chitietsanpham.php?id=<?= $tsp->getId() ?>"></a>
                                    <div class="w-100">
                                        <img src="quantri/uploads/<?= $tsp->hinhanh ?>" alt="..." class="product-img">
                                    </div>
                                    <div class="p-2">
                                        <h6 class="p-name"><?= $tsp->tensanpham ?></h6>
                                        <span>Kích thước: <?= $tsp->kichthuoc ?></span><br>
                                        <?php if ($tsp->giamgia > 0) : ?>
                                            Giá: <span class="p-current-price"><?= currency_format($tsp->gia - $tsp->gia * ($tsp->giamgia / 100)) ?></span> &nbsp; &nbsp; <span class="p-old-price"><?= currency_format($sp->gia) ?></span>
                                    </div>
                                    <div class="card-footer ">
                                        <span>
                                            Đã giảm giá: <?= $tsp->giamgia ?>%
                                        </span>
                                    </div>
                                        <?php else : ?>
                                            Giá: <span class="p-current-price"><?= currency_format($tsp->gia) ?></span>
                                    </div>
                                    <div class="card-footer ">
                                        <span>
                                            Miễn phí vận chuyển
                                        </span>
                                    </div>
                                        <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </main>
    <?php include '../partials/footer.php' ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL_PATH . "js/jquery-3.6.1.min.js" ?>"></script>
    <script src="<?= BASE_URL_PATH . "js/main.js" ?>"></script>
</body>
</html>