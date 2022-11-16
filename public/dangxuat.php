<?php 
session_start();
if(isset($_SESSION["userID"])){
    unset($_SESSION["userID"]);
    echo "<script>alert('Đăng xuất thành công!')</script>";
    echo "<script>window.location = 'index.php'</script>";
} else {
    echo "Không thể đăng xuất";
}
?>