<?php
session_start();
if($_SESSION['level'] == 'employee'){
    include("../../../connection.php");
    $folder_path = "../../../images/gallery/";
    var_dump(is_dir($folder_path));
    if(is_dir($folder_path)){
        if(!empty($_FILES['file']['name'])){
            $file = $_FILES['file']['name'];
            $target = "../../../images/gallery/".basename($file);
            $sql = "INSERT INTO gallery (gallery_name) VALUES ('$file')";
            if(move_uploaded_file($_FILES['file']['tmp_name'], $target)){
                if ($conn->query($sql) === TRUE) {    
                } else {
                  echo "Error updating record: " . $conn->error;
                }
            }
        }
    }else{
        mkdir($folder_path);
        if(!empty($_FILES['file']['name'])){
            $file = $_FILES['file']['name'];
            $target = "../../../images/gallery/".basename($file);
            $sql = "INSERT INTO gallery (gallery_name) VALUES ('$file')";
            if(move_uploaded_file($_FILES['file']['tmp_name'], $target)){
                if ($conn->query($sql) === TRUE) {    
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