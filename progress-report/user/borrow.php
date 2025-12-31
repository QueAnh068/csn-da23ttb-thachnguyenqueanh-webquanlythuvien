<?php
    include("../connect.php");
    session_start();

    /*Kiểm tra request hợp lệ*/
    if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['id'])) {
        echo "<script>
            alert('⚠️ Truy cập không hợp lệ!');
            window.location='../index.php';
        </script>";
        exit;
    }

    $id_sach = intval($_POST['id']);

    /*Kiểm tra đăng nhập*/
    if (!isset($_SESSION['tenuser'])) {
        echo "<script>
            alert('⚠️ Vui lòng đăng nhập trước khi mượn sách!');
            window.location='../login.php';
        </script>";
        exit;
    }

    /*Lấy ID user từ tài khoản*/
    $sql_user = "SELECT ID FROM ql_user WHERE TenDN = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $_SESSION['tenuser']);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $row_user = $result_user->fetch_assoc();

    if (!$row_user) {
        echo "<script>
            alert('❌ Không tìm thấy tài khoản người dùng!');
            window.location='../login.php';
        </script>";
        exit;
    }

    $id_user = $row_user['ID'];

    /* =============================
    4. Kiểm tra số lượng sách
    ============================= */
    $sql_check = "SELECT SoLuong FROM ql_sach WHERE ID = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id_sach);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if (!$row_check) {
        echo "<script>
            alert('❌ Sách không tồn tại!');
            window.location='../index.php';
        </script>";
        exit;
    }

    if ($row_check['SoLuong'] <= 0) {
        echo "<script>
            alert('❌ Sách này đã hết. Không thể mượn!');
            window.location='../index.php';
        </script>";
        exit;
    }

    /* =============================
    5. Ghi bản ghi mượn
    ============================= */
    $ngayMuon = date("Y-m-d");
    $hanTra   = date("Y-m-d", strtotime($ngayMuon . " +20 days"));

    $sql_insert = "INSERT INTO ql_muontra 
    (IDuser, IDsach, NgayMuon, HanTra, NgayTra, TrangThai)
    VALUES (?, ?, ?, ?, NULL, 'Đang mượn')";

    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiss", $id_user, $id_sach, $ngayMuon, $hanTra);

    if ($stmt_insert->execute()) {

        $sql_update = "UPDATE ql_sach SET SoLuong = SoLuong - 1 WHERE ID = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $id_sach);
        $stmt_update->execute();

        echo "<script>
            alert('✅ Mượn sách thành công!');
            window.location='../index.php';
        </script>";

    } else {
        echo "<script>
            alert('❌ Lỗi khi mượn sách: " . addslashes($stmt_insert->error) . "');
            history.back();
        </script>";
    }


    if ($stmt_insert->execute()) {

        /* =============================
        6. Giảm số lượng sách
        ============================= */
        $sql_update = "UPDATE ql_sach SET SoLuong = SoLuong - 1 WHERE ID = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $id_sach);
        $stmt_update->execute();

        echo "<script>
            alert('✅ Mượn sách thành công!');
            window.location='../index.php';
        </script>";

    } else {
        echo "<script>
            alert('❌ Lỗi khi mượn sách: " . addslashes($stmt_insert->error) . "');
            history.back();
        </script>";
    }

    

?>
