<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include("../../../connection.php");
    $cost_id = $_REQUEST['cost_id'];
    $del = "DELETE FROM cost WHERE cost_id = $cost_id";
    if ($conn->query($del) === TRUE) {
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