<?php 
include("admin/header.php"); 
include("admin/sidebar.php"); 
include("admin/navbar.php"); 
include("pages/connect.php"); // Kết nối CSDL
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Danh sách sinh viên</h1>

    <!-- Example Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bảng thông tin sinh viên</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="table-primary">
                        <tr>
                            <th>Mã SV</th>
                            <th>Tên SV</th>
                            <th>Email</th>
                            <th>Lớp</th>
                            <th>Giới tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM ql_sinhvien";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['MaSV'] . "</td>";
                                echo "<td>" . $row['TenSV'] . "</td>";
                                echo "<td>" . $row['Email'] . "</td>";
                                echo "<td>" . $row['Lop'] . "</td>";
                                echo "<td>" . $row['GioiTinh'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Không có dữ liệu</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include("../footer.php"); ?>

