<?php


require_once "../bootstrap.php";
session_start();

use CT275\Labs\GioHang;
use CT275\Labs\HoaDon;
use CT275\Labs\ChiTietHoaDon;

$hoadon = new HoaDon($PDO);
$chitiethoadon = new ChiTietHoaDon($PDO);
$giohang = new GioHang($PDO);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoadon->fill($_SESSION["userID"], $_POST["thanhtien"]);
    $hoadon->save();
    $ds = $giohang->findKH($_SESSION["userID"]);
    foreach ($ds as $giohang) :
        $arr = ["idSanPham" => $giohang->sp_id, "nbSoLuong" => $giohang->so_luong];
        $chitiethoadon->fill($arr, $hoadon->getId());
        $chitiethoadon->save();
        $giohang->delete();
    endforeach;
}
redirect(BASE_URL_PATH . "giohang.php");
