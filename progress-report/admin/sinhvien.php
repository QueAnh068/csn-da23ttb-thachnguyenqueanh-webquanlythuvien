<?php include("../connect.php");

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
<div class="container mt-3">
    <div class="card">
        <div class="card-header">
            <nav class="navbar navbar-expand-sm bg-primary navbar-dark justify-content-center py-2">
                <div class="container-fluid justify-content-center flex-wrap">
    <!-- Ô tìm kiếm -->
    <form method="GET" action="searchs.php" class="d-flex">
            <input type="text" name="query" class="form-control me-2" placeholder="Tìm sinh viên...">
            <input type="hidden" name="table" value="ql_user">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </form>

      <div class="text-center">
        <a href="admin_dashboard.php" class="btn btn-outline-black">← Quay lại trang chủ</a>
      </div>
                </div>
            </nav>
     </div>
</div>

<div class="container mt-3">
                    <h3>Quản lý thành viên</h3><br>
                    <table class="table table-bordered">
                        <thead class="table-dark table-bordered">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
