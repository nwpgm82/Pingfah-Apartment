<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
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
    Header("Location: ../../../login.php");
}
    
?>