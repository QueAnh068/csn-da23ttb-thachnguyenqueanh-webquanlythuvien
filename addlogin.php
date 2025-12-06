<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("connect.php");

$username = "admin2";
$password = "123456";
$role = "admin";

$hash = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO ql_user (HoTen, TenDN, MatKhau, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Lỗi prepare: " . $conn->error);
}

$stmt->bind_param("ssss", $hoten, $username, $hash, $role);

$hoten = "Admin 2";

if ($stmt->execute()) {
    echo "✔️ Tạo tài khoản admin2 thành công!";
} else {
    echo "❌ Lỗi SQL: " . $stmt->error;
}
