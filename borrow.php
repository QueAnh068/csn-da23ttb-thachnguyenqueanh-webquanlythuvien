<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("connect.php");
session_start();

// Kiểm tra request hợp lệ
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['id'])) {
    echo "<script>
        alert('⚠️ Truy cập không hợp lệ!');
        window.location='index.php';
    </script>";
    exit;
}

$id_sach = intval($_POST['id']);

// Nếu chưa đăng nhập
if (!isset($_SESSION['TenDN'])) {
    echo "<script>
        alert('⚠️ Vui lòng đăng nhập trước khi mượn sách!');
        window.location='login.php';
    </script>";
    exit;
}

// Lấy ID user theo TenDN
$sql_user = "SELECT ID FROM ql_user WHERE TenDN = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $_SESSION['TenDN']);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$row_user = $result_user->fetch_assoc();

if (!$row_user) {
    echo "<script>
        alert('❌ Không tìm thấy tài khoản người dùng!');
        window.location='login.php';
    </script>";
    exit;
}

$id_user = $row_user['ID'];

// Thêm bản ghi mượn
$sql = "INSERT INTO ql_muontra (IDuser, IDsach, NgayMuon, NgayTra, TrangThai)
        VALUES (?, ?, NOW(), NULL, 'Đang mượn')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_user, $id_sach);

if ($stmt->execute()) {
    echo "<script>
        alert('✅ Mượn sách thành công!');
        window.location='index.php';
    </script>";
} else {
    echo "<script>
        alert('❌ Lỗi khi mượn sách: " . addslashes($stmt->error) . "');
        history.back();
    </script>";
}
?>
