<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../../connection.php');
    $id = $_REQUEST["ID"];
    // echo $id;
    $room_data = "DELETE FROM roommember WHERE room_member = '$id'";
    $room_list = "DELETE FROM roomlist WHERE room_id = '$id'";
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
    $del_folder = rmdir("../../../images/roommember/$id");
    if ($conn->query($room_list) === TRUE && $conn->query($room_data) === TRUE && $del_folder === TRUE) {
        
        echo "<script type='text/javascript'>alert('ลบห้อง $id เรียบร้อย')</script>";
        echo "<script type='text/javascript'>location.assign('../index.php')</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}else{
    Header("Location: ../../../login.php");
}

?>