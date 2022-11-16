<?php

use CT275\Labs\GioHang;
session_start();
require_once "../bootstrap.php";

$giohang = new GioHang($PDO);
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['id'])
    && ($giohang->find($_POST['id'])) !== null
) {
    if (isset($_POST['edit'])) {
        $giohang->so_luong = $_POST["nbSoLuong"];
        $giohang->save();
    }
    if (isset($_POST['delete'])) {
        $giohang->delete();
    }
    echo "<script>window.location.href = 'giohang.php'</script>";
}
