<?php
session_start();
if($_SESSION["level"] == "admin"){
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
    $id = $_REQUEST["employee_id"];
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
    $profile_img = @$_FILES['profile_img']['name'];
    $pic_idcard = @$_FILES["id_img"]["name"];
    $pic_home = @$_FILES["home_img"]["name"];
    $main_target = "../../../images/employee/";
    $folder_target = "../../../images/employee/$id_card/";
    $target1 = "../../../images/employee/$id_card/".basename($pic_idcard);
    $target2 = "../../../images/employee/$id_card/".basename($pic_home);
    $target3 = "../../../images/employee/$id_card/".basename($profile_img);
    if(isset($_POST["accept-edit"])){
        $update_data = "UPDATE employee SET title_name = '$title_name', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', position = '$position', id_card = '$id_card', tel = '$tel', email = '$email', birthday = '$birthday', age = $age, race = '$race', nationality = '$nat', address = '$address' WHERE employee_id = $id";
        if(isset($pic_idcard)){
            if(move_uploaded_file($_FILES["id_img"]["tmp_name"], $target1)){
                $update_idcard = "UPDATE employee SET pic_idcard = '$pic_idcard' WHERE employee_id = $id";
                $conn->query($update_idcard);
            }
        }
        if(isset($pic_home)){
            if(move_uploaded_file($_FILES["id_img"]["tmp_name"], $target2)){
                $update_home = "UPDATE employee SET pic_home = '$pic_home' WHERE employee_id = $id";
                $conn->query($update_home);
            }
        }
        if(isset($profile_img)){
            if(move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target3)){
                $update_profile = "UPDATE employee SET profile_img = '$profile_img' WHERE employee_id = $id";
                $conn->query($update_profile);
            }
        }
        $check_rename = mysqli_query($conn,"SELECT id_card FROM employee WHERE employee_id = $id");
        $result_check = mysqli_fetch_assoc($check_rename);
        if($result_check["id_card"] != $id_card){
            rename("../../../images/employee/".$result_check["id_card"]."/","../../../images/employee/$id_card/");
        }
        if($conn->query($update_data) === TRUE){
            echo "<script>";
            echo "alert('อัปเดตข้อมูลเรียบร้อยแล้ว');";
            // echo "location.href = '../emDetail.php?employee_id=$id';";
            echo "</script>";
        }else{
            echo $conn->error;
        }
    }
}
?>