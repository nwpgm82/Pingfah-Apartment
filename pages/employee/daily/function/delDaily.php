<?php
session_start();
if($_SESSION['level'] == 'employee'){
    include("../../../connection.php");
    $id = $_REQUEST['id'];
    $sql = "DELETE FROM daily WHERE daily_id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>";
        echo "alert('ลบรายการเช่าห้องพักเรียบร้อยแล้ว');";
        echo "location.assign('../index.php');";
        echo "</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}else{
    Header("Location: ../../../login.php");
}
?>