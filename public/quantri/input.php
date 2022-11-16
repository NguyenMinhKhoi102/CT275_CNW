<?php
require_once "../../bootstrap.php";
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    if (!$_POST['email']) {
        $errors["email"] = "Bạn chưa nhập email!";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email không hợp lệ!";
    } else {
        $errors["email"] = "";
    }
    if (!$_POST['pwdUser']) {
        $errors["pwdUser"] = "Bạn chưa nhập mật khẩu!";
    } else if (strlen($_POST['pwdUser']) < 8) {
        $errors["pwdUser"] = "Mật khẩu không hợp lệ!";
    } else {
        $errors["pwdUser"] = "";
    }
    if ($errors["email"] == "" &&  $errors["pwdUser"] == "") {
        $sql = $PDO->prepare("select * from khachhang where email = ? and matkhau = ? and vai_tro = 1");
        $sql->execute([
            $_POST['email'],
            md5($_POST['pwdUser'])
        ]);
        if ($sql->rowCount() > 0) {
            $result = $sql->fetch();
            session_start();
            $_SESSION["adminID"] = $result["id"];
            
            redirect('/quantri/index.php');
        } else {
            $errors["invalid"] = "Email hoặc mật khẩu không chính xác!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <title>Document</title>
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <form id="frmLogin" method="POST">
        <div class="text-center icon"><i class="fa fa-key"></i></div>
        <h1 class="text-center m-4">Admin Login</h1>
        <div class="form-field">
            <input type="text" class="form-input" name="email" id="email" placeholder=" " autocomplete="off">
            <label for="email" class="form-label">Email</label>
            <div class="form-underline"></div>
        </div>
        <?php if (isset($errors["invalid"])) : ?>
            <span class="help-block">
                <strong><?= $errors["invalid"] ?></strong>
            </span>
        <?php endif ?>
        <div class="form-field">
            <input type="password" class="form-input" name="pwdUser" id="pwdUser" placeholder=" ">
            <label for="pwdUser" class="form-label">Password</label>
            <div class="form-underline"></div>
        </div>
        <?php if (isset($errors["pwdUser"])) : ?>
            <span class="help-block">
                <strong><?= $errors["pwdUser"] ?></strong>
            </span>
        <?php endif ?>
        <button type="submit" class="btn my-4 w-100" name="btnDangNhap">Login</button>
    </form>
</body>

</html>