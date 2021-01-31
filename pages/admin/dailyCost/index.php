<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include("../../connection.php");
    $check_in = @$_REQUEST['check_in'];
    $check_out = @$_REQUEST['check_out'];
    $code = @$_REQUEST['code'];
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
        $query = "SELECT check_in ,SUM(total_price) as daily_price FROM dailycost WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out )) GROUP BY check_in";
    }else{
        $query = "SELECT check_in ,SUM(total_price) as daily_price FROM dailycost GROUP BY check_in";
    }
    
    $query_result = mysqli_query($conn, $query);
    $datax = array();
    foreach ($query_result as $k) {
        $datax[] = "['".DateThai($k['check_in'])."'".", ".$k['daily_price']."]";
    }
    $datax = implode(",", $datax);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/dailyCost.css">
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
    <?php include("../../../components/sidebar.php"); ?>
    <div class="box">
        <div id="box-padding" style="padding:24px;">
            <div class="dailycost-box">
                <h3>ค้นหารายการชำระเงินรายวัน</h3>
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
                    if(isset($check_in) || isset($check_out) || isset($code)){
                    ?>
                    <div class="cancel-box">
                        <a href="index.php"><button type="button" class="cancel-sort">ยกเลิกการกรองทั้งหมด</button></a>
                    </div>
                    <?php } ?>
                </div>
                <div class="hr"></div>
                <div class="card">
                    <?php
                    if(strlen($datax) != 0){
                    ?>
                    <div id="columnchart_material1" class="chart"></div>
                    <?php
                    }else{
                        echo "<p style='margin:auto;'>ไม่มีข้อมูล</p>";
                    }
                    ?>
                </div>
                <div class="hr"></div>
                <?php
                $perpage = 10;
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }else{
                    $page = 1;
                }
                $start = ($page - 1) * $perpage;
                $num = $start + 1;
                if(isset($check_in) && isset($check_out)){
                    $sql = "SELECT * FROM dailycost WHERE (check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out ) LIMIT {$start} , {$perpage}";
                }else if(isset($code)){
                    $sql = "SELECT * FROM dailycost WHERE code = '$code'";
                }else{
                    $sql = "SELECT * FROM dailycost LIMIT {$start} , {$perpage}";
                }
                $result = $conn->query($sql);
                if(isset($code)){
                    echo "<h3>ผลลัพธ์การค้นหา : $code</h3>";
                }else{
                    echo "<h3>รายการชำระเงินห้องพักรายวันทั้งหมด</h3>";
                }
                if ($result->num_rows > 0) {
                ?>
                <div style="overflow-x: auto;overflow-y: hidden;">
                    <table>
                        <tr>
                            <th>ลำดับ</th>
                            <th>เลขห้องที่จอง</th>
                            <th>ชื่อผู้เช่า</th>
                            <th>วันที่เข้าพัก</th>
                            <th>เลขที่ในการจอง</th>
                            <th>ราคารวม</th>
                            <th>สถานะการชำระเงิน</th>
                            <th>เพิ่มเติม</th>
                        </tr>
                        <?php
                            while($row = $result->fetch_assoc()) {
                            $calculate = strtotime($row["check_out"]) - strtotime($row["check_in"]);
                            $night = floor($calculate / 86400);
                        ?>
                        <tr>
                            <td><?php echo $num; ?></td>
                            <td><?php echo $row['room_id']; ?></td>
                            <td><?php echo $row['firstname'] ." " .$row['lastname']; ?></td>
                            <td><?php echo DateThai($row['check_in']) ."&nbsp; ~ &nbsp;" .DateThai($row['check_out'])."(".$night." คืน)"; ?>
                            </td>
                            <td><?php echo $row['code']; ?></td>
                            <td><?php echo $row['total_price']; ?></td>
                            <td><button class="status-success"><?php echo $row['pay_status']; ?></button></td>
                            <td>
                                <div class="option-grid">
                                    <a href="../../receipt_room.php?code=<?php echo $row["code"]; ?>" target="_blank"><button type="button" class="print">ค่าเช่าห้องพัก</button></a> 
                                    <a href="dailyCostDetail.php?dailycost_id=<?php echo $row['dailycost_id']; ?>"><button>รายละเอียด</button></a>
                                    <button type="button" class="del" id="<?php echo $row['daily_id']; ?>"></button>
                                </div>
                            </td>
                        </tr>
                        <?php $num++; } ?>
                    </table>
                </div>
                <?php
                    ///////pagination
                    $sql2 = "SELECT * FROM dailycost";
                    $query2 = mysqli_query($conn, $sql2);
                    $total_record = mysqli_num_rows($query2);
                    $total_page = ceil($total_record / $perpage);
                    ?>
                <div style="display:flex;justify-content:flex-end">
                    <div class="pagination">
                        <a href="index.php?page=1">&laquo;</a>
                        <?php for($i=1;$i<=$total_page;$i++){ ?>
                        <a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php } ?>
                        <a href="index.php?page=<?php echo $total_page; ?>">&raquo;</a>
                    </div>
                </div>
                <?php 
                }else{
                    echo "<div style='padding-top:32px;'>ไม่มีรายการชำระเงินเช่ารายวัน</div>";
                } 
                ?>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/dailyCost.js"></script>
    <script>
    google.charts.load('current', {
        'packages': ['bar']
    });
    <?php
    if(strlen($datax) != 0){
    ?>
    google.charts.setOnLoadCallback(drawChart);
    <?php } ?>
    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['วัน / เดือน / ปี', 'รายได้ (บาท)'],
            <?php echo $datax;?>
        ]);

        var options = {
            title: 'รายการชำระเงินรายวัน',
            colors: ['rgb(131, 120, 47)'],
            fontName: "Sarabun",
            vAxis: { format: "decimal"}
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    $(window).resize(function(){
        drawChart();
    });
    </script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>