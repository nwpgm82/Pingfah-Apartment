<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../../connection.php');
    function BasicDate($tdate){
        $search = ["มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        $replace = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $edate = str_replace($search, $replace, $tdate);
        $str_date = strtotime($edate);
        $year =  date("Y",$str_date);
        $month = date("m",$str_date);
        $day = date("d",$str_date);
        return "$year-$month-$day"; 
    }
    $come = BasicDate($_POST['come']);
    $title_name = $_POST['title_name'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $nickname = $_POST['nickname'];
    $position = $_POST['position'];
    $id_card = $_POST['id_card'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $birthday = BasicDate($_POST['birthday']);
    $age = $_POST['age'];
    $race = $_POST['race'];
    $nat = $_POST['nation'];
    $add = $_POST['address'];
    $profile_img = $_FILES['profile_img']['name'];
    $pic_idcard = $_FILES["id_img"]["name"];
    $pic_home = $_FILES["home_img"]["name"];
    $username = $email;
    $password = $id_card;
    $main_target = "../../../images/employee/";
    $folder_target = "../../../images/employee/$username/";
    $target1 = "../../../images/employee/$username/".basename($pic_idcard);
    $target2 = "../../../images/employee/$username/".basename($pic_home);
    $target3 = "../../../images/employee/$username/".basename($profile_img);
    $checkData = "SELECT * FROM employee WHERE id_card = '$id_card'";
    $result = $conn->query($checkData);
    if ($result->num_rows > 0) {
        echo "<script>";
        echo "alert('ไม่สามารถเพิ่มพนักงานได้เนื่องจากมีพนักงานท่านนี้อยู่แล้ว');";
        echo "window.history.back();";
        echo "</script>";
    }else{
        if(!is_dir($main_target)){
            mkdir($main_target);
        }
        mkdir($folder_target);
        $sql = "INSERT INTO employee (come_date, employee_status, title_name, firstname, lastname, nickname, position, id_card, tel, email, birthday, age, race, nationality, address, pic_idcard, pic_home, profile_img) VALUES ('$come','กำลังทำงาน','$title_name','$firstname','$lastname','$nickname','$position','$id_card','$tel','$email','$birthday','$age','$race','$nat','$add','$pic_idcard','$pic_home','$profile_img')";
        $addUser = "INSERT INTO login (username, name, password, email, level) VALUES ('$username', '$firstname', MD5('$password'), '$email', 'employee')";
        if(move_uploaded_file($_FILES['id_img']['tmp_name'], $target1) && move_uploaded_file($_FILES['home_img']['tmp_name'], $target2) && move_uploaded_file($_FILES['profile_img']['tmp_name'], $target3)){
            if ($conn->query($sql) === TRUE && $conn->query($addUser) === TRUE) {
                echo "<script>";
                echo "alert('เพิ่มข้อมูลพนักงานสำเร็จ');";
                echo "location.href = '../index.php';";
                echo "</script>";
            }else{
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }  
    }
}else{
    Header("Location: ../../../login.php");
}

?>