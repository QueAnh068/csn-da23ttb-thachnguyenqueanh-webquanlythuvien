<?php
$page = isset($_GET['pages']) ? $_GET['pages'] : 'dashboar';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Trang Quản Trị Thư Viện</title>

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="admin/tc/dist/css/adminlte.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

  <!-- Navbar -->
  <?php include("admin/tc/navbar.php"); ?>

  <!-- Sidebar -->
  <?php include("admin/tc/sidebar.php"); ?>

  <!-- Main Content -->
  <main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">

        <?php 
          $filepath = "admin/$page.php";
          if (file_exists($filepath)) {
            include($filepath);
          } else {
            echo "<h3 class='text-danger'>⚠ Trang <b>$page</b> không tồn tại!</h3>";
          }
        ?>

      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php include("admin/tc/footer.php"); ?>

</div>

<!-- AdminLTE JS (đặt cuối body để load nhanh) -->
<script src="admin/tc/dist/js/adminlte.js"></script>

</body>
</html>
