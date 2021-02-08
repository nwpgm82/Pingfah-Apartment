<?php
session_start();
if ($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee") {
    include "../../../connection.php";
    $id = $_REQUEST['dailycost_id'];
    $search = mysqli_query($conn, "SELECT a.*, b.* FROM dailycost a INNER JOIN daily b ON a.dailycost_id = b.daily_id WHERE a.dailycost_id = $id");
    $result = mysqli_fetch_assoc($search);
    $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('ชำระเงิน(รายวัน)', 'เพิ่มหลักฐานการชำระเงินค่าเช่าห้องพัก (" . $result["name_title"] . $result["firstname"] . " " . $result["lastname"] . ")', '" . $_SESSION["name"] . "', '" . $_SESSION["level"] . "')";
    $folder_path = "../../../images/daily/";
    $folder_path2 = "../../../images/daily/" . $result["code"] . "/";
    $folder_path3 = "../../../images/daily/" . $result["code"] . "/payment/";
    if (!is_dir($folder_path)) {
        mkdir($folder_path);
    }
    if (!is_dir($folder_path2)) {
        mkdir($folder_path2);
    }
    if(!is_dir($folder_path3)){
        mkdir($folder_path3);
    }
    if (!empty($_FILES['file']['name'])) {
        $file = $_FILES['file']['name'];
        $target = "../../../images/daily/" . $result["code"] . "/payment/" . basename($file);
        $sql = "UPDATE dailycost SET pay_img = '$file' WHERE dailycost_id = $id";
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            if ($conn->query($sql) === true && $conn->query($addLogs) === true) {
                echo "<script>alert('เพิ่มหลักฐานการชำระเงินค่าห้องพักเรียบร้อยแล้ว');location.href = '../dailyCostDetail.php?dailycost_id=$id';</script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }
} else {
    Header("Location: ../../../login.php");
}
