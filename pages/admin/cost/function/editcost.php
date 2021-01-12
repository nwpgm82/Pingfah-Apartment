<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
    $cost_id = $_REQUEST["cost_id"];
    $room_price = $_POST["room_price"];
    $cable_price = $_POST["cable_price"];
    $water_price = $_POST["water_price"];
    $elec_price = $_POST["elec_price"];
    $total_price = $_POST["total_price"];
    $sql = "UPDATE cost SET room_cost = $room_price, water_bill = $water_price, elec_bill = $elec_price, cable_charge = $cable_price, total = $total_price WHERE cost_id = $cost_id";
    if($conn->query($sql) === TRUE){
        echo "<script>";
        echo "alert('แก้ไขข้อมูลการชำระเงินเรียบร้อยแล้ว');";
        echo "window.history.back()";
        echo "</script>";
    }
}else{
    Header("Location: ../../../login.php");
}
?>