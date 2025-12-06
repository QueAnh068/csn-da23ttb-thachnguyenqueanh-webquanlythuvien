<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("connect.php"); // Kết nối database

$ten = $password = "";
$tenErr = $passwordErr = $error = "";

// Khi người dùng bấm Đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = isset($_POST['ten']) ? trim($_POST['ten']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($ten)) $tenErr = "⚠️ Vui lòng nhập tên đăng nhập!";
    if (empty($password)) $passwordErr = "⚠️ Vui lòng nhập mật khẩu!";

    if (empty($tenErr) && empty($passwordErr)) {
        $sql = "SELECT * FROM ql_user WHERE TenDN = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ten);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['MatKhau'])) {
                if ($row['role'] === 'user') {
                    // Lưu session riêng cho user
                    $_SESSION['user_HoTen'] = $row['HoTen'];
                    $_SESSION['user_TenDN'] = $row['TenDN'];
                    $_SESSION['user_role'] = $row['role'];
                    $_SESSION['user_ID'] = $row['ID'];

                    header("Location: index_user.php");
                    exit();
                } else {
                    $error = "❌ Bạn không có quyền truy cập trang này!";
                }
            } else {
                $error = "❌ Sai mật khẩu!";
            }
        } else {
            $error = "❌ Tên đăng nhập không tồn tại!";
        }
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

                                <form class="user" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" placeholder="Tên đăng nhập" name="ten" value="<?php echo htmlspecialchars($ten); ?>">
                                        <small class="text-danger"><?php echo $tenErr; ?></small>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" placeholder="Mật khẩu" name="password">
                                        <small class="text-danger"><?php echo $passwordErr; ?></small>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
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
