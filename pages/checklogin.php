<?php
session_start();
if(isset($_POST['login'])){
    include('connection.php');
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM login WHERE username = '$user' AND password = MD5('$pass')";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)==1){
        $row = mysqli_fetch_array($result);
        $_SESSION['ID'] = $row['username'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['level'] = $row['level'];
        
        if($_SESSION['level'] == 'admin'){
            Header("Location: admin/index.php");
        }
        else if($_SESSION['level'] == 'employee'){
            Header("Location: employee/index.php");
        }else if($_SESSION['level'] == 'guest'){
            Header("Location: guest/index.php");
        }else{
        echo "<script>";
        echo "alert('บัญชีผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');"; 
        echo "window.history.back();";
        echo "</script>";
        }
    }else{
        echo "<script>";
        echo "alert('บัญชีผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');"; 
        echo "window.history.back();";
        echo "</script>";
    }
}


?>