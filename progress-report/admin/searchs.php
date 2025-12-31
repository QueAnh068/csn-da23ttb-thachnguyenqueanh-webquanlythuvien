<?php
include("../connect.php");
session_start();
?>

<div class="container-fluid py-4">
    <h1 class="h3 mb-4 text-gray-800">Kết quả tìm kiếm</h1>

<?php
// Lấy tên bảng
$table = isset($_GET['table']) ? trim($_GET['table']) : "";

// Nếu không có table thì báo lỗi
if ($table == "") {
    echo "<p class='text-danger'>Không xác định được bảng.</p>";
    exit;
}

// Lấy từ khóa tìm kiếm
$query = isset($_GET['query']) ? trim($_GET['query']) : "";
$query_safe = mysqli_real_escape_string($conn, $query);

// Lấy tên bảng
$table = isset($_GET['table']) ? trim($_GET['table']) : "";

// Nếu không có table thì báo lỗi
if ($table == "") {
    echo "<p class='text-danger'>Không xác định được bảng.</p>";
    exit;
}

// Lấy ID tìm kiếm
$id = isset($_GET['query']) ? trim($_GET['query']) : "";
$id_safe = mysqli_real_escape_string($conn, $id);

// Lấy danh sách cột (bắt buộc phải có để kiểm tra cột ảnh)
$columns_res = mysqli_query($conn, "SHOW COLUMNS FROM $table");
$columns = [];
while ($col = mysqli_fetch_assoc($columns_res)) {
    $columns[] = $col['Field'];
}

// Tạo câu SQL tìm kiếm theo ID
if ($id_safe != "") {
    $sql = "SELECT * FROM $table WHERE ID LIKE '%$id_safe%'";
} else {
    $sql = "SELECT * FROM $table";
}

$result = mysqli_query($conn, $sql);

// Xác định cột chứa ảnh (nếu có)
$imgField = "";
if (in_array("AnhBia", $columns)) $imgField = "AnhBia";
if (in_array("AnhDaiDien", $columns)) $imgField = "AnhDaiDien";


$result = mysqli_query($conn, $sql);


// Xác định cột chứa ảnh (nếu có)
$imgField = "";
if (in_array("AnhBia", $columns)) $imgField = "AnhBia";
if (in_array("AnhDaiDien", $columns)) $imgField = "AnhDaiDien";


// --- HIỂN THỊ DỮ LIỆU ---
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        echo '<div class="card mb-3 shadow-sm">';
        echo '<div class="row g-0">';

        // ===== HIỂN THỊ ẢNH (NẾU BẢNG CÓ ẢNH) =====
        if ($imgField != "") {
            echo '<div class="col-md-3">';
            if (!empty($row[$imgField])) {
                echo '<img src="' . $row[$imgField] . '" class="img-fluid rounded-start">';
            } else {
                echo '<img src="no-image.png" class="img-fluid rounded-start">';
            }
            echo '</div>';
            echo '<div class="col-md-9">';
        } else {
            // Nếu bảng KHÔNG có ảnh → thông tin rộng full
            echo '<div class="col-md-12">';
        }

        // ===== THÔNG TIN CHI TIẾT =====
        echo '<div class="card-body">';

        foreach ($columns as $col) {
            if ($col === $imgField) continue;

            // Format tên label
            $label = ucwords(str_replace(['_', 'ID'], [' ', 'Mã'], $col));

            // Format giá trong bảng sách
            if ($col === 'Gia') {
                echo '<p class="mb-1"><strong>' . $label . ':</strong> ' . number_format($row[$col], 0, ',', '.') . ' VNĐ</p>';
            } else {
                $value = $row[$col] ?? "—"; // tránh lỗi khi NULL (ví dụ: NgayTra)
                echo '<p class="mb-1"><strong>' . $label . ':</strong> ' . htmlspecialchars($value) . '</p>';
            }

        }

        // ===== NÚT TÁC VỤ (tự động theo bảng) =====
        echo '<div class="mt-2">';

        // Nếu bảng sách → có nút mượn + chi tiết
        if ($table == "ql_sach") {
            echo '<a href="borrow.php?id=' . $row['ID'] . '" class="btn btn-primary me-2">Mượn sách</a>';
            echo '<a href="chitietsach.php?id=' . $row['ID'] . '" class="btn btn-secondary">Chi tiết</a>';
        }

        // Bảng user → xem chi tiết user
        if ($table == "ql_user") {
            echo '<a href="user/index_user.php?id=' . $row['ID'] . '" class="btn btn-info">Xem thông tin</a>';
        }

        // Bảng mượn trả → xem hóa đơn
        if ($table == "ql_muontra") {
            echo '<a href="muontra_detail.php?id=' . $row['ID'] . '" class="btn btn-warning">Xem chi tiết</a>';
        }

        echo '</div>'; // end nút
        echo '</div>'; // end card-body
        echo '</div>'; // end col
        echo '</div>'; // end row
        echo '</div>'; // end card
    }

} else {
    echo '<div class="alert alert-danger">Không tìm thấy dữ liệu phù hợp.</div>';
}
?>

</div>

<div class="text-center">
    <a href="admin_dashboard.php" class="btn btn-outline-primary">← Quay lại trang chủ</a>
</div>

<?php include("tc/footer.php"); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
