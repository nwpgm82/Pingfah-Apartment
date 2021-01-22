<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
    $id = $_REQUEST['dailycost_id'];
    $folder_path = "../../../images/dailycost/";
    // var_dump(is_dir($folder_path));
    if(is_dir($folder_path)){
        mkdir("../../../images/dailycost/$id/");
        if(!empty($_FILES['file']['name'])){
            $file = $_FILES['file']['name'];
            $target = "../../../images/daily/$id/".basename($file);
            $sql = "UPDATE dailycost SET pay_img = '$file' WHERE dailycost_id = $id";
            if(move_uploaded_file($_FILES['file']['tmp_name'], $target)){
                if ($conn->query($sql) === TRUE) {    
                } else {
                  echo "Error updating record: " . $conn->error;
                }
            }
        }
    }else{
        mkdir($folder_path);
        mkdir("../../../images/dailycost/$id/");
        if(!empty($_FILES['file']['name'])){
            $file = $_FILES['file']['name'];
            $target = "../../../images/dailycost/$id/".basename($file);
            $sql = "UPDATE dailycost SET pay_img = '$file' WHERE dailycost_id = $id";
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