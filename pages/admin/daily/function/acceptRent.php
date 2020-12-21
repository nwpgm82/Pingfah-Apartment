<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
    $daily_id = $_REQUEST["daily_id"];
    $sql = "UPDATE daily SET daily_status = 'รอการเข้าพัก' WHERE daily_id = $daily_id";
    if($conn->query($sql)){
        echo "<script>";
        echo "alert('ยืนยันการเข้าพักเรียบร้อยแล้ว');";
        echo "location.href = '../index.php';";
        echo "</script>";
    }
}