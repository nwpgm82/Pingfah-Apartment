<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
    $from = @$_REQUEST['from'];
    $to = @$_REQUEST['to'];
    $check = @$_REQUEST['status'];
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strMonthThai $strYear";
    }
    function DateThai2($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    if(isset($from) && isset($to)){
        $query = "SELECT date ,SUM(case WHEN cost_status = 'ชำระเงินแล้ว' THEN total ELSE 0 END) as total_price, SUM(case WHEN cost_status = 'รอการชำระเงิน' THEN total ELSE 0 END) as pendingtotal_price, SUM(case WHEN cost_status = 'ยังไม่ได้ชำระเงิน' THEN total ELSE 0 END) as untotal_price FROM cost WHERE (date BETWEEN '$from' AND '$to') GROUP BY date";
        $total_cost = mysqli_query($conn,"SELECT SUM(case WHEN cost_status = 'ชำระเงินแล้ว' THEN total ELSE 0 END) as total_cost, SUM(case WHEN cost_status = 'ยังไม่ได้ชำระเงิน' THEN total ELSE 0 END) as untotal_cost FROM cost WHERE (date BETWEEN '$from' AND '$to')");
        $totalresult = mysqli_fetch_assoc($total_cost);
    }else{
        $query = "SELECT date ,SUM(case WHEN cost_status = 'ชำระเงินแล้ว' THEN total ELSE 0 END) as total_price, SUM(case WHEN cost_status = 'รอการชำระเงิน' THEN total ELSE 0 END) as pendingtotal_price, SUM(case WHEN cost_status = 'ยังไม่ได้ชำระเงิน' THEN total ELSE 0 END) as untotal_price FROM cost GROUP BY date ORDER BY date ASC LIMIT 5";
        $total_cost = mysqli_query($conn,"SELECT SUM(case WHEN cost_status = 'ชำระเงินแล้ว' THEN total ELSE 0 END) as total_cost, SUM(case WHEN cost_status = 'รอการชำระเงิน' THEN total ELSE 0 END) as pendingtotal_price, SUM(case WHEN cost_status = 'ยังไม่ได้ชำระเงิน' THEN total ELSE 0 END) as untotal_cost FROM cost ");
        $totalresult = mysqli_fetch_assoc($total_cost);
    }
    $result = mysqli_query($conn, $query);
    $datax = array();
    foreach ($result as $k) {
        $datax[] = "['".DateThai($k['date'])."'".", ".$k['total_price'] .",".$k['pendingtotal_price'].",".$k['untotal_price']."]";
    }
    $datax = implode(",", $datax);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/cost.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <script src="../../../js/admin/costDate.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="cost-box">
                <h3>ค้นหารายการชำระเงินห้องพักรายเดือน</h3>
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
                                <a href="index.php"><button type="button"
                                        class="cancel-sort">ยกเลิกการกรองทั้งหมด</button></a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <a href="addcost.php"><button>เพิ่มรายการชำระเงิน</button></a>
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
                    <div style="padding-top:32px;">
                        <div style="line-height:40px;">
                            <p>ชำระเงินแล้ว : <?php echo number_format($totalresult["total_cost"]); ?> บาท</p>
                            <p>ยังไม่ได้ชำระเงิน : <?php echo number_format($totalresult["untotal_cost"]); ?> บาท
                            </p>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <h3>รายการชำระเงินห้องพักรายเดือนทั้งหมด</h3>
                    <div style="display:flex;align-items:center;">
                        <div style="padding:32px 16px 32px 0px;display: flex;align-items: center;">
                            <input type="checkbox" id="all" <?php if(!isset($check)){ echo "checked";} ?>>
                            <label for="scales">ทั้งหมด</label>
                        </div>
                        <div style="padding:32px 16px;display: flex;align-items: center;">
                            <input type="checkbox" id="unsuccess" <?php if(isset($check)){ if($check == "unsuccess"){ echo "checked";}} ?>>
                            <label for="scales">ยังไม่ได้ชำระเงิน</label>
                        </div>
                        <div style="padding:32px 16px;display: flex;align-items: center;">
                            <input type="checkbox" id="pending" <?php if(isset($check)){ if($check == "pending"){ echo "checked";}} ?>>
                            <label for="scales">รอการชำระเงิน</label>
                        </div>
                        <div style="padding:32px 16px;display: flex;align-items: center;">
                            <input type="checkbox" id="success" <?php if(isset($check)){ if($check == "success"){ echo "checked";}} ?>>
                            <label for="scales">ชำระเงินแล้ว</label>
                        </div>
                        
                    </div>
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
                            $sql ="SELECT * FROM cost WHERE (date BETWEEN '$from' AND '$to') ORDER BY date LIMIT {$start} , {$perpage}";
                        }else if(!isset($from) && !isset($to) && isset($check)){
                            if($check == "success"){
                                $check_s = "ชำระเงินแล้ว";
                            }else if($check == "unsuccess"){
                                $check_s = "ยังไม่ได้ชำระเงิน";
                            }else if($check = "pending"){
                                $check_s = "รอการชำระเงิน";
                            }
                            $sql = "SELECT * FROM cost WHERE cost_status = '$check_s' ORDER BY date LIMIT {$start} , {$perpage}";
                        }else if(isset($from) && isset($to) && isset($check)){
                            if($check == "success"){
                                $check_s = "ชำระเงินแล้ว";
                            }else if($check == "unsuccess"){
                                $check_s = "ยังไม่ได้ชำระเงิน";
                            }else if($check == "pending"){
                                $check_s = "รอการชำระเงิน";
                            }
                            $sql = "SELECT * FROM cost WHERE (date BETWEEN '$from' AND '$to') AND cost_status = '$check_s' ORDER BY date LIMIT {$start} , {$perpage}";
                        }else{
                            $sql = "SELECT * FROM cost ORDER BY date LIMIT {$start} , {$perpage} ";
                        }
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        ?>
                    <table>
                        <tr>
                            <th>ลำดับ</th>
                            <th>เลขห้อง</th>
                            <th>ประจำเดือน</th>
                            <th>วันที่ชำระเงิน</th>
                            <th>ยอดรวม</th>
                            <th>ค่าปรับ</th>
                            <th>สถานะการชำระเงิน</th>
                            <th>เพิ่มเติม</th>
                        </tr>
                        <?php while($row = $result->fetch_assoc()){ ?>
                        <form action="function/confirmStatus.php?cost_id=<?php echo $row["cost_id"]; ?>" onsubmit="return confirm('คุณต้องการยืนยันการชำระเงินใช่หรือไม่ ?')" method="POST">
                            <tr>
                                <td><?php echo $num; ?></td>
                                <td><?php echo $row["room_id"];?></td>
                                <td><?php echo DateThai($row["date"]);?></td>
                                <td><?php if(isset($row["pay_date"])){ echo DateThai2($row["pay_date"]); }?></td>
                                <td><?php echo $row["total"];?></td>
                                <td><?php if(isset($row["fines"])){ echo $row["fines"]; }else{ echo "0.00"; }?></td>
                                <?php
                                if($row['cost_status'] == 'ชำระเงินแล้ว'){
                                ?>
                                <td>
                                    <div class="status-success">
                                        <p><?php echo $row["cost_status"]?></p>
                                    </div>
                                </td>
                                <?php
                                }else if($row['cost_status'] == 'รอการชำระเงิน'){
                                ?>
                                <td>
                                    <div class="status-pending">
                                        <p><?php echo $row["cost_status"]?></p>
                                    </div>
                                </td>
                                <?php
                                }else{
                                ?>
                                <td>
                                    <div class="status-nosuccess">
                                        <p><?php echo $row["cost_status"]?></p>
                                    </div>
                                </td>
                                <?php } ?>
                                <?php
                                if($row['cost_status'] != 'ชำระเงินแล้ว'){
                                ?>
                                <td>
                                    <div class="option">
                                        <button type="submit" class="confirm-status" title="ยืนยันการชำระเงิน">ยืนยันการชำระเงิน</button>
                                        <a href="costDetail.php?cost_id=<?php echo $row["cost_id"]; ?>"><button type="button" class="more" title="ดูข้อมูลเพิ่มเติม">ดูข้อมูลเพิ่มเติม</button></a>
                                        <button type="button" class="del-btn" id="<?php echo $row["cost_id"]; ?>" title="ลบข้อมูล"></button>
                                    </div>

                                </td>
                                <?php 
                                }else{
                                ?>
                                <td>
                                    <div class="option">
                                        <button type="button" class="confirmed-status">ชำระเงินแล้ว</button>
                                        <a href="costDetail.php?cost_id=<?php echo $row["cost_id"]; ?>"><button type="button" class="more" title="ดูข้อมูลเพิ่มเติม">ดูข้อมูลเพิ่มเติม</button></a>
                                        <button type="button" class="del-btn" id="<?php echo $row["cost_id"]; ?>" title="ลบข้อมูล"></button>
                                    </div>
                                </td>
                                <?php } ?>
                            </tr>
                        </form>
                        <?php $num++; } ?>
                    </table>
                    <?php
                        ///////pagination
                        if(isset($from) && isset($to) && !isset($check)){
                            $sql2 ="SELECT * FROM cost WHERE date BETWEEN '$from' AND '$to'";
                        }else if(!isset($from) && !isset($to) && isset($check)){
                            $sql2 = "SELECT * FROM cost WHERE cost_status = '$check_s'";
                        }else if(isset($from) && isset($to) && isset($check)){
                            $sql2 = "SELECT * FROM cost WHERE (date BETWEEN '$from' AND '$to') AND cost_status = '$check_s'";   
                        }else{
                            $sql2 = "SELECT * FROM cost";
                        }
                        $query2 = mysqli_query($conn, $sql2);
                        $total_record = mysqli_num_rows($query2);
                        $total_page = ceil($total_record / $perpage);
                        ?>
                    <div style="display:flex;justify-content:flex-end">
                        <div class="pagination">
                            <?php
                            if(isset($from) && isset($to) && !isset($check)){
                            ?>
                            <a href="index.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page=<?php echo $i; ?>"
                            <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else if(!isset($from) && !isset($to) && isset($check)){
                            ?>
                            <a href="index.php?status=<?php echo $check; ?>&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?status=<?php echo $check; ?>&page=<?php echo $i; ?>"
                            <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?status=<?php echo $check; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else if(isset($from) && isset($to) && isset($check)){
                            ?>
                            <a href="index.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&status=<?php echo $check; ?>&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&status=<?php echo $check; ?>&page=<?php echo $i; ?>"
                            <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>&status=<?php echo $check; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
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
                            echo "<div style='margin:32px 0'>ไม่มีรายการชำระเงินรายเดือน</div>";
                        }
                        ?>
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
            ['เดือน / ปี', 'ชำระเงินแล้ว (บาท)', 'รอการชำระเงิน (บาท)', 'ยังไม่ได้ชำระเงิน (บาท)'],
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