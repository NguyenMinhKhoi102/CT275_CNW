<?php 
session_start();
if(isset($_SESSION["adminID"])){
    unset($_SESSION["adminID"]);
    echo "<script>alert('Đăng xuất thành công!')</script>";
    echo "<script>window.location = 'dangnhap.php'</script>";
} else {
    echo "Không thể đăng xuất";
}
?>