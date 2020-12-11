<?php 
session_start();
if($_SESSION['level'] == 'admin'){
    include('../connection.php');
    include('../../components/sidebar.php');
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strMonthThai $strYear";
    }
    $query = "SELECT date ,SUM(case WHEN cost_status = 'ชำระเงินแล้ว' THEN total ELSE 0 END) as total_price, SUM(case WHEN cost_status = 'ยังไม่ได้ชำระ' THEN total ELSE 0 END) as untotal_price FROM cost GROUP BY date";
    $result = mysqli_query($conn, $query);

    //echo $query;
    $datax = array();
    foreach ($result as $k) {
      $datax[] = "['".DateThai($k['date'])."'".", ".$k['total_price'] ."," .$k['untotal_price'] ."]";
    }

    //cut last commar
    $datax = implode(",", $datax);
    echo $datax;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/home.css">
    <link rel="stylesheet" href="../../css/my-style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../js/datedropper.pro.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="home-box">
                <h3>Overview</h3>
                <div class="hr"></div>
                <div class="grid">
                    <div class="card">
                        <div class="detail">
                            <div>
                                <h4>รายได้ทั้งหมด</h4>
                                <?php
                                    $sql = mysqli_query($conn,"SELECT SUM(total) as total_cost FROM cost");
                                    $sql2 = mysqli_query($conn,"SELECT SUM(price_total) as total_cost2 FROM dailycost");
                                    $data = mysqli_fetch_assoc($sql);  
                                    $data2 = mysqli_fetch_assoc($sql2);
                                    $total_ALL = $data['total_cost'] + $data2['total_cost2'];
                                    ?>
                                <p><?php echo number_format($total_ALL); ?> บาท</p>
                            </div>
                        </div>
                        <div class="icon-box">
                            <img src="../../img/main_logo.png" alt="">
                        </div>
                    </div>
                    <div class="card">
                        <form id="search-cost-month" action="">
                            <div class="detail">
                                <div>
                                    <h4>รายได้ต่อเดือน</h4>
                                    <?php
                                    $sql = mysqli_query($conn,"SELECT SUM(total) as total_cost FROM cost WHERE date = '".date("Y-m")."'");
                                    $data = mysqli_fetch_assoc($sql);  
                                    ?>
                                    <p id="total_cost"><?php echo number_format($data['total_cost']); ?> บาท</p>
                                </div>
                            </div>
                            <div class="search-box">
                                <input type="text" id="cost-month" type="subtmit" name="searchcost">
                                <div id="arrow-down" class="arrow-down"></div>
                                <p class="dateText1">รายได้เดือน : </p>
                                <p id="month-detail" class="dateText2"></p>
                            </div>
                            <div class="icon-box">
                                <img src="../../img/tool/cash.png" alt="">
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="detail">
                            <div>
                                <h4>จำนวนห้องว่าง</h4>
                                <?php
                                    $available_room = mysqli_query($conn,"SELECT COUNT(*) as total_room FROM roomlist WHERE room_status = 'ว่าง'");
                                    $room = mysqli_fetch_assoc($available_room);  
                                    ?>
                                <p><?php echo $room['total_room']; ?> ห้อง</p>
                            </div>
                        </div>
                        <a href="roomlist/index.php?Status=available">
                            <div class="search-box">
                                <p class="dateText1">ห้องว่างทั้งหมด</p>
                            </div>
                        </a>
                        <div class="icon-box">
                            <img src="../../img/tool/room_available.png" alt="">
                        </div>
                    </div>
                    <div class="card">
                        <div class="detail">
                            <div>
                                <h4>จำนวนพนักงาน</h4>
                                <?php
                                    $employee = mysqli_query($conn,"SELECT COUNT(*) as total_em FROM employee");
                                    $em = mysqli_fetch_assoc($employee);  
                                    ?>
                                <p><?php echo $em['total_em']; ?> คน</p>
                            </div>
                        </div>
                        <a href="employee/index.php">
                            <div class="search-box">
                                <p class="dateText1">พนักงานทั้งหมด</p>
                            </div>
                        </a>
                        <div class="icon-box">
                            <img src="../../img/tool/employee_icon.png" alt="">
                        </div>
                    </div>
                    <div class="card">
                        <div class="detail">
                            <div>
                                <h4>จำนวนที่ค้างชำระ</h4>
                                <?php
                                    $overdue_cost = mysqli_query($conn,"SELECT COUNT(*) as total_overdue FROM cost WHERE cost_status = 'ยังไม่ได้ชำระ'");
                                    $overdue = mysqli_fetch_assoc($overdue_cost);  
                                    ?>
                                <p><?php echo $overdue['total_overdue']; ?> รายการ</p>
                            </div>
                        </div>
                        <a href="cost/index.php?Status=unsuccess">
                            <div class="search-box">
                                <p class="dateText1">รายการค้างชำระทั้งหมด</p>
                            </div>
                        </a>
                        <div class="icon-box">
                            <img src="../../img/tool/overdue.png" alt="">
                        </div>
                    </div>
                    <div class="card">
                        <div class="detail">
                            <div>
                                <h4>พัสดุที่ยังไม่ได้รับ</h4>
                                <?php
                                    $package_cost = mysqli_query($conn,"SELECT COUNT(*) as total_package FROM package WHERE package_status = 'ยังไม่ได้รับพัสดุ'");
                                    $package = mysqli_fetch_assoc($package_cost);  
                                    ?>
                                <p><?php echo $package['total_package']; ?> ชิ้น</p>
                            </div>
                        </div>
                        <a href="package/index.php?Status=unsuccess">
                            <div class="search-box">
                                <p class="dateText1">รายการพัสดุที่ยังไม่ได้รับทั้งหมด</p>
                            </div>
                        </a>
                        <div class="icon-box">
                            <img src="../../img/tool/package.png" alt="">
                        </div>
                    </div>
                    <div class="card">
                        <div class="detail">
                            <div>
                                <h4>รายการแจ้งซ่อม</h4>
                                <?php
                                    $repair = mysqli_query($conn,"SELECT COUNT(*) as total_repair FROM repair");
                                    $repair_total = mysqli_fetch_assoc($repair);  
                                    ?>
                                <p><?php echo $repair_total['total_repair']; ?> รายการ</p>
                            </div>
                        </div>
                        <a href="repair/index.php">
                            <div class="search-box">
                                <p class="dateText1">รายการแจ้งซ่อมทั้งหมด</p>
                            </div>
                        </a>
                        <div class="icon-box">
                            <img src="../../img/tool/repair.png" alt="">
                        </div>
                    </div>
                    <div class="card">
                        <div class="detail">
                            <div>
                                <h4>รายการเช่ารายวัน (วันนี้)</h4>
                                <?php
                                    $daily = mysqli_query($conn,"SELECT COUNT(*) as total_daily FROM daily WHERE check_in = '".date("Y-m-d")."' AND check_out = '".date("Y-m-d")."'");
                                    $daily_total = mysqli_fetch_assoc($daily);  
                                    ?>
                                <p><?php echo $daily_total['total_daily']; ?> รายการ</p>
                            </div>
                        </div>
                        <a href="daily/index.php">
                            <div class="search-box">
                                <p class="dateText1">รายการเช่ารายวันทั้งหมด</p>
                            </div>
                        </a>
                        <div class="icon-box">
                            <img src="../../img/tool/daily.png" alt="">
                        </div>
                    </div>
                </div>
                <!-- <div class="grid">
                    <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
                </div> -->
            </div>
        </div>
    </div>

    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['เดือน', 'ชำระเงินแล้ว', 'ยังไม่ได้ชำระ'],
            <?php echo $datax;?>
        ]);

        var options = {
            title: 'รายการชำระรายเดือน',
            colors: ['rgb(131, 120, 47)', '#a8a06d']
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    </script>
    <script src="../../js/home.js"></script>
    <!-- <script src="../../js/costGraph.js"></script> -->
</body>

</html>
<?php
}else{
    Header("Location: ../login.php");   
}