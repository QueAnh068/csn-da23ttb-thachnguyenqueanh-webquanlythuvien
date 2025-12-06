<?php
include("connect.php");

$table = $_GET['table'] ?? '';
$id    = $_GET['id'] ?? '';

if ($table == '' || $id == '') {
    die("Thiếu table hoặc id!");
}

// Lấy khóa chính tự động
$pkQuery = mysqli_query($conn, "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'");
$pkData = mysqli_fetch_assoc($pkQuery);
$pk = $pkData['Column_name'];

$sql = "DELETE FROM $table WHERE $pk = '$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: sach.php?table=$table&msg=deleted");
    exit;
} else {
    echo "Lỗi khi xóa: " . mysqli_error($conn);
}
?>
