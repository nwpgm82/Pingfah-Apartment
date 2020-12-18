<?php
session_start();
if($_SESSION['level'] == 'employee'){
  include('../../../connection.php');
  $type = $_REQUEST['type'];
  $gal_id = $_REQUEST['gal_id'];
  $gal_name = $_REQUEST['gal_name'];
  $folder_path = "../../../images/roomdetail/$type/$gal_name";
  if($type == "fan"){
      $countCheck = mysqli_query($conn,"SELECT COUNT(gal_name) AS total FROM fan_gal WHERE gal_name = '$gal_name' GROUP BY gal_name HAVING COUNT(gal_name)");
  }else if($type == "air"){
      $countCheck = mysqli_query($conn,"SELECT COUNT(gal_name) AS total FROM air_gal WHERE gal_name = '$gal_name' GROUP BY gal_name HAVING COUNT(gal_name)");
  }
  $countTotal = mysqli_fetch_assoc($countCheck);
  // echo $countTotal['total'];
  if($countTotal['total'] > 1){
      if($type == "fan"){
          $sql = "DELETE FROM fan_gal WHERE gal_id = $gal_id";
      }else if($type == "air"){
          $sql = "DELETE FROM air_gal WHERE gal_id = $gal_id";
      }
      if($conn->query($sql) === TRUE){
        echo "<script>";      
        echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
        echo "location.assign('../detail.php?type=$type');";
        echo "</script>";
      }else{
          echo "Error deleting record: " . $conn->error;
      }
  }else{
    if($type == "fan"){
      $sql = "DELETE FROM fan_gal WHERE gal_id = $gal_id";
    }else if($type == "air"){
      $sql = "DELETE FROM air_gal WHERE gal_id = $gal_id";
    }
    if($conn->query($sql) === TRUE && unlink($folder_path)){
      echo "<script>";      
      echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
      echo "location.assign('../detail.php?type=$type');";
      echo "</script>";
    }else{
      echo "Error deleting record: " . $conn->error;
    }
  }
  $conn->close();
}else{
    Header("Location : ../../../login.php");
}
?>