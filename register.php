<?php
include("connect.php");
session_start();

$hotenErr = $tenErr = $passwordErr = $repasswordErr = "";
$hoten = $ten = $password = $repassword = "";

// Xử lý khi nhấn nút đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu và lọc đầu vào
    $hoten = test_input($_POST["hoten"]);
    $ten = test_input($_POST["ten"]);
    $password = test_input($_POST["password"]);
    $repassword = test_input($_POST["repassword"]);

    // Kiểm tra họ tên
    if (empty($hoten)) {
        $hotenErr = "Họ tên là bắt buộc";
    } elseif (!preg_match("/^[a-zA-ZÀ-ỹ\s]+$/u", $hoten)) {
        $hotenErr = "Họ tên chỉ được chứa chữ cái và khoảng trắng";
    }
    //Kiểm tra tên
    if(empty($ten)){
        $tenErr = " Tên đăng nhập là bắt buộc";
    } elseif (!preg_match('/^[a-z0-9]+$/', $ten)) {
        $tenErr ="Họ tên không được có dấu và viết hoa";
    }
    // Kiểm tra mật khẩu
    if (empty($password)) {
        $passwordErr = "Mật khẩu là bắt buộc";
    } elseif (strlen($password) < 4) {
        $passwordErr = "Mật khẩu phải có ít nhất 4 ký tự";
    }

    // Kiểm tra nhập lại mật khẩu
    if (empty($repassword)) {
        $repasswordErr = "Vui lòng nhập lại mật khẩu";
    } elseif ($repassword != $password) {
        $repasswordErr = "Mật khẩu nhập lại không khớp";
    }

    // Nếu không có lỗi
    if (empty($hotenErr) && empty($passwordErr) && empty($repasswordErr)) {
        // Kiểm tra tên đăng nhập đã tồn tại chưa
        $check_sql = "SELECT * FROM ql_user WHERE TenDN = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("s", $hoten);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<p style='color:red; text-align:center;'>❌ Tên đăng nhập đã tồn tại!</p>";
        } else {
            // Mã hóa mật khẩu
            $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

            // Thêm user mới với role = 'user'
            $sql = "INSERT INTO ql_user (HoTen, TenDN, MatKhau, role) VALUES (?, ?, ?, 'user')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $hoten, $ten, $hashed_pw);

            if ($stmt->execute()) {
                echo "<script>
                        alert('🎉 Đăng ký thành công! Vui lòng đăng nhập.');
                        window.location='login.php';
                      </script>";
                exit();
            } else {
                echo "<p style='color:red; text-align:center;'>❌ Lỗi: Không thể thêm người dùng!</p>";
            }
        }
    }
}

// Hàm lọc dữ liệu đầu vào
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký - Thư viện TVU</title>
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
                                        <h1 class="h4 text-gray-900 mb-4">Đăng ký tài khoản</h1>
                                    </div>

                                    <form class="user" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="hoten" placeholder="Họ và tên" value="<?php echo $hoten; ?>">
                                            <span class="text-danger small"><?php echo $hotenErr; ?></span>
                                        </div><br>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="ten" placeholder="Tên đăng nhập" value="<?php echo $ten; ?>">
                                            <span class="text-danger small"><?php echo $tenErr; ?></span>
                                        </div><br>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" placeholder="Mật khẩu">
                                            <span class="text-danger small"><?php echo $passwordErr; ?></span>
                                        </div><br>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="repassword" placeholder="Nhập lại mật khẩu">
                                            <span class="text-danger small"><?php echo $repasswordErr; ?></span>
                                        </div><br>

                                        <button type="submit" class="btn btn-outline-success btn-user btn-block">Đăng ký</button>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <p>Đã có tài khoản? <a href="login.php" class="text-primary">Đăng nhập ngay</a></p>
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
