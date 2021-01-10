<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../../connection.php');
    $package_id = $_REQUEST["package_id"];
    $received = $_POST["received"]; 
    $re_date = date("Y-m-d");
    $sql = "UPDATE package SET package_status ='รับพัสดุแล้ว', package_received = '$received', package_receiveddate = '$re_date' WHERE package_id = '$package_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>";
        echo "alert('รับพัสดุเรียบร้อย');";
        echo "location.href = '../index.php';";
        echo "</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}else{
    Header("Location: ../../../login.php");
}

?>