<?php
include("../../../connection.php");
function BasicDate($tdate){
    $search = ["มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    $replace = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    $edate = str_replace($search, $replace, $tdate);
    $str_date = strtotime($edate);
    $year =  date("Y",$str_date);
    $month = date("m",$str_date);
    $day = date("d",$str_date);
    return "$year-$month-$day"; 
}
$room_id = $_REQUEST["ID"];
$come = BasicDate($_POST["come"]);
$title_name = $_POST["title_name"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$nickname = $_POST["nickname"];
$id_card = $_POST["id_card"];
$birthday = BasicDate($_POST["birthday"]);
$age = date_diff(date_create(BasicDate($_POST["come"])),date_create(date("Y-m-d")))->format("%y");
$tel = $_POST["tel"];
$email = $_POST["email"];
$race = $_POST["race"];
$nation = $_POST["nation"];
$job = $_POST["job"];
$address = $_POST["address"];
$id_img = $_FILES["id_img"]["name"];
$home_img = $_FILES["home_img"]["name"];

$roommember_folder_path = "../../../images/roommember/";
$come_folder = "../../../images/roommember/$room_id/$come";
$room_folder = "../../../images/roommember/$room_id/";
$id_target = "../../../images/roommember/$room_id/".basename($id_img);
$home_target = "../../../images/roommember/$room_id/".basename($home_img);
if(!is_dir($roommember_folder_path)){
    mkdir($roommember_folder_path);
}
if(!is_dir($room_folder)){
    mkdir($room_folder);
}
if(!is_dir($come_folder)){
    mkdir($come_folder);
}

if(is_dir($roommember_folder_path) && is_dir($room_folder) && is_dir($come_folder)){
    if(move_uploaded_file($_FILES["id_img"]["tmp_name"], $id_target) && move_uploaded_file($_FILES["home_img"]["tmp_name"], $home_target)){
        $addData = "INSERT INTO roommember (room_id, come_date, member_status, name_title, firstname, lastname, nickname, id_card, phone, email, birthday, age, race, nationality, job, address, pic_idcard, pic_home) VALUES ('$room_id','$come','กำลังเข้าพัก','$title_name','$firstname', '$lastname', '$nickname', '$id_card', '$birthday', $age, '$tel' ,'$email', '$race', '$nation', '$job', '$address', '$id_img', '$home_img')";
        if($conn->query($addData) === TRUE){
            echo "<script>";
            echo "alert('เพิ่มข้อมูลผู้พักห้อง $room_id เรียบร้อยแล้ว');";
            echo "location.href = '../index.php';";
            echo "</script>";
        }else{
            echo "Error: " . $addData . "<br>" . $conn->error;
        }
    }else{
        echo $conn->error;
    }
}else{
    echo $conn->error;
}

?>