<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include("../../../connection.php");
    $code = $_REQUEST['code'];
    $sql = "DELETE FROM daily WHERE code = '$code'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>";
        echo "alert('ลบรายการเช่าห้องพักเรียบร้อยแล้ว');";
        echo "location.assign('../index.php');";
        echo "</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}else{
    Header("Location: ../../../login.php");
}
?>