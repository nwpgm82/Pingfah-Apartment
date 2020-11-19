<?php
session_start();
if($_SESSION['level'] == 'admin'){
  include('../../../connection.php');
  $user = $_REQUEST['User'];
  $sql = "DELETE FROM employee WHERE username = '$user'";
  $login = "DELETE FROM login WHERE username = '$user'";
  $file = glob("../../../images/employee/$user/*");
  foreach($file as $data){
    if(is_file($data)){
        unlink($data);
    }
  }
  if ($conn->query($sql) === TRUE && $conn->query($login) === TRUE && rmdir("../../../images/employee/$user") == true) {
      echo "<script>";
      echo "alert('ลบพนักงานเรียบร้อยแล้ว');";
      echo "window.location.assign('../../employee/index.php');";
      echo "</script>";
  } else {
      echo "Error deleting record: " . $conn->error;
  }
}else{
  Header("Location: ../../../login.php");
}
?>