<?php

require_once "../bootstrap.php";
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
        $sql = $PDO->prepare("select * from khachhang where email = ? and matkhau = ? and vai_tro = 0");
        $sql->execute([
            $_POST['email'],
            md5($_POST['pwdUser'])
        ]);
        if ($sql->rowCount() > 0) {
            $result = $sql->fetch();
            session_start();
            $_SESSION["userID"] = $result["id"];
            
            redirect('/');
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel="stylesheet">
    <link href="<?= BASE_URL_PATH . "css/style-nav.css" ?>" rel="stylesheet">
    <link href="<?= BASE_URL_PATH . "css/style-main.css" ?>" rel="stylesheet">
    <title>Đăng nhập</title>
</head>

<body>
    <div class="container-fluid">
        <?php include '../partials/header.php' ?>

        <main class="row">
            <div class="container">
                <div class="row border p-0">
                    <div class="col-12 col-md-6 p-0 m-0">
                        <img src="./img/login-image.webp" width="100%" class="m-0">
                    </div>
                    <div class="col-12 col-md-6 my-auto">
                        <form action="" id="frmLogin" class="p-2" method="POST">
                            <h3 class="text-center font-weight-bold text-primary">ĐĂNG NHẬP</h3>
                            <?php if (isset($errors["invalid"])) : ?>
                                <span class="help-block">
                                    <strong><?= $errors["invalid"] ?></strong>
                                </span>
                            <?php endif ?>
                            <div class="form-group">
                                <label for="">Gmail: </label>
                                <input type="text" class="form-control" name="email" id="email" value="<?php echo (isset($_POST["email"])) ?  $_POST["email"] : ""; ?>">
                                <?php if (isset($errors["email"])) : ?>
                                    <span class="help-block">
                                        <strong><?= $errors["email"] ?></strong>
                                    </span>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <label for="">Mật khẩu: </label>
                                <input type="password" class="form-control" name="pwdUser" id="pwdUser" value="<?php echo (isset($_POST["pwdUser"])) ?  $_POST["pwdUser"] : ""; ?>">
                                <?php if (isset($errors["pwdUser"])) : ?>
                                    <span class="help-block">
                                        <strong><?= $errors["pwdUser"] ?></strong>
                                    </span>
                                <?php endif ?>
                            </div>


                            <button type="submit" class="btn btn-primary my-2 w-100" name="btnDangNhap">Đăng nhập</button>

                        </form>
                        <div class="text-align-end">
                            <p class="text-center">Bạn chưa có tài khoản? <a href="dangky.php">Đăng ký ngay</a></p>
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


</body>

</html>