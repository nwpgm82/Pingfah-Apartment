<?php
include('../../connection.php');
include('../../components/sidebar.php'); 
$date = @$_REQUEST['Date'];
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
    }
    if($_SESSION['level'] == 'admin'){
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pingfah/css/admin/repair.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="repair-box">
                <h3>รายการอุปกรณ์ที่เสียหายในแต่ละห้อง</h3>
                <div style="margin-top:32px">
                    <label>วันที่</label>
                    <input type="date" id="repair_date" value="<?php if(isset($date)){ echo $date; }else{ echo ""; } ?>"
                        onchange="searchDate(value)">
                </div>
                <hr />

                <?php
                if(!isset($date)){
                    $repairData = "SELECT * FROM repair WHERE repair_status != 'ดำเนินการเสร็จสิ้น' ORDER BY room_id";
                    $repairCount = "SELECT COUNT(*) FROM repair WHERE repair_status != 'ดำเนินการเสร็จสิ้น' ";
                    $resultCount = $conn->query($repairCount);
                    $rowCount = $resultCount->fetch_row();
                    $result = $conn->query($repairData);
                    if ($result->num_rows > 0) {
                ?>
                <h3>รายการซ่อมคงค้างทั้งหมด <?php echo $rowCount[0]; ?> รายการ</h3>
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
                    <?php
                    while($row = $result->fetch_assoc()) {
                    ?>
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
                                    href="/Pingfah/pages/admin/repair/repairDetail.php?room_id=<?php echo $row['room_id'];?>&repairappliance=<?php echo $row['repair_appliance'];?>&repaircategory=<?php echo $row['repair_category'];?>&repairdate=<?php echo $row['repair_date'];?>"><button>ดูข้อมูลเพิ่มเติม</button></a>
                            </div>
                            <div>
                            <button class="del-btn" onclick="repair_del(<?php echo "'".$row['room_id']."','".$row['repair_appliance']."','".$row['repair_category']."','".$row['repair_date']."'"?>)">ลบ</button>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                <?php
                }
                    }else{
                        $repairData = "SELECT * FROM repair WHERE repair_date = '$date' ORDER BY room_id";
                        $repairCount2 = "SELECT COUNT(*) FROM repair WHERE repair_date = '$date'";
                        $resultCount2 = $conn->query($repairCount2);
                        $rowCount2 = $resultCount2->fetch_row();
                        $result = $conn->query($repairData);
                        if ($result->num_rows > 0) {
                                 
                ?>
                <h3>รายการซ่อมทั้งหมด <?php echo $rowCount2[0] ?> รายการ</h3>
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
                    <?php 
                     while($row = $result->fetch_assoc()) {
                    ?>
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
                                    href="/Pingfah/pages/admin/repair/repairDetail.php?room_id=<?php echo $row['room_id'];?>&repairappliance=<?php echo $row['repair_appliance'];?>&repaircategory=<?php echo $row['repair_category'];?>&repairdate=<?php echo $row['repair_date'];?>"><button>ดูข้อมูลเพิ่มเติม</button></a>
                            </div>
                            <div>
                                <button class="del-btn" onclick="repair_del(<?php echo "'".$row['room_id']."','".$row['repair_appliance']."','".$row['repair_category']."','".$row['repair_date']."'"?>)">ลบ</button>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                <?php }else{
                    echo "<div style='margin:32px 0'>0 results</div>";
                }} ?>
                <div style="margin-top:32px;">
                    <a href="/Pingfah/pages/admin/repair/addRepair.php"><button>เพิ่มรายการ</button></a>
                </div>

            </div>
        </div>
    </div>
    <script src="/Pingfah/js/repair.js"></script>
</body>

</html>
<?php
}else{
    if($_SESSION['level'] == 'employee'){
        Header("Location: /Pingfah/pages/employee/repair/index.php");
    }else{
       Header("Location: ../login.php"); 
    }
}
?>