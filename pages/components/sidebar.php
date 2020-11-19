<?php
// session_start();
// if($_SESSION['level'] == 'admin'){
    
// ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="/Pingfah/css/navbar.css">
    <title>Pingfah</title>
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
                <img src="https://sites.google.com/site/rabbiteieicom/_/rsrc/1467891358746/home/image8.jpg"
                    alt="profile_logo" class="profile-logo">
                <p class="profile-text">ยินดีต้อนรับ <?php echo $_SESSION['ID']; ?></p>
            </div>
        </div>
    </div>



    <!--- JavaScript Field --->
    <script src="/Pingfah/js/sidebar.js"></script>
</body>

</html>
<?php
// }else{
//     Header("Location: ../login.php");
// }
?>