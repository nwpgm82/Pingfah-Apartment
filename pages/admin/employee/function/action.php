<?php
session_start();
if($_SESSION["level"] == "admin"){
    include('../../../connection.php');
    $id = $_REQUEST["employee_id"];
    if(isset($_POST["accept-edit"])){
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
        $get_email = mysqli_query($conn,"SELECT email FROM employee WHERE employee_id = $id");
        $result_get = mysqli_fetch_assoc($get_email);
        $update_data = "UPDATE employee SET title_name = '$title_name', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', position = '$position', id_card = '$id_card', tel = '$tel', email = '$email', birthday = '$birthday', age = $age, race = '$race', nationality = '$nat', address = '$add' WHERE employee_id = $id";
        $update_level = "UPDATE login SET username = '$email', email = '$email', level = '$position' WHERE username = '".$result_get["email"]."'";
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
        if($conn->query($update_level) === TRUE){
            if($conn->query($update_data) === TRUE){
                echo "<script>";
                echo "alert('อัปเดตข้อมูลเรียบร้อยแล้ว');";
                echo "location.href = '../emDetail.php?employee_id=$id';";
                echo "</script>";
            }else{
                echo $conn->error;
            }
        }else{
            echo $conn->error;
        }
    }
    if(isset($_POST["quit"])){
        $out_date = date("Y-m-d");
        $get_email = mysqli_query($conn,"SELECT email FROM employee WHERE employee_id = $id");
        $result_get = mysqli_fetch_assoc($get_email);
        $quit = "UPDATE employee SET out_date = '$out_date', employee_status = 'ลาออก' WHERE employee_id = $id";
        $login = "DELETE FROM login WHERE username = '".$result_get["email"]."'";
        if($conn->query($quit) === TRUE && $conn->query($login) === TRUE){
            echo "<script>";
            echo "alert('เปลี่ยนสถานะเรียบร้อยแล้ว');";
            echo "location.href = '../index.php';";
            echo "</script>";
        }else{
            $conn->error;
        }
    }
    if(isset($_POST["del_data"])){
        $get_idcard_email = mysqli_query($conn,"SELECT id_card, email FROM employee WHERE employee_id = $id");
        $result_get = mysqli_fetch_assoc($get_idcard_email);
        $folder_path = glob("../../../images/employee/".$result_get["id_card"]."/*");
        foreach($folder_path as $data){
            if(is_file($data)){
                unlink($data);
            }
        }
        $login = "DELETE FROM login WHERE username = '".$result_get["email"]."'";
        $del_data = "DELETE FROM employee WHERE employee_id = $id";
        if($conn->query($del_data) === TRUE && $conn->query($login) === TRUE && rmdir("../../../images/employee/".$result_get["id_card"]."/")){
            echo "<script>";
            echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
            echo "location.href = '../emDetail.php?employee_id=$id';";
            echo "</script>";
        }
    }
}
?>