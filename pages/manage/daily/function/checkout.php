<?php
session_start();
if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
    include("../../../connection.php");
    $id = $_REQUEST["daily_id"];
    $sql = mysqli_query($conn, "SELECT * FROM daily WHERE daily_id = $id");
    $result = mysqli_fetch_assoc($sql);
    $room_arr = explode(", ",$result["room_select"]);
    $damages = $_POST["damages"];
    $total_price = ($result["total_price"] - $result["payment_price"]) + $damages;
    $sql2 = "UPDATE daily SET daily_status = 'เช็คเอาท์แล้ว' WHERE daily_id = $id";
    $sql3 = "UPDATE daily_cost SET damages = $damages WHERE dailycost_id = $id";
    $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('ข้อมูลลูกค้า', 'เปลี่ยนสถานะเป็น เช็คเอาท์แล้ว (".$result["name_title"].$result["firstname"]." ".$result["lastname"].")', '".$_SESSION["name"]."', '".$_SESSION["level"]."')";
    for($i = 0 ; $i < sizeof($room_arr) ; $i++){
        $update_roomlist = "UPDATE roomlist SET room_status = 'ว่าง' WHERE room_id = '$room_arr[$i]'";
        $update_roommember = "UPDATE roommember SET member_status = 'แจ้งออกแล้ว' WHERE room_id = '$room_arr[$i]' AND member_status = 'กำลังเข้าพัก'";
        $conn->query($update_roomlist);
        $conn->query($update_roommember);
        
    }
    if($conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE && $conn->query($addLogs) === TRUE){
        echo "<script>";
        echo "alert('เช็คเอ้าท์เรียบร้อยแล้ว');";
        echo "location.href = '../index.php';";
        echo "</script>";
    }
    // echo $sql3;
    $conn->close();
}else{
    header("Location : ../../../login.php");
}
?>