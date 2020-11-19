<?php
include('../../connection.php');
include('../../components/sidebar.php'); 
if($_SESSION['level'] == 'admin'){
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pingfah/css/appeal.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="appeal-box">
            </div>
        </div>
    </div>
</body>

</html>
<?php
}else{
    if($_SESSION['level'] == 'employee'){
        Header("Location: /Pingfah/pages/employee/appeal/index.php");
    }else{
       Header("Location: ../login.php"); 
    }
}
?>