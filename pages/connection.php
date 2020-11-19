<?php
$conn= mysqli_connect("localhost","root","","Pingfah") or die("Error: " . mysqli_error($con));
mysqli_query($conn, "SET NAMES 'utf8' ");
  date_default_timezone_set('Asia/Bangkok');
  if(date("d") == "6"){
    $updatefines = "UPDATE cost SET fines = 150 WHERE cost_status != 'ชำระเงินแล้ว' ";
    $conn->query($updatefines) === TRUE;
  }

?>