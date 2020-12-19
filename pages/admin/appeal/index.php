<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
    $from = @$_REQUEST['from'];
    $to = @$_REQUEST['to'];
    $date = @$_REQUEST['Date'];
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/appeal.css">
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
            <div class="appeal-box">
                <h3>ค้นหารายการร้องเรียน</h3>
                <div class="search">
                    <div style="padding-right:16px">
                        <div style="display:flex;align-items:center;">
                            <label>ค้นหาตามวันที่</label>
                            <div style="position:relative;">
                                <input type="text" class="roundtrip-input" id="date_from" value="<?php echo $from; ?>"
                                    required>
                                <p id="from_date" class="dateText"></p>
                            </div>
                            <label>~</label>
                            <div style="position:relative;">
                                <input type="text" class="roundtrip-input" id="date_to" value="<?php echo $to; ?>"
                                    required>
                                <p id="to_date" class="dateText"></p>
                            </div>
                            <button type="button" onclick="searchDate()">ค้นหา</button>
                        </div>
                    </div>
                    <?php
                        if(isset($from) || isset($to)){
                        ?>
                    <button class="cancel-sort" style="margin:0 8px;" onclick="unCheckAll()">ยกเลิกการกรองทั้งหมด</button>
                    <?php } ?>
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
                    if(isset($from) && isset($to)){
                        $sql = "SELECT * FROM appeal WHERE (appeal_date BETWEEN '$from' AND '$to') LIMIT {$start} , {$perpage}";
                    }else{
                        $sql = "SELECT * FROM appeal LIMIT {$start} , {$perpage}";
                    }
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    ?>
                    <h3>รายการร้องเรียนทั้งหมด</h3>
                    <table>
                        <tr>
                            <th>ลำดับ</th>
                            <th>เลขห้อง</th>
                            <th>หัวข้อร้องเรียน</th>
                            <th>วันที่ร้องเรียน</th>
                            <th>เพิ่มเติม</th>
                        </tr>
                        <?php
                        while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $num; ?></td>
                            <td><?php echo $row['room_id']; ?></td>
                            <td><?php echo $row['appeal_topic']; ?></td>
                            <td><?php echo DateThai($row['appeal_date']); ?></td>
                            <td>
                                <a
                                    href="appealDetail.php?appeal_id=<?php echo $row['appeal_id']; ?>"><button>รายละเอียด</button></a>
                                <button class="del-btn" onclick="del(<?php echo $row['appeal_id']; ?>)">ลบ</button>
                            </td>
                        </tr>
                        <?php $num++; } ?>
                    </table>
                    <?php
                    ///////pagination
                    $sql2 = "SELECT * FROM appeal";
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
                        echo "<div style='padding-top:32px;'>ไม่มีรายการร้องเรียน</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/appeal.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>