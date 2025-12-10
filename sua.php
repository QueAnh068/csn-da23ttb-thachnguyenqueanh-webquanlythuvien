<?php
include("../connect.php");

// Lấy tham số an toàn
$table = isset($_GET['table']) ? $_GET['table'] : null;
$id    = isset($_GET['ID']) ? $_GET['ID'] : null;

if (!$table || !$id) {
    die("Thiếu tham số table hoặc ID. Ví dụ: sua.php?table=ql_sach&ID=5");
}

// Chỉ chấp nhận các bảng hợp lệ (whitelist)
$allowed_tables = ['ql_user','ql_sach','ql_muontra'];
if (!in_array($table, $allowed_tables, true)) {
    die("Bảng không hợp lệ!");
}

// Khóa chính (ở đây dùng ID cho các bảng đã liệt kê)
$pk = "ID";

// Lấy dữ liệu cũ (chú ý escape tên bảng & cột bằng backticks vì đã được whitelist)
$sql = "SELECT * FROM `$table` WHERE `$pk` = '" . mysqli_real_escape_string($conn, $id) . "' LIMIT 1";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
if (!$row) die("Không tìm thấy dữ liệu!");

// Khi nhấn Lưu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updates = [];

    // Chỉ chấp nhận các key là những cột thật của bảng (tránh trường lạ)
    $valid_columns = array_keys($row);
    foreach ($_POST as $key => $value) {
        // Bỏ qua nếu người dùng gửi trường không có trong DB hoặc là PK
        if (!in_array($key, $valid_columns, true) || $key === $pk) continue;

        // Làm sạch dữ liệu để tránh SQL injection / XSS
        $safe_val = mysqli_real_escape_string($conn, trim($value));
        // Ghi nhận cập nhật với backticks cho tên cột
        $updates[] = "`$key` = '$safe_val'";
    }

    if (!empty($updates)) {
        $setString = implode(", ", $updates);
        $updateSQL = "UPDATE `$table` SET $setString WHERE `$pk` = '" . mysqli_real_escape_string($conn, $id) . "'";
        if (mysqli_query($conn, $updateSQL)) {
            // Chuyển về trang danh sách của bảng
            header("Location: admin_dashboard.php?table=" . urlencode($table));
            exit;
        } else {
            echo "Lỗi khi cập nhật: " . mysqli_error($conn);
        }
    } else {
        echo "<div class='alert alert-info'>Không có trường hợp lệ để cập nhật.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sửa dữ liệu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h4 class="m-0">Sửa dữ liệu bảng: <?php echo htmlspecialchars($table, ENT_QUOTES, 'UTF-8'); ?></h4>
        </div>

        <div class="card-body">
            <form method="POST">
                <?php foreach ($row as $col => $val): ?>
                    <?php if ($col == $pk): ?>
                        <div class="mb-3">
                            <label class="form-label"><?php echo htmlspecialchars($col, ENT_QUOTES, 'UTF-8'); ?></label>
                            <input type="text" value="<?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?>" class="form-control" disabled>
                            <!-- giữ id trong hidden để còn dùng nếu cần -->
                            <input type="hidden" name="<?php echo htmlspecialchars($col, ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <label class="form-label"><?php echo htmlspecialchars($col, ENT_QUOTES, 'UTF-8'); ?></label>
                            <input type="text" name="<?php echo htmlspecialchars($col, ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?>" class="form-control">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-primary w-100">Lưu thay đổi</button>
                <a href="admin_dashboard.php" class="btn btn-outline-primary">← Quay lại trang chủ</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
