<?php
session_start();
if($_SESSION['level'] == 'employee'){
  if(isset($_POST['accept'])){
    include('../../../connection.php');
    $type = $_REQUEST['type'];
    if($type == "fan"){
      $type_show = "พัดลม";
    }else if($type == "air"){
      $type_show = "แอร์";
    }
    $water = $_POST['water_bill'];
    $elec = $_POST['elec_bill'];
    $cable = $_POST['cable_charge'];
    $fines = $_POST['fines'];
    if(isset($_POST['sv_fan'])){
      $sv_fan = $_POST['sv_fan'];
    }else{
      $sv_fan = null;
    }
    if(isset($_POST['sv_air'])){
      $sv_air = $_POST['sv_air'];
    }else{
      $sv_air = null;
    }
    if(isset($_POST['sv_wifi'])){
      $sv_wifi = $_POST['sv_wifi'];
    }else{
      $sv_wifi = null;
    }
    if(isset($_POST['sv_furniture'])){
      $sv_furniture = $_POST['sv_furniture'];
    }else{
      $sv_furniture = null;
    }
    if(isset($_POST['sv_readtable'])){
      $sv_readtable = $_POST['sv_readtable'];
    }else{
      $sv_readtable = null;
    }
    $sql = "UPDATE roomdetail SET water_bill = $water, elec_bill = $elec, cable_charge = $cable, fines = $fines, sv_fan ='$sv_fan', sv_air ='$sv_air', sv_wifi ='$sv_wifi', sv_furniture ='$sv_furniture', sv_readtable ='$sv_readtable'  WHERE type = '$type_show' ";
    if ($conn->query($sql) === TRUE) {
      echo "<script>";
      echo "alert('แก้ไขข้อมูลสำเร็จ');";
      echo "location.href = '../detail.php?type=$type'";
      echo "</script>";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
    // echo $type;
    // echo "<br>";
    // echo $water;
    // echo "<br>";
    // echo $elec;
    // echo "<br>";
    // echo $cable;
    // echo "<br>";
    // echo $fines;
    // echo "<br>";
    // echo "w".$sv_fan;
    // echo "<br>";
    // echo "x".$sv_air;
    // echo "<br>";
    // echo "y".$sv_wifi;
    // echo "<br>";
    // echo "z".$sv_furniture;
    // echo "<br>";
    // echo "zz".$sv_readtable;
    
    // $sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
    
    $conn->close();
  }
}else{
  Header("Location: ../../../login.php"); 
}

?>