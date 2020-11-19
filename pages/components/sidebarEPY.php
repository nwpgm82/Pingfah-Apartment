<?php
session_start();
if($_SESSION['level'] == 'employee'){
    include('../connection.php');
    $user = $_SESSION['ID'];
    $get_data = "SELECT * FROM employee WHERE username = '$user'";
    $result = $conn->query($get_data);
    $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="/Pingfah/css/navbar.css">
    <title>Document</title>
</head>

<body>
    <div id="app">
        <div class="sidebar">
            <div class="logo_box">
                <img src="/Pingfah/img/logo.png" alt="logo" class="logo">
            </div>
            <ul>
                <a :href="i.link" v-for="(i,index) in menuList" :key="index"><li :id="i.id">{{i.text}}</li></a>
                <a href="/Pingfah/pages/logout.php"><li class="logout">ออกจากระบบ</li></a>
            </ul>
        </div>
        <div class="topbar">
            <div style="padding:16px 24px">
              <h3 id="topbar-page"></h3>  
            </div>
            <div class="profile">
                <img src="/Pingfah/pages/images/employee/<?php echo $row['profile_img']; ?>"
                    alt="profile_logo" class="profile-logo">
                <p class="profile-text">ยินดีต้อนรับ <?php echo $row['firstname']; ?></p>
            </div>
        </div>
    </div>



    <!--- JavaScript Field --->
    <script src="/Pingfah/js/sidebarEPY.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../login.php");
}