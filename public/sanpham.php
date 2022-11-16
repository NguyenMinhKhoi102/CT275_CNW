<?php


use CT275\Labs\SanPham;

session_start();
$flat = 0;
require_once "../bootstrap.php";

if (isset($_POST["btnLSearch"])) {
    $flat = 1;
    $sanPham = new SanPham($PDO);
    $listSP = $sanPham->findByOptions($_POST);
}

if (isset($_POST["txtSearch"])) {
    $flat = 1;
    $sanPham = new SanPham($PDO);
    $listSP = $sanPham->search($_POST["txtSearch"]);
}




$sqlNH = $PDO->query("SELECT DISTINCT nhan_hieu FROM sanpham;");
$sqlLSP = $PDO->query("SELECT DISTINCT tenloai FROM loaisanpham;");


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
    <title>Mắt kính</title>
</head>

<body>
    <div class="container-fluid">
        <?php include '../partials/header.php' ?>

        <main>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg p-0">
                        <img src="img/banner-sp1.jpg" alt="kính cận" class="w-100" height="200px">
                    </div>
                    <div class="col-12 col-md-4 col-lg  p-0">
                        <img src="img/banner-sp5.webp" alt="kính cận" class="w-100" height="200px">
                    </div>
                    <div class="col-12 col-md-4 col-lg  p-0">
                        <img src="img/banner-sp3.jpg" alt="kính cận" class="w-100" height="200px">
                    </div>
                    <div class="col-12 col-md-4 col-lg  p-0">
                        <img src="img/banner-sp4.jpg" alt="kính cận" class="w-100" height="200px">
                    </div>
                    <div class="col-12 col-md-4 col-lg  p-0">
                        <img src="img/banner-sp6.png" alt="kính cận" class="w-100" height="200px">
                    </div>
                </div>

            </div>

            <div class="container-fluid my-2">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-3  p-2">
                        <nav class="p-3 rounded shadow-sm my-3">
                            <h5 class="text-center font-weight-bold">Bộ lọc</h5>
                            <form action="" method="POST">
                                <span class="font-weight-bold text-primary">Giới tính: </span>
                                <ul class="nav flex-column ">
                                    <li class="nav-item">
                                        <label for=""><input type="checkbox" name="chkGioiTinh[]" value="'Nam'" <?php if (isset($_POST["chkGioiTinh"])) {
                                                                                                                    if (in_array("'Nam'", $_POST["chkGioiTinh"]))
                                                                                                                        echo "checked";
                                                                                                                }
                                                                                                                ?>> Nam</label>
                                    </li>
                                    <li class="nav-item">
                                        <label for=""><input type="checkbox" name="chkGioiTinh[]" value="'Nữ'" <?php if (isset($_POST["chkGioiTinh"])) {
                                                                                                                    if (in_array("'Nữ'", $_POST["chkGioiTinh"]))
                                                                                                                        echo "checked";
                                                                                                                }
                                                                                                                ?>> Nữ</label>
                                    </li>
                                    <li class="nav-item">
                                        <label for=""><input type="checkbox" name="chkGioiTinh[]" value="'Unisex'" <?php if (isset($_POST["chkGioiTinh"])) {
                                                                                                                        if (in_array("'Unisex'", $_POST["chkGioiTinh"]))
                                                                                                                            echo "checked";
                                                                                                                    }
                                                                                                                    ?>> Unisex</label>
                                    </li>
                                </ul>

                                <span class="font-weight-bold text-primary">Loại kính: </span>
                                <ul class="nav flex-column">

                                    <?php while ($row = $sqlLSP->fetch()) : ?>
                                        <li class="nav-item">
                                            <label for=""><input type="checkbox" name="chkLoai[]" value="'<?= $row[0] ?>'" <?php
                                                                                                                            if (isset($_POST["chkLoai"])) {
                                                                                                                                $loai = $row[0];
                                                                                                                                if (in_array("'$loai'", $_POST["chkLoai"]))
                                                                                                                                    echo "checked";
                                                                                                                            }
                                                                                                                            ?>> <?= $row[0] ?></label>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                                <span class="font-weight-bold text-primary">Thương hiệu: </span>
                                <div class="form-group">
                                    <select name="slThuongHieu" id="" class="custom-select">
                                        <option value="">--Chọn--</option>
                                        <?php while ($row = $sqlNH->fetch()) : ?>
                                            <option value="<?= "'" . $row[0] . "'" ?>" <?php
                                                                                        if (isset($_POST["slThuongHieu"]) && $_POST["slThuongHieu"] == "'$row[0]'") {
                                                                                            echo "selected";
                                                                                        }
                                                                                        ?>><?= $row[0] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <ul class="nav flex-column">
                                    <div class="form-group">
                                        <label for="formControlRange " class="text-primary">Mức giá: <span id="valueRange"></span> đ</label>
                                        <input type="range" class="form-control-range" id="formControlRange" min="0" max="10000000" value="<?= (isset($_POST["rgMucGia"])) ? $_POST["rgMucGia"] : "2000000" ?>" name="rgMucGia">
                                    </div>

                                </ul>
                                <input type="number" name="boLoc" hidden>
                                <button type="submit" class="btn btn-primary w-100 " name="btnLSearch" id="btnLSearch">Tìm kiếm</button>
                            </form>
                        </nav>
                    </div>
                    <div class="col-12 col-md-8 col-lg-9 ">
                        <div class="row border justify-content-between bg-light rounded">
                            <div class="col-8">
                                <img src="./img/logoMatKinh-removebg.png" alt="" height="45px" width="45px">
                            </div>
                            <div class="col-4 p-2">
                                <select class="form-control form-control-sm" name="slBoLoc">
                                    <option>--Chọn--</option>
                                    <option value="1">Giá giảm dần</option>
                                    <option value="2">Giá tăng dần</option>
                                </select>
                            </div>
                        </div>
                        <div class="container-fluid d-flex flex-wrap">
                            <?php if ($flat == 0) : ?>
                                <?php foreach ($danhSachSanPham as $sanPham) : ?>
                                    <div class="m-2 product-card">
                                        <a href="chitietsanpham.php?id=<?= $sanPham->getId() ?>"></a>
                                        <div class="w-100">
                                            <img src="quantri/uploads/<?= $sanPham->hinhanh ?>" alt="..." class="product-img">

                                        </div>
                                        <div class="p-2">
                                            <h6 class="p-name"><?= $sanPham->tensanpham ?></h6>
                                            <span>Kích thước: <?= $sanPham->kichthuoc ?></span><br>
                                            <?php if ($sanPham->giamgia > 0) : ?>
                                                Giá: <span class="p-current-price"><?= currency_format($sanPham->gia - $sanPham->gia * ($sanPham->giamgia / 100)) ?></span> &nbsp; &nbsp; <span class="p-old-price"><?= currency_format($sanPham->gia) ?></span>
                                        </div>
                                        <div class="card-footer ">
                                            <span>
                                                Đã giảm giá: <?= $sanPham->giamgia ?>%
                                            </span>
                                        </div>
                                        <?php else : ?>
                                        Giá: <span class="p-current-price"><?= currency_format($sanPham->gia) ?></span>
                                    </div>
                                    <div class="card-footer ">
                                        <span>
                                            Miễn phí vận chuyển
                                        </span>
                                    </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <?php if ($listSP == null) : ?>
                                    <img src="img/empty.png" alt="" class="w-25 mx-auto"> <br>
                                    <h5 class="text-danger m-auto mt-5">Sản phẩm hiện không tồn tại hoặc đã hết hàng....🥲 <a href="sanpham.php" class="font-italic initialism">Xem sản phẩm khác</a></h5>
                                 <?php else : ?>
                                    <?php foreach ($listSP as $sanPham) : ?>
                                        <div class="m-2 product-card">
                                            <a href="chitietsanpham.php?id=<?= $sanPham->getId() ?>"></a>
                                                <div class="w-100">
                                                    <img src="quantri/uploads/<?= $sanPham->hinhanh ?>" alt="..." class="product-img">

                                                 </div>
                                                <div class="p-2">
                                                    <h6 class="p-name"><?= $sanPham->tensanpham ?></h6>
                                                    <span>Kích thước: <?= $sanPham->kichthuoc ?></span><br>
                                                    <?php if ($sanPham->giamgia > 0) : ?>
                                                        Giá: <span class="p-current-price"><?= currency_format($sanPham->gia - $sanPham->gia * ($sanPham->giamgia / 100))  ?></span> &nbsp; &nbsp; <span class="p-old-price"><?= currency_format($sanPham->gia) ?></span>
                                                </div>

                                                <div class="card-footer ">
                                                    <span>
                                                        Đã giảm giá: <?= $sanPham->giamgia ?>%
                                                    </span>

                                                </div>
                                                    <?php else : ?>
                                                        Giá: <span class="p-current-price"><?= currency_format($sanPham->gia) ?></span>
                                                    </div>

                                                <div class="card-footer ">
                                                    <span>
                                                        Miễn phí vận chuyển
                                                    </span>

                                                </div>
                                                    <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
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