<?php
include("../connection.php");
$daily_id = $_REQUEST["daily_id"];
$img = $_FILES['payment_img']['name'];
$path_file = "../images/daily/";
$path_file2 = "../images/daily/$daily_id/";
$target = "../images/daily/$daily_id/".basename($img);
$result = mysqli_query($conn,"SELECT code FROM daily WHERE daily_id = $daily_id LIMIT 1");
$row = mysqli_fetch_assoc($result);
$sql = "UPDATE daily SET payment_img = '$img' WHERE daily_id = '$daily_id'";
if(is_dir($path_file)){
    if(is_dir($path_file2)){
        if(!empty($img)){
            if(move_uploaded_file($_FILES['payment_img']['tmp_name'], $target)){
                if($conn->query($sql) === TRUE){
                    echo "<script>";
                    echo "alert('เพิ่มรูปภาพเรียบร้อยแล้ว');";
                    echo "location.href = '../checkCode.php?code=".$row['code']."';";
                    echo "</script>";
                }
            }else{
                echo "Error updating record: " . $conn->error;
            }
        }else{
            echo "<script>";
            echo "alert('เพิ่มรูปภาพเรียบร้อยแล้ว');";
            echo "location.href = '../checkCode.php?code=".$row['code']."';";
            echo "</script>";
        }
    }else{
        mkdir($path_file2);
        if(!empty($img)){
            if(move_uploaded_file($_FILES['payment_img']['tmp_name'], $target)){
                if($conn->query($sql) === TRUE){
                    echo "<script>";
                    echo "alert('เพิ่มรูปภาพเรียบร้อยแล้ว');";
                    echo "location.href = '../checkCode.php?code=".$row['code']."';";
                    echo "</script>";
                }
            }else{
                echo "Error updating record: " . $conn->error;
            }
        }else{
            echo "<script>";
            echo "alert('เพิ่มรูปภาพเรียบร้อยแล้ว');";
            echo "location.href = '../checkCode.php?code=".$row['code']."';";
            echo "</script>";
        }
    }
}else{
    mkdir($path_file);
    mkdir($path_file2);
    if(!empty($img)){
        if(move_uploaded_file($_FILES['payment_img']['tmp_name'], $target)){
            if($conn->query($sql) === TRUE){
                echo "<script>";
                echo "alert('เพิ่มรูปภาพเรียบร้อยแล้ว');";
                echo "location.href = '../checkCode.php?code=".$row['code']."';";
                echo "</script>";
            }
        }else{
            echo "Error updating record: " . $conn->error;
        }
    }else{
        echo "<script>";
        echo "alert('เพิ่มรูปภาพเรียบร้อยแล้ว');";
        echo "location.href = '../checkCode.php?code=".$row['code']."';";
        echo "</script>";
    }
}
