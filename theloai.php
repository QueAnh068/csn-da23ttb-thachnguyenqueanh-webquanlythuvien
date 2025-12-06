 <?php
    include("connect.php"); // file kết nối CSDL
        // Chỉ admin mới được truy cập
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     echo "<p class='text-danger'>Bạn không có quyền truy cập trang này.</p>";
//     exit();
// }

    $idErr = $hotenErr = "";
    $id = $hoten = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["id"])) {
                $idErr = "iD là bắt buộc";
            } 
            else {
                $id = test_input($_POST["id"]);
                if (!preg_match("/^[0-9]*$/",$id)) {
                    $idErr = "Chỉ được nhập số";
                    }
                }

                if (empty($_POST["hoten"])) {
                    $hotenErr = "Bắt buộc";
                } 
                else {
                    $hoten = test_input($_POST["hoten"]);
                    if (!preg_match("/^[a-zA-Z]*$/",$hoten)) {
                        $hotenrdErr = "Chỉ được chữ hoa, chữ thường & không có khoảng trắng";
                    }
                }
                if (empty($idErr) && empty($hotenErr)) {
                    echo "<script>alert('Đăng ký thành công!');</script>";
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

    // Lấy từ khóa tìm kiếm
    $search = "";
    if (isset($_GET['search'])) {
        $search = trim($_GET['search']);
    }
    // bảo mật chuỗi
    $search_safe = mysqli_real_escape_string($conn, $search);

    if ($search_safe != "") {
        $sql = "SELECT * FROM ql_theloai WHERE TenTL LIKE '%$search_safe%'";
    } else {
        $sql = "SELECT * FROM ql_theloai ORDER BY MaTL DESC";
    }
    $result = mysqli_query($conn, $sql);
?> 
<!DOCTYPE html>
<html lang="vi">
<head>
        <title> Quản lý thể loại </title>
        <meta charset=" utf-8" name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <header>
                    <!-- PHẦN TIÊU ĐỀ -->
                    <div class="container-fluid py-4 bg-primary text-white text-center position-relative">
                        <img src="image/1.jpg" 
                            alt="Logo Trường Đại Học Trà Vinh" 
                            class="position-absolute start-0 ms-4 top-50 translate-middle-y rounded" 
                            width="60" height="60">
                        <h1 class="fw-bold m-0">THƯ VIỆN TRƯỜNG ĐẠI HỌC TRÀ VINH</h1>
                    </div> 
                    <nav class="navbar navbar-expand-sm bg-primary navbar-dark justify-content-center py-2">
                        <div class="container-fluid justify-content-center flex-wrap">
                            <!-- Ô tìm kiếm -->
                        <form class="d-flex mx-3" method="get" action="">
                            <input class="form-control form-control-sm" type="search" name="search" placeholder="Tìm kiếm thể loại..." value="<?php echo htmlspecialchars($search); ?>">
                                    <!-- htmlspecialchars($search) để hiển thị lại từ khóa người dùng đã nhập -->
                            <button class="btn btn-outline-light btn-sm ms-2" type="submit">Tìm</button>
                        </form>
                        </div>
                    </nav>
                </header>
            </div>

    <!-- form quản lý thẻ loại -->
            <div class="card-body  text-black " style="background-color: #b3e5fc;">
                <h3>Form thể loại</h3><br>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="book" method="post" id="login">
                        <div class="input-group mb-3">
                            <span class="input-group-text">@</span>
                            <input type="text" class="form-control" placeholder="Mã thể loại" name="id" value="<?php echo $id;?>">
                            <span class="error">* <?php echo $idErr;?></span>
                        </div><br>

                        <div class="input-group mb-3">
                            <span class="input-group-text">@</span>
                            <input type="text" class="form-control" placeholder="Tên thể loại" name="name" value="<?php echo $id;?>">
                            <span class="error">* <?php echo $idErr;?></span>
                        </div><br>

                        <div class="input-group mb-3">
                            <span class="input-group-text">Ngày mượn</span>
                            <input type="date" class="form-control" name="date" value="">
                        </div><br>
                        <button type="submit">Cập nhật</button>
                    </form><br>
            <!-- Bảng danh sách sinh viên -->
                <div class="container mt-3">
                    <h3>Quản lý thể loại</h3><br>
                    <table class="table table-bordered">
                        <thead class="table-dark table-bordered">
                            <tr>
                                <th>Mã thể loại</th>
                                <th>Tên thể loại</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM ql_theloai ORDER BY MaTL DESC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['MaSV']}</td>
                                                <td>{$row['TenTL']}</td>
                                                <td>
                                                    <a href='sua.php?id={$row['MaTL']}' class='btn btn-warning btn-sm'>Sửa</a>
                                                    <a href='xoa.php?id={$row['MaTL']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Bạn có chắc muốn xóa thể loại sách này không?')\">Xóa</a>
                                                </td>
                                            </tr>";
                                        }      
                                    }
                                else {
                                    echo "<tr><td colspan='3'>Chưa có thể loại nào.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <footer class="text-center mt-4 p-3 bg-light">
                    <p>Thư viện TRƯỜNG ĐẠI HỌC TRÀ VINH.</p>
                    <p>Địa chỉ: 126 Nguyễn Thiện Thành, phường Hòa Thuận, thành phố Vĩnh Long.</p>
                    <p>Liên hệ sđt:02.xxx.xxx.xx |Email:celras@tvu.edu.vn</p>
                </footer>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




