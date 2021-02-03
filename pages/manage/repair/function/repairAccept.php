<?php
session_start();
if($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'employee'){
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
  if(isset($_POST['repair_accept'])){
      $room_id = $_POST['room_select'];
      $app = $_POST['repair_appliance'];
      $cate = $_POST['repair_category'];
      $detail = $_POST['repair_detail'];
      $date = BasicDate($_POST['repair_date']);
      // $status = $_POST['repair_status'];
      // echo $room_id .$app .$cate .$detail .$date .$status;
      $sql = "INSERT INTO repair (room_id, repair_appliance, repair_category, repair_detail, repair_date, repair_status) VALUES ('$room_id', '$app', '$cate', '$detail', '$date', 'รอคิวซ่อม')";
      $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('แจ้งซ่อม', 'เพิ่มรายการแจ้งซ่อม (ห้อง $room_id)', '".$_SESSION["name"]."', '".$_SESSION["level"]."')";
      if ($conn->query($sql) === TRUE && $conn->query($addLogs) === TRUE) {
          echo "<script>";
          echo "alert('ลงรายการแจ้งซ่อมเรียบร้อย');";
          echo "location.href = '../index.php';";
          echo "</script>";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
  }
}else{
  Header("Location: ../../../login.php");
}


?>