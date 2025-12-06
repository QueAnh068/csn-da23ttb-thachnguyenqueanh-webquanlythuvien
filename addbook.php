<?php
include("connect.php"); // Kết nối CSDL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $theloai = $_POST['TheLoai'];
    $tensach = $_POST['TenSach'];
    $tentg = $_POST['TenTG'];
    $nhaxb = $_POST['NhaXB'];
    $soluong = $_POST['SoLuong'];
    $gia = $_POST['Gia'];
    $tinhtrang = $_POST['TinhTrang'];

    // --- Xử lý ảnh upload ---
    $target_dir = "image/"; // Thư mục lưu ảnh (tạo sẵn)
    $file_name = basename($_FILES["AnhBia"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra có phải ảnh không
    $check = getimagesize($_FILES["AnhBia"]["tmp_name"]);
    if ($check === false) {
        echo "File không phải là ảnh.";
        $uploadOk = 0;
    }

    // Giới hạn định dạng ảnh
    $allowTypes = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowTypes)) {
        echo "Chỉ chấp nhận file JPG, JPEG, PNG, GIF.";
        $uploadOk = 0;
    }

    // Nếu mọi thứ OK → lưu ảnh và thêm vào DB
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["AnhBia"]["tmp_name"], $target_file)) {
            // Lưu thông tin vào CSDL
            $anhBiaDB = "image/" . $file_name; // đường dẫn tương đối để user đọc được

            $sql = "INSERT INTO ql_sach (TheLoai, TenSach, TenTG, NhaXB, SoLuong, Gia, AnhBia, TinhTrang)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssidss", $theloai, $tensach, $tentg, $nhaxb, $soluong, $gia, $anhBiaDB, $tinhtrang);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success text-center'>✅ Thêm sách thành công!</div>";
            } else {
                echo "<div class='alert alert-danger'>❌ Lỗi thêm sách: " . $conn->error . "</div>";
            }
        } else {
            echo "❌ Lỗi khi tải ảnh lên.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm Sách Mới</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">📚 Thêm Sách Mới</h2>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Thể loại</label>
            <select name="TheLoai" class="form-select" required>
                <option value="">-- Chọn thể loại --</option>
                <option value="Văn học">Văn học</option>
                <option value="Lập trình">Lập trình</option>
                <option value="Tiểu thuyết">Tiểu thuyết</option>
                <option value="Tạp chí">Tạp chí</option>
                <option value="Ngoại văn">Ngoại văn</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên sách</label>
            <input type="text" name="TenSach" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên tác giả</label>
            <input type="text" name="TenTG" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Nhà xuất bản</label>
            <input type="text" name="NhaXB" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="number" name="SoLuong" class="form-control" value="1">
        </div>

        <div class="mb-3">
            <label class="form-label">Giá (VNĐ)</label>
            <input type="number" name="Gia" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh bìa</label>
            <input type="file" name="AnhBia" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tình trạng</label>
            <select name="TinhTrang" class="form-select" required>
                <option value="Văn học">Còn hàng</option>
                <option value="Lập trình">Hết hàng</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Thêm Sách</button>

        <a href="sach.php" class="btn btn-outline-primary">← Quay lại trang chủ</a>
    </form>
</div>
</body>
</html>  