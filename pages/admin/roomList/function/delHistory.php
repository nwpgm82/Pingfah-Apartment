<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
    $member_id = $_REQUEST["member_id"];
    $sql = mysqli_query($conn, "SELECT member_status FROM roommember WHERE member_id = $member_id");
    $result = mysqli_fetch_assoc($sql);
    if($result["member_status"] == "แจ้งออกแล้ว"){
        $delHis = "DELETE FROM roommember WHERE member_id = $member_id";
        if($conn->query($delHis) === TRUE){
            echo "<script>";
            echo "alert('ลบประวัติเรียบร้อยแล้ว');";
            echo "location.href = '../roomHistory.php'";
            echo "</script>";
        }
    }else{
        echo "<script>";
        echo "alert('ไม่สามารถลบประวัติได้เนื่องจากมีผู้พักยังพักอยู่');";
        echo "location.href = '../roomHistory.php'";
        echo "</script>";
    }
}
?>