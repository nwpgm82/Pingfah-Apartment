<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
    $id = $_REQUEST["id"];
    $sql = "SELECT * FROM gallery WHERE gallery_id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $picData = $row["gallery_name"];
    }
    $del = "DELETE FROM gallery WHERE gallery_id = $id";
    $pic_location = "../../../images/gallery/$picData";
    if($conn->query($del) === TRUE && unlink($pic_location)){
        echo "<script>";
        echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
        echo "window.location.assign('../index.php');";
        echo "</script>";
    } 
}else{
    Header("Location: ../../../login.php");
}

?>