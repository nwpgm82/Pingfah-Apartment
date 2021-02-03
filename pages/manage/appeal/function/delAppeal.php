<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
    $id = $_REQUEST["appeal_id"];
    $sql = "DELETE FROM appeal WHERE appeal_id = $id";
    if($conn->query($sql) === TRUE){
        echo "<script>";
        echo "alert('ลบรายการร้องเรียนเรียบร้อยแล้ว');";
        echo "window.location.assign('../index.php');";
        echo "</script>";
    }
}else{
    Header("Location: ../../../login.php");
}
?>