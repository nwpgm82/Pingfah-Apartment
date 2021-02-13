<?php
session_start();
if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee" || $_SESSION["level"] == "guest"){
    include("../../../connection.php");
    $cost_id = $_REQUEST["cost_id"];
    $pay_img = $_FILES["pay_img"]["name"];
    $search = mysqli_query($conn, "SELECT room_id, date FROM cost WHERE cost_id = $cost_id");
    $result_search = mysqli_fetch_assoc($search);
    $cost_path = "../../../images/cost/";
    $sub_cost_path = "../../../images/cost/".$result_search["date"]."/";
    $sub2_cost_path  = "../../../images/cost/".$result_search["date"]."/".$result_search["room_id"]."/";
    $sub3_cost_path  = "../../../images/cost/".$result_search["date"]."/".$result_search["room_id"]."/payment/";
    $target = "../../../images/cost/".$result_search["date"]."/".$result_search["room_id"]."/payment/".basename($pay_img);
    if(!is_dir($cost_path)){
        mkdir($cost_path);
    }
    if(!is_dir($sub_cost_path)){
        mkdir($sub_cost_path);
    }
    if(!is_dir($sub2_cost_path)){
        mkdir($sub2_cost_path);
    }
    if(!is_dir($sub3_cost_path)){
        mkdir($sub3_cost_path);
    }
    if(move_uploaded_file($_FILES["pay_img"]["tmp_name"], $target)){
        $sql = "UPDATE cost SET pay_img = '$pay_img' WHERE cost_id = $cost_id";
        if($conn->query($sql) === TRUE){
            echo "<script>
                alert('เพิ่มหลักฐานการชำระเงินค่าห้องพักเรียบร้อยแล้ว');
                location.href = '../costDetail.php?cost_id=$cost_id';
                </script>";
        }
    }
    
}else{
    header("Location: ../../../login.php");
}
?>