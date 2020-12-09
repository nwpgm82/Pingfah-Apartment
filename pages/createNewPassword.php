<?php
include("connection.php");
$email = $_REQUEST["email"];
$sql = "SELECT * FROM login WHERE email = '$email'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/resetPass.css">
    <title>Document</title>
</head>

<body>
    <div class="resetPass">
        <a href="../index.php"><img src="../img/main_logo.png" alt=""></a>
        <form method="POST">
            <h3>รีเซ็ตรหัสผ่าน</h3>
            <div>
                <p>รหัสผ่านใหม่ / New password</p>
                <input type="password" name="pass">
            </div>
            <div>
                <p>ยืนยันรหัสผ่าน / Confirm password</p>
                <input type="password" name="confirm-pass">
            </div>
            <div style="padding-top:32px;display:flex;justify-content:flex-end;align-items:flex-end;">
                <button type="submit" name="confirm-reset">ยืนยัน</button>
            </div>
        </form>
    </div>
</body>

</html>
<?php } ?>
<?php 
if(isset($_POST["confirm-reset"])){
    if($_POST["pass"] == $_POST["confirm-pass"]){
        $resetPass = "UPDATE login SET password = md5('".$_POST["pass"]."') WHERE email = '$email'";
        if($conn->query($resetPass) === TRUE){
            echo "<script>";
            echo "alert('รีเซ็ตรหัสผ่านเรียบร้อยแล้ว');";
            echo "location.href = 'login.php';";
            echo "</script>";
        }else{
            echo "Error: " . $resetPass . "<br>" . $conn->error;
        }
    }else{
        echo "<script>";
        echo "alert('รหัสผ่านไม่ตรงกัน');";
        echo "</script>";
    }
}
?>