<?php
session_start();
if($_SESSION["level"] == "employee"){
    include("../../../connection.php");
    $id = $_REQUEST["daily_id"];
    $sql = "SELECT * FROM daily WHERE daily_id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $room_arr = explode(",",$row["room_select"]);
        }
    }
    $sql = "UPDATE daily SET daily_status = 'เช็คเอ้าท์แล้ว' WHERE daily_id = $id";
    for($i = 0 ; $i < sizeof($room_arr) ; $i++){
        $sql2 = "UPDATE roomlist SET room_status = 'ว่าง', check_in = '', check_out = '' WHERE room_id = '$room_arr[$i]'";
        $sql3 = "DELETE FROM roommember WHERE room_member = '$room_arr[$i]'";
        if($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE){
            
        }else{
            echo "Error updating record: $sql1" . $conn->error;
            echo "Error updating record: $sql2" . $conn->error;
            echo "Error deleting record: $sql3" . $conn->error;
            exit();
        }
    }
    echo "<script>";
    echo "alert('เช็คเอ้าท์เรียบร้อยแล้ว');";
    echo "location.href = '../index.php';";
    echo "</script>";
    $conn->close();
}else{
    header("Location : ../../../login.php");
}
?>