<?php
session_start();
if($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'employee'){
    include('../../connection.php');
    $check_in = @$_REQUEST['check_in'];
    $check_out = @$_REQUEST['check_out'];
    $code = @$_REQUEST['code'];
    $check = @$_REQUEST['status'];
    $num = 1;
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    if($check_in != "" && $check_out != ""){
        $query = "SELECT check_in, SUM(people) as total_people FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out )) AND daily_status != 'ยกเลิกการจอง' GROUP BY check_in ORDER BY check_in ASC";
        $query2 = "SELECT check_in, SUM(air_room) as total_air, SUM(fan_room) as total_fan FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out )) AND daily_status != 'ยกเลิกการจอง' GROUP BY check_in ORDER BY check_in ASC";
    }else{
        $query = "SELECT check_in, SUM(people) as total_people FROM daily WHERE daily_status != 'ยกเลิกการจอง' GROUP BY check_in ORDER BY check_in ASC";
        $query2 = "SELECT check_in, SUM(air_room) as total_air, SUM(fan_room) as total_fan FROM daily WHERE daily_status != 'ยกเลิกการจอง' GROUP BY check_in ORDER BY check_in ASC";
    }
    $query_result = mysqli_query($conn, $query);
    $query_result2 = mysqli_query($conn, $query2);
    $datax = array();
    $datax2 = array();
    foreach ($query_result as $k) {
        $datax[] = "['".DateThai($k['check_in'])."'".",".$k['total_people']."]";
    }
    foreach ($query_result2 as $l) {
        $datax2[] = "['".DateThai($l['check_in'])."'".",".$l['total_air'] ."," .$l['total_fan'] ."]";
    }
    $datax = implode(",", $datax);
    $datax2 = implode(",", $datax2);
    // echo $datax;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/daily.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <link rel="stylesheet" href="../../../css/navbar.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <script src="../../../js/sidebar.js"></script>
    <title>Pingfah Apartment</title>
</head>

<body>
    <?php include('../../../components/sidebar.php'); ?>
    <div class="box">
        <div id="box-padding" style="padding:24px;">
            <div class="daily-box">
                <h3>ค้นหารายการเช่ารายวัน</h3>
                <div class="search">
                    <label class="search-topic" style="padding:10px 8px 0 0;">ค้นหาตามวันที่</label>
                    <div class="from-box" style="position:relative;">
                        <input type="text" class="roundtrip-input" id="check_in"
                            value="<?php if(isset($check_in)){ echo DateThai($check_in); } ?>">
                        <h5 id="checkIn_error" style="color:red;"></h5>
                    </div>
                    <label class="to-text" style="padding:10px 8px 0 8px;">~</label>
                    <div class="to-box" style="position:relative;">
                        <input type="text" class="roundtrip-input" id="check_out"
                            value="<?php if(isset($check_out)){ echo DateThai($check_out); } ?>">
                        <h5 id="checkOut_error" style="color:red;"></h5>
                    </div>
                    <button class="search-btn" type="button" id="searchDate">ค้นหา</button>
                    <label class="searchcode-topic" style="padding:10px 8px 0 0;">ค้นหาเลขที่ในการจอง</label>
                    <div class="searchcode-box" >
                        <input type="text" id="code" value="<?php echo $code?>">
                        <h5 id="code_error" style="color:red;"></h5>
                    </div>
                    <button class="searchcode-btn" type="button" id="searchCode">ค้นหา</button>
                    <?php
                    if(isset($check_in) || isset($check_out) || isset($check) || isset($code)){
                    ?>
                    <div class="cancel-box">
                        <a href="index.php"><button type="button" class="cancel-sort">ยกเลิกการกรองทั้งหมด</button></a>
                    </div>
                    <?php } ?>
                </div>
                <div class="hr"></div>
                <div>
                    <div class="card">
                        <div class="sub-grid">
                            <?php
                            if(strlen($datax) != 0){
                            ?>
                            <div id="curve_chart" class="chart"></div>
                            <?php 
                            }else{
                                echo "<p style='margin:auto;'>ไม่มีข้อมูล</p>";
                            } 
                            ?>
                            <?php
                            if(strlen($datax2) != 0){
                            ?>
                            <div id="columnchart_material2" class="chart"></div>
                            <?php
                            }else{
                                echo "<p style='margin:auto;'>ไม่มีข้อมูล</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div>
                        <?php
                    $perpage = 10;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $perpage;
                    $num = $start + 1;
                    if(isset($check_in) && isset($check_out) && !isset($check)){
                        $sql = "SELECT * FROM daily WHERE (check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out ) LIMIT {$start} , {$perpage}";
                    }else if(!isset($check_in) && !isset($check_out) && isset($check)){
                        if($check == "come"){
                            $check_s = "เข้าพักแล้ว";
                        }else if($check == "checkout"){
                            $check_s = "เช็คเอาท์แล้ว";
                        }else if($check == "pending"){
                            $check_s = "รอการเข้าพัก";
                        }else if($check == "waiting"){
                            $check_s = "รอการยืนยัน";
                        }else if($check == "cancel"){
                            $check_s = "ยกเลิกการจอง";
                        }
                        $sql = "SELECT * FROM daily WHERE daily_status = '$check_s' LIMIT {$start} , {$perpage}";
                    }else if(isset($check_in) && isset($check_out) && isset($check)){
                        if($check == "come"){
                            $check_s = "เข้าพักแล้ว";
                        }else if($check == "checkout"){
                            $check_s = "เช็คเอาท์แล้ว";
                        }else if($check == "pending"){
                            $check_s = "รอการเข้าพัก";
                        }else if($check == "waiting"){
                            $check_s = "รอการยืนยัน";
                        }else if($check == "cancel"){
                            $check_s = "ยกเลิกการจอง";
                        }
                        $sql = "SELECT * FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out )) AND daily_status = '$check_s' LIMIT {$start} , {$perpage}"; 
                    }else if(isset($code)){
                        $sql = "SELECT * FROM daily WHERE code = '$code'";
                    }else{
                        $sql = "SELECT * FROM daily LIMIT {$start} , {$perpage}";
                    }
                    $result = $conn->query($sql);
                    if(isset($code)){
                        echo "<h3 style='padding-bottom:32px;'>ผลลัพธ์การค้นหา : $code</h3>";
                    }else{
                        echo "<h3>รายการเช่าห้องพักทั้งหมด</h3>";
                    }
                    ?>
                    <?php
                    if(!isset($code)){
                    ?>
                        <div class="checkbox-grid">
                            <div style="padding:32px 16px 32px 0;display: flex;align-items: center;">
                                <input type="checkbox" id="all" <?php if(!isset($check)){ echo "checked";} ?>>
                                <label for="scales">ทั้งหมด</label>
                            </div>
                            <div style="padding:32px 16px;display: flex;align-items: center;">
                                <input type="checkbox" id="waiting"
                                    <?php if(isset($check)){ if($check == "waiting"){ echo "checked";}} ?>>
                                <label for="scales">รอการยืนยัน</label>
                            </div>
                            <div style="padding:32px 16px;display: flex;align-items: center;">
                                <input type="checkbox" id="pending"
                                    <?php if(isset($check)){ if($check == "pending"){ echo "checked";}} ?>>
                                <label for="scales">รอการเข้าพัก</label>
                            </div>
                            <div style="padding:32px 16px;display: flex;align-items: center;">
                                <input type="checkbox" id="come"
                                    <?php if(isset($check)){ if($check == "come"){ echo "checked";}} ?>>
                                <label for="scales">เข้าพักแล้ว</label>
                            </div>
                            <div style="padding:32px 16px;display: flex;align-items: center;">
                                <input type="checkbox" id="checkout"
                                    <?php if(isset($check)){ if($check == "checkout"){ echo "checked";}} ?>>
                                <label for="scales">เช็คเอาท์แล้ว</label>
                            </div>
                            <div style="padding:32px 16px;display: flex;align-items: center;">
                                <input type="checkbox" id="cancel"
                                    <?php if(isset($check)){ if($check == "cancel"){ echo "checked";}} ?>>
                                <label for="scales">ยกเลิกการจอง</label>
                            </div>
                        </div>
                        <?php } ?>
                        <?php
                        if ($result->num_rows > 0) {
                        ?>
                        <div style="overflow-x: auto;overflow-y: hidden;">
                            <table>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>ชื่อผู้เช่า</th>
                                    <th>วันที่เข้าพัก</th>
                                    <!-- <th>จำนวนผู้พัก (ท่าน)</th>
                                    <th>ห้องแอร์ (ห้อง)</th>
                                    <th>ห้องพัดลม (ห้อง)</th> -->
                                    <th>เลขที่ในการจอง</th>
                                    <th>สถานะ</th>
                                    <th>เพิ่มเติม</th>
                                </tr>
                                <?php
                                while($row = $result->fetch_assoc()) {
                                ?>
                                <form action="function/acceptRent.php?daily_id=<?php echo $row["daily_id"]; ?>" method="POST">
                                    <tr>
                                        <td><?php echo $num; ?></td>
                                        <td><?php echo $row['name_title'].$row['firstname'] ." " .$row['lastname']; ?></td>
                                        <td><?php echo DateThai($row['check_in']) ."&nbsp; ~ &nbsp;" .DateThai($row['check_out']) ." (".$row['night']." คืน)"?></td>
                                        <td><?php echo $row['code']; ?></td>
                                        <td><?php if($row['daily_status'] == 'เข้าพักแล้ว'){ echo "<button type='button' class='confirmed-btn'>เข้าพักแล้ว</button>"; }else if($row['daily_status'] == "เช็คเอาท์แล้ว"){ echo "<button type='button' class='checkoutStatus-btn'>เช็คเอาท์แล้ว</button>"; }else if($row['daily_status'] == "ยกเลิกการจอง"){ echo "<button type='button' class='canceldaily-btn'>ยกเลิกการจอง</button>"; }else if($row['daily_status'] == "รอการเข้าพัก"){ echo "<button type='button' class='pending-btn'>รอการเข้าพัก</button>"; }else{ echo "<button type='button' class='waiting-btn'>รอการยืนยัน</button>";} ?></td>
                                        <td>
                                            <div class="option-grid">
                                                <?php
                                                if($row['daily_status'] == 'รอการยืนยัน'){
                                                ?>
                                                    <button type="submit" class="acceptRent-btn">ยืนยัน</button>
                                                
                                                <?php
                                                }else if($row['daily_status'] == 'รอการเข้าพัก'){
                                                ?>
                                                    <a href="selectroom.php?daily_id=<?php echo $row['daily_id']; ?>"><button type="button" class="select_room">เลือกห้อง</button></a>
                                                <?php 
                                                }else if($row['daily_status'] == 'เข้าพักแล้ว'){
                                                ?>
                                                    <a href="confirm_checkout.php?daily_id=<?php echo $row["daily_id"]; ?>"><button type="button" class="checkout-btn">เช็คเอาท์</button></a>
                                                <?php 
                                                }
                                                ?>
                                                <?php
                                                if($row["daily_status"] != "รอการยืนยัน" && $row["daily_status"] != "ยกเลิกการจอง"){
                                                ?>
                                                <a href="receipt_deposit.php?code=<?php echo $row["code"]; ?>" target="_blank"><button type="button" class="print">ค่ามัดจำห้องพัก</button></a>
                                                <?php 
                                                }else{ 
                                                ?>
                                                <button type="button" class="un-print">ค่ามัดจำห้องพัก</button>
                                                <?php } ?>
                                                <a href="dailyDetail.php?daily_id=<?php echo $row['daily_id']; ?>"><button type="button">รายละเอียด</button></a>
                                                <button type="button" class="del-btn" id="<?php echo $row['daily_id']; ?>"></button>
                                            </div>
                                        </td>
                                    </tr>
                                </form>
                                <?php $num++; } ?>
                            </table>
                        </div>
                        <?php
                        ///////pagination
                        if(isset($check_in) && isset($check_out) && !isset($check)){
                            $sql2 ="SELECT * FROM daily WHERE (check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out )";
                        }else if(!isset($check_in) && !isset($check_out) && isset($check)){
                            $sql2 = "SELECT * FROM daily WHERE daily_status = '$check_s'";
                        }else if(isset($check_in) && isset($check_out) && isset($check)){
                            $sql2 = "SELECT * FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out )) AND daily_status = '$check_s'";   
                        }else{
                            $sql2 = "SELECT * FROM daily";
                        }
                        $query2 = mysqli_query($conn, $sql2);
                        $total_record = mysqli_num_rows($query2);
                        $total_page = ceil($total_record / $perpage);
                        ?>
                        <div style="display:flex;justify-content:flex-end">
                            <div class="pagination">
                                <?php
                                if(isset($check_in) && isset($check_out) && !isset($check)){
                                ?>
                                <a href="index.php?check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out;?>&page=1">&laquo;</a>
                                <?php for($i=1;$i<=$total_page;$i++){ ?>
                                <a href="index.php?check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out;?>&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                                <?php } ?>
                                <a href="index.php?check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out;?>&page=<?php echo $total_page; ?>">&raquo;</a>
                                <?php
                                }else if(!isset($check_in) && !isset($check_out) && isset($check)){
                                ?>
                                <a href="index.php?status=<?php echo $check; ?>&page=1">&laquo;</a>
                                <?php for($i=1;$i<=$total_page;$i++){ ?>
                                <a href="index.php?status=<?php echo $check; ?>&page=<?php echo $i; ?>"
                                    <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                                <?php } ?>
                                <a href="index.php?status=<?php echo $check; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                                <?php
                                }else if(isset($check_in) && isset($check_out) && isset($check)){
                                ?>
                                <a href="index.php?check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out;?>&status=<?php echo $check; ?>&page=1">&laquo;</a>
                                <?php for($i=1;$i<=$total_page;$i++){ ?>
                                <a href="index.php?check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out;?>&status=<?php echo $check; ?>&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                                <?php } ?>
                                <a href="index.php?check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out;?>&status=<?php echo $check; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                                <?php
                                }else{
                                ?>
                                <a href="index.php?page=1">&laquo;</a>
                                <?php for($i=1;$i<=$total_page;$i++){ ?>
                                <a href="index.php?page=<?php echo $i; ?>"
                                    <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                                <?php } ?>
                                <a href="index.php?page=<?php echo $total_page; ?>">&raquo;</a>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        }else{
                            echo "<div style='padding-top:32px;'>ไม่มีรายการเช่ารายวัน</div>";
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="../../../js/manage/daily.js"></script>
    <script>
    google.charts.load("current", {packages: ["line"]});
    google.charts.load('current', {
        'packages': ['bar']
    });
    <?php
    if(strlen($datax) != 0){
    ?>
    google.charts.setOnLoadCallback(drawChart);
    <?php } ?>
    <?php
    if(strlen($datax2) != 0){
    ?>
    google.charts.setOnLoadCallback(drawChart2);
    <?php } ?>

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['วัน / เดือน / ปี', 'จำนวนผู้พัก'],
            ['',0],
            <?php echo $datax;?>
        ]);

        var options = {
            title: 'จำนวนผู้เช่าห้องพักรายวันในแต่ละวัน',
            colors: ['rgb(131, 120, 47)'],
            fontName: "Sarabun",
        };

        var chart = new google.charts.Line(document.getElementById('curve_chart'));
        chart.draw(data, google.charts.Line.convertOptions(options));
    }

    function drawChart2() {

        var data = google.visualization.arrayToDataTable([
            ['วัน / เดือน / ปี','แอร์ (ห้อง)', 'พัดลม (ห้อง)'],
            <?php echo $datax2;?>
        ]);

        var options = {
            title: 'จำนวนผู้เช่าห้องพักรายวันในแต่ละประเภท',
            colors: ['rgb(131, 120, 47)', '#c6b66b'],
            fontName: "Sarabun",
            vAxis: { ticks: [5,10,15,20] }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material2'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    $(window).resize(function(){
        drawChart();
        drawChart2();
    });
    </script>
</body>

</html>

<?php
}else{
    Header("Location: ../../login.php"); 
}
?>