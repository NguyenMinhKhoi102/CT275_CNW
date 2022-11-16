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
	<title>Trang chủ</title>
</head>

<body>
	<div class="container-fluid">
		<?php include '../partials/header.php' ?>

		<main class="row">


			<div id="carouselFade" class="carousel slide carousel-fade col-12 col-lg-10 mx-auto" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img src="img/banner1.webp" class="d-block w-100">
					</div>
					<div class="carousel-item">
						<img src="img/banner2.jpg" class="d-block  w-100">
					</div>
					<div class="carousel-item">
						<img src="img/banner3.jpg" class="d-block w-100">
					</div>
				</div>
				<button class="carousel-control-prev" type="button " data-target="#carouselFade" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-target="#carouselFade" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</button>
			</div>

			<div class="col-12 py-2">

				<div class="container d-flex justify-content-center">

					<div class="card " style="width: 500px;">
						<div class="row no-gutters">
							<div class="col-md-7">
								<img src="img/kinhram.jpg" alt="Kính râm" class="fit-img">
							</div>
							<div class="col-md-5">
								<div class="card-body">
									<h4 class="card-title">Kính mát</h4>
									<a href="sanpham.php" class="btn btn-primary">Xem ngay</a>

								</div>
							</div>
						</div>
					</div>

					<div class="card mx-auto" style="width: 500px;">
						<div class="row no-gutters">
							<div class="col-md-7">
								<img src="img/kinhcan.jpg" alt="kính cận" class="fit-img">
							</div>
							<div class="col-md-5">
								<div class="card-body">
									<h4 class="card-title">Kính cận</h4>
									<a href="sanpham.php" class="btn btn-primary">Xem ngay</a>

								</div>
							</div>
						</div>
					</div>

				</div>

			</div>

			<div class="col-12 pb-3">

				<div class="row brand-row p-3">
					<h3 class="col-12 text-center">Thương hiệu đa dạng</h3>
					<div class="col p-1 ">
						<img src="img/costa-brand.png" class="rounded-circle">

					</div>
					<div class="col p-1">
						<img src="img/eco-brand.png" class="rounded-circle">
					</div>
					<div class="col p-1">
						<img src="img/etnia-brand.png" class="rounded-circle">

					</div>
					<div class="col p-1">
						<img src="img/fysh-brand.png" class="rounded-circle">

					</div>
					<div class="col p-1">
						<img src="img/flexon-brand.png" class="rounded-circle">

					</div>
					<div class="col p-1">
						<img src="img/lafont-brand.png" class="rounded-circle">

					</div>
					<div class="col p-1">
						<img src="img/guess-brand.png" class="rounded-circle">

					</div>
					<div class="col p-1">
						<img src="img/modo-brand.png" class="rounded-circle">

					</div>


				</div>
			</div>

			<div class="col-10 mx-auto ">
				<div class="row mt-1">
					<div class="col-12 col-md-7 m-auto">
						<div class="row">
							<div class="col-12">
								<h3 class="font-weight-bold">Tài sản lớn nhất của chúng tôi chính là khách hàng</h3>
								<p>Với 10 năm kinh nghiệm trên thị trường kính mắt Việt, chúng tự hào là đơn vị cung cấp
									các sản phẩm và dịch vụ về kính mắt uy tín tại Việt Nam. Các sản phẩm được tuyển chọn kỹ lưỡng,
									đạt độ tinh xảo và chất lượng cao, hướng đến trải nghiệm tốt nhất cho khách hàng.</p>

								<p>
									Là một sản phẩm về sức khoẻ con người, chúng tôi lấy khách hàng là trọng tâm,
									không ngừng thay đổi cải tiến sản phẩm cũng như dịch vụ đi kèm. Ngoài ra, hệ thống kỹ thuật viên giàu kinh nghiệm,
									trang thiết bị máy móc hiện đại cùng dịch vụ tư vấn tận tâm giúp chúng tôi trở thành địa chỉ tin cậy đồng hành cùng hàng triệu khách hàng Việt.
								</p>
							</div>
						</div>


					</div>
					<div class="col-12  col-md-5">
						<img src="img/tc-nn.jpg" alt="..." class="fit-img">
					</div>

					<div class="col-12">
						<div class="row mx-auto gioithieu">
							<div class="col-12 col-md-6 col-lg-3 p-3">

								<h4 class="text-center font-weight-bold">Chất lượng cao</h4>
								<div>
									<img src="img/high-quality.jpg" alt="..." class="w-100" height="200px">
								</div>



							</div>
							<div class="col-12 col-md-6 col-lg-3 p-3">


								<h4 class="text-center font-weight-bold">Mẫu mã đa dạng</h4>
								<div>
									<img src="img/brand-varity.jpg" alt="..." class="w-100" height="200px">
								</div>

							</div>
							<div class="col-12 col-md-6 col-lg-3 p-3">


								<h4 class="text-center font-weight-bold">Tư vấn tận tâm</h4>
								<div>
									<img src="img/service-high.jpg" alt="..." class="w-100" height="200px">
								</div>

							</div>
							<div class="col-12 col-md-6 col-lg-3 p-3">


								<h4 class="text-center font-weight-bold">Máy móc hiện đại</h4>
								<div>
									<img src="img/myopia-meter.jpg" alt="..." class="w-100" height="200px">
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="row justify-content-center mt-2">
					<h3 class="text-center font-weight-bold">Sản phẩm đang giảm giá</h3>
					<div class="container-fluid d-flex flex-wrap justify-content-center">
						<?php foreach ($danhSachSanPham as $i => $sanPham) : ?>
							<?php if ($sanPham->giamgia > 0) : ?>
								<div class="m-2 product-card">
									<a href="chitietsanpham.php?id=<?= $sanPham->getId() ?>"></a>
									<div class="w-100">
										<img src="quantri/uploads/<?= $sanPham->hinhanh ?>" alt="..." class="product-img">

									</div>
									<div class="p-2">
										<h6 class="p-name"><?= $sanPham->tensanpham ?></h6>
										<span>Kích thước: <?= $sanPham->kichthuoc ?></span><br>

										Giá: <span class="p-current-price"><?= currency_format($sanPham->gia - $sanPham->gia * ($sanPham->giamgia / 100))  ?></span> &nbsp; &nbsp; <span class="p-old-price"><?= currency_format($sanPham->gia) ?></span>
									</div>

									<div class="card-footer ">
										<span>
											Đã giảm giá: <?= $sanPham->giamgia ?>%
										</span>

									</div>

								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<div class="row "><a href="sanpham.php" class="btn btn-primary mx-auto">Xem thêm</a></div>
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