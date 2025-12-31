<?php


if (!isset($_SESSION['tenadmin'])) {
    header("Location: ../login.php");
    exit();
}

$tenadmin = $_SESSION['tenadmin'];
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="admin_dashboard.php" class="nav-link">Trang chủ</a>
        </li>
    </ul>

    <!-- SEARCH -->
    <form class="form-inline ml-3" method="GET" action="search.php">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar"
                   type="search"
                   name="keyword"
                   placeholder="Tìm kiếm..."
                   aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- RIGHT NAVBAR -->
    <ul class="navbar-nav ml-auto">

        <!-- USER DROPDOWN -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="far fa-user-circle"></i>
                <span class="ms-1 fw-bold">
                    <?= htmlspecialchars($tenadmin) ?>
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-end">
                <span class="dropdown-item-text">
                    Xin chào, <b><?= htmlspecialchars($tenadmin) ?></b>
                </span>

                <div class="dropdown-divider"></div>

                <a href="../logout.php" class="dropdown-item text-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Đăng xuất
                </a>
            </div>
        </li>

    </ul>
</nav>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
