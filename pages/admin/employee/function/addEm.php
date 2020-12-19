<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../../connection.php');
    $title_name = $_POST['title_name'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $nickname = $_POST['nickname'];
    $position = $_POST['position'];
    $id_card = $_POST['id_card'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $id_line = $_POST['id_line'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $race = $_POST['race'];
    $nat = $_POST['nationality'];
    $add = $_POST['address'];
    $profile_img = $_FILES['profile_img']['name'];
    $pic_idcard = $_FILES['pic_idcard']['name'];
    $pic_home = $_FILES['pic_home']['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
    $main_target = "../../../images/employee/";
    $folder_target = "../../../images/employee/$username/";
    $target1 = "../../../images/employee/$username/".basename($pic_idcard);
    $target2 = "../../../images/employee/$username/".basename($pic_home);
    $target3 = "../../../images/employee/$username/".basename($profile_img);
    if($password == $confirm_pass){
        $checkData = "SELECT * FROM employee WHERE id_card = '$id_card'";
        $result = $conn->query($checkData);
        if ($result->num_rows > 0) {
            echo "<script>";
            echo "alert('ไม่สามารถเพิ่มพนักงานได้เนื่องจากมีพนักงานท่านนี้อยู่แล้ว');";
            echo "location.href = '../../employee/index.php';";
            echo "</script>";
        }else{
            if(!is_dir($main_target)){
                mkdir($main_target);
            }
            mkdir($folder_target);
            $sql = "INSERT INTO employee (title_name, firstname, lastname, nickname, position, id_card, tel, email, id_line, birthday, age, race, nationality, address, pic_idcard, pic_home, profile_img, username, password) VALUES ('$title_name','$firstname','$lastname','$nickname','$position','$id_card','$tel','$email','$id_line','$birthday','$age','$race','$nat','$add','$pic_idcard','$pic_home','$profile_img', '$username', MD5('$password'))";
            $addUser = "INSERT INTO login (username, name, password, email, level) VALUES ('$username', '$firstname', MD5('$password'), '$email', 'employee')";
            if(move_uploaded_file($_FILES['pic_idcard']['tmp_name'], $target1) && move_uploaded_file($_FILES['pic_home']['tmp_name'], $target2) && move_uploaded_file($_FILES['profile_img']['tmp_name'], $target3)){
                if ($conn->query($sql) === TRUE && $conn->query($addUser) === TRUE) {
                    echo "<script>";
                    echo "alert('เพิ่มข้อมูลพนักงานสำเร็จ');";
                    echo "location.href = '../index.php';";
                    echo "</script>";
                }
            }  
        }
    }else{
        echo "<script>";
        echo "alert('รหัสผ่านไม่ตรงกัน');";
        echo "window.history.back();";
        echo "</script>";
    }
}else{
    Header("Location: ../../../login.php");
}

?>