<?php
session_start();
if($_SESSION['level'] == 'employee'){
  include('../../../connection.php');
  $room_id = $_POST['room_select'];
  $room_price = $_POST['room_price'];
  $cable_price = $_POST['cable_price'];
  $water_price = $_POST['water_price'];
  $elec_price = $_POST['elec_price'];
  $total_price = $_POST['total_price'];
  $date = date("Y-m");
  // $roomresult = $conn->query($searchRoom);
  // $roomrow = $roomresult->fetch_assoc();
  // $room_type = $roomrow['room_type'];
  // $searchDetail = "SELECT * FROM roomdetail WHERE type = '$room_type'";
  // $resultDetail = mysqli_query($conn, $searchDetail)or die ("Error in query: $searchDetail " . mysqli_error());
  // $roomDetail = mysqli_fetch_array($resultDetail);
  // extract($roomDetail);
  // $water_total = $water_bill * $water_count;
  // $elec_total = $elec_count * $elec_bill;
  // $total = $water_total + $elec_total + $cable_charge + $price;

  $search = "SELECT * FROM cost WHERE room_id = '$room_id' AND date = '$date'" or die(mysql_error());
  $result = $conn->query($search);
  if ($result->num_rows > 0) {
      echo "<script>";
      echo "alert('ไม่สามารถบันทึกได้เนื่องจากมีข้อมูลอยู่แล้ว');";
      echo "location.href = '../../cost/addcost.php';";
      echo "</script>";
  } else {
    $sql = "INSERT INTO cost (room_id, cost_status, date, room_cost, water_bill, elec_bill, cable_charge, fines, total) VALUES ('$room_id', 'ยังไม่ได้ชำระ', '$date', '$room_price', '$water_price', '$elec_price', '$cable_price', 0, '$total_price')";
    if ($conn->query($sql) === TRUE) {
      echo "<script>";
      echo "alert('บันทึกค่าใช้จ่ายของห้อง $room_id เสร็จสิ้น');";
      echo "location.href = '../../cost/addcost.php';";
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