<?php
session_start();
if($_SESSION['level'] == 'admin'){
  include('../../../connection.php');
  $room = $_REQUEST['room_id'];
  $date = $_REQUEST['date'];
  // echo $room;
  // echo $date;
  // $search = "SELECT * FROM cost WHERE room_id = '$room_id' AND date = '$date'" or die(mysql_error());
  $sql = "SELECT * FROM cost WHERE room_id = '$room' AND date = '$date' AND cost_status = 'ชำระเงินแล้ว' " or die(mysql_error());
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      echo "<script>";
      echo "alert('ไม่สามารถยืนยันได้เนื่องจากได้ยืนยันการชำระเรียบร้อยแล้วแล้ว');";
      echo "location.href = '../index.php?ID=$room&Date=$date';";
      echo "</script>";
  } else {
      $sql2 = "UPDATE cost SET cost_status = 'ชำระเงินแล้ว' WHERE room_id= '$room' AND date ='$date'";
      if ($conn->query($sql2) === TRUE) {
          // echo "Record updated successfully";
          echo "<script>";
          echo "alert('ยืนยันการชำระเงินเรียบร้อยแล้ว');";
          echo "location.href = '../index.php';";
          echo "</script>";
        } else {
          echo "Error updating record: " . $conn->error;
        }
  }
}else{
  Header("Location: ../../../login.php");
}
?>