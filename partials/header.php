<?php

use CT275\Labs\KhachHang;
use CT275\Labs\SanPham;





if(isset($_SESSION["userID"])){
    
    $id = $_SESSION["userID"];
    $khachHang = new KhachHang($PDO);
    $khachHang->find($id);
    
}

$sanPham = new SanPham($PDO);
$danhSachSanPham = $sanPham->all();


?>
<nav class="navbar fixed-top navbar-light bg-light navbar-expand-lg p-0">
    <a class="navbar-brand" href=""><img src="./img/logoMatKinh-removebg.png" alt="" height="50px" width="50px"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto ">
           
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Trang chủ <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                
                <a class="nav-link " href="sanpham.php" >
                    Mắt kính
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="diachi.php">Địa chỉ</a>
            </li>

        </ul>
        <ul class="navbar-nav mx-auto">
            <form class="form-inline" method="POST" action="sanpham.php">
                <div class="input-group border-none">
                    <input type="text" class="form-control search-input" placeholder="Tìm kiếm mắt kính..." name="txtSearch">
                    <div class="input-group-append">
                        <button type="submit" class="input-group-text search-append bg-white" id="basic-addon2" name="btnSearch"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>

        </ul>
        <?php if (isset($_SESSION["userID"])) : ?>
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item dropdown ">
                    <div class="nav-link dropdown-toggle align-middle font-weight-bold text-info" href="#" role="button" data-toggle="dropdown">
                        <?php echo $khachHang->hoten?> 
                    </div>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="dangxuat.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="giohang.php" class="btn  mx-2 align-middle "><i class="fa fa-shopping-cart fav" aria-hidden="true"></i></a>
                </li>
            </ul>
        <?php else : ?>
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item">
                    <a class="nav-link text-primary" href="dangnhap.php">Đăng nhập</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link  " href="dangky.php">Đăng ký</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</nav>