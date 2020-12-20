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
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    $query_data = "SELECT repair_successdate, SUM(repair_income) as income, SUM(repair_expenses) as expenses FROM repair WHERE repair_status = 'ซ่อมเสร็จแล้ว' GROUP BY repair_successdate";
    $result = mysqli_query($conn, $query_data);
    $datax = array();
    foreach ($result as $k) {
        $datax[] = "['".DateThai($k['repair_successdate'])."'".", ".$k['income'] ."," .$k['expenses'] ."]";
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
                <h3>ค้นหารายการแจ้งซ่อม</h3>
                <div style="padding-top:32px;display:flex;justify-content:space-between;align-items:center;">
                    <div style="display:flex;align-items:center;">
                        <label>ค้นหาตามวันที่</label>
                        <div style="position:relative;">
                            <input type="text" id="date_from" class="roundtrip-input" value="<?php echo $from; ?>">
                            <p id="from_date" class="dateText"></p>
                        </div>
                        <label>~</label>
                        <div style="position:relative;">
                            <input type="text" id="date_to" class="roundtrip-input" value="<?php echo $to; ?>">
                            <p id="to_date" class="dateText"></p>
                            <button type="button" style="margin:0 8px;" onclick="searchDate()">ค้นหา</button>
                        </div>
                        <?php
                        if(isset($from) || isset($to)){
                        ?>
                        <button class="cancel-sort" style="margin:0 8px;" onclick="unCheckAll()">ยกเลิกการกรองทั้งหมด</button>
                        <?php } ?>
                    </div>
                    <a href="addRepair.php"><button>เพิ่มรายการแจ้งซ่อม</button></a>
                </div>
                <div class="hr"></div>
                <div>
                    <div class="card">
                        <?php
                        if(strlen($datax) != 0){
                        ?>
                        <div id="columnchart_material1" class="chart"></div>
                        <?php }else{  echo "<p style='margin:auto;'>ไม่มีข้อมูล</p>"; } ?>
                    </div>
                    <div class="hr"></div>
                    <h3>รายการแจ้งซ่อมทั้งหมด</h3>
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
                            <th>เวลาที่ซ่อมเสร็จ</th>
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
                            <td><?php echo DateThai($row['repair_successdate']); ?></td>
                            <td>
                                <div class="success-status">
                                    <p><?php echo $row['repair_status']; ?></p>
                                </div>
                            </td>
                            <td>
                                <div class="flex-more">
                                    <a href="repairDetail.php?repair_id=<?php echo $row['repair_id'];?>"><button>ดูข้อมูลเพิ่มเติม</button></a>
                                    <button class="del-btn" onclick="repair_del(<?php echo $row['repair_id']; ?>)">ลบ</button>
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
        'packages': ['bar']
    });
    <?php
    if(strlen($datax) != 0){
    ?>
    google.charts.setOnLoadCallback(drawChart);
    <?php } ?>

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['วัน / เดือน / ปี', 'รายได้ (บาท)', 'รายจ่าย (บาท)'],
            <?php echo $datax;?>
        ]);

        var options = {
            title: 'ค่าใช้จ่ายจากการแจ้งซ่อม',
            colors: ['rgb(131, 120, 47)', '#c6b66b'],
            fontName: "Sarabun",
            vAxis: { format: "decimal"}
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    </script>
</body>

</html>
<?php
}else{
    header("Location : ../../login.php");
}