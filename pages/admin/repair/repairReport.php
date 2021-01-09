<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../connection.php");
    include("../../../components/sidebar.php");
    $from = @$_REQUEST['from'];
    $to = @$_REQUEST['to'];
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
    $query_data = "SELECT repair_successdate, SUM(repair_profit) as profit FROM repair WHERE repair_status = 'ซ่อมเสร็จแล้ว' GROUP BY repair_successdate";
    $result = mysqli_query($conn, $query_data);
    $datax = array();
    foreach ($result as $k) {
        $datax[] = "['".DateThai($k['repair_successdate'])."'".", ".$k['profit'] ."]";
    }
    $datax = implode(",", $datax);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/repairReport.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="repairReport-box">
                <h3>ค้นหารายการแจ้งซ่อมที่ซ่อมเสร็จแล้ว</h3>
                <div class="search">
                    <div style="padding-right:16px">
                        <div style="height:57px;display:flex;align-items:flex-start;">
                            <label style="padding:10px 8px 0 0;">ค้นหาตามวันที่</label>
                            <div style="position:relative;">
                                <input type="text" class="roundtrip-input" id="date_from"
                                    value="<?php if(isset($from)){ echo DateThai($from); } ?>">
                                <h5 id="from_error" style="color:red;"></h5>
                            </div>
                            <label style="padding:10px 8px 0 8px;">~</label>
                            <div style="position:relative;">
                                <input type="text" class="roundtrip-input" id="date_to"
                                    value="<?php if(isset($to)){ echo DateThai($to); } ?>">
                                <h5 id="to_error" style="color:red;"></h5>
                            </div>
                            <button type="button" id="searchDate" style="margin-left:16px;">ค้นหา</button>
                            <?php
                            if(isset($from) || isset($to) || isset($check)){
                            ?>
                            <div style="padding:0 16px;">
                                <a href="repairReport.php"><button type="button" class="cancel-sort">ยกเลิกการกรองทั้งหมด</button></a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="hr" style="margin-top:16px;"></div>
                <div>
                    <div class="card">
                        <?php
                        if(strlen($datax) != 0){
                        ?>
                        <div id="curve_chart" class="chart"></div>
                        <?php }else{  echo "<p style='margin:auto;'>ไม่มีข้อมูล</p>"; } ?>
                    </div>
                    <div class="hr"></div>
                    <h3>รายการแจ้งซ่อมที่ซ่อมเสร็จแล้วทั้งหมด</h3>
                    <?php
                    $perpage = 5;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $perpage;
                    $num = $start + 1;
                    if(isset($from) && isset($to)){
                        $sql = "SELECT * FROM repair WHERE (repair_successdate BETWEEN '$from' AND '$to') AND repair_status = 'ซ่อมเสร็จแล้ว' ORDER BY repair_date";
                    }else{
                        $sql = "SELECT * FROM repair WHERE repair_status = 'ซ่อมเสร็จแล้ว' ORDER BY repair_date LIMIT {$start} , {$perpage} ";
                    }
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                ?>
                    <table>
                        <tr>
                            <th>ลำดับ</th>
                            <th>เลขห้อง</th>
                            <th>อุปกรณ์</th>
                            <th>หมวดหมู่</th>
                            <th>รายได้</th>
                            <th>รายจ่าย</th>
                            <th>กำไร</th>
                            <th>วันที่แจ้งซ่อม</th>
                            <th>วันที่ซ่อมเสร็จ</th>
                            <th>สถานะ</th>
                            <th>เพิ่มเติม</th>
                        </tr>
                        <?php while($row = $result->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $num; ?></td>
                            <td><?php echo $row['room_id']; ?></td>
                            <td><?php echo $row['repair_appliance']; ?></td>
                            <td><?php echo $row['repair_category']; ?></td>
                            <td><?php echo $row['repair_income']; ?></td>
                            <td><?php echo $row['repair_expenses']; ?></td>
                            <td><?php echo $row['repair_profit']; ?></td>
                            <td><?php echo DateThai($row['repair_date']); ?></td>
                            <td><?php echo DateThai($row['repair_successdate']); ?></td>
                            <td>
                                <div class="success-status">
                                    <p><?php echo $row['repair_status']; ?></p>
                                </div>
                            </td>
                            <td>
                                <div class="flex-more">
                                    <a href="repairDetail.php?repair_id=<?php echo $row['repair_id'];?>"><button>ดูข้อมูลเพิ่มเติม</button></a>
                                    <button class="del-btn" id="<?php echo $row['repair_id']; ?>" ></button>
                                </div>
                            </td>
                        </tr>
                        <?php $num++; } ?>
                    </table>
                    <?php
                    ///////pagination
                    $sql2 = "SELECT * FROM repair";
                    $query2 = mysqli_query($conn, $sql2);
                    $total_record = mysqli_num_rows($query2);
                    $total_page = ceil($total_record / $perpage);
                    ?>
                    <div style="display:flex;justify-content:flex-end">
                        <div class="pagination">
                            <?php
                            if(isset($from) && isset($to) && !isset($check)){
                            ?>
                            <a
                                href="repairReport.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="repairReport.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a
                                href="repairReport.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else{
                            ?>
                            <a href="repairReport.php?page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="repairReport.php?page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="repairReport.php?page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    }else{
                        echo "<div style='margin:32px 0'>ไม่มีรายการแจ้งซ่อม</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/repairReport.js"></script>
    <script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    <?php
    if(strlen($datax) != 0){
    ?>
    google.charts.setOnLoadCallback(drawChart);
    <?php } ?>

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['วัน / เดือน / ปี', 'กำไรทั้งหมด (บาท)'],
            <?php echo $datax;?>
        ]);

        var options = {
            title: 'ค่าใช้จ่ายจากการแจ้งซ่อม',
            colors: ['rgb(131, 120, 47)'],
            fontName: "Sarabun",
            vAxis: { format: "decimal"}
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
    </script>
</body>

</html>
<?php
}else{
    header("Location : ../../login.php");
}