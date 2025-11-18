<?php
include("connect.php"); // Kết nối CSDL

// Lấy từ khóa người dùng nhập
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Chống lỗi SQL Injection
$search_safe = mysqli_real_escape_string($conn, $search);

// Câu truy vấn tìm theo tên sách hoặc tác giả
$sql = "SELECT * FROM ql_sach WHERE TenSach LIKE '%$search_safe%'OR TenTG LIKE '%$search_safe%'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kết quả tìm kiếm sách</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .book-card {
            margin-bottom: 20px;
        }
        .book-img {
            width: 180px;
            height: auto;
            object-fit: contain;
        }
        .book-info {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .borrow-btn {
            align-self: start;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <h2 class="mb-4">Kết quả tìm kiếm sách</h2>

    <?php
    if ($search == "") {
        echo '<div class="alert alert-warning">Nhập từ khóa để tìm kiếm.</div>';
    } else {
        if (mysqli_num_rows($result) > 0) {
            echo "<h5 class='mb-4'>Kết quả tìm kiếm cho: <span class='text-primary'>$search</span></h5>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card book-card shadow-sm p-3">';
                echo '<div class="row g-3 align-items-center">';
                
                // Ảnh bìa bên trái
                echo '<div class="col-md-3">';
                if (!empty($row['AnhBia'])) {
                    echo '<img src="' . $row['AnhBia'] . '" class="book-img img-fluid" alt="Bìa sách">';
                } else {
                    echo '<img src="no-image.png" class="book-img img-fluid" alt="Không có ảnh">';
                }
                echo '</div>';

                // Thông tin bên phải
                echo '<div class="col-md-9 book-info">';
                echo '<div>';
                echo '<h5>' . $row['TenSach'] . '</h5>';
                echo '<p class="mb-1"><strong>Tác giả:</strong> ' . $row['TenTG'] . '</p>';
                echo '<p class="mb-1"><strong>Thể loại:</strong> <span class="badge bg-info text-dark">' . $row['TheLoai'] . '</span></p>';
                echo '<p class="mb-1"><strong>NXB:</strong> ' . $row['NhaXB'] . '</p>';
                echo '<p class="mb-1"><strong>Số lượng:</strong> ' . $row['SoLuong'] . '</p>';
                echo '<p class="mb-1"><strong>Tình trạng:</strong> ' . $row['TinhTrang'] . '</p>';
                echo '<p class="fw-bold text-success"><strong>Giá:</strong>' . number_format($row['Gia'], 0, ',', '.') . ' VNĐ</p>';
                echo '<p class="mb-1"><strong>Mô tả:</strong> ' . $row['MoTa'] . '</p>';
                echo '</div>';
                
                // Nút mượn sách
                echo '<a href="borrow.php?id=' . $row['ID'] . '" class="btn btn-primary borrow-btn mt-2">Mượn sách</a>';
                echo '<a href="chitietsach.php?id=' . $row['ID'] . '" class="btn btn-primary borrow-btn mt-2">Chi tiết</a>';
                
                echo '</div>'; // col-md-9
                echo '</div>'; // row
                echo '</div>'; // card
            }

        } else {
            echo '<div class="alert alert-danger">❌ Không tìm thấy sách hoặc tác giả phù hợp.</div>';
        }
    }
    ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
