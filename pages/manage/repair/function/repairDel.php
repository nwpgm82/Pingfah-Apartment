<?php
session_start();
if($_SESSION['level'] == 'admin'){
  include('../../../connection.php');
  $repair_id = $_REQUEST["repair_id"];

  $sql = "DELETE FROM repair WHERE repair_id = $repair_id ";

  if ($conn->query($sql) === TRUE) {
      echo "<script>";
      echo "alert('ลบรายการแจ้งซ่อมสำเร็จ');";
      echo "window.location.assign('../index.php');";
      echo "</script>";
    } else {
      echo "Error updating record: " . $conn->error;
    }
  
    $conn->close();
}else{
  Header("Location: ../../../login.php");
}

?>