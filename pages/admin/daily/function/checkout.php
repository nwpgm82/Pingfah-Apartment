<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
    $id = $_REQUEST["daily_id"];
    $sql = "SELECT * FROM daily WHERE daily_id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $room_arr = explode(", ",$row["room_select"]);
        }
    }
    $sql = "UPDATE daily SET daily_status = 'เช็คเอ้าท์แล้ว' WHERE daily_id = $id";
    for($i = 0 ; $i < sizeof($room_arr) ; $i++){
        $sql2 = "UPDATE roomlist SET room_status = 'ว่าง' WHERE room_id = '$room_arr[$i]'";
        $sql3 = "UPDATE roommember SET member_status = 'แจ้งออกแล้ว' WHERE room_id = '$room_arr[$i]' AND member_status = 'กำลังเข้าพัก'";
        $conn->query($sql2);
        $conn->query($sql3);
        
    }
    if($conn->query($sql) === TRUE){
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