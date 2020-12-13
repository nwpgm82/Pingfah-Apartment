<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include("../../connection.php");
    include("../../../components/sidebar.php");
    $check_in = @$_REQUEST['check_in'];
    $check_out = @$_REQUEST['check_out'];
    $code = @$_REQUEST['Code'];
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
    if($check_in != "" && $check_out != ""){
        $query = "SELECT check_in ,SUM(price_total) as daily_price FROM dailycost WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out )) GROUP BY check_in";
    }else{
        $query = "SELECT check_in ,SUM(price_total) as daily_price FROM dailycost GROUP BY check_in";
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="dailycost-box">
                <h3>ค้นหารายการชำระเงินรายวัน</h3>
                <div class="search">
                    <div style="padding-right:16px;">
                        <div style="display:flex;align-items:center;">
                            <label>ค้นหาตามวันที่</label>
                            <div style="position:relative;">
                                <input type="text" class="roundtrip-input" id="check_in"
                                    value="<?php echo $check_in; ?>" required>
                                <p id="check_in_date" class="dateText"></p>
                            </div>
                            <label>~</label>
                            <div style="position:relative;">
                                <input type="text" class="roundtrip-input" id="check_out"
                                    value="<?php echo $check_out; ?>" required>
                                <p id="check_out_date" class="dateText"></p>
                            </div>
                            <button type="button" onclick="searchDate()">ค้นหา</button>
                        </div>
                    </div>
                    <div style="padding-right:16px;">
                        <label>ค้นหาเลขในการจอง</label>
                        <input type="text" id="code" value="<?php echo $code?>">
                        <button type="button" onclick="searchCode()">ค้นหา</button>
                    </div>
                    <div>
                        <a href="index.php"><button type="button">ยกเลิกการกรองทั้งหมด</button></a>
                    </div>
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
                <table class="fixed">
                    <tr>
                        <th style="width:4%">ลำดับ</th>
                        <th style="width:15%">เลขห้องที่จอง</th>
                        <th style="width:18%">ชื่อผู้เช่า</th>
                        <th style="width:18%">วันที่เข้าพัก</th>
                        <th style="width:10%">เลขที่ในการจอง</th>
                        <th style="width:8%">ราคารวม</th>
                        <th style="width:12%">สถานะการชำระเงิน</th>
                        <th style="width:15%">เพิ่มเติม</th>
                    </tr>
                    <?php
                        while($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $num; ?></td>
                        <td><?php echo $row['room_id']; ?></td>
                        <td><?php echo $row['firstname'] ." " .$row['lastname']; ?></td>
                        <td><?php echo DateThai($row['check_in']) ."&nbsp; ~ &nbsp;" .DateThai($row['check_out']); ?>
                        </td>
                        <td><?php echo $row['code']; ?></td>
                        <td><?php echo $row['price_total']; ?></td>
                        <td><button class="status-success"><?php echo $row['daily_status']; ?></button></td>
                        <td>
                            <a
                                href="dailyCostDetail.php?dailycost_id=<?php echo $row['dailycost_id']; ?>"><button>รายละเอียด</button></a>
                            <button type="button" class="del"
                                onclick="delDailyCost(<?php echo $row['dailycost_id']; ?>)">ลบ</button>
                        </td>
                    </tr>
                    <?php $num++; } ?>
                </table>
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
            ['วัน / เดือน / ปี', 'รายได้'],
            <?php echo $datax;?>
        ]);

        var options = {
            title: 'รายการชำระเงินรายวัน',
            colors: ['rgb(131, 120, 47)'],
            fontName: "Sarabun"
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    </script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>