<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../connection.php");
    function DateThai($strDate){
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    $from = @$_REQUEST["from"];
    $to = @$_REQUEST["to"];
    $check = @$_REQUEST["style"];
    if(isset($from) && isset($to)){
        $query = "SELECT come_date, COALESCE(SUM(member_cat = 'รายเดือน'),0) AS month_total, COALESCE(SUM(member_cat = 'รายวัน')) AS daily_total FROM roommember WHERE come_date BETWEEN '$from' AND '$to' GROUP BY come_date ORDER BY come_date ASC";
    }else{
        $query = "SELECT come_date, COALESCE(SUM(member_cat = 'รายเดือน'),0) AS month_total, COALESCE(SUM(member_cat = 'รายวัน')) AS daily_total FROM roommember GROUP BY come_date ORDER BY come_date ASC";
    }
    $query_result = mysqli_query($conn, $query);
    $datax = array();
    foreach ($query_result as $k) {
        $datax[] = "['".DateThai($k['come_date'])."',".$k['daily_total'].",".$k['month_total']."]";
    }
    $datax = implode(",", $datax);
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/history.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <script src="../../../js/admin/history.js"></script>
    <title>Document</title>
</head>

<body>
    <?php include("../../../components/sidebar.php"); ?>
    <div class="box">
        <div style="padding:24px;">
            <div class="history-box">
                <h3>ค้นหาประวัติการเข้าพัก</h3>
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
                            <button type="button" id="searchHistory" style="margin-left:16px;">ค้นหา</button>
                            <?php
                            if(isset($from) || isset($to) || isset($check)){
                            ?>
                            <div style="padding:0 16px;">
                                <a href="roomHistory.php"><button type="button" class="cancel-sort">ยกเลิกการกรองทั้งหมด</button></a>
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
                        <div id="columnchart_material1" class="chart"></div>
                        <?php 
                        }else{
                            echo "<p style='margin:auto;'>ไม่มีข้อมูล</p>";
                        } 
                        ?>
                    </div>
                    <div class="hr"></div>
                    <div>
                        <h3>รายการประวัติการเข้าพักทั้งหมด</h3>
                        <?php
                        $perpage = 10;
                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                        }else{
                            $page = 1;
                        }
                        $start = ($page - 1) * $perpage;
                        $num = $start + 1;
                        if(isset($from) && isset($to) && !isset($check)){
                            $sql = "SELECT member_id, room_id, come_date, out_date, member_cat, member_status, name_title, firstname, lastname FROM roommember WHERE come_date BETWEEN '$from' AND '$to' ORDER BY come_date DESC";
                        }else if(!isset($from) && !isset($to) && isset($check)){
                            if($check == "daily"){
                                $check_s = "รายวัน";
                            }else if($check == "month"){
                                $check_s = "รายเดือน";
                            }
                            $sql = "SELECT member_id, room_id, come_date, out_date, member_cat, member_status, name_title, firstname, lastname FROM roommember WHERE member_cat = '$check_s' ORDER BY come_date DESC";
                        }else if(isset($from) && isset($to) && isset($check)){
                            if($check == "daily"){
                                $check_s = "รายวัน";
                            }else if($check == "month"){
                                $check_s = "รายเดือน";
                            }
                            $sql = "SELECT member_id, room_id, come_date, out_date, member_cat, member_status, name_title, firstname, lastname FROM roommember WHERE come_date BETWEEN '$from' AND '$to' AND member_cat = '$check_s' ORDER BY come_date DESC";
                        }else{
                            $sql = "SELECT member_id, room_id, come_date, out_date, member_cat, member_status, name_title, firstname, lastname FROM roommember ORDER BY come_date DESC";
                        }
                        $result = $conn->query($sql);
                        ?>
                        <div style="display:flex;align-items:center;">
                            <div style="padding:32px 16px 32px 0;display: flex;align-items: center;">
                                <input type="checkbox" id="all" <?php if(!isset($check)){ echo "checked"; } ?>>
                                <label for="scales">ทั้งหมด</label>
                            </div>
                            <div style="padding:32px 16px;display: flex;align-items: center;">
                                <input type="checkbox" id="daily_check" <?php if($check == "daily"){ echo "checked"; } ?>>
                                <label for="scales">รายวัน</label>
                            </div>
                            <div style="padding:32px 16px;display: flex;align-items: center;">
                                <input type="checkbox" id="month_check" <?php if($check == "month"){ echo "checked"; } ?>>
                                <label for="scales">รายเดือน</label>
                            </div>
                        </div>
                        <?php
                        if($result->num_rows > 0){
                        ?>
                        <table>
                            <tr>
                                <th>ลำดับ</th>
                                <th>เลขห้อง</th>
                                <th>ชื่อผู้พัก</th>
                                <th>วันที่เข้าพัก</th>
                                <th>วันที่ออกจากที่พัก</th>
                                <th>ลักษณะ</th>
                                <th>สถานะ</th>
                                <th>เพิ่มเติม</th>
                            </tr>
                            <?php
                            while($row = $result->fetch_assoc()){
                            ?>
                            <tr>
                                <td><?php echo $num; ?></td>
                                <td><?php echo $row["room_id"]; ?></td>
                                <td><?php echo $row["name_title"].$row["firstname"] ." " .$row["lastname"]; ?></td>
                                <td><?php echo DateThai($row["come_date"]); ?></td>
                                <td><?php if(isset($row["out_date"])){ echo DateThai($row["out_date"]); } ?></td>
                                <td><img id="cat"
                                    src="<?php if($row['member_cat'] == 'รายวัน'){ echo '../../../img/tool/clock-icon.png'; }else if($row['member_cat'] == 'รายเดือน'){ echo '../../../img/tool/calendar-icon.png'; } ?>"
                                    alt="category-icon" title="<?php if($row['member_cat'] == 'รายวัน'){ echo "รายวัน"; }else if($row['member_cat'] == 'รายเดือน'){ echo "รายเดือน"; } ?>"></td>
                                <td><?php echo $row["member_status"]; ?></td>
                                <td>
                                    <div class="option-grid">
                                        <a href="memberDetail.php?member_id=<?php echo $row["member_id"];?>"><button>ดูข้อมูลเพิ่มเติม</button></a>
                                        <button class="del-btn" id="<?php echo $row["member_id"]; ?>"></button>
                                    </div>
                                </td>
                            </tr>
                            <?php $num++; } ?>
                        </table>
                        <?php
                         ///////pagination
                        $sql2 = "SELECT * FROM roommember";
                        $query2 = mysqli_query($conn, $sql2);
                        $total_record = mysqli_num_rows($query2);
                        $total_page = ceil($total_record / $perpage);
                        ?>
                        <div style="display:flex;justify-content:flex-end">
                            <div class="pagination">
                                <?php
                                if(isset($from) && isset($to) && !isset($check)){
                                ?>
                                <a href="roomHistory.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page=1">&laquo;</a>
                                <?php for($i=1;$i<=$total_page;$i++){ ?>
                                <a href="roomHistory.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page=<?php echo $i; ?>"
                                    <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                                <?php } ?>
                                <a href="roomHistory.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                                <?php
                                }else if(!isset($from) && !isset($to) && isset($check)){
                                ?>
                                <a href="roomHistory.php?style=<?php echo $check; ?>&page=1">&laquo;</a>
                                <?php for($i=1;$i<=$total_page;$i++){ ?>
                                <a href="roomHistory.php?style=<?php echo $check; ?>&page=<?php echo $i; ?>"
                                    <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                                <?php } ?>
                                <a href="roomHistory.php?style=<?php echo $check; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                                <?php
                                }else if(isset($from) && isset($to) && isset($check)){
                                ?>
                                <a href="roomHistory.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&style=<?php echo $check; ?>&page=1">&laquo;</a>
                                <?php for($i=1;$i<=$total_page;$i++){ ?>
                                <a href="roomHistory.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&style=<?php echo $check; ?>&page=<?php echo $i; ?>"
                                    <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                                <?php } ?>
                                <a href="roomHistory.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&style=<?php echo $check; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                                <?php
                                }else{
                                ?>
                                <a href="roomHistory.php?page=1">&laquo;</a>
                                <?php for($i=1;$i<=$total_page;$i++){ ?>
                                <a href="roomHistory.php?page=<?php echo $i; ?>"
                                    <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                                <?php } ?>
                                <a href="roomHistory.php?page=<?php echo $total_page; ?>">&raquo;</a>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        }else{
                            echo "<div style='padding-top:32px;'>ไม่มีรายการประวัติการเข้าพัก</div>"; 
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            ['วัน / เดือน / ปี', 'รายวัน (ห้อง)', 'รายเดือน (ห้อง)'],
            <?php echo $datax;?>
        ]);
        var options = {
            title: 'จำนวนการเข้าพักในแต่ละวัน',
            colors: ['rgb(131, 120, 47)', '#c6b66b'],
            fontName: "Sarabun",
            vAxis: {
                format: "decimal"
            }
        };
        var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    </script>
</body>

</html>
<?php
}else{
    Header("Location : ../../login.php");
}