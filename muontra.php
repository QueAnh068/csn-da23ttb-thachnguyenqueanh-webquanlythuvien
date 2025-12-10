
 <?php
    include("../connect.php"); // file kết nối CSDL


// Xử lý trả sách nếu admin bấm trả
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "tra") {
    $maMuon = $_POST['maMuon'];
    $maSach = $_POST['maSach'];

    // Cập nhật trạng thái mượn và ngày trả
    $stmt = $conn->prepare("UPDATE ql_muontra SET TrangThai='Đã trả', NgayTra=NOW() WHERE ID=?");
    $stmt->bind_param("i", $maMuon);
    $stmt->execute();

    // Tăng số lượng sách
    $stmt = $conn->prepare("UPDATE ql_sach SET SoLuong = SoLuong + 1 WHERE ID = ?");
    $stmt->bind_param("s", $maSach);
    $stmt->execute();

    echo "<script>alert('Xác nhận trả sách thành công!'); window.location='admin_dashboard.php';</script>";
    exit;
}


    // Lấy từ khóa tìm kiếm
    $search = "";
    if (isset($_GET['search'])) {
        $search = trim($_GET['search']);
    }
    // bảo mật chuỗi
    $search_safe = mysqli_real_escape_string($conn, $search);

    if ($search_safe != "") {
        $sql = "SELECT * FROM ql_muontra WHERE TenSach LIKE '%$search_safe%'";
    } else {
        $sql = "SELECT * FROM ql_muontra ORDER BY ID DESC";
    }
    $result = mysqli_query($conn, $sql);
?> 
<!DOCTYPE html>
<html lang="vi">
<head>
        <title> Quản lý sách </title>
        <meta charset=" utf-8" name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="m-0">Quản lý mượn trả</h1>

            <!-- Ô tìm kiếm -->
            <form method="GET" action="searchs.php" class="d-flex">
            <input type="text" name="query" class="form-control me-2" placeholder="Tìm phiếu mượn...">
            <input type="hidden" name="table" value="ql_muontra">
            <button class="btn btn-primary" type="submit">Tìm</button>
        
        <a href="admin_dashboard.php" class="btn btn-outline-primary">← Quay lại trang chủ</a>
      </div>
            </form>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Bảng mượn trả -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Danh sách mượn trả sách</h3>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>ID sách</th>
                                    <th>ID sinh viên</th>
                                    <th>Ngày mượn</th>
                                    <th>Ngày trả</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                
            <?php
if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        // escape dữ liệu
        $id        = htmlspecialchars($row['ID']);
        $idsach    = htmlspecialchars($row['IDsach']);
        $iduser    = htmlspecialchars($row['IDuser']);
        $ngayMuon  = htmlspecialchars($row['NgayMuon']);
        $ngayTra   = $row['NgayTra'] ? htmlspecialchars($row['NgayTra']) : '';
        $trangThai = htmlspecialchars($row['TrangThai']);

        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$idsach}</td>";
        echo "<td>{$iduser}</td>";
        echo "<td>{$ngayMuon}</td>";
        echo "<td>{$ngayTra}</td>";
        echo "<td>{$trangThai}</td>";

        echo "<td>";

        // Nút trả sách
        if ($row['TrangThai'] === 'Đang mượn') {
            echo '<form method="POST" style="margin:0;">';
            echo '<input type="hidden" name="action" value="tra">';
            echo '<input type="hidden" name="maMuon" value="'.$id.'">';
            echo '<input type="hidden" name="maSach" value="'.$idsach.'">';
            echo '<button type="submit" class="btn btn-warning btn-sm">Xác nhận trả sách</button>';
            echo '</form>';
        } else {
            echo '<span class="text-success">Đã trả</span><br>';
            if ($ngayTra) {
                echo '<small>'.$ngayTra.'</small>';
            }
        }

        // Nút sửa – xóa
        echo "<br>";
        echo "<a href='sua.php?table=ql_muontra&ID={$id}' class='btn btn-warning btn-sm mt-1'>Sửa</a> ";
        echo "<a href='xoa.php?table=ql_muontra&ID={$id}' class='btn btn-danger btn-sm mt-1'>Xóa</a>";

        echo "</td>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='7'>Chưa có dữ liệu mượn trả.</td></tr>";
}
?>

              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




