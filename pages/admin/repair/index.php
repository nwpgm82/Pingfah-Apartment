<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
    $from = @$_REQUEST['from'];
    $to = @$_REQUEST['to'];
    $check = @$_REQUEST['Status'];
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    $query = "SELECT repair_category, COUNT(repair_category) as total_cate FROM repair GROUP BY repair_category";
    $query2 = "SELECT repair_status, COUNT(repair_status) as total_cate_status FROM repair GROUP BY repair_status";
    $result = mysqli_query($conn, $query);
    $result2 = mysqli_query($conn, $query2);
    $datax = array();
    $datax2 = array();
    foreach ($result as $k) {
        $datax[] = "['".$k['repair_category']."'".", ".$k['total_cate']."]";
    }
    foreach ($result2 as $l) {
        $datax2[] = "['".$l['repair_status']."'".", ".$l['total_cate_status']."]";
    }
    $datax = implode(",", $datax);
    $datax2 = implode(",", $datax2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/repair.css">
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
            <div class="repair-box">
                <div class="card">
                    <div class="sub-grid">
                        <div id="piechart" class="chart"></div>
                        <div id="piechart2" class="chart"></div>
                    </div>
                </div>
                <div class="hr"></div>
                <div>
                    <h3>ค้นหารายการแจ้งซ่อม</h3>
                    <div style="padding-top:32px">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <div style="display:flex;align-items:center;">
                                <label>ค้นหาตามวันที่</label>
                                <div style="position:relative;">
                                    <input type="text" id="date_from" class="roundtrip-input"
                                        value="<?php echo $from; ?>">
                                    <p id="from_date" class="dateText"></p>
                                </div>
                                <label>~</label>
                                <div style="position:relative;">
                                    <input type="text" id="date_to" class="roundtrip-input" value="<?php echo $to; ?>">
                                    <p id="to_date" class="dateText"></p>
                                </div>
                                <button type="button" onclick="searchDate()">ค้นหา</button>
                            </div>
                            <a href="addRepair.php"><button>เพิ่มรายการแจ้งซ่อม</button></a>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <h3>รายการแจ้งซ่อมทั้งหมด</h3>
                    <div style="display:flex;align-items:center;">
                        <div style="padding:32px 16px;">
                            <input type="checkbox" id="success"
                                onchange="<?php if(isset($from) && isset($to)){ echo "searchCheck2('$from','$to',this.id)"; }else{ echo "searchCheck(this.id)"; } ?>"
                                <?php if(isset($check)){ if($check == "success"){ echo "checked";}} ?>>
                            <label for="scales">ดำเนินการเสร็จสิ้น</label>
                        </div>
                        <div style="padding:32px 16px;">
                            <input type="checkbox" id="inprogress"
                                onchange="<?php if(isset($from) && isset($to)){ echo "searchCheck2('$from','$to',this.id)"; }else{ echo "searchCheck(this.id)"; } ?>"
                                <?php if(isset($check)){ if($check == "inprogress"){ echo "checked";}} ?>>
                            <label for="scales">กำลังดำเนินการ</label>
                        </div>
                        <div style="padding:32px 16px;">
                            <input type="checkbox" id="pending"
                                onchange="<?php if(isset($from) && isset($to)){ echo "searchCheck2('$from','$to',this.id)"; }else{ echo "searchCheck(this.id)"; } ?>"
                                <?php if(isset($check)){ if($check == "pending"){ echo "checked";}} ?>>
                            <label for="scales">รอดำเนินการ</label>
                        </div>
                        <button onclick="unCheckAll()">ยกเลิกการกรองทั้งหมด</button>
                    </div>
                    <?php
                    $perpage = 5;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $perpage;
                    if(isset($from) && isset($to) && !isset($check)){
                        $sql = "SELECT * FROM repair WHERE (repair_date BETWEEN '$from' AND '$to') ORDER BY repair_date";
                    }else if(!isset($from) && !isset($to) && isset($check)){
                        if($check == "success"){
                            $check = "ดำเนินการเสร็จสิ้น";
                        }else if($check == "inprogress"){
                            $check = "กำลังดำเนินการ";
                        }else if($check == "pending"){
                            $check = "รอดำเนินการ";
                        }
                        $sql = "SELECT * FROM repair WHERE repair_status = '$check' ORDER BY repair_date LIMIT {$start} , {$perpage}";
                    }else if(isset($from) && isset($to) && isset($check)){
                        if($check == "success"){
                            $check = "ดำเนินการเสร็จสิ้น";
                        }else if($check == "inprogress"){
                            $check = "กำลังดำเนินการ";
                        }else if($check == "pending"){
                            $check = "รอดำเนินการ";
                        }
                        $sql = "SELECT * FROM repair WHERE (repair_date BETWEEN '$from' AND '$to') AND repair_status = '$check' ORDER BY repair_date LIMIT {$start} , {$perpage}";   
                    }else{
                        $sql = "SELECT * FROM repair ORDER BY repair_date LIMIT {$start} , {$perpage} ";
                    }
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                ?>
                    <table>
                        <tr>
                            <th>เลขห้อง</th>
                            <th>อุปกรณ์</th>
                            <th>หมวดหมู่</th>
                            <th>รายละเอียด</th>
                            <th>เวลาที่ลง</th>
                            <th>สถานะ</th>
                            <th>เพิ่มเติม</th>
                        </tr>
                        <?php while($row = $result->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $row['room_id']; ?></td>
                            <td><?php echo $row['repair_appliance']; ?></td>
                            <td><?php echo $row['repair_category']; ?></td>
                            <td><?php echo $row['repair_detail']; ?></td>
                            <td><?php echo DateThai($row['repair_date']); ?></td>
                            <td>
                                <?php
                                if($row['repair_status'] == 'รอดำเนินการ'){
                            ?>
                                <div class="pending-status">
                                    <p><?php echo $row['repair_status']; ?></p>
                                </div>
                                <?php
                                }else if($row['repair_status'] == 'กำลังดำเนินการ'){
                            ?>
                                <div class="inprogress-status">
                                    <p><?php echo $row['repair_status']; ?></p>
                                </div>
                                <?php
                                }else if($row['repair_status'] == 'ดำเนินการเสร็จสิ้น'){
                            ?>
                                <div class="success-status">
                                    <p><?php echo $row['repair_status']; ?></p>
                                </div>
                                <?php
                                }else{
                                    echo "error!";
                                }
                            ?>
                            </td>
                            <td class="flex-more">
                                <div>
                                    <a
                                        href="../repair/repairDetail.php?room_id=<?php echo $row['room_id'];?>&repairappliance=<?php echo $row['repair_appliance'];?>&repaircategory=<?php echo $row['repair_category'];?>&repairdate=<?php echo $row['repair_date'];?>"><button>ดูข้อมูลเพิ่มเติม</button></a>
                                </div>
                                <div>
                                    <button class="del-btn"
                                        onclick="repair_del(<?php echo "'".$row['room_id']."','".$row['repair_appliance']."','".$row['repair_category']."','".$row['repair_date']."'"?>)">ลบ</button>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
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
                        if(isset($date) && !isset($check)){
                        ?>
                            <a href="index.php?Date=<?php echo $date; ?>&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Date=<?php echo $date; ?>&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Date=<?php echo $date; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                        }else if(!isset($date) && isset($check)){
                        ?>
                            <a href="index.php?Status=<?php echo $check; ?>&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=<?php echo $check; ?>&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=<?php echo $check; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                        }else if(isset($date) && isset($check)){
                        ?>
                            <a
                                href="index.php?Date=<?php echo $date; ?>&Status=<?php echo $check; ?>&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Date=<?php echo $date; ?>&Status=<?php echo $check; ?>&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a
                                href="index.php?Date=<?php echo $date; ?>&Status=<?php echo $check; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
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
                    echo "<div style='margin:32px 0'>ไม่มีรายการแจ้งซ่อม</div>";
                }
                ?>
                </div>

            </div>
        </div>
    </div>
    <script src="../../../js/admin/repair.js"></script>
    <script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart2);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['ประเภท', 'รายการ'],
            <?php echo $datax;?>
        ]);
        var options = {
            title: 'รายการแจ้งซ่อมแยกตามประเภท',
            is3D: true,
            fontName: "Sarabun"
            // colors: ['rgb(131, 120, 47)']
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }

    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['ประเภท', 'รายการ'],
            <?php echo $datax2;?>
        ]);
        var options = {
            title: 'รายการแจ้งซ่อมแยกตามสถานะ',
            is3D: true,
            fontName: "Sarabun"
            // colors: ['rgb(131, 120, 47)']
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart.draw(data, options);
    }
    </script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>