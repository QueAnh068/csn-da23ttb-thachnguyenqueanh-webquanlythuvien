<?php
include("connect.php");
session_start();

// Nếu chưa đăng nhập → quay lại login
if (!isset($_SESSION['TenDN'])) {
    header("Location: login.php");
    exit();
}

$tenUser = $_SESSION['TenDN'];

// Lấy thông tin người dùng hiện tại
$sql_user = "SELECT * FROM ql_user WHERE TenDN = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("s", $tenUser);
$stmt->execute();
$info = $stmt->get_result()->fetch_assoc();
$idUser = $info['ID'];

// Lấy danh sách sách đang mượn
$sql = "SELECT s.TenSach, s.TenTG, s.TheLoai, m.NgayMuon, m.NgayTra 
        FROM ql_muontra m
        JOIN ql_sach s ON m.IDSach = s.ID
        WHERE m.IDUser = ?";

$stmt2 = $conn->prepare($sql);
$stmt2->bind_param("i", $idUser);
$stmt2->execute();
$result_muon = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang người dùng - Thư viện TVU</title>

    <!-- Font + CSS -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <h5 class="text-primary font-weight-bold m-0">Thư viện TVU - Người dùng</h5>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                👤 <?php echo htmlspecialchars($tenUser); ?>
                            </span>
                        </li>
                    </ul>
                </nav>

                <!-- Page Content -->
                <div class="container-fluid">

                    <!-- Thông tin tài khoản -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary">
                            <h6 class="m-0 font-weight-bold text-white">Thông tin cá nhân</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>👩 Họ tên:</strong> <?php echo htmlspecialchars($info['TenDN']); ?></p>
                            <p><strong>🔑 Vai trò:</strong> 
                                <span class="badge badge-<?php echo $info['role'] == 'admin' ? 'danger' : 'info'; ?>">
                                    <?php echo ucfirst($info['role']); ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Danh sách sách đang mượn -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-success">
                            <h6 class="m-0 font-weight-bold text-white">📚 Danh sách sách đã mượn</h6>
                        </div>
                        <div class="card-body">
                            <?php if ($result_muon->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" width="100%" cellspacing="0">
                                    <thead class="bg-light text-dark">
                                        <tr>
                                            <th>Tên sách</th>
                                            <th>Tác giả</th>
                                            <th>Thể loại</th>
                                            <th>Ngày mượn</th>
                                            <th>Ngày trả</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result_muon->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['TenSach']); ?></td>
                                            <td><?php echo htmlspecialchars($row['TenTG']); ?></td>
                                            <td><?php echo htmlspecialchars($row['TheLoai']); ?></td>
                                            <td><?php echo htmlspecialchars($row['NgayMuon']); ?></td>
                                            <td><?php echo htmlspecialchars($row['NgayTra'] ?? 'Chưa trả'); ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                                <p class="text-center text-muted">Hiện tại bạn chưa mượn quyển sách nào.</p>
                            <?php endif; ?>
                        </div>

                        <div class="text-center">
                            <a href="index.php" class="btn btn-outline-primary">← Quay lại danh sách sách</a>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

        </div>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
