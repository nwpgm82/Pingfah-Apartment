<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
    $id = $_REQUEST["id"];
    $name = $_REQUEST["name"];
    $pic_location = "../../../images/daily/$id/$name";
    $countCheck = mysqli_query($conn,"SELECT COUNT(payment_img) AS total FROM daily WHERE payment_img = '$name' GROUP BY payment_img HAVING COUNT(payment_img)");
    $countTotal = mysqli_fetch_assoc($countCheck);
    if($countTotal['total'] > 1){
        $del = "UPDATE daily SET payment_img = NULL WHERE daily_id = $id";
        if($conn->query($del) === TRUE){
            echo "<script>";
            echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
            echo "window.location.assign('../dailyCostDetail.php?dailycost_id=$id');";
            echo "</script>";
        }else{
            echo "Error deleting record: " . $conn->error;
        } 
    }else{
        $del = "UPDATE daily SET payment_img = NULL WHERE daily_id = $id";
        if($conn->query($del) === TRUE && unlink($pic_location)){
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