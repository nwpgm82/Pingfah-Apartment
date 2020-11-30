<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include("../../../connection.php");
    $id = $_REQUEST['id'];
    $sql = "DELETE FROM dailycost WHERE dailycost_id = $id";
    if ($conn->query($sql) === TRUE) {
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