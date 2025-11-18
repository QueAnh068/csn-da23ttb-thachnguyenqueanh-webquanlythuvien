<?php
include("connect.php"); // Kết nối CSDL

// Lấy ID sách từ URL
$sach_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($sach_id <= 0) {
    echo '<div class="alert alert-danger">Sách không tồn tại!</div>';
    exit;
}

// Lấy thông tin sách
$sql_sach = "SELECT * FROM ql_sach WHERE ID = ?";
$stmt = $conn->prepare($sql_sach);
$stmt->bind_param("i", $sach_id);
$stmt->execute();
$result_sach = $stmt->get_result();
$sach = $result_sach->fetch_assoc();

if (!$sach) {
    echo '<div class="alert alert-danger">Sách không tồn tại!</div>';
    exit;
}

// Lấy 2–3 chương đầu
$sql_chuong = "SELECT * FROM ql_chuong WHERE IdSach = ? ORDER BY SoChuong ASC LIMIT 3";
$stmt_chuong = $conn->prepare($sql_chuong);
$stmt_chuong->bind_param("i", $sach_id);
$stmt_chuong->execute();
$result_chuong = $stmt_chuong->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sách: <?php echo htmlspecialchars($sach['TenSach']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; font-family: Arial, sans-serif; }
        .sach-container { display: flex; flex-wrap: wrap; gap: 30px; margin-bottom: 40px; }
        .sach-bia img { width: 100%; max-width: 300px; height: auto; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .sach-info { flex: 1; min-width: 300px; }
        .btn-group-custom { display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap; }
        .chuong { margin-bottom: 25px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9; }
        .chuong h3 { margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="container">

    <h1 class="mb-4"><?php echo htmlspecialchars($sach['TenSach']); ?></h1>

    <div class="card shadow-sm p-3 mb-4">
        <div class="row g-3 align-items-start">
            <!-- Ảnh bìa -->
            <div class="col-md-3">
                <?php
                // Nếu trường AnhBia lưu đường dẫn tương đối, bạn có thể thêm 'uploads/' trước
                $img = htmlspecialchars($sach['AnhBia'] ?? '');
                if ($img === '') {
                    // placeholder nếu không có ảnh
                    $img = 'uploads/no-image.png';
                }
                ?>
                <img src="<?php echo $img; ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($sach['TenSach'] ?? ''); ?>" style="height: 300px; object-fit: cover;">
            </div>

            <!-- Thông tin sách -->
            <div class="col-md-9">
                <h3><?php echo htmlspecialchars($sach['TenSach']); ?></h3>
                <p><strong>Tác giả:</strong> <?php echo htmlspecialchars($sach['TenTG']); ?></p>
                <p><strong>Thể loại:</strong> <span class="badge bg-info text-dark"><?php echo htmlspecialchars($sach['TheLoai']); ?></span></p>
                <p><strong>Nhà xuất bản:</strong> <?php echo htmlspecialchars($sach['NhaXB']); ?></p>
                <p><strong>Số lượng:</strong> <?php echo htmlspecialchars($sach['SoLuong']); ?></p>
                <p><strong>Tình trạng:</strong> <?php echo htmlspecialchars($sach['TinhTrang']); ?></p>
                <p class="fw-bold text-success"><strong>Giá:</strong> <?php echo number_format($sach['Gia'],0,',','.'); ?> VNĐ</p>
                <p><strong>Mô tả:</strong> <?php echo nl2br(htmlspecialchars($sach['MoTa'])); ?></p>

                <!-- Nút Mượn & Chi tiết -->
                <div class="btn-group-custom">
                    <a href="borrow.php?id=<?php echo $sach['ID']; ?>" class="btn btn-success">Mượn sách</a>
                    <a href="chitietsach.php?id=<?php echo $sach['ID']; ?>" class="btn btn-primary">Chi tiết</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chương đầu -->
    <h2 class="mb-3">Nội dung sách (2–3 chương đầu)</h2>
    <?php if ($result_chuong->num_rows > 0): ?>
        <?php while ($chuong = $result_chuong->fetch_assoc()): ?>
            <div class="chuong">
                <h3>Chương <?php echo $chuong['SoChuong']; ?>: <?php echo htmlspecialchars($chuong['TieuDe']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($chuong['NoiDung'])); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Chưa có chương nào được thêm vào sách này.</p>
    <?php endif; ?>

</div>

</body>
</html>
