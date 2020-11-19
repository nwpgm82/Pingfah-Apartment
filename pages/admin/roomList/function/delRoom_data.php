<?php
session_start();
if($_SESSION['level'] == 'admin'){
  include('../../../connection.php');
  $id = $_REQUEST["ID"];
  $file_pointer = "../../"; 
  $sql1 = "DELETE FROM `roommember` WHERE room_member = '$id'";
  $roomlist = "UPDATE roomlist SET room_status = 'ว่าง', come = NULL, check_in = null, check_out = null WHERE room_id = '$id' ";
    if($conn->query($sql1) === TRUE){
        if ($conn->query($roomlist) === TRUE) {
            echo "New record updated successfully";
          } else {
            echo "Error: " .$roomlist . "<br>" . $conn->error;
        }
        echo "<script>";
        echo "alert('ลบข้อมูลห้อง $id เรียบร้อยแล้ว');";
        echo "window.location.assign('../index.php');";
        echo "</script>";
    }
}else{
  Header("Location: ../../../login.php");
}

?>