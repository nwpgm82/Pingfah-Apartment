<?php
session_start();
if($_SESSION["level"] == "guest"){
    include("../../../connection.php");
    $room_id = $_SESSION["name"];
    $member_id = $_SESSION["member_id"];
    $topic = $_POST["topic"];
    $detail = $_POST["detail"];
    $appeal_date = date("Y-m-d");
    $sql = "INSERT INTO appeal (member_id, room_id, appeal_topic, appeal_detail, appeal_date) VALUES ($member_id, '$room_id', '$topic', '$detail', '$appeal_date')";
    if($conn->query($sql) === TRUE){
        echo "<script>alert('ส่งคำร้องเรียนเรียบร้อยแล้ว');location.href = '../../index.php';</script>";
    }
}
?>