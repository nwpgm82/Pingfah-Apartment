<?php
session_start();
if($_SESSION['level'] == 'admin'){
  include('../../../connection.php');
  $package_id = $_REQUEST["package_id"];
  $sql = "DELETE FROM package WHERE package_id = '$package_id'";
  if ($conn->query($sql) === TRUE) {
    echo "<script>";
    echo "alert('เพิ่มพัสดุเรียบร้อยแล้ว');";
    echo "location.href = '../index.php';";
    echo "</script>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}else{
  Header("Location: ../../../login.php");
}

?>