<?php
session_start();
if($_SESSION['level'] == 'admin'){
  include('../../../connection.php');
  function BasicDate($tdate){
    $search = ["มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    $replace = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    $edate = str_replace($search, $replace, $tdate);
    $str_date = strtotime($edate);
    $year =  date("Y",$str_date);
    $month = date("m",$str_date);
    $day = date("d",$str_date);
    return "$year-$month-$day"; 
  }
  $repair_id = $_REQUEST['repair_id'];
  $status = $_POST["status"];
  @$income = $_POST["income"];
  @$expenses = $_POST["expenses"];
  @$profit = $_POST["profit"];
  @$success_date = BasicDate($_POST["success_date"]);
  if($status == "ซ่อมเสร็จแล้ว"){
    $sql = "UPDATE repair SET repair_status = '$status', repair_successdate = '$success_date', repair_income = $income, repair_expenses = $expenses, repair_profit = $profit WHERE repair_id = $repair_id";
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