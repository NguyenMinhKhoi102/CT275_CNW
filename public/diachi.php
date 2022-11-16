<?php
require_once "../bootstrap.php";
session_start();


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
    <title>Địa chỉ</title>
</head>

<body>
    <div class="container-fluid">
        <?php include '../partials/header.php' ?>

        <main class="container">
            <h3 class="text-center font-weight-bold">ĐỊA CHỈ</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.8415183216944!2d105.77061529999999!3d10.029933699999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0895a51d60719%3A0x9d76b0035f6d53d0!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBD4bqnbiBUaMah!5e0!3m2!1svi!2s!4v1667369263422!5m2!1svi!2s" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="row">
                <div class="col-6">
                    <h6>THỜI GIAN MỞ CỬA: 07:00 – 21:30</h6>
                    <h6>HOLINE: <a href="tel: 0932988029">0932988029</a> </h6>
                </div>
            </div>
            <div class="row p-2 rounded " style="background-color: #d6efff; color: #021aed;">
                <h4 class="col-12 text-bold">Chuỗi hệ thống cửa hàng</h4>
                <div class="col-12 col-md-6">
                    <h6> <i class="fa fa-map-o" aria-hidden="true"></i> 164 Tôn Đức Thắng – Đống Đa HN</h6>
                    <h6> <i class="fa fa-map-o" aria-hidden="true"></i> 38 Nguyễn Khang – Cầu Giấy HN</h6>
                    <h6> <i class="fa fa-map-o" aria-hidden="true"></i> 82 Trần Phú – Hà Đông HN</h6>
                   
                </div>
                <div class="col-12  col-md-6">
                <h6> <i class="fa fa-map-o" aria-hidden="true"></i> 399 – 401 Lê Văn Sỹ – Q.Tân Bình HCM</h6>
                    <h6> <i class="fa fa-map-o" aria-hidden="true"></i> 56 Nguyễn Cư Trinh – Q.1 HCM</h6>
                    <h6> <i class="fa fa-map-o" aria-hidden="true"></i> 21 Võ Văn Kiệt – Cần Thơ</h6>
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