<?php
session_start();
if($_SESSION['level'] == 'employee'){
  include('../../connection.php');

  $id = $_REQUEST["ID"];
  // $name_title = $_POST['name_title'];
  
  if(isset($_POST['formSubmit'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $nickname = $_POST['nickname'];
    $id_card = $_POST['id_card'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $line = $_POST['line'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $race = $_POST['race'];
    $nationality = $_POST['nationality'];
    $job = $_POST['job'];
    $address = $_POST['address'];
    $name_title = $_POST['name_title'];
    @$pic_idcard = $_FILES['pic_idcard']['name'];
    @$pic_home = $_FILES['pic_home']['name'];
    $date = date("Y/m/d");
    $target = "../../images/roommember/$id/1/".basename($pic_idcard);
    $target2 = "../../images/roommember/$id/1/".basename($pic_home);
  
    $checkData = "SELECT * FROM roommember WHERE room_member = '$id' ";
    $result = $conn->query($checkData);
    if ($result->num_rows > 0) {
      $updateData = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', id_line = '$line' WHERE room_member = '$id' ";
      if ($conn->query($updateData) === TRUE) {
        for($i = 1;$i <= 2;$i++){ 
          if($pic_idcard != ""){
            $update_pic1 = "UPDATE roommember SET pic_idcard = '$pic_idcard' WHERE room_member = '$id' ";
            if(move_uploaded_file($_FILES['pic_idcard']['tmp_name'], $target)){
              if ($conn->query($update_pic1) === TRUE) {    
              } else {
                echo "Error updating record: " . $conn->error;
              }
             }
          }
          if($pic_home != ""){
            $update_pic2 = "UPDATE roommember SET pic_home = '$pic_home' WHERE room_member = '$id' ";
            if(move_uploaded_file($_FILES['pic_home']['tmp_name'], $target2)){
              if ($conn->query($update_pic2) === TRUE) {    
              } else {
                echo "Error updating record: " . $conn->error;
              }
            }
          }
        }
        echo "<script>";
        echo "alert('แก้ไขข้อมูลสำเร็จ');";
        echo "window.location ='room_id.php?ID=$id'; "; 
        echo "</script>";
      }
    }else{
        if(move_uploaded_file($_FILES['pic_idcard']['tmp_name'], $target) && move_uploaded_file($_FILES['pic_home']['tmp_name'], $target2)){
          $sql = "INSERT INTO roommember (room_member, name_title, firstname, lastname, nickname, id_card, phone, email, id_line, birthday, age, race, nationality, job, address, pic_idcard, pic_home) VALUES ('$id', '$name_title', '$firstname', '$lastname', '$nickname', '$id_card', '$phone', '$email', '$line', '$birthday', '$age', '$race', '$nationality', '$job', '$address', '$pic_idcard', '$pic_home')";
          $roomlist = "UPDATE roomlist SET room_status = 'ไม่ว่าง',come = '$date' WHERE room_id = '$id' ";
          $insertUser = "INSERT INTO login (username, name, password, email, level) VALUES ('$id', '$id', md5('$id_card'), '$email', 'guest')";
          if ($conn->query($sql) === TRUE && $conn->query($roomlist) === TRUE && $conn->query($insertUser) === TRUE) {  
            echo "<script>";
            echo "alert('เพิ่มข้อมูลสำเร็จ');";
            echo "window.location ='room_id.php?ID=$id'; ";
            echo "</script>";
          } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
          }
        }
    }
  }
  
  if(isset($_POST['formSubmit2'])){
    $firstname2 = $_POST['firstname2'];
    $lastname2 = $_POST['lastname2'];
    $nickname2 = $_POST['nickname2'];
    $id_card2 = $_POST['id_card2'];
    $phone2 = $_POST['phone2'];
    $email2 = $_POST['email2'];
    $line2 = $_POST['line2'];
    $birthday2 = $_POST['birthday2'];
    $age2 = $_POST['age2'];
    $race2 = $_POST['race2'];
    $nationality2 = $_POST['nationality2'];
    $job2 = $_POST['job2'];
    $address2 = $_POST['address2'];
    $name_title2 = $_POST['name_title2'];
    @$pic_idcard2 = $_FILES['pic_idcard2']['name'];
    @$pic_home2 = $_FILES['pic_home2']['name'];
    $target3 = "../../images/roommember/$id/2/".basename($pic_idcard2);
    $target4 = "../../images/roommember/$id/2/".basename($pic_home2);
    $updateData = "UPDATE roommember SET name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone2 = '$phone2', email2 = '$email2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2', id_line2 = '$line2' WHERE room_member = '$id' ";
    if ($conn->query($updateData) === TRUE) {
      for($i = 1;$i <= 2;$i++){ 
        if($pic_idcard2 != ""){
          $update_pic1 = "UPDATE roommember SET pic_idcard2 = '$pic_idcard2' WHERE room_member = '$id' ";
          if(move_uploaded_file($_FILES['pic_idcard2']['tmp_name'], $target3)){
            if ($conn->query($update_pic1) === TRUE) {    
            } else {
                echo "Error updating record: " . $conn->error;
            }
          }
        }
        if($pic_home2 != ""){
          $update_pic2 = "UPDATE roommember SET pic_home2 = '$pic_home2' WHERE room_member = '$id' ";
          if(move_uploaded_file($_FILES['pic_home2']['tmp_name'], $target4)){
            if ($conn->query($update_pic2) === TRUE) {    
            } else {
                echo "Error updating record: " . $conn->error;
            }
          }
        }
      }
      echo "<script>";
      echo "alert('แก้ไขข้อมูลสำเร็จ');";
      echo "window.location ='room_id.php?ID=$id'; "; 
      echo "</script>";
    }
  }
  if(isset($_POST['formSubmit3'])){
    @$pic_idcard = $_FILES['pic_idcard']['name'];
    $target = "../../images/roommember/$id/1/".basename($pic_idcard);
    $checkData = "SELECT * FROM roommember WHERE room_member = '$id' ";
    $result = $conn->query($checkData);
    if ($result->num_rows > 0) {
      if($pic_idcard != ""){
        $update_pic1 = "UPDATE roommember SET pic_idcard = '$pic_idcard' WHERE room_member = '$id' ";
        if(move_uploaded_file($_FILES['pic_idcard']['tmp_name'], $target)){
            if($conn->query($update_pic1) === TRUE) {   
              echo "<script>";
              echo "alert('แก้ไขข้อมูลสำเร็จ');";
              echo "window.location ='room_id.php?ID=$id'; "; 
              echo "</script>";
            } else {
              echo "Error updating record: " . $conn->error;
            }
        }
      }
    }
  }
}else{
  Header("Location: ../../login.php");
}








// if(isset($_POST['formSubmit'])){
//   if(move_uploaded_file($_FILES['pic_idcard']['tmp_name'], $target) && move_uploaded_file($_FILES['pic_home']['tmp_name'], $target2)){
//     $sql = "INSERT INTO roommember (room_member, name_title, firstname, lastname, nickname, id_card, phone, email, id_line, birthday, age, race, nationality, job, address, pic_idcard, pic_home) VALUES ('$id', '$name_title', '$firstname', '$lastname', '$nickname', '$id_card', '$phone', '$email', '$line', '$birthday', '$age', '$race', '$nationality', '$job', '$address', '$pic_idcard', '$pic_home')";
//     $roomlist = "UPDATE roomlist SET room_status = 'ไม่ว่าง' WHERE room_id = '$id' ";
//     if ($conn->query($sql) === TRUE  ) {  
//       echo "<script>";
//       echo "alert('เพิ่มข้อมูลสำเร็จ');";
//       echo "window.location ='index.php '; ";
//       echo "</script>";
//       if ($conn->query($roomlist) === TRUE) {
//         echo "New record updated successfully";
//       } else {
//         echo "Error: " .$roomlist . "<br>" . $conn->error;
//       }
//     } else {
//       echo "Error: " . $sql . "<br>" . $conn->error;
//     }
  
//   }
// }

// if(isset($_POST['formEdit'])){
//   //////////////// มีไฟล์ pic_home /////////////////
//   if($_FILES['pic_idcard']['size'] == 0 && $_FILES['pic_home']['size'] != 0 && $_FILES['pic_idcard2']['size'] == 0 && $_FILES['pic_home2']['size'] == 0){
  
//     if(move_uploaded_file($_FILES['pic_home']['tmp_name'], $target2)){
//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', pic_home = '$pic_home', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2' WHERE room_member = '$id'";
    
//       if ($conn->query($sql) === TRUE) {
    
//         echo "<script>";
//           echo "alert('แก้ไขข้อมูลสำเร็จ');";
//           echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//           echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
    
//   }
//   //////////////// มีไฟล์ pic_idcard  //////////////
//   else if($_FILES['pic_home']['size'] == 0 && $_FILES['pic_idcard']['size'] != 0 && $_FILES['pic_idcard2']['size'] == 0 && $_FILES['pic_home2']['size'] == 0){
  
//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', pic_idcard = '$pic_idcard', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2' WHERE room_member = '$id'";
//     if(move_uploaded_file($_FILES['pic_idcard']['tmp_name'], $target)){
//       if ($conn->query($sql) === TRUE) {
    
//       echo "<script>";
//       echo "alert('แก้ไขข้อมูลสำเร็จ');";
//       echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//       echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
//   }
//   //////////////// มีไฟล์ pic_home2  //////////////
//   else if($_FILES['pic_idcard2']['size'] == 0 && $_FILES['pic_home2']['size'] != 0 && $_FILES['pic_idcard']['size'] == 0 && $_FILES['pic_home']['size'] == 0){
  
//     if(move_uploaded_file($_FILES['pic_home2']['tmp_name'], $target4)){
//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2', pic_home2 = '$pic_home2' WHERE room_member = '$id'";
    
//       if ($conn->query($sql) === TRUE) {
    
//         echo "<script>";
//           echo "alert('แก้ไขข้อมูลสำเร็จ');";
//           echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//           echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
  
//   }
//   /////////////////// มีไฟล์ pic_idcard2 ////////////  
//   else if($_FILES['pic_home2']['size'] == 0 && $_FILES['pic_idcard2']['size'] != 0 && $_FILES['pic_idcard']['size'] == 0 && $_FILES['pic_home']['size'] == 0){
  
//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone2 = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2', pic_idcard2 = '$pic_idcard2' WHERE room_member = '$id'";
//     if(move_uploaded_file($_FILES['pic_idcard2']['tmp_name'], $target3)){
//       if ($conn->query($sql) === TRUE) {
    
//       echo "<script>";
//       echo "alert('แก้ไขข้อมูลสำเร็จ');";
//       echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//       echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
//   }
//   //////////////// มีไฟล์ทั้ง pic_idcard และ pic_home ////////////////
//   else if($_FILES['pic_idcard']['size'] != 0 && $_FILES['pic_home']['size'] != 0 && $_FILES['pic_idcard2']['size'] == 0 && $_FILES['pic_home2']['size'] == 0){

//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', pic_idcard = '$pic_idcard', pic_home = '$pic_home',name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone2 = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2' WHERE room_member = '$id'";
//     if(move_uploaded_file($_FILES['pic_idcard']['tmp_name'], $target) && move_uploaded_file($_FILES['pic_home']['tmp_name'], $target2)){
//       if ($conn->query($sql) === TRUE) {
//         echo "<script>";
//         echo "alert('แก้ไขข้อมูลสำเร็จ');";
//         echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//         echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
//   //////////////// มีไฟล์ทั้ง pic_idcard2 และ pic_home2  //////////////
//   }else if($_FILES['pic_idcard']['size'] == 0 && $_FILES['pic_home']['size'] == 0 && $_FILES['pic_idcard2']['size'] != 0 && $_FILES['pic_home2']['size'] != 0){

//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone2 = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2', pic_idcard2 = '$pic_idcard2', pic_home2 = '$pic_home2' WHERE room_member = '$id'";
//     if(move_uploaded_file($_FILES['pic_idcard2']['tmp_name'], $target3) && move_uploaded_file($_FILES['pic_home2']['tmp_name'], $target4)){
//       if ($conn->query($sql) === TRUE) {
//         echo "<script>";
//         echo "alert('แก้ไขข้อมูลสำเร็จ');";
//         echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//         echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
//   }
//   //////////////// มีไฟล์ pic_idcard และไฟล์ pic_idcard2  //////////////
//   else if($_FILES['pic_idcard']['size'] != 0 && $_FILES['pic_home']['size'] == 0 && $_FILES['pic_idcard']['size'] != 0 && $_FILES['pic_home']['size'] == 0){

//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', pic_idcard = '$pic_idcard', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone2 = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2', pic_idcard2 = '$pic_idcard2' WHERE room_member = '$id'";
//     if(move_uploaded_file($_FILES['pic_idcard']['tmp_name'], $target) && move_uploaded_file($_FILES['pic_idcard2']['tmp_name'], $target3)){
//       if ($conn->query($sql) === TRUE) {
//         echo "<script>";
//         echo "alert('แก้ไขข้อมูลสำเร็จ');";
//         echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//         echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
//   }
//   //////////////// มีไฟล์ pic_idcard และไฟล์ pic_home2  //////////////
//   else if($_FILES['pic_idcard']['size'] != 0 && $_FILES['pic_home']['size'] == 0 && $_FILES['pic_idcard']['size'] == 0 && $_FILES['pic_home']['size'] != 0){
//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', pic_idcard = '$pic_idcard', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone2 = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2', pic_home2 = '$pic_home2' WHERE room_member = '$id'";
//     if(move_uploaded_file($_FILES['pic_idcard']['tmp_name'], $target) && move_uploaded_file($_FILES['pic_home2']['tmp_name'], $target4)){
//       if ($conn->query($sql) === TRUE) {
//         echo "<script>";
//         echo "alert('แก้ไขข้อมูลสำเร็จ');";
//         echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//         echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
//   }
//   //////////////// มีไฟล์ pic_home และไฟล์ pic_idcard2  //////////////
//   else if($_FILES['pic_idcard']['size'] == 0 && $_FILES['pic_home']['size'] != 0 && $_FILES['pic_idcard']['size'] != 0 && $_FILES['pic_home']['size'] == 0){
//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', pic_home = '$pic_home', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone2 = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2', pic_idcard2 = '$pic_idcard2' WHERE room_member = '$id'";
//     if(move_uploaded_file($_FILES['pic_home']['tmp_name'], $target2) && move_uploaded_file($_FILES['pic_idcard2']['tmp_name'], $target3)){
//       if ($conn->query($sql) === TRUE) {
//         echo "<script>";
//         echo "alert('แก้ไขข้อมูลสำเร็จ');";
//         echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//         echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
//   }
//    //////////////// มีไฟล์ pic_home และไฟล์ pic_home2  //////////////
//    else if($_FILES['pic_idcard']['size'] == 0 && $_FILES['pic_home']['size'] != 0 && $_FILES['pic_idcard']['size'] == 0 && $_FILES['pic_home']['size'] != 0){
//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', pic_home = '$pic_home', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone2 = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2', pic_home = '$pic_home2' WHERE room_member = '$id'";
//     if(move_uploaded_file($_FILES['pic_home']['tmp_name'], $target2) && move_uploaded_file($_FILES['pic_idcard2']['tmp_name'], $target3)){
//       if ($conn->query($sql) === TRUE) {
//         echo "<script>";
//         echo "alert('แก้ไขข้อมูลสำเร็จ');";
//         echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//         echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
//   }
//   //////////////// ไม่มีอะไรเลย  //////////////
//   else if($_FILES['pic_idcard']['size'] == 0 && $_FILES['pic_home']['size'] == 0 && $_FILES['pic_idcard']['size'] == 0 && $_FILES['pic_home']['size'] == 0){
  
//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone2 = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2' WHERE room_member = '$id'";
//       if ($conn->query($sql) === TRUE) {
//         echo "<script>";
//         echo "alert('แก้ไขข้อมูลสำเร็จz');";
//         echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//         echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//   }
//   //////////////// มีทั้งหมด  //////////////
//   else{
    
//     $sql = "UPDATE roommember SET name_title = '$name_title', firstname = '$firstname', lastname = '$lastname', nickname = '$nickname', id_card = '$id_card', phone = '$phone', email = '$email', id_line = '$line', birthday = '$birthday', age = '$age', race = '$race', nationality = '$nationality', job = '$job', address = '$address', pic_idcard = '$pic_idcard', pic_home = '$pic_home', name_title2 = '$name_title2', firstname2 = '$firstname2', lastname2 = '$lastname2', nickname2 = '$nickname2', id_card2 = '$id_card2', phone2 = '$phone2', email2 = '$email2', id_line2 = '$line2', birthday2 = '$birthday2', age2 = '$age2', race2 = '$race2', nationality2 = '$nationality2', job2 = '$job2', address2 = '$address2', pic_idcard2 = '$pic_idcard2', pic_home2 = '$pic_home2' WHERE room_member = '$id'";
//     if(move_uploaded_file($_FILES['pic_idcard']['tmp_name'], $target) && move_uploaded_file($_FILES['pic_home']['tmp_name'], $target2) && move_uploaded_file($_FILES['pic_idcard2']['tmp_name'], $target3) && move_uploaded_file($_FILES['pic_home2']['tmp_name'], $target4)){
//       if ($conn->query($sql) === TRUE) {
//         echo "<script>";
//         echo "alert('แก้ไขข้อมูลสำเร็จ');";
//         echo "window.location ='/Pingfah/pages/admin/roomList/room_id.php?ID=$id'; ";
//         echo "</script>";
//       } else {
//         echo "Error updating record: " . $conn->error;
//       }
//     }
//   }
// }
?>