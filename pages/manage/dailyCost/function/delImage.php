<?php
session_start();
if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
    include("../../../connection.php");
    $id = $_REQUEST["id"];
    $name = $_REQUEST["name"];
    $pic_location = "../../../images/daily/$id/$name";
    $countCheck = mysqli_query($conn,"SELECT COUNT(payment_img) AS total FROM dailycost WHERE payment_img = '$name' GROUP BY payment_img HAVING COUNT(payment_img)");
    $countTotal = mysqli_fetch_assoc($countCheck);
    $search = mysqli_query($conn, "SELECT * FROM dailycost WHERE dailycost_id = $id");
    $result = mysqli_fetch_assoc($search);
    $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('ชำระเงิน(รายวัน)', 'ลบหลักฐานการชำระเงินค่าเช่าห้องพัก (".$result["name_title"].$result["firstname"]." ".$result["lastname"].")', '".$_SESSION["name"]."', '".$_SESSION["level"]."')";
    if($countTotal['total'] > 1){
        $del = "UPDATE dailycost SET payment_img = NULL WHERE dailycost_id = $id";
        if($conn->query($del) === TRUE && $conn->query($addLogs) === TRUE){
            echo "<script>";
            echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
            echo "window.location.assign('../dailyCostDetail.php?dailycost_id=$id');";
            echo "</script>";
        }else{
            echo "Error deleting record: " . $conn->error;
        } 
    }else{
        $del = "UPDATE dailycost SET payment_img = NULL WHERE dailycost_id = $id";
        if($conn->query($del) === TRUE && unlink($pic_location) && $conn->query($addLogs) === TRUE){
            echo "<script>";
            echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
            echo "window.location.assign('../dailyCostDetail.php?dailycost_id=$id');";
            echo "</script>";
        }else{
            echo "Error deleting record: " . $conn->error;
        } 
    }
}else{
    Header("Location: ../../../login.php");
}

?>