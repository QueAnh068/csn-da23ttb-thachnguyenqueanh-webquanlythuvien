<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$page = isset($_GET['pages']) ? $_GET['pages'] : 'dashboar';

include("connect.php");

// Xử lý trả sách nếu admin bấm trả
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "tra") {
    $maMuon = $_POST['maMuon'];
    $maSach = $_POST['maSach'];

    // Cập nhật trạng thái mượn và ngày trả
    $stmt = $conn->prepare("UPDATE ql_muontra SET TrangThai='Đã trả', NgayTra=NOW() WHERE ID=?");
    $stmt->bind_param("i", $maMuon);
    $stmt->execute();

    // Tăng số lượng sách
    $stmt = $conn->prepare("UPDATE ql_sach SET SoLuong = SoLuong + 1 WHERE ID = ?");
    $stmt->bind_param("s", $maSach);
    $stmt->execute();

    echo "<script>alert('Xác nhận trả sách thành công!'); window.location='admin_dashboard.php';</script>";
    exit;
}

// Lấy danh sách mượn trả
$sql = "SELECT * FROM ql_user WHERE role = 'user' ORDER BY ID ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng điều khiển Admin</title>

    <!-- AdminLTE CSS giống trang chủ -->
    <link rel="stylesheet" href="tc/dist/css/adminlte.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<!-- Body layout giống trang chủ -->
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- Navbar -->
    <?php include("tc/navbar.php"); ?>

    <!-- Sidebar -->
    <?php include("tc/sidebar.php"); ?>

    <!-- Nội dung -->
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <?php
                    // Kiểm tra nếu có tham số pages
                    if (isset($_GET['pages'])) {
                        $page = $_GET['pages'];

                        // Tạo đường dẫn file module
                        $file = "pages/" . $page . ".php";

                        // Kiểm tra file có tồn tại không
                        if (file_exists($file)) {
                            include($file);
                            exit; // Dừng không cho chạy phần mặc định bên dưới
                        } else {
                            echo "<div class='alert alert-danger mt-3'>Không tìm thấy trang: $page</div>";
                        }
                    }
                    ?>
<!-- 4 hộp thống kê -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>150</h3>
            <p>Tổng số</p>
          </div>
          <div class="icon"><i class="fa-solid fa-cart-shopping"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>53<sup style="font-size: 20px">%</sup></h3>
            <p>Sách</p>
          </div>
          <div class="icon"><i class="fa-solid fa-chart-line"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>44</h3>
            <p>Sinh viên</p>
          </div>
          <div class="icon"><i class="fa-solid fa-user-plus"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>65</h3>
            <p>Lượng truy cập</p>
          </div>
          <div class="icon"><i class="fa-solid fa-chart-pie"></i></div>
        </div>
      </div>
    </div>

                <!-- Bảng danh sách sinh viên -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title">Danh sách sinh viên</h3>
      </div>

      <div class="card-body table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
          <thead class="table-light">
            <tr>
              <th>Mã SV</th>
              <th>Họ tên</th>
              <th>Tên đăng nhập</th>
              <th >Eamil</th>
              <th>Thao tác</th>

            </tr>
          </thead>
          <tbody>
            <?php
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>
                          <td>{$row['ID']}</td>
                          <td>{$row['Hoten']}</td>
                          <td>{$row['TenDN']}</td>
                          <td>{$row['Email']}</td>
                          <td>
                            <a href='admin/sua.php?table=ql_user&ID={$row['ID']}' class='btn btn-warning'>Sửa</a>
                            <a href='admin/xoa.php?table=ql_user&ID={$row['ID']}' class='btn btn-danger'>Xóa</a>
                          </td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='6' class='text-center text-muted'>Không có dữ liệu sinh viên</td></tr>";
              }
            ?>
              </tbody>
            </table>
          </div>
        </div>
            </div>
        </div>
    </main>

      </div>

    <?php include("tc/footer.php"); ?>

    <!-- AdminLTE Script giống trang chủ -->
    <script src="tc/dist/js/adminlte.js"></script>
</body>
</html>
