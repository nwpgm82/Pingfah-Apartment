<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include("../../../connection.php");
    $daily_id = $_REQUEST['daily_id'];
    $room = json_decode($_REQUEST['room_select']);
    $room_str = implode(', ', $room);
    $search = "SELECT * FROM daily WHERE daily_id = $daily_id";
    $result = mysqli_query($conn, $search)or die ("Error in query: $search " . mysqli_error());
    $row = mysqli_fetch_array($result);
    if($row != null){
        extract($row);
    }
    $search2 = "SELECT * FROM roomdetail";
    $result2 = $conn->query($search2);
    if ($result2->num_rows > 0) {
        // output data of each row
        while($row2 = $result2->fetch_assoc()) {
            if($row2["type"] == "แอร์"){
                $airtotal_price = $row2["daily_price"] * $air_room;
            }else if($row2["type"] == "พัดลม"){
                $fantotal_price = $row2["daily_price"] * $fan_room;
            }
        }
    }
    $total_price = $airtotal_price + $fantotal_price;
    $sql2 = "INSERT INTO dailycost (room_id, firstname, lastname, id_card, email, tel, check_in, check_out, price_total, daily_status,code) VALUES ('$room_str', '$firstname', '$lastname', '$id_card', '$email', '$tel', '$check_in','$check_out',$total_price,'ชำระเงินแล้ว','$code')";
    $update2 = "UPDATE daily SET daily_status = 'เข้าพักแล้ว', room_select = '$room_str' WHERE daily_id = $daily_id";
    for($i = 0 ; $i < sizeof($room) ; $i++){
        $sql = "INSERT INTO roommember (room_member, firstname, lastname, id_card, phone, email) VALUES ('$room[$i]','$firstname','$lastname','$id_card','$tel','$email')";
        $update = "UPDATE roomlist SET room_status = 'เช่ารายวัน', check_in = '$check_in', check_out = '$check_out' WHERE room_id = '$room[$i]'";
        if($conn->query($sql) === TRUE && $conn->query($update) === TRUE){
            
        }else{
            echo $conn->error;
            echo "</br>";
            exit();
        }
    }
    if($conn->query($sql2) === TRUE && $conn->query($update2)){
        echo "<script>";
        echo "alert('เลือกห้องเรียบร้อยแล้ว');";
        echo "location.href = '../index.php';";
        echo "</script>";
    }else{
        echo $conn->error;
        echo "</br>";
        exit();
    }
}else{
    Header("Location: ../../../login.php");
}

?>