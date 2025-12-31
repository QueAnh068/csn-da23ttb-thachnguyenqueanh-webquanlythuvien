<?php
include("connect.php"); // file kết nối CSDL
session_start();

$loggedIn = isset($_SESSION['tenuser']) && $_SESSION['role'] == 'user';

$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$theloai = isset($_GET['theloai']) ? trim($_GET['theloai']) : "";

// Truy vấn sách dựa trên tìm kiếm hoặc thể loại
$where = [];
if ($search != "") {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $where[] = "(TenSach LIKE '%$search_safe%' OR TenTG LIKE '%$search_safe%')";
}
if ($theloai != "") {
    $theloai_safe = mysqli_real_escape_string($conn, $theloai);
    $where[] = "TheLoai='$theloai_safe'";
}

$sql = "SELECT * FROM ql_sach";
if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$result = mysqli_query($conn, $sql);

// Sách tiêu biểu (6 sách mới nhất)
$highlight_sql = "SELECT * FROM ql_sach ORDER BY ID DESC LIMIT 8";
$highlight_result = mysqli_query($conn, $highlight_sql);
?> 

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>THƯ VIỆN TRƯỜNG ĐẠI HỌC TRÀ VINH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="container-fluid py-4 bg-primary text-white text-center position-relative">
        <img src="image/1.jpg" 
             alt="Logo Trường Đại Học Trà Vinh" 
             class="position-absolute start-0 ms-4 top-50 translate-middle-y rounded" 
             width="60" height="60">
        <h1 class="fw-bold m-0">THƯ VIỆN TRƯỜNG ĐẠI HỌC TRÀ VINH</h1>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark justify-content-center py-2">
        <div class="container-fluid justify-content-center flex-wrap">
            <ul class="navbar-nav align-items-center mb-2 mb-sm-0">
                <li class="nav-item mx-3">
                    <a class="nav-link text-white fw-semibold" href="index.php">Trang chủ</a>
                </li>
                <li class="nav-item dropdown mx-3">
                    <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Thể loại
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productDropdown">
                        <?php
                        $categories = [
                            "Văn học",
                            "Lập trình",
                            "Tiểu thuyết",
                            "Tạp chí",
                            "Ngoại văn",
                        ];
                        foreach ($categories as $cat) {
                            echo '<li><a class="dropdown-item" href="?theloai='.urlencode($cat).'">'.$cat.'</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <?php if (isset($_SESSION['tenuser'])): ?>
                <li class="nav-item mx-3">
                    <a class="nav-link text-white fw-semibold" href="user/lsmuon.php">Lịch sử mượn</a>
                </li>
            <?php endif; ?>
            </ul>
            
            
            <form class="d-flex mx-3" method="get" action="user/search.php">
                <input class="form-control form-control-sm" type="search" name="search" placeholder="Tìm kiếm sách hoặc tác giả..." value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-light btn-sm ms-2" type="submit">Tìm</button>
            </form>

            <!-- Dropdown người dùng -->
            <div class="dropdown user-dropdown mx-3">
                <div class="d-flex align-items-center text-white" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-5 me-1"></i>
                    <?php if (isset($_SESSION['tenuser'])): ?>
                        <span class="fw-semibold"><?php echo htmlspecialchars($_SESSION['tenuser']); ?></span>
                    <?php else: ?>
                        <span class="fw-semibold">Tài khoản</span>
                    <?php endif; ?>
                </div>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <?php if (isset($_SESSION['tenuser'])): ?>
                        <li><a class="dropdown-item" href="#">👋 Xin chào, <?php echo htmlspecialchars($_SESSION['tenuser']); ?></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="login.php">Đăng nhập</a></li>
                        <li><a class="dropdown-item" href="register.php">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Banner -->
<div class="banner position-relative text-center text-white">
    <img src="image/2.jpg" alt="Banner Thư viện" class="w-100" style="height: 350px; object-fit: cover;">
    <div class="banner-overlay"></div>
    <div class="banner-text position-absolute top-50 start-50 translate-middle">
        <h2 class="fw-bold">Chào mừng đến với Thư viện Trường Đại học Trà Vinh</h2>
        <p>Không gian học tập - nghiên cứu - khám phá tri thức</p>
    </div>
</div>

<!-- Sách tiêu biểu -->
<div class="container my-5">
    <h3 class="mb-4">Sách tiêu biểu</h3>
    <div class="row">
        <?php if ($highlight_result->num_rows > 0): ?>
            <?php while($row = $highlight_result->fetch_assoc()): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo htmlspecialchars($row['AnhBia']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($row['TenSach']); ?>" style="height: 300px; object-fit: cover;">
                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark"><?php echo $row['TenSach']; ?></h5>
                            <p class="card-text mb-1 text-secondary"><?php echo $row['TenTG']; ?></p>
                            <p class="card-text mb-3"><small class="text-muted"><?php echo $row['TheLoai']; ?></small></p>

                            <div class="d-flex gap-2">
                                <form action="user/borrow.php" method="POST" class="flex-fill">
                                    <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-book"></i> Mượn sách
                                    </button>
                                </form>

                                <a href="user/chitietsach.php?id=<?php echo $row['ID']; ?>" class="btn btn-primary flex-fill">
                                    <i class="bi bi-info-circle"></i> Chi tiết sách
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Chưa có sách tiêu biểu</p>
        <?php endif; ?>
    </div>
</div>

<!-- Kết quả tìm kiếm hoặc thể loại -->
<?php if ($search != "" || $theloai != ""): ?>
<div class="container my-5">
    <h3 class="mb-4">
        <?php 
        if ($search != "") echo 'Kết quả tìm kiếm cho "'.htmlspecialchars($search).'"';
        if ($theloai != "") echo 'Sách thể loại: '.htmlspecialchars($theloai);
        ?>
    </h3>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo htmlspecialchars($row['AnhBia']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($row['TenSach']); ?>" style="height: 300px; object-fit: cover;">
                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark"><?php echo $row['TenSach']; ?></h5>
                            <p class="card-text mb-1 text-secondary"><?php echo $row['TenTG']; ?></p>
                            <p class="card-text mb-3"><small class="text-muted"><?php echo $row['TheLoai']; ?></small></p>

                            <div class="d-flex gap-2">
                                <form action="user/borrow.php" method="POST" class="flex-fill">
                                    <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-book"></i> Mượn sách
                                    </button>
                                </form>

                                <a href="user/chitietsach.php?id=<?php echo $row['ID']; ?>" class="btn btn-primary flex-fill">
                                    <i class="bi bi-info-circle"></i> Chi tiết sách
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Không tìm thấy sách.</p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<footer class="app-footer text-center">
    <strong>Thư viện TVU</strong><br>

    <small>
        Trường Đại học Trà Vinh<br>
        Địa chỉ: 126 Nguyễn Thiện Thành, phường Hòa Thuận, TP. Vĩnh Long<br>
        Liên hệ: 02.xxx.xxx.xx |
        <a href="mailto:celras@tvu.edu.vn">celras@tvu.edu.vn</a>
    </small>
</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
