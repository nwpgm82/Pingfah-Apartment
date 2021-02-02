<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
    $type = $_REQUEST["type"];
    $main_path = "../../../images/roomdetail/";
    if(!is_dir($main_path)){
        mkdir($main_path);
    }
    if($type == "fan"){
        $folder_path = "../../../images/roomdetail/fan/";
    }else if($type == "air"){
        $folder_path = "../../../images/roomdetail/air/";
    }
    if(!is_dir($folder_path)){
        mkdir($folder_path);
    }
    if(!empty($_FILES['file']['name'])){
        $file = $_FILES['file']['name'];
        $target = $folder_path.basename($file);
        if($type == "fan"){
            $sql = "INSERT INTO fan_gal (gal_name) VALUES ('$file')";
        }else if($type == "air"){
            $sql = "INSERT INTO air_gal (gal_name) VALUES ('$file')";
        }
        if(move_uploaded_file($_FILES['file']['tmp_name'], $target)){
            if ($conn->query($sql) === TRUE) {
                echo $file; 
                exit;   
            } else {
              echo "Error updating record: " . $conn->error;
            }
        }
    }
}else{
    Header("Location: ../../../login.php");
}
    
?>