<?php
include("../connect.php");
session_start();

// Lấy tổng số sách
$sql_sach = "SELECT COUNT(*) AS total FROM ql_sach";
$result_sach = mysqli_query($conn, $sql_sach);
$row_sach = mysqli_fetch_assoc($result_sach);
$total_sach = $row_sach['total'];

// Lấy tổng số sinh viên
$sql_sv = "SELECT COUNT(*) AS total FROM ql_sinhvien";
$result_sv = mysqli_query($conn, $sql_sv);
$row_sv = mysqli_fetch_assoc($result_sv);
$total_sv = $row_sv['total'];

// Lấy tổng số lượt mượn trả
$sql_muontra = "SELECT COUNT(*) AS total FROM ql_muontra";
$result_mt = mysqli_query($conn, $sql_muontra);
$row_mt = mysqli_fetch_assoc($result_mt);
$total_mt = $row_mt['total'];

// Lấy số lượng vi phạm
$sql_vp = "SELECT COUNT(*) AS total FROM ql_vipham";
$result_vp = mysqli_query($conn, $sql_vp);
$row_vp = mysqli_fetch_assoc($result_vp);
$total_vp = $row_vp['total'];
?>

<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="tc/dist/css/adminlte.min.css">

<div class="row">

  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?php echo $total_sach; ?></h3>
        <p>Books</p>
      </div>
      <div class="icon">
        <i class="fa-solid fa-book"></i>
      </div>
      <a href="sach.php" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?php echo $total_sv; ?></h3>
        <p>Members</p>
      </div>
      <div class="icon">
        <i class="fa-solid fa-users"></i>
      </div>
      <a href="sinhvien.php" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?php echo $total_mt; ?></h3>
        <p>Borrow/Return</p>
      </div>
      <div class="icon">
        <i class="fa-solid fa-newspaper"></i>
      </div>
      <a href="muontra.php" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?php echo $total_vp; ?></h3>
        <p>Violations</p>
      </div>
      <div class="icon">
        <i class="fa-solid fa-file-word"></i>
      </div>
      <a href="vipham.php" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

</div>


