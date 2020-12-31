<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../../connection.php');
    $id = $_REQUEST["ID"];
    $search_data = mysqli_query($conn, "SELECT room_status FROM roomlist WHERE room_id = '$id'");
    $result = mysqli_fetch_assoc($search_data);
    if($result["room_status"] == "ว่าง"){
        $room_list = "DELETE FROM roomlist WHERE room_id = '$id'";
        if ($conn->query($room_list) === TRUE) {
            echo "<script>";
            echo "alert('ลบห้อง $id เรียบร้อย');";
            echo "location.href = '../index.php';";
            echo "</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }else{
        echo "<script>";
        echo "alert('ไม่สามารถลบห้อง $id ได้เนื่องจากมีผู้พักยังพักอยู่');";
        echo "location.href = '../index.php';";
        echo "</script>";
    } 
}else{
    Header("Location: ../../../login.php");
}

?>