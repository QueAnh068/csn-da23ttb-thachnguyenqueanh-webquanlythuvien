<?php
include("../connect.php"); // kết nối CSDL

// XỬ LÝ CẬP NHẬT VI PHẠM
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

    // Xử lý thu tiền / hoàn tất vi phạm
    if ($_POST['action'] == "xuly") {
        $idVP = $_POST['idVP'];
        $stmt = $conn->prepare("UPDATE ql_vipham SET TrangThai = 'Da xu ly' WHERE ID = ?");
        $stmt->bind_param("i", $idVP);
        $stmt->execute();

        echo "<script>alert('Đã xử lý vi phạm thành công!'); window.location='vipham.php';</script>";
        exit;
    }
}

// LẤY DANH SÁCH VI PHẠM

$sql = "SELECT 
            vp.ID,
            u.HoTen,
            s.TenSach,
            vp.Ngayvp,
            vp.MucPhat,
            vp.TrangThai
        FROM ql_vipham vp
        JOIN ql_user u ON vp.IDuser = u.ID
        JOIN ql_sach s ON vp.IDsach = s.ID
        ORDER BY vp.ID DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Quản lý vi phạm</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-3">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand-sm bg-primary navbar-dark justify-content-center py-2">
                        <div class="container-fluid justify-content-center flex-wrap">
                        <!-- FORM TÌM KIẾM -->
                        <form method="GET" action="" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Tìm vi phạm...">
                            <button class="btn btn-outline-light btn-sm ms-2" type="submit">Tìm</button>
                        </form>
                    </div>
                </nav>
            </div>

            <div class="container mt-3">
                <h3>Quản lý vi phạm</h3><br>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-dark table-bordered">
                            <tr>
                                <th>ID</th>
                                <th>Sinh viên</th>
                                <th>Tên sách</th>
                                <th>Ngày vi phạm</th>
                                <th>Mức phạt</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                echo "<tr>
                                        <td>{$row['ID']}</td>
                                        <td>{$row['IDuser']}</td>
                                        <td>{$row['IDsach']}</td>
                                        <td>{$row['Ngayvp']}</td>
                                        <td>".number_format($row['MucPhat'])." đ</td>
                                        <td>{$row['TrangThai']}</td>
                                        <td>";

                                // Nút xử lý vi phạm
                                if ($row['TrangThai'] == 'Chua xu ly') {
                                    echo "
                                        <form method='POST' action='xuly_vipham.php' style='margin:0;'>
                                            <input type='hidden' name='idVP' value='{$row['ID']}'>
                                            <button class='btn btn-warning btn-sm'>Xử lý</button>
                                        </form>
                                    ";
                                } else {
                                    echo "<span class='text-success'>Đã xử lý</span>";
                                }

                                echo "
                                        <a href='xoa.php?table=vi_pham&ID={$row['ID']}' class='btn btn-danger btn-sm mt-1'>Xóa</a>
                                    </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Không có vi phạm nào.</td></tr>";
                        }
                        ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
