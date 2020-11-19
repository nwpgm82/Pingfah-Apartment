<?php
include("../connection.php");
if(isset($_POST['accept_daily'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $id_card = $_POST['id_card'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $room_type = $_REQUEST['room_type'];
    $check_in = $_REQUEST['check_in'];
    $check_out = $_REQUEST['check_out'];
    $code = createRandomPassword();
    // echo $firstname ."/" .$lastname ."/" .$id_card ."/" .$email ."/" .$tel ."/" .$room_type ."/ " .$check_in ."/" .$check_out;
    $searchroom = mysqli_query($conn,"SELECT COUNT(*) AS total FROM roomlist WHERE room_type = '$room_type' AND room_status = 'ว่าง'");
    $data= mysqli_fetch_assoc($searchroom);  
    $total_int = intval($data['total']);
    if($total_int != 0){
        $searchfreeroom = "SELECT * FROM roomlist WHERE room_status = 'ว่าง' LIMIT 1";
        $result = $conn->query($searchfreeroom);
        $row = $result->fetch_assoc();
        $room_select = $row['room_id'];
        $sql = "INSERT INTO daily (firstname, lastname, id_card, email, tel, room_type, code, check_in, check_out) VALUES ('$firstname', '$lastname', '$id_card', '$email', '$tel', '$room_type', '$code', '$check_in', '$check_out')";
        $sql2 = "INSERT INTO roommember (room_member, firstname, lastname, id_card, phone, email) VALUE ('$room_select', '$firstname','$lastname','$id_card','$tel','$email') LIMIT 1";
        $update = "UPDATE roomlist SET room_status = 'เช่ารายวัน', check_in = '$check_in', check_out = '$check_out' WHERE room_id = '$room_select'";
        if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql2) && $conn->query($update) === TRUE) {
            echo "<script>";
            echo "alert('จองห้องเรียบร้อยแล้ว กรุณาดูคำสั่งในการจองได้ในอีเมล์');";
            echo "location.href = '../index.php'";
            echo "</script>";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
    }else{
        echo "<script>";
        echo "alert('ไม่สามารถจองห้องได้เนื่องจากห้องเต็มแล้ว');";
        echo "window.history.back();";
        echo "</script>";
    }
}

function createRandomPassword() { 
    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 
    while ($i <= 10) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 
    return $pass; 
} 
?>