<?php
session_start();
if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
    include("../../../connection.php");
    $id = $_REQUEST['dailycost_id'];
    $search = mysqli_query($conn, "SELECT * FROM dailycost WHERE dailycost_id = $id");
    $result = mysqli_fetch_assoc($search);
    $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('ข้อมูลลูกค้า', 'เพิ่มหลักฐานการชำระเงินค่าเช่าห้องพัก (".$result["name_title"].$result["firstname"]." ".$result["lastname"].")', '".$_SESSION["name"]."', '".$_SESSION["level"]."')";
    $folder_path = "../../../images/daily/";
    // var_dump(is_dir($folder_path));
    if(is_dir($folder_path)){
        mkdir("../../../images/daily/$id/");
        if(!empty($_FILES['file']['name'])){
            $file = $_FILES['file']['name'];
            $target = "../../../images/daily/$id/".basename($file);
            $sql = "UPDATE dailycost SET pay_img = '$file' WHERE dailycost_id = $id";
            if(move_uploaded_file($_FILES['file']['tmp_name'], $target)){
                if ($conn->query($sql) === TRUE && $conn->query($addLogs) === TRUE) {    
                } else {
                  echo "Error updating record: " . $conn->error;
                }
            }
        }
    }else{
        mkdir($folder_path);
        mkdir("../../../images/daily/$id/");
        if(!empty($_FILES['file']['name'])){
            $file = $_FILES['file']['name'];
            $target = "../../../images/daily/$id/".basename($file);
            $sql = "UPDATE dailycost SET pay_img = '$file' WHERE dailycost_id = $id";
            if(move_uploaded_file($_FILES['file']['tmp_name'], $target)){
                if ($conn->query($sql) === TRUE && $conn->query($addLogs) === TRUE) {    
                } else {
                  echo "Error updating record: " . $conn->error;
                }
            }
        }
    }
    
}else{
    Header("Location: ../../../login.php");
}
    
?>