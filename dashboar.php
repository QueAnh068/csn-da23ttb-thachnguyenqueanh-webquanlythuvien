<?php
include("connect.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Thống kê
$sql_sv = "SELECT COUNT(*) AS total_sv FROM ql_user";
$sv = mysqli_fetch_assoc(mysqli_query($conn, $sql_sv))['total_sv'] ?? 0;
?>

<div class="content-header">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <h1 class="m-0">Bảng thống kê</h1>

    <form method="GET" action="index.php?page=dashboard" class="d-flex">
      <input type="hidden" name="page" value="dashboard">
      <input type="text" name="search" class="form-control me-2" placeholder="Tìm sinh viên...">
      <button class="btn btn-primary" type="submit">Tìm</button>
    </form>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

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

    <!-- Bảng danh sách -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title">Danh sách sinh viên</h3>
      </div>

      <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-light">
            <tr>
              <th>Mã SV</th>
              <th>Họ tên</th>
              <th>Tên đăng nhập</th>
              <th>Email</th>
              <th>Thao tác</th>
            </tr>
          </thead>

          <tbody>
            <?php
$search = $_GET['search'] ?? "";
$search_safe = mysqli_real_escape_string($conn, $search);

// Câu SQL mặc định
$sql = "SELECT * FROM ql_user WHERE role = 'user'";

// Nếu có từ khóa thì thêm điều kiện lọc
if ($search_safe != "") {
    $sql .= " AND (Hoten LIKE '%$search_safe%' OR ID LIKE '%$search_safe%')";
}

// Cuối cùng thêm sắp xếp
$sql .= " ORDER BY ID ASC";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        echo "<tr>
                <td>{$row['ID']}</td>
                <td>{$row['Hoten']}</td>
                <td>{$row['TenDN']}</td>
                <td>{$row['Email']}</td>
                <td>
                    <a href='index.php?page=them&id={$row['ID']}' class='btn btn-success btn-sm'>Thêm</a>
                    <a href='index.php?page=sua&id={$row['ID']}' class='btn btn-warning btn-sm'>Sửa</a>
                    <a href='index.php?page=xoa&id={$row['ID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Xóa sinh viên này?\")'>Xóa</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>Không tìm thấy sinh viên</td></tr>";
}
?>
            
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>
