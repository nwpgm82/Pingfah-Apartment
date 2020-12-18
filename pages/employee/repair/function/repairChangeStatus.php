<?php
session_start();
if($_SESSION['level'] == 'employee'){
  include('../../../connection.php');
  $repair_id = $_REQUEST['repair_id'];
  $status = $_POST["status"];
  @$income = $_POST["income"];
  @$expenses = $_POST["expenses"];
  @$success_date = $_POST["success_date"];
  if($status == "ซ่อมเสร็จแล้ว"){
    $sql = "UPDATE repair SET repair_status = '$status', repair_successdate = '$success_date', repair_income = $income, repair_expenses = $expenses WHERE repair_id = $repair_id";
  }else{
    $sql = "UPDATE repair SET repair_status = '$status' WHERE repair_id = $repair_id";
  }

  if ($conn->query($sql) === TRUE) {
      echo "<script>";
      echo "alert('แก้ไขสถานะสำเร็จ');";
      echo "location.href = '../index.php';";
      echo "</script>";
    } else {
      echo "Error updating record: " . $conn->error;
    }
  
    $conn->close();
}else{
  Header("Location: ../../../login.php");
}

?>