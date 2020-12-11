<?php
include("../connection.php");
// $query = mysqli_query($conn,"SELECT SUM(total) as total_cost WHERE date = '".$_POST['value']."'");
// $result = mysqli_fetch_assoc($query);
// $data = $result['total_cost'];
// echo "<script>alert('".$data['total_cost']."');</script>";
if(isset($_POST['searchcost'])){
    $sql = mysqli_query($conn,"SELECT SUM(total) as total_cost FROM cost WHERE date = '".$_POST['value']."'");
    $data = mysqli_fetch_assoc($sql);  
    echo $data['total_cost'];
}

?>