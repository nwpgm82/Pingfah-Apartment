<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
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
            <h3>ค้นหารายการเช่ารายวัน</h3>
                <div class="search">
                    <div style="padding-right:16px;">
                        <label>ค้นหาตามวันที่</label>
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
                        <a href="index.php"><button type="button">ยกเลิกการกรองทั้งหมด</button></a>
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
                            <th>ชื่อผู้เช่า</th>
                            <th>ห้องแอร์</th>
                            <th>ห้องพัดลม</th>
                            <th>วันที่เข้าพัก</th>
                            <th>เลขที่ในการจอง</th>
                            <th>สถานะ</th>
                            <th>ห้องที่เลือก</th>
                            <th>เพิ่มเติม</th>
                        </tr>
                        <?php
                        while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $num; ?></td>
                            <td><?php echo $row['firstname'] ." " .$row['lastname']; ?></td>
                            <td><?php echo $row['air_room']; ?></td>
                            <td><?php echo $row['fan_room']; ?></td>
                            <td><?php echo DateThai($row['check_in']) ."&nbsp; ~ &nbsp;" .DateThai($row['check_out']); ?></td>
                            <td><?php echo $row['code']; ?></td>
                            <td><?php if($row['daily_status'] == 'เข้าพักแล้ว'){ echo "<button type='button' class='confirmed-btn'>เข้าพักแล้ว</button>"; }else if($row['daily_status'] == "เช็คเอ้าท์แล้ว"){ echo "<button type='button' class='checkoutStatus-btn'>เช็คเอ้าท์แล้ว</button>"; }else{ echo "<button type='button' class='pending-btn'>รอการเข้าพัก</button>"; } ?></td>
                            <td><?php echo $row['room_select']; ?></td>
                            <td>
                                <?php
                                if($row['daily_status'] == ''){
                                ?>
                                <div id="btn<?php echo $num; ?>">
                                    <a href="selectroom.php?daily_id=<?php echo $row['daily_id']; ?>"><button class="select_room">เลือกห้อง</button></a>
                                    <a href="dailyDetail.php?daily_id=<?php echo $row['daily_id']; ?>"><button>รายละเอียด</button></a>
                                    <button class="del-btn" onclick="del('<?php echo $row['daily_id']; ?>')">ลบ</button>
                                </div>
                                <div id="select<?php echo $num; ?>" style="display:none;">
                                    <select name="" id="room_select<?php echo $num; ?>">
                                        <option value="">---</option>
                                        <?php
                                            $room = "SELECT * FROM roomlist WHERE room_type = '$roomtype' AND room_status = 'ว่าง'";
                                            $result2 = $conn->query($room);
                                            if ($result2->num_rows > 0) {
                                                while($select = $result2->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $select['room_id']; ?>"><?php echo $select['room_id']; ?></option>
                                        <?php } } ?>
                                    </select>
                                    <button onclick="confirmRoom('<?php echo $row['daily_id']; ?>',<?php echo $num; ?>)">ยืนยัน</button>
                                </div>
                                <?php 
                                }else if($row['daily_status'] == 'เข้าพักแล้ว'){
                                ?>
                                <button class="checkout-btn" onclick="check_out(<?php echo $row['daily_id']; ?>)">เช็คเอ้าท์</button>
                                <a href="dailyDetail.php?daily_id=<?php echo $row['daily_id']; ?>"><button>รายละเอียด</button></a>
                                <button class="del-btn" onclick="del('<?php echo $row['daily_id']; ?>')">ลบ</button>
                                <?php 
                                }else{
                                ?>
                                <a href="dailyDetail.php?daily_id=<?php echo $row['daily_id']; ?>"><button>รายละเอียด</button></a>
                                <button class="del-btn" onclick="del('<?php echo $row['daily_id']; ?>')">ลบ</button>
                                <?php    
                                } 
                                ?>
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
                            <a href="index.php?page=<?php echo $i; ?>" <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
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