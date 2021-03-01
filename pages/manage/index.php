<?php 
session_start();
if($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'employee' || $_SESSION['level'] == 'guest'){
    include('../connection.php');
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strMonthThai $strYear";
    }
    function DateThai2($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
        $query = "SELECT date, SUM(total) as totalPrice FROM cost GROUP BY date ORDER BY date";
        $query2 = "SELECT b.check_in ,SUM(a.total_allprice) as daily_price FROM dailycost a INNER JOIN daily b ON a.dailycost_id = b.daily_id GROUP BY b.check_in";
        $query3 = "SELECT repair_category, COUNT(repair_category) as total_cate FROM repair GROUP BY repair_category";
        $query4 = "SELECT repair_status, COUNT(repair_status) as total_cate_status FROM repair GROUP BY repair_status";
    }else if($_SESSION["level"] == "guest"){
        $query = "SELECT date, SUM(total) as totalPrice FROM cost WHERE member_id = ".$_SESSION["member_id"]." GROUP BY date ORDER BY date";
        $query3 = "SELECT repair_category, COUNT(repair_category) as total_cate FROM repair WHERE member_id = ".$_SESSION["member_id"]." GROUP BY repair_category";
        $query4 = "SELECT repair_status, COUNT(repair_status) as total_cate_status FROM repair WHERE member_id = ".$_SESSION["member_id"]." GROUP BY repair_status";
    }
    $result = mysqli_query($conn, $query);
    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
        $result2 = mysqli_query($conn, $query2);
    }
    $result3 = mysqli_query($conn, $query3);
    $result4 = mysqli_query($conn, $query4);
    //echo $query;
    $datax = array();
    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
        $datax2 = array();
    }
    $datax3 = array();
    $datax4 = array();
    foreach ($result as $k) {
        $datax[] = "['".DateThai($k['date'])."'".", ".$k['totalPrice']."]";
    }
    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
        foreach ($result2 as $j) {
            $datax2[] = "['".DateThai2($j['check_in'])."'".", ".$j['daily_price']."]";
        }
    }
    foreach ($result3 as $l) {
      $datax3[] = "['".$l['repair_category']."'".", ".$l['total_cate']."]";
    }
    foreach ($result4 as $m) {
      $datax4[] = "['".$m['repair_status']."'".", ".$m['total_cate_status']."]";
    }
    //cut last commar
    $datax = implode(",", $datax);
    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
        $datax2 = implode(",", $datax2);
    }
    $datax3 = implode(",", $datax3);
    $datax4 = implode(",", $datax4);
    // echo $datax;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/home.css">
    <link rel="stylesheet" href="../../css/my-style.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../js/datedropper.pro.min.js"></script>
    <script src="../../js/sidebar.js"></script>
    <title>Pingfah Apartment</title>
</head>

<body>
    <?php include('../../components/sidebar.php'); ?>
    <div class="box">
        <div id="box-padding" style="padding:24px;">
            <div class="home-box">
                <h3>Overview Dashboard</h3>
                <div class="hr"></div>
                <div class="grid">
                    <?php
                    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
                    ?>
                    <div class="card">
                        <div class="detail" style="border-bottom:none;">
                            <div>
                                <h4>รายได้ทั้งหมด</h4>
                                <?php
                                    $sql = mysqli_query($conn,"SELECT SUM(total) as total_cost FROM cost");
                                    $sql2 = mysqli_query($conn,"SELECT SUM(total_allprice) as total_cost2 FROM dailycost");
                                    $sql3 = mysqli_query($conn,"SELECT SUM(repair_profit) as total_cost3 FROM repair");
                                    $data = mysqli_fetch_assoc($sql);  
                                    $data2 = mysqli_fetch_assoc($sql2);
                                    $data3 = mysqli_fetch_assoc($sql3);
                                    $total_ALL = $data['total_cost'] + $data2['total_cost2'] + $data3['total_cost3'];
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
                                    $sql = mysqli_query($conn,"SELECT SUM(total) as total_cost FROM cost WHERE date = '".date("Y-m")."' AND cost_status = 'ชำระเงินแล้ว'");
                                    $sql2 = mysqli_query($conn,"SELECT SUM(a.total_allprice) as total_dailycost FROM dailycost a INNER JOIN daily b ON a.dailycost_id = b.daily_id WHERE YEAR(b.check_in) = '".date("Y")."' AND MONTH(b.check_in) = '".date("m")."'");
                                    $sql3 = mysqli_query($conn,"SELECT SUM(repair_profit) as total_repaircost FROM repair WHERE YEAR(repair_successdate) = '".date("Y")."' AND MONTH(repair_successdate) = '".date("m")."'");
                                    $datam = mysqli_fetch_assoc($sql);  
                                    $datam2 = mysqli_fetch_assoc($sql2);
                                    $datam3 = mysqli_fetch_assoc($sql3);
                                    $total_cost = floatval($datam['total_cost']) + floatval($datam2['total_dailycost']) + floatval($datam3['total_repaircost']);
                                    ?>
                                    <p id="total_cost"><?php echo number_format($total_cost); ?> บาท</p>
                                </div>
                            </div>
                            <div class="search-box">
                                <input type="text" id="cost-month" type="submit" name="searchcost">
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
                        <a href="roomList/index.php?Status=avai_all">
                            <div class="search-box">
                                <p class="dateText1">ห้องว่างทั้งหมด</p>
                            </div>
                        </a>
                        <div class="icon-box">
                            <img src="../../img/tool/room_available.png" alt="">
                        </div>
                    </div>
                    <div class="card">
                        <div class="detail" <?php if($_SESSION["level"] == "employee"){ echo "style='border-bottom:none;'"; } ?>>
                            <div>
                                <h4>จำนวนพนักงาน</h4>
                                <?php
                                    $employee = mysqli_query($conn,"SELECT COUNT(*) as total_em FROM employee");
                                    $em = mysqli_fetch_assoc($employee);  
                                    ?>
                                <p><?php echo $em['total_em']; ?> คน</p>
                            </div>
                        </div>
                        <?php
                        if($_SESSION["level"] == "admin"){
                        ?>
                        <a href="employee/index.php">
                            <div class="search-box">
                                <p class="dateText1">พนักงานทั้งหมด</p>
                            </div>
                        </a>
                        <?php } ?>
                        <div class="icon-box">
                            <img src="../../img/tool/employee_icon.png" alt="">
                        </div>
                    </div>
                    <?php } ?>
                    <div class="card">
                        <div class="detail">
                            <div>
                                <h4>จำนวนที่ค้างชำระ</h4>
                                <?php
                                    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
                                        $overdue_cost = mysqli_query($conn,"SELECT COUNT(*) as total_overdue FROM cost WHERE cost_status != 'ชำระเงินแล้ว'");
                                    }else if($_SESSION["level"] == "guest"){
                                        $overdue_cost = mysqli_query($conn,"SELECT COUNT(*) as total_overdue FROM cost WHERE cost_status != 'ชำระเงินแล้ว' AND member_id = ".$_SESSION["member_id"]);
                                    }
                                    $overdue = mysqli_fetch_assoc($overdue_cost);  
                                    ?>
                                <p><?php echo $overdue['total_overdue']; ?> รายการ</p>
                            </div>
                        </div>
                        <a href="cost/index.php?status=unsuccess">
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
                                    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
                                        $package_cost = mysqli_query($conn,"SELECT COUNT(*) as total_package FROM package WHERE package_status = 'ยังไม่ได้รับพัสดุ'");
                                    }else if($_SESSION["level"] == "guest"){
                                        $package_cost = mysqli_query($conn,"SELECT COUNT(*) as total_package FROM package WHERE package_status = 'ยังไม่ได้รับพัสดุ' AND member_id = ".$_SESSION["member_id"]);
                                    }
                                    $package = mysqli_fetch_assoc($package_cost);  
                                    ?>
                                <p><?php echo $package['total_package']; ?> ชิ้น</p>
                            </div>
                        </div>
                        <a href="package/index.php?status=unsuccess">
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
                                <h4>รายการแจ้งซ่อมที่รอการซ่อม</h4>
                                <?php
                                    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
                                        $repair = mysqli_query($conn,"SELECT COUNT(*) as total_repair FROM repair WHERE repair_status != 'ซ่อมเสร็จแล้ว'");
                                    }else if($_SESSION["level"] == "guest"){
                                        $repair = mysqli_query($conn,"SELECT COUNT(*) as total_repair FROM repair WHERE repair_status != 'ซ่อมเสร็จแล้ว' AND member_id = ".$_SESSION["member_id"]);
                                    }
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
                    <?php
                    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
                    ?>
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
                    <?php } ?>
                </div>
                <div class="chart-grid" <?php if($_SESSION["level"] == "guest"){  echo 'style="grid-template-areas:'."'a a' 'c c'".'"'; } ?>>
                    <div class="card2 a">
                        <?php
                        if(strlen($datax) != 0){
                        ?>
                        <div id="columnchart_material1" class="chart"></div>
                        <?php 
                        }else{
                            echo "<p style='margin:auto;'>ไม่มีข้อมูลชำระเงินห้องพักรายเดือน</p>";
                        }
                        ?>
                    </div>
                    <?php
                    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
                    ?>
                    <div class="card2 b">
                        <?php
                        if(strlen($datax2) != 0){
                        ?>
                        <div id="curve_chart" class="chart"></div>
                        <?php 
                        }else{
                            echo "<p style='margin:auto;'>ไม่มีข้อมูลชำระเงินห้องพักรายวัน</p>";
                        }
                        ?>
                    </div>
                    <?php } ?>
                    <div class="card2 c">
                        <div class="sub-grid">
                            <?php
                            if(strlen($datax3) != 0){
                            ?>
                            <div id="piechart" class="chart"></div>
                            <?php 
                            }else{
                                echo "<p style='margin:auto;'>ไม่มีข้อมูลการแจ้งซ่อมแยกตามประเภท</p>";
                            } ?>
                            <?php
                            if(strlen($datax4) != 0){
                            ?>
                            <div id="piechart2" class="chart"></div>
                            <?php 
                            }else{
                                echo "<p style='margin:auto;'>ไม่มีข้อมูลการแจ้งซ่อมแยกตามสถานะ</p>";
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.load("current", {
        packages: ["line"]
    });
    <?php
    if(strlen($datax) != 0){
    ?>
    google.charts.setOnLoadCallback(drawChart);
    <?php } ?>
    <?php
    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
    ?>
    google.charts.setOnLoadCallback(drawChart2);
    <?php } ?>
    google.charts.setOnLoadCallback(drawChart3);
    google.charts.setOnLoadCallback(drawChart4);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['เดือน / ปี', 'ยอดรวมทั้งหมด (บาท)'],
            <?php echo $datax;?>
        ]);
        var options = {
            title: 'รายการชำระเงินห้องพักรายเดือน',
            colors: ['rgb(131, 120, 47)', '#c6b66b', '#ffefab'],
            fontName: "Sarabun",
            vAxis: {
                format: "decimal"
            }
        };
        var chart = new google.charts.Line(document.getElementById('columnchart_material1'));

        chart.draw(data, google.charts.Line.convertOptions(options));
    }
    <?php
    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
    ?>
    function drawChart2() {

        var data = google.visualization.arrayToDataTable([
            ['วัน / เดือน / ปี', 'รายได้ (บาท)'],
            <?php echo $datax2;?>
        ]);

        var options = {
            title: 'รายการชำระเงินรายวัน',
            colors: ['rgb(131, 120, 47)'],
            fontName: "Sarabun",
            vAxis: {
                format: "decimal"
            }
        };

        var chart = new google.charts.Line(document.getElementById('curve_chart'));
        chart.draw(data, google.charts.Line.convertOptions(options));
    }
    <?php } ?>

    function drawChart3() {

        var data = google.visualization.arrayToDataTable([
            ['ประเภท', 'รายการ'],
            <?php echo $datax3;?>
        ]);

        var options = {
            title: 'รายการแจ้งซ่อมแยกตามประเภท',
            is3D: true,
            fontName: "Sarabun",
            slices: {
                0: {
                    color: 'rgb(131, 120, 47)'
                },
                1: {
                    color: '#c6b66b'
                },
                2: {
                    color: '#e5d170'
                }
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }

    function drawChart4() {

        var data = google.visualization.arrayToDataTable([
            ['ประเภท', 'รายการ'],
            <?php echo $datax4;?>
        ]);

        var options = {
            title: 'รายการแจ้งซ่อมแยกตามสถานะ',
            is3D: true,
            fontName: "Sarabun",
            slices: {
                0: {
                    color: 'rgb(131, 120, 47)'
                },
                1: {
                    color: '#c6b66b'
                },
                2: {
                    color: '#e5d170'
                }
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart.draw(data, options);
    }
    $(window).resize(function(){
        drawChart();
        drawChart2();
        drawChart3();
        drawChart4();
    });
    </script>
    <script src="../../js/home.js"></script>
    <!-- <script src="../../js/costGraph.js"></script> -->
</body>

</html>
<?php
}else{
    Header("Location: ../login.php");   
}