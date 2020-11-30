<?php
session_start();
if($_SESSION['level'] == 'employee'){
  include('../../../connection.php');
  $room = $_REQUEST['room_id'];
  $pic = $_REQUEST['pic'];
  $num = $_REQUEST['num'];
  $search = "SELECT * FROM roommember WHERE room_member = '$room'";
  $result = $conn->query($search);
  $row = $result->fetch_assoc();
  $pic_location = $row["$pic"];
  $delete_location = "../../../images/roommember/$room/$num/$pic_location";
  $sql = "UPDATE roommember SET $pic = NULL WHERE room_member = '$room' ";
  if ($conn->query($sql) === TRUE) {
    unlink($delete_location);
    echo "<script>";
    echo "alert('ลบรูปภาพสำเร็จ');";
    echo "window.location.assign('../room_id.php?ID=$room'); ";
    echo "</script>";
  } else {
    echo "Error updating record: " . $conn->error;
  }
}else{
  Header("Location: ../../../login.php");
}
?>