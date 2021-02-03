<?php
session_start();
if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
    include("../../../connection.php");
    $id = $_REQUEST["daily_id"];
    $sql = mysqli_query($conn, "SELECT * FROM daily WHERE daily_id = $id");
    $result = mysqli_fetch_assoc($sql);
    $room_arr = explode(", ",$result["room_select"]);
    $sql = "UPDATE daily SET daily_status = 'เช็คเอาท์แล้ว' WHERE daily_id = $id";
    $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('ข้อมูลลูกค้า', 'เปลี่ยนสถานะเป็น เช็คเอาท์แล้ว (".$result["name_title"].$result["firstname"]." ".$result["lastname"].")', '".$_SESSION["name"]."', '".$_SESSION["level"]."')";
    for($i = 0 ; $i < sizeof($room_arr) ; $i++){
        $sql2 = "UPDATE roomlist SET room_status = 'ว่าง' WHERE room_id = '$room_arr[$i]'";
        $sql3 = "UPDATE roommember SET member_status = 'แจ้งออกแล้ว' WHERE room_id = '$room_arr[$i]' AND member_status = 'กำลังเข้าพัก'";
        $conn->query($sql2);
        $conn->query($sql3);
        
    }
    if($conn->query($sql) === TRUE && $conn->query($addLogs) === TRUE){
        echo "<script>";
        echo "alert('เช็คเอ้าท์เรียบร้อยแล้ว');";
        echo "location.href = '../index.php';";
        echo "</script>";
    }
    $conn->close();
}else{
    header("Location : ../../../login.php");
}
?>