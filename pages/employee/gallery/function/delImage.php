<?php
session_start();
if($_SESSION["level"] == "employee"){
    include("../../../connection.php");
    $id = $_REQUEST["id"];
    $name = $_REQUEST["name"];
    $pic_location = "../../../images/gallery/$name";
    $countCheck = mysqli_query($conn,"SELECT COUNT(gallery_name) AS total FROM gallery WHERE gallery_name = '$name' GROUP BY gallery_name HAVING COUNT(gallery_name)");
    $countTotal = mysqli_fetch_assoc($countCheck);
    if($countTotal['total'] > 1){
        $del = "DELETE FROM gallery WHERE gallery_id = $id";
        if($conn->query($del) === TRUE){
            echo "<script>";
            echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
            echo "window.location.assign('../index.php');";
            echo "</script>";
        }else{
            echo "Error deleting record: " . $conn->error;
        } 
    }else{
        $del = "DELETE FROM gallery WHERE gallery_id = $id";
        if($conn->query($del) === TRUE && unlink($pic_location)){
            echo "<script>";
            echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
            echo "window.location.assign('../index.php');";
            echo "</script>";
        }else{
            echo "Error deleting record: " . $conn->error;
        } 
    }
}else{
    Header("Location: ../../../login.php");
}

?>