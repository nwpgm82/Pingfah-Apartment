<?php
session_start();
if($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'employee'){
    include("../../../connection.php");
    $cost_id = $_REQUEST['cost_id'];
    $del = "DELETE FROM cost WHERE cost_id = $cost_id";
    $search = mysqli_query($conn, "SELECT room_id, date FROM cost WHERE cost_id = $cost_id");
    $result = mysqli_fetch_assoc($search);
    $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('ชำระเงิน(รายเดือน)', 'ลบรายการชำระเงินค่าเช่าห้องพัก (ห้อง ".$result["room_id"].")(".$result["date"].")', '".$_SESSION["name"]."', '".$_SESSION["level"]."')";
    if ($conn->query($del) === TRUE && $conn->query($addLogs) === TRUE) {
        echo "<script>";
        echo "alert('ลบรายการชำระเงินเรียบร้อยแล้ว');";
        echo "location.href = '../index.php';";
        echo "</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
      }
      
      $conn->close();
}else{
    Header("Location: ../../../login.php"); 
}
?>