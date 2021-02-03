<?php
session_start();
if($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'employee'){
    include("../../../connection.php");
    $id = $_REQUEST['id'];
    $search = mysqli_query($conn, "SELECT * FROM dailycost WHERE dailycost_id = $id");
    $result = mysqli_fetch_assoc($search);
    $sql = "DELETE FROM dailycost WHERE dailycost_id = $id";
    $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('ชำระเงิน(รายวัน)', 'ลบรายการชำระเงิน (".$result["name_title"].$result["firstname"]." ".$result["lastname"].")', '".$_SESSION["name"]."', '".$_SESSION["level"]."')";
    if ($conn->query($sql) === TRUE && $conn->query($addLogs) === TRUE) {
        echo "<script>";
        echo "alert('ลบรายการชำระเงินเรียบร้อยแล้ว');";
        echo "location.assign('../index.php');";
        echo "</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}else{
    Header("Location: ../../../login.php");
}