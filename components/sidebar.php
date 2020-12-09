<?php
// session_start();
// if($_SESSION['level'] == 'admin'){
    
// ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pingfah/css/navbar.css">
    <title>Pingfah</title>
</head>

<body onload="menubar()">
    <div >
        <div class="sidebar">
            <div class="logo_box">
                <img src="/Pingfah/img/logo.png" alt="logo" class="logo">
            </div>
            <ul>
                <a href="/Pingfah/pages/admin/index.php">
                    <li id="main">หน้าหลัก</li>
                </a>
                <a href="/Pingfah/pages/admin/employee/index.php">
                    <li id="employee">จัดการพนักงาน</li>
                </a>
                <li class="dropdown-btn">
                    ข้อมูลหอพัก
                    <div id="arrow-down" class="arrow-down"></div>
                    <div id="arrow-up" class="arrow-up" style="display:none;"></div>
                </li>
                <div id="dropdown" class="dropdown-container">
                    <ul>
                        <a href="/Pingfah/pages/admin/roomDetail/index.php">
                            <li id="roomdetail">- ประเภทห้องพัก</li>
                        </a>
                        <a href="/Pingfah/pages/admin/gallery/index.php">
                            <li id="gallery">- แกลลอรี่</li>
                        </a>
                    </ul>
                </div>
                <a href="/Pingfah/pages/admin/roomList/index.php">
                    <li id="roomlist">รายการห้องพัก</li>
                </a>
                <a href="/Pingfah/pages/admin/daily/index.php">
                    <li id="daily">รายการเช่ารายวัน</li>
                </a>
                <li class="dropdown-btn2">
                    รายการชำระเงิน 
                    <div id="arrow-down2" class="arrow-down"></div>
                    <div id="arrow-up2" class="arrow-up" style="display:none;"></div>
                </li>
                <div id="dropdown2" class="dropdown-container">
                    <ul>
                        <a href="/Pingfah/pages/admin/dailyCost/index.php">
                            <li id="dailycost">- รายวัน</li>
                        </a>
                        <a href="/Pingfah/pages/admin/cost/index.php">
                            <li id="cost">- รายเดือน</li>
                        </a>
                    </ul>
                </div>
                <a href="/Pingfah/pages/admin/repair/index.php">
                    <li id="repair">รายการแจ้งซ่อม</li>
                </a>
                <a href="/Pingfah/pages/admin/package/index.php">
                    <li id="package">รายการพัสดุ</li>
                </a>
                <a href="/Pingfah/pages/admin/rule/index.php">
                    <li id="rule">กฎระเบียบหอพัก</li>
                </a>
                <a href="/Pingfah/pages/admin/appeal/index.php">
                    <li id="appeal">รายการร้องเรียน</li>
                </a>
                <a href="/Pingfah/pages/logout.php">
                    <li class="logout">ออกจากระบบ</li>
                </a>
            </ul>
        </div>
        <div class="topbar">
            <div style="padding:16px 24px">
                <h3 id="topbar-page"></h3>
            </div>
            <div class="profile">
                <img src="https://sites.google.com/site/rabbiteieicom/_/rsrc/1467891358746/home/image8.jpg"
                    alt="profile_logo" class="profile-logo">
                <p class="profile-text">ยินดีต้อนรับ <?php echo $_SESSION['name']; ?></p>
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