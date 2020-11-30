<?php
session_start();
if($_SESSION['level'] == 'employee'){
  if(isset($_POST['accept'])){
    include('../../../connection.php');
    $type = $_REQUEST['type'];
    $water = $_POST['water_bill'];
    $elec = $_POST['elec_bill'];
    $cable = $_POST['cable_charge'];
    $fines = $_POST['fines'];
    $detail = $_POST['detail'];
    $pic1 = $_FILES['pic1']['name'];
    $pic2 = $_FILES['pic2']['name'];
    $pic3 = $_FILES['pic3']['name'];
    $pic4 = $_FILES['pic4']['name'];
    $pic5 = $_FILES['pic5']['name'];
    $pic6 = $_FILES['pic6']['name'];
    
    $target1 = "../../../images/roomdetail/".basename($pic1);
    $target2 = "../../../images/roomdetail/".basename($pic2);
    $target3 = "../../../images/roomdetail/".basename($pic3);
    $target4 = "../../../images/roomdetail/".basename($pic4);
    $target5 = "../../../images/roomdetail/".basename($pic5);
    $target6 = "../../../images/roomdetail/".basename($pic6);
    
    $sql = "UPDATE roomdetail SET water_bill = $water, elec_bill = $elec, cable_charge = $cable, fines = $fines, detail = '$detail'  WHERE type = '$type' ";
    if ($conn->query($sql) === TRUE) {
      for($i = 1;$i<=6;$i++){
        $pic = ${'pic'.$i};
        $target = ${'target'.$i};
        if($pic != ""){
          $sql2 = "UPDATE roomdetail SET pic$i = '$pic' WHERE type = '$type' ";
          if(move_uploaded_file($_FILES['pic'.$i]['tmp_name'], $target)){
            if ($conn->query($sql2) === TRUE) {
                
            } else {
              echo "Error updating record: " . $conn->error;
            }
          }
        }
      }
      echo "<script>";
      echo "alert('แก้ไขข้อมูลสำเร็จ');";
      echo "window.history.back()";
      echo "</script>";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
    echo $type;
    echo "<br>";
    echo $water;
    echo "<br>";
    echo $elec;
    echo "<br>";
    echo $cable;
    echo "<br>";
    echo $fines;
    echo "<br>";
    echo $detail;
    
    
    // $sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
    
    $conn->close();
  }
}else{
  Header("Location: ../../../login.php"); 
}

?>