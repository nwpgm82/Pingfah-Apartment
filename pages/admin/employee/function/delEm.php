<?php
session_start();
if($_SESSION['level'] == 'admin'){
  include('../../../connection.php');
  $employee_id = $_REQUEST['employee_id'];
  $get_idcard_email = mysqli_query($conn,"SELECT id_card, email FROM employee WHERE employee_id = $id");
  $result_get = mysqli_fetch_assoc($get_idcard_email);
  $sql = "DELETE FROM employee WHERE employee_id = $employee_id";
  $login = "DELETE FROM login WHERE username = '".$result_get["email"]."'";
  $file = glob("../../../images/employee/".$result_get["id_card"]."/*");
  foreach($file as $data){
    if(is_file($data)){
        unlink($data);
    }
  }
  if ($conn->query($sql) === TRUE && $conn->query($login) === TRUE && rmdir("../../../images/employee/".$result_get["id_card"]."/")) {
      echo "<script>";
      echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
      echo "location.href('../index.php');";
      echo "</script>";
  } else {
      echo "Error deleting record: " . $conn->error;
  }
}else{
  Header("Location: ../../../login.php");
}
?>