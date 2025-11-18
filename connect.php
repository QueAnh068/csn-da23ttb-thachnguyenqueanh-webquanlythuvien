<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql_thuvien";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>

