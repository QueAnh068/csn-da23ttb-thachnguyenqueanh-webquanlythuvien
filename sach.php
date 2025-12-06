<?php
include("connect.php"); 

// Lấy từ khóa tìm kiếm
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}


$search_safe = mysqli_real_escape_string($conn, $search);

// Câu SQL chính thức duy nhất
if ($search_safe != "") {
    $sql = "SELECT * FROM ql_sach 
            WHERE TenSach LIKE '%$search_safe%' 
            ORDER BY ID DESC";
} else {
    $sql = "SELECT * FROM ql_sach ORDER BY ID DESC";
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
        <title> Quản lý sách </title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h1 class="m-0">Quản lý sách</h1>

        <!-- FORM TÌM KIẾM ĐÚNG -->
        <form method="GET" action="searchs.php" class="d-flex">
            <input type="text" name="query" class="form-control me-2" placeholder="Tìm sách...">
            <input type="hidden" name="table" value="ql_sach">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </form>

        <div class="text-center">
            <a href="admin_dashboard.php" class="btn btn-outline-primary">← Quay lại trang chủ</a>
        </div>

    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">

            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Danh sách sách</h3>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã sách</th>
                            <th>Thể loại</th>
                            <th>Tên sách</th>
                            <th>Tác giả</th>
                            <th>Ảnh bìa</th>
                            <th>Nhà xuất bản</th>
                            <th>Số lượng</th>
                            <th>Tình trạng</th>
                            <th>Giá</th>
                            <th>Mô tả</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['ID']}</td>
                                        <td>{$row['TheLoai']}</td>
                                        <td>{$row['TenSach']}</td>
                                        <td>{$row['TenTG']}</td>
                                        <td>
                                            <img src='admin/image/{$row['AnhBia']}'
                                                alt='Ảnh bìa'
                                                style='width: 80px; height: 120px; object-fit: cover;'>
                                        </td>
                                        <td>{$row['NhaXB']}</td>
                                        <td>{$row['SoLuong']}</td>
                                        <td>{$row['TinhTrang']}</td>
                                        <td>{$row['Gia']}</td>
                                        <td>{$row['MoTa']}</td>
                                        <td>
                                            <a href='sua.php?table=ql_sach&ID={$row['ID']}' class='btn btn-warning'>Sửa</a>
                                            <a href='xoa.php?table=ql_sach&ID={$row['ID']}' class='btn btn-danger'>Xóa</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>Không tìm thấy sách nào.</td></tr>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

       <div class="mb-3">
                <a href="addbook.php" class="btn btn-success">Thêm </a>
        </div>
    </div>
</section>

</body>
</html>
