<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include("../../../connection.php");
    $room_id = $_REQUEST['room_id'];
    $date = $_REQUEST['date'];
    $del = "DELETE FROM cost WHERE '$room_id' AND date = '$date'";
    if ($conn->query($del) === TRUE) {
        echo "<script>";
        echo "alert('ลบรายการชำระเงินสำเร็จ');";
        echo "window.location.assign('../index.php');";
        echo "</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
      }
      
      $conn->close();
}else{
    Header("Location: ../../../login.php"); 
}
?>