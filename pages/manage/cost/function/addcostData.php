<?php
session_start();
if($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'employee'){
  include('../../../connection.php');
  $room_id = $_POST['room_select'];
  $room_type = $_POST['room_type'];
  $room_price = $_POST['room_price'];
  $cable_price = $_POST['cable_price'];
  $water_price = $_POST['water_price'];
  $elec_price = $_POST['elec_price'];
  $total_price = $_POST['total_price'];
  $date = date("Y-m");
  $search = "SELECT * FROM cost WHERE room_id = '$room_id' AND date = '$date'" or die(mysql_error());
  $result = $conn->query($search);
  $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('ชำระเงิน(รายเดือน)', 'เพิ่มรายการชำระเงินค่าเช่าห้องพัก (ห้อง $room_id)($date)', '".$_SESSION["name"]."', '".$_SESSION["level"]."')";
  if ($result->num_rows > 0) {
      echo "<script>";
      echo "alert('ไม่สามารถบันทึกได้เนื่องจากมีข้อมูลอยู่แล้ว');";
      echo "location.href = '../../cost/addcost.php';";
      echo "</script>";
  } else {
    $sql = "INSERT INTO cost (room_id, room_type, member_cost, cost_status, date, room_cost, water_bill, elec_bill, cable_charge, total) VALUES ('$room_id', '$room_type', 'กำลังเข้าพัก', 'รอการชำระเงิน', '$date', '$room_price', '$water_price', '$elec_price', '$cable_price', '$total_price')";
    if ($conn->query($sql) === TRUE && $conn->query($addLogs) === TRUE) {
      echo "<script>";
      echo "alert('บันทึกค่าใช้จ่ายของห้อง $room_id เรียบร้อยแล้ว');";
      echo "location.href = '../index.php';";
      echo "</script>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  $conn->close();
}else{  
  Header("Location: ../../../login.php");
}
?>