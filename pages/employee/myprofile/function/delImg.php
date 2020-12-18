<?php
session_start();
if($_SESSION['level'] == 'employee'){
  include('../../../connection.php');
  $pic = $_REQUEST['pic'];
  $searchpic = "SELECT $pic FROM employee WHERE username = '".$_SESSION['ID']."'";
  $pic_result = $conn->query($searchpic);
  if ($pic_result->num_rows > 0) {
    $row = $pic_result->fetch_assoc();
    $picData = $row["$pic"];
  }
  $sql = "UPDATE employee SET $pic = NULL WHERE username = '".$_SESSION['ID']."'";
  $pic_location = "../../../images/employee/".$_SESSION['ID']."/$picData";
  if ($conn->query($sql) === TRUE && unlink($pic_location) === TRUE) {
    echo "<script>";
    echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
    echo "window.location.assign('../index.php');";
    echo "</script>";
  } else {
    echo "Error updating record: " . $conn->error;
  }
}else{
  Header("Location: ../../../login.php");
}

?>