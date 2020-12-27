<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../../connection.php");
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
    @$room_id = $_REQUEST["ID"];
    @$title_name = $_POST["title_name"];
    @$firstname = $_POST["firstname"];
    @$lastname = $_POST["lastname"];
    @$nickname = $_POST["nickname"];
    @$id_card = $_POST["id_card"];
    @$birthday = BasicDate($_POST["birthday"]);
    @$age = $_POST["age"];
    @$tel = $_POST["tel"];
    @$email = $_POST["email"];
    @$race = $_POST["race"];
    @$nation = $_POST["nation"];
    @$job = $_POST["job"];
    @$address = $_POST["address"];
    @$id_img = $_FILES["id_img"]["name"];
    @$home_img = $_FILES["home_img"]["name"];
    $search_comeDate = mysqli_query($conn,"SELECT come_date FROM roommember WHERE room_id = '$room_id' AND member_status='กำลังเข้าพัก' ");
    $result_search = mysqli_fetch_assoc($search_comeDate);
    if(isset($_POST["addData-btn"])){
        $come = BasicDate($_POST["come"]);
        $roommember_folder_path = "../../../images/roommember/";
        $room_folder = "../../../images/roommember/$room_id/";
        $come_folder = "../../../images/roommember/$room_id/$come";
        $id_target = "../../../images/roommember/$room_id/$come/".basename($id_img);
        $home_target = "../../../images/roommember/$room_id/$come/".basename($home_img);
        if(!is_dir($roommember_folder_path)){
            mkdir($roommember_folder_path);
        }
        if(!is_dir($room_folder)){
            mkdir($room_folder);
        }
        if(!is_dir($come_folder)){
            mkdir($come_folder);
        } 
        if(is_dir($roommember_folder_path) && is_dir($room_folder) && is_dir($come_folder)){
            if(move_uploaded_file($_FILES["id_img"]["tmp_name"], $id_target) && move_uploaded_file($_FILES["home_img"]["tmp_name"], $home_target)){
                $addData = "INSERT INTO roommember (room_id, come_date, member_status, name_title, firstname, lastname, nickname, id_card, phone, email, birthday, age, race, nationality, job, address, pic_idcard, pic_home) VALUES ('$room_id','$come','กำลังเข้าพัก','$title_name','$firstname', '$lastname', '$nickname', '$id_card', '$tel', '$email', '$birthday' , $age, '$race', '$nation', '$job', '$address', '$id_img', '$home_img')";
                $change_status = "UPDATE roomlist SET room_status = 'ไม่ว่าง' WHERE room_id = '$room_id' ";
                if($conn->query($addData) === TRUE && $conn->query($change_status) === TRUE){
                    echo "<script>";
                    echo "alert('เพิ่มข้อมูลผู้พักห้อง $room_id เรียบร้อยแล้ว');";
                    echo "location.href = '../index.php';";
                    echo "</script>";
                }else{
                    echo "Error: " . $addData . "<br>" . $conn->error;
                }
            }else{
                echo $conn->error;
            }
        }else{
            echo $conn->error;
        }
    }
    if(isset($_POST["del-idimg"])){
        $delimg_update = "UPDATE roommember SET pic_idcard = '' WHERE room_id = '$room_id' AND member_status = 'กำลังเข้าพัก' ";
        if($conn->query($delimg_update) === TRUE){
            echo "<script>";
            echo "alert('ลบรูปสำเนาบัตรประชาชนเรียบร้อยแล้ว');";
            echo "location.href = '../room_id.php?ID=$room_id';";
            echo "</script>";
        }
    }
    if(isset($_POST["del-homeimg"])){
        $delimg_update = "UPDATE roommember SET pic_home = '' WHERE room_id = '$room_id' AND member_status = 'กำลังเข้าพัก' ";
        if($conn->query($delimg_update) === TRUE){
            echo "<script>";
            echo "alert('ลบรูปสำเนาทะเบียนบ้านเรียบร้อยแล้ว');";
            echo "location.href = '../room_id.php?ID=$room_id';";
            echo "</script>";
        }
    }
    if(isset($_POST["accept-edit"])){
        $idimg_path = "../../../images/roommember/$room_id/".$result_search["come_date"]."/".basename($id_img);
        $homeimg_path = "../../../images/roommember/$room_id/".$result_search["come_date"]."/".basename($home_img);
        if($id_img == "" && $home_img == ""){
            $update_data = "UPDATE roommember SET name_title = '$title_name', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$tel', email = '$email', birthday = '$birthday', age = $age, race = '$race', nationality = '$nation', job = '$job', address = '$address' ";
        }else if($id_img != "" && $home_img == ""){
            if(move_uploaded_file($_FILES["id_img"]["tmp_name"], $idimg_path)){
                $update_data = "UPDATE roommember SET name_title = '$title_name', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$tel', email = '$email', birthday = '$birthday', age = $age, race = '$race', nationality = '$nation', job = '$job', address = '$address', pic_idcard = '$id_img' ";
            }else{
                echo $conn->error;
            }
        }else if($id_img == "" && $home_img != ""){
            if(move_uploaded_file($_FILES["home_img"]["tmp_name"], $homeimg_path)){
                $update_data = "UPDATE roommember SET name_title = '$title_name', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$tel', email = '$email', birthday = '$birthday', age = $age, race = '$race', nationality = '$nation', job = '$job', address = '$address', pic_home = '$home_img' ";
            }else{
                echo $conn->error;
            }
        }else{
            if(move_uploaded_file($_FILES["id_img"]["tmp_name"], $idimg_path) && move_uploaded_file($_FILES["home_img"]["tmp_name"], $homeimg_path)){
                $update_data = "UPDATE roommember SET name_title = '$title_name', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$tel', email = '$email', birthday = '$birthday', age = $age, race = '$race', nationality = '$nation', job = '$job', address = '$address', pic_idcard = '$id_img', pic_home = '$home_img' ";
            }else{
                echo $conn->error;
            }
        }
        if($conn->query($update_data) === TRUE){
            echo "<script>";
            echo "alert('อัปเดตข้อมูลเรียบร้อยแล้ว');";
            echo "location.href = '../room_id.php?ID=$room_id';";
            echo "</script>";
        }else{
            echo "Error: " . $update_data . "<br>" . $conn->error;
        }
    }
    if(isset($_POST["del_data"])){
        $folder_path = glob("../../../images/roommember/$room_id/".$result_search["come_date"]."/*");
        foreach($folder_path as $data){
            if(is_file($data)){
                unlink($data);
            }
        }
        $del_data = "DELETE FROM roommember WHERE room_id = '$room_id' AND member_status = 'กำลังเข้าพัก'";
        if($conn->query($del_data) === TRUE && rmdir("../../../images/roommember/$room_id/".$result_search["come_date"]."/")){
            echo "<script>";
            echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
            echo "location.href = '../room_id.php?ID=$room_id';";
            echo "</script>";
        }else{
            echo $conn->error;
        }
    }
    if(isset($_POST["quit"])){
        $out_date = date('Y-m-d');
        $update_status = "UPDATE roommember SET member_status = 'แจ้งออกแล้ว', out_date = '$out_date' WHERE room_id = '$room_id' AND member_status = 'กำลังเข้าพัก' ";
        $update_room_status = "UPDATE roomlist SET room_status = 'ว่าง' WHERE room_id = '$room_id' ";
        if($conn->query($update_status) === TRUE && $conn->query($update_room_status) === TRUE){
            echo "<script>";
            echo "alert('แจ้งออกเรียบร้อยแล้ว');";
            echo "location.href = '../room_id.php?ID=$room_id';";
            echo "</script>";
        }else{
            echo $conn->error;
        }
    }
}
?>