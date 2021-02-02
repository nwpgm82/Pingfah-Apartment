<?php
session_start();
if($_SESSION['level'] == 'admin'){
  if(isset($_POST['accept'])){
    include('../../../connection.php');
    $type = $_REQUEST['type'];
    if($type == "fan"){
      $type_show = "พัดลม";
    }else if($type == "air"){
      $type_show = "แอร์";
    }
    $daily_price = $_POST['daily_price'];
    $daily_deposit = $_POST['daily_deposit'];
    $daily_tax = $_POST['daily_tax'];
    $price = $_POST['price'];
    $water = $_POST['water_bill'];
    $elec = $_POST['elec_bill'];
    $cable = $_POST['cable_charge'];
    $fines = $_POST['fines'];
    if(isset($_POST['sv_fan'])){
      $sv_fan = $_POST['sv_fan'];
    }else{
      $sv_fan = "off";
    }
    if(isset($_POST['sv_air'])){
      $sv_air = $_POST['sv_air'];
    }else{
      $sv_air = "off";
    }
    if(isset($_POST['sv_wifi'])){
      $sv_wifi = $_POST['sv_wifi'];
    }else{
      $sv_wifi = "off";
    }
    if(isset($_POST['sv_furniture'])){
      $sv_furniture = $_POST['sv_furniture'];
    }else{
      $sv_furniture = "off";
    }
    if(isset($_POST['sv_readtable'])){
      $sv_readtable = $_POST['sv_readtable'];
    }else{
      $sv_readtable = "off";
    }
    if(isset($_POST['sv_telephone'])){
      $sv_telephone = $_POST['sv_telephone'];
    }else{
      $sv_telephone = "off";
    }
    if(isset($_POST['sv_television'])){
      $sv_television = $_POST['sv_television'];
    }else{
      $sv_television = "off";
    }
    if(isset($_POST['sv_refrigerator'])){
      $sv_refrigerator = $_POST['sv_refrigerator'];
    }else{
      $sv_refrigerator = "off";
    }
    if(isset($_POST['sv_waterbottle'])){
      $sv_waterbottle = $_POST['sv_waterbottle'];
    }else{
      $sv_waterbottle = "off";
    }
    if(isset($_POST['sv_toilet'])){
      $sv_toilet = $_POST['sv_toilet'];
    }else{
      $sv_toilet = "off";
    }
    if(isset($_POST['sv_hairdryer'])){
      $sv_hairdryer = $_POST['sv_hairdryer'];
    }else{
      $sv_hairdryer = "off";
    }
    if(isset($_POST['sv_towel'])){
      $sv_towel = $_POST['sv_towel'];
    }else{
      $sv_towel = "off";
    }
    $sql = "UPDATE roomdetail SET water_bill = $water, elec_bill = $elec, cable_charge = $cable, fines = $fines, price = $price, daily_price = $daily_price, daily_deposit = $daily_deposit, daily_tax = $daily_tax, sv_fan ='$sv_fan', sv_air ='$sv_air', sv_wifi ='$sv_wifi', sv_furniture ='$sv_furniture', sv_readtable ='$sv_readtable', sv_telephone = '$sv_telephone', sv_television = '$sv_television', sv_refrigerator = '$sv_refrigerator', sv_waterbottle = '$sv_waterbottle', sv_toilet = '$sv_toilet', sv_hairdryer = '$sv_hairdryer', sv_towel = '$sv_towel' WHERE type = '$type_show' ";
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