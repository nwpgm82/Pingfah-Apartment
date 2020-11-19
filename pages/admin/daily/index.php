<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../components/sidebar.php');
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/daily.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="daily-box">
                <div class="search">
                    <div style="padding-right:16px;">
                        <label>ประจำวันที่</label>
                        <input type="date" id="check_in" value="<?php echo $check_in; ?>" required>
                        <label>~</label>
                        <input type="date" id="check_out" value="<?php echo $check_out; ?>" required>
                        <button type="button" onclick="searchDate()">ค้นหา</button>
                    </div>
                    <div style="padding-right:16px;">
                        <label>ค้นหาเลขในการจอง</label>
                        <input type="text" id="code" value="<?php echo $code?>">
                        <button type="button" onclick="searchCode()">ค้นหา</button>
                    </div>
                    <div>
                        <a href="index.php"><button type="button">ยกเลิกการกรอง</button></a>
                    </div>
                </div>

                <hr />
                <div>
                    <?php
                    $perpage = 10;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $perpage;
                    if(isset($check_in) && isset($check_out)){
                        $sql = "SELECT * FROM daily WHERE (check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out ) LIMIT {$start} , {$perpage}";
                    }else if(isset($code)){
                        $sql = "SELECT * FROM daily WHERE code = '$code'";
                    }else{
                        $sql = "SELECT * FROM daily LIMIT {$start} , {$perpage}";
                    }
                    $result = $conn->query($sql);
                    if(isset($code)){
                        echo "<h3>ผลลัพธ์การค้นหา : $code</h3>";
                    }else{
                        echo "<h3>รายการเช่าห้องพักทั้งหมด</h3>";
                    }
                    if ($result->num_rows > 0) {
                    ?>
                    <table>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อ</th>
                            <th>เลขบัตรประชาชน/Passport</th>
                            <th>อีเมล</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>ประเภทห้อง</th>
                            <th>เช็คอิน</th>
                            <th>เช็คเอ้าท์</th>
                            <th>เลขในการจอง</th>
                            <th>เพิ่มเติม</th>
                        </tr>
                        <?php
                        while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $num; ?></td>
                            <td><?php echo $row['firstname'] ." " .$row['lastname']; ?></td>
                            <td><?php echo $row['id_card']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['tel']; ?></td>
                            <td><?php echo $row['room_type']; ?></td>
                            <td><?php if(isset($row['check_in'])){ echo DateThai($row['check_in']); } ?></td>
                            <td><?php if(isset($row['check_out'])){ echo DateThai($row['check_out']); } ?></td>
                            <td><?php echo $row['code']; ?></td>
                            <td>
                                <div class="confirmed-btn">
                                    <p>ยืนยัน</p>
                                </div>
                                <!-- <button class="del-btn">ลบ</button> -->
                            </td>
                        </tr>
                        <?php $num++; } ?>
                    </table>
                    <?php
                    ///////pagination
                    $sql2 = "SELECT * FROM daily";
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
                        echo "<div style='padding-top:32px;'>ไม่มีรายการเช่ารายวัน</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/daily.js"></script>
</body>

</html>

<?php
}else{
    Header("Location: ../../login.php"); 
}
?>