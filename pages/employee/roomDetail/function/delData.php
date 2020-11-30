<?php
session_start();
if($_SESSION['level'] == 'admin'){
  include('../../../connection.php');
  $type = $_REQUEST['type'];
  $pic = $_REQUEST['pic'];
  $searchpic = "SELECT $pic FROM roomdetail WHERE type = '$type'";
  $pic_result = $conn->query($searchpic);
  if ($pic_result->num_rows > 0) {
    $row = $pic_result->fetch_assoc();
    $picData = $row["$pic"];
  }
  $sql = "UPDATE roomdetail SET $pic = null WHERE type = '$type'";
  $pic_location = "../../../images/roomdetail/$picData";
  // "UPDATE MyGuests SET lastname='Doe' WHERE id=2"
  if ($conn->query($sql) === TRUE && unlink($pic_location)) {
      echo "<script>";
      echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
      echo "window.location.assign('/Pingfah/pages/admin/roomDetail/detail.php?type=$type'); ";
      echo "</script>";
    } else {
      echo "Error deleting record: " . $conn->error;
    }
    
    $conn->close();
}
?>