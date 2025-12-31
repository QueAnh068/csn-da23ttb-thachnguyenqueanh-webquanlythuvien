<?php
session_start();
include("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $maMuon = $_POST['maMuon'];
    $maSach = $_POST['maSach'];

    // Ngày trả = hôm nay
    $ngayTra = date("Y-m-d");

    // 1. Cập nhật bảng mượn trả
    $sql1 = "UPDATE ql_muontra 
             SET TrangThai='Đã trả', NgayTra='$ngayTra' 
             WHERE ID='$maMuon'";
    mysqli_query($conn, $sql1);

    // 2. Cộng lại số lượng sách
    $sql2 = "UPDATE ql_sach 
             SET SoLuong = SoLuong + 1 
             WHERE ID='$maSach'";
    mysqli_query($conn, $sql2);

    // 3. Thông báo thành công
    $_SESSION['msg'] = "Trả sách thành công!";

    // 4. Điều hướng về danh sách
    header("Location: admin_dashboard.php");
    exit();
}
?>
