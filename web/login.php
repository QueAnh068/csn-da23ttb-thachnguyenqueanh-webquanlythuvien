
<?php

session_start();
include("connect.php"); // Kết nối database

if(isset($_POST['dangnhap'])){

    $ten = $_POST['ten'];
    $password = $_POST['password'];
    $hashed_pw = md5($password);

        // check user
    if (!empty($ten) && !empty($password)) {       
        $sql = "SELECT * FROM ql_user  WHERE TenDN = '$ten' AND MatKhau = '$hashed_pw'";
          //  $stmt = $conn->prepare($sql);
        $rs=$conn->query($sql);
        $kq=$rs->fetch_assoc();

        // Lấy nhiều dòng
        if ($kq) {

            // role lấy thẳng từ DB
            $role = $kq['role'];

            if ($role == "admin") {

                $_SESSION['role'] = $role;
                $_SESSION['tenadmin'] = $kq['TenDN'];
              
                header("Location: ../admin/admin_dashboard.php");
             //   exit();

            } else {

                $_SESSION['role'] = $role;
                $_SESSION['tenuser'] = $kq['TenDN'];
               
                header("Location: index.php");
             //   exit();

            }
            echo $role;

        } else {
            echo "Tài khoản hoặc mật khẩu sai";
        }

    } else {
        echo "Vui lòng nhập đầy đủ thông tin";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập - Thư viện TVU</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Đăng nhập</h1>
                                </div>

                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger text-center py-2">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>

                                <form class="user" action="" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" placeholder="Tên đăng nhập" name="ten" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" placeholder="Mật khẩu" name="password" required>
                                    </div>

                                    <button type="submit" name="dangnhap" class="btn btn-primary btn-user btn-block">
                                        Đăng nhập
                                    </button>
                                </form>

                                <div class="text-center mt-3">
                                    <p>Chưa có tài khoản? 
                                        <a href="register.php" class="text-primary">Đăng ký ngay</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
</body>
</html>


