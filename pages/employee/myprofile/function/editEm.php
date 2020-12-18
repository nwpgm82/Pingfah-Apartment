<?php
session_start();
if($_SESSION['level'] == 'employee'){
    if(isset($_POST['accept_edit'])){
        include('../../../connection.php');
        @$profile_img = $_FILES['profile_img']['name'];
        @$target = "../../../images/employee/".$_SESSION['ID']."/".basename($profile_img);
        if($profile_img != ""){
            $update_pic = "UPDATE employee SET profile_img = '$profile_img' WHERE username = '".$_SESSION['ID']."' ";
            if(move_uploaded_file($_FILES['profile_img']['tmp_name'], $target)){
                if ($conn->query($update_pic) === TRUE) {
                    echo "<script>";
                    echo "alert('แก้ไขข้อมูลพนักงานสำเร็จ');";
                    echo "location.href = '../index.php';";
                    echo "</script>";    
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }
        }else{
            echo "<script>";
            echo "alert('แก้ไขข้อมูลพนักงานสำเร็จ');";
            echo "location.href = '../index.php';";
            echo "</script>"; 
        }  
    }
}else{
    Header("Location: ../../../login.php");
}

?>