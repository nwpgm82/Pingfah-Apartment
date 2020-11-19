<?php
session_start();
if($_SESSION['level'] == 'admin'){
  include('../../../connection.php');
  $num = $_POST['num'];
  $company = $_POST['company'];
  $arrived = $_POST['arrived'];
  $name = $_POST['name'];
  $room = $_POST['room'];
      $sql = "INSERT INTO package (package_num, package_company, package_arrived, package_status, package_name, package_room, package_received) VALUES ('$num', '$company', '$arrived', 'ยังไม่ได้รับพัสดุ', '$name', '$room', '')";
      if ($conn->query($sql) === TRUE) {
        echo "<script>alert('เพิ่มพัสดุเรียบร้อยแล้ว');location.assign('/Pingfah/pages/admin/package/index.php');</script>";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
}else{
  Header("Location: ../../../login.php");
}

?>