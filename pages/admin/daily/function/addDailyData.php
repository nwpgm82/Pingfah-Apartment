<?php
session_start();
if($_SESSION['level'] == "admin"){
    include('../../../connection.php');
    $code = $_REQUEST['code'];
    $room_select = $_REQUEST['room_select'];
    $count =  mysqli_query($conn,"SELECT COUNT(*) as total FROM daily WHERE code = '$code'");
    $countdata= mysqli_fetch_assoc($count);
    $total_int = intval($countdata['total']);
    // echo $total_int;
    $searchData = "SELECT * FROM daily WHERE code = '$code'";
    $result = mysqli_query($conn, $searchData)or die ("Error in query: $searchData " . mysqli_error());
    $row = mysqli_fetch_array($result);
    if($row != null){
        extract($row);
    }
    $date_start = date_create($check_in);
    $date_end = date_create($check_out);
    $diff = date_diff($date_start,$date_end);
    $day =  $diff->days;
    // echo $day;
    $room_detail = "SELECT daily_price FROM roomdetail WHERE type = '$room_type'";
    $detail_result = $conn->query($room_detail);
    $row2 = $detail_result->fetch_assoc();
    $total_price = ($row2['daily_price'] * $day) / $total_int;
    $costData = "INSERT INTO dailycost (room_id, check_in, check_out, price_total, daily_status, code) VALUES ('$room_select', '$check_in', '$check_out', $total_price, 'ชำระเงินแล้ว', '$code')";
    $roomData = "INSERT INTO roommember (room_member, firstname, lastname, id_card, phone, email) VALUES ('$room_select', '$firstname', '$lastname', '$id_card', '$tel', '$email')";
    $daily = "UPDATE daily SET daily_status = 'เข้าพักแล้ว' WHERE code = '$code' AND daily_status IS NULL LIMIT 1";
    $roomlist = "UPDATE roomlist SET room_status = 'เช่ารายวัน', check_in = '$check_in', check_out = '$check_out' WHERE room_id = '$room_select'";
    if ($conn->query($costData) === TRUE && $conn->query($roomData) === TRUE && $conn->query($daily) === TRUE && $conn->query($roomlist) === TRUE) {
        echo "<script>";
        echo "alert('เลือกห้องพักเรียบร้อยแล้ว');";
        echo "location.href = '../index.php';";
        echo "</script>";
      } else {
        echo "Error: " . $roomData . "<br>" . $conn->error;
        echo "Error: " . $roomlist . "<br>" . $conn->error;
      }
}else{
  Header("Location: ../../../login.php");
}
?>