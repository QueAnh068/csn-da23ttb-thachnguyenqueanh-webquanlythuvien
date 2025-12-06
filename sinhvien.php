<?php include("connect.php");
    // Chỉ admin mới được truy cập
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     echo "<p class='text-danger'>Bạn không có quyền truy cập trang này.</p>";
//     exit();
// }
// Lấy dữ liệu sinh viên từ MySQL
$sql = "SELECT * FROM ql_user WHERE role = 'user' ORDER BY ID ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
        <title> Quản lý sách </title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="content-header">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <h1 class="m-0">Quản lý sinh viên</h1>

    <!-- Ô tìm kiếm -->
    <form method="GET" action="searchs.php" class="d-flex">
            <input type="text" name="query" class="form-control me-2" placeholder="Tìm sinh viên...">
            <input type="hidden" name="table" value="ql_user">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </form>

      <div class="text-center">
        <a href="admin_dashboard.php" class="btn btn-outline-primary">← Quay lại trang chủ</a>
      </div>
    </form>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

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
                            <a href='sua.php?table=ql_user&ID={$row['ID']}' class='btn btn-warning'>Sửa</a>
                            <a href='xoa.php?table=ql_user&ID={$row['ID']}' class='btn btn-danger'>Xóa</a>
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
</section>
</body>
</html>
