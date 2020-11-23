<?php
session_start();
if($_SESSION['level'] == 'admin'){
  include('../../../connection.php');
  $id = $_REQUEST["ID"];
  $sql1 = "DELETE FROM `roommember` WHERE room_member = '$id'";
  $dellogin = "DELETE FROM login WHERE username = '$id'";
  $roomlist = "UPDATE roomlist SET room_status = 'ว่าง', come = NULL, check_in = null, check_out = null WHERE room_id = '$id' ";
    if($conn->query($sql1) === TRUE && $conn->query($dellogin) === TRUE && $conn->query($roomlist) === TRUE){
        for($i = 1;$i<=2;$i++){
          ${'file-' .$i} = glob("../../../images/roommember/$id/$i/*");
          ${'file-' .$i} = glob("../../../images/roommember/$id/$i/*");
          foreach(${'file-' .$i} as $data){
              if(is_file($data)){
                  unlink($data);
              }
          }
        }   
        echo "<script>";
        echo "alert('ลบข้อมูลห้อง $id เรียบร้อยแล้ว');";
        echo "window.location.assign('../index.php');";
        echo "</script>";
    } else {
        echo "Error: " .$sql1 . "<br>" . $conn->error;
        echo "Error: " .$roomlist . "<br>" . $conn->error;
    }
}else{
  Header("Location: ../../../login.php");
}

?>