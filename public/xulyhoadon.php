<?php
require_once "../bootstrap.php";
session_start();

use CT275\Labs\ChiTietHoaDon;
use CT275\Labs\GioHang;
use CT275\Labs\HoaDon;
use CT275\Labs\SanPham;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($_POST["idKhachHang"] == "") {
		var_dump($_POST);
		echo "<script>alert('Bạn chưa đăng nhập!')</script>";
		echo "<script>window.location = 'dangnhap.php'</script>";
	}

	$hoaDon = new HoaDon($PDO);
	$chiTiet = new ChiTietHoaDon($PDO);
	$sanpham = new SanPham($PDO);
	$giohang = new GioHang($PDO);
	$sanpham->find($_POST["idSanPham"]);

	if (isset($_POST["btnGioHang"])) {

		$_POST["sp_id"] = $_POST["idSanPham"];
		$_POST["kh_id"] = $_SESSION["userID"];
		$_POST["so_luong"] = $_POST['nbSoLuong'];

		if ($giohang->findKH_SP($_POST) !== NULL) {

			$giohang->so_luong += $_POST["so_luong"];
			$giohang->save();
			$str = "chitietsanpham.php?id=" . $_POST["idSanPham"];
			echo "<script>alert('Đã cập nhật số lượng sản phẩm!')</script>";
			echo "<script>window.location = '$str'</script>";
		} else {

			$giohang->fill($_POST);
			if ($giohang->validate()) {
				$giohang->save();
				$str = "chitietsanpham.php?id=" . $_POST["idSanPham"];
				echo "<script>alert('Thêm sản phẩm thành công!')</script>";
				echo "<script>window.location = '$str'</script>";
			}
		}
	}

	$sanpham->find($_POST["idSanPham"]);
	if ($sanpham->giamgia > 0) {
		$sanpham->gia = $sanpham->gia - ($sanpham->gia * ($sanpham->giamgia / 100));
	}


	$tien = ($sanpham->gia * $_POST["nbSoLuong"]);

	if (isset($_POST["btnXacNhan"])) {
		$hoaDon->fill($_POST["idKhachHang"], $tien);
		if ($hoaDon->validate()) {
			if ($hoaDon->save()) {
				$chiTiet->fill($_POST, $hoaDon->getId());
				$chiTiet->save();
				$str = "chitietsanpham.php?id=" . $_POST["idSanPham"];
				echo "<script>alert('Đặt hàng thành công!')</script>";
				echo "<script>window.location = '$str'</script>";
			}
		}
	}
} else {
	redirect("/");
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
	<title>Đặt hàng</title>
</head>

<body>
	<div class="container-fluid">
		<?php include '../partials/header.php' ?>
	
		<main class="container d-flex flex-wrap justify-content-center">
			<div class="col-12 col-md-6" >
				<div class="border p-4">
						<h4 class="font-weigth-bold text-primary text-center font-weight-bold">THÔNG TIN ĐƠN HÀNG</h4>
						<img src="./quantri/uploads/<?=$sanpham->hinhanh ?>" alt="" width="100%" height="400px">
						<h5 class="text mt-2"><?= $sanpham->tensanpham ?></h5>
						<p>Số lượng: <span class="font-italic font-weight-bold"><?= $_POST["nbSoLuong"] ?></span></p>
						<p>Giá: <span class="font-weight-bold"><?= currency_format($sanpham->gia)?></span> (đã bao gồm giảm giá)</p>
						<h5>Thành tiền: <span class="font-weight-bold"><?= currency_format($tien) ?></span></h5>
					<form method="POST" action="" >
					<div class="input-group ">
						<input type="text" name="idKhachHang" id="idKhachHang" value="<?= isset($khachHang) ? $khachHang->getId() : '' ?>" hidden>
						<input type="text" name="idSanPham" id="idSanPham" value="<?= $_POST["idSanPham"] ?>" hidden>
						<input type="number" name="nbSoLuong" value="<?= $_POST["nbSoLuong"] ?>" hidden>
					</div>
					<a class="btn btn-light " href="sanpham.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Thoát</a>
					<button class="btn btn-primary float-right" name="btnXacNhan" type="submit">Xác nhận đặt hàng</button>
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
	<script src="<?= BASE_URL_PATH . "js/main.js" ?>"></script>
</body>

</html>