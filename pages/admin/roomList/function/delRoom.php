<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../../connection.php');
    $id = $_REQUEST["ID"];
    $room_data = "DELETE FROM roommember WHERE room_member = '$id'";
    $room_list = "DELETE FROM roomlist WHERE room_id = '$id'";
    if ($conn->query($room_list) === TRUE && $conn->query($room_data) === TRUE) {
        for($i = 1;$i<=2;$i++){
            ${'file-' .$i} = glob("../../../images/roommember/$id/$i/*");
            ${'file-' .$i} = glob("../../../images/roommember/$id/$i/*");
            foreach(${'file-' .$i} as $data){
                if(is_file($data)){
                    unlink($data);
                }
            }
            rmdir("../../../images/roommember/$id/$i");
        }
        rmdir("../../../images/roommember/$id");
        echo "<script>";
        echo "alert('ลบห้อง $id เรียบร้อย');";
        echo "location.href = '../index.php';";
        echo "</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}else{
    Header("Location: ../../../login.php");
}

?>