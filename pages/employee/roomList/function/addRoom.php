<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../../connection.php');
    $room = $_POST['room'];
    $type = $_POST['type'];
    // echo $room;
    // echo $type;
    $sql = "INSERT INTO roomlist (room_id, room_type, room_status) VALUES ('$room', '$type', 'ว่าง')";
    $create = "../../../images/roommember/$room";
    if ($conn->query($sql) === TRUE && mkdir($create) === TRUE) {
        $create2 = mkdir("../../../images/roommember/$room/1");
        $create3 = mkdir("../../../images/roommember/$room/2");
        if($create2 === TRUE && $create3 === TRUE){
            echo "<script type='text/javascript'>alert('เพิ่มห้อง $room ประเภท $type เรียบร้อย')</script>";
            echo "<script type='text/javascript'>location.assign('../index.php')</script>";
        }
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