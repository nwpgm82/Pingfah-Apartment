<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../../connection.php');
    $room = $_POST['room_id'];
    $type = $_POST['room_type'];
    $cat = $_POST['room_cat'];
    $sql = "INSERT INTO roomlist (room_id, room_type, room_cat, room_status) VALUES ('$room', '$type', '$cat', 'ว่าง')";
    $main_target = "../../../images/roommember/";
    $create = "../../../images/roommember/$room";
    if(!is_dir($main_target)){
        mkdir($main_target);
    }
    mkdir($create);
    if ($conn->query($sql) === TRUE) {
        echo "<script>";
        echo "alert('เพิ่มห้อง $room เรียบร้อยแล้ว');";
        echo "location.href = '../index.php';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('ไม่สามารถเพิ่มห้องได้เนื่องจากมีห้องพักนี้อยู่แล้ว');";
        echo "window.history.back();";
        echo "</script>";
        // echo "Error updating record: " . $conn->error;
    }
}else{
    Header("Location: ../../../login.php");
}

?>