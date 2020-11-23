<?php
    include("connection.php");
    include("../components/maintopbar.php");
    @$check_in = $_REQUEST['check_in'];
    @$check_out = $_REQUEST['check_out'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/checkRoom.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div class="checkRoom">
            <form action="checkRoom.php?check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out; ?>">
                <div class="searchDate">
                    <div>
                        <label>Check In : </label>
                        <input type="date" value="<?php echo $check_in; ?>" name="check_in">
                    </div>
                    <div style="padding:0 16px">
                        <label>Check Out : </label>
                        <input type="date" value="<?php echo $check_out; ?>" name="check_out">
                    </div>
                    <button type="submit">ค้นหา</button>
                </div>
            </form>
            <div class="hr"></div>
            <h3>ผลลัพธ์การค้นหา</h3>
            <div class="grid">
                <?php
                    if(isset($check_in) || isset($check_out)){
                        $countAir = "SELECT * FROM daily WHERE room_type = 'แอร์' AND ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out ))";
                        $airresult = $conn->query($countAir);
                        $airtotal_int = 0;
                        if ($airresult->num_rows > 0) {
                            while($air = $airresult->fetch_assoc()) {
                                $airtotal_int += $air['room_count'];
                            }
                        }else{
                            $airtotal_int = 0;
                        }
                        $countroom = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal FROM roomlist WHERE room_type = 'แอร์' AND (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
                        $roomdata= mysqli_fetch_assoc($countroom);  
                        $roomtotal_int = intval($roomdata['roomtotal']);
                        $total_int = $roomtotal_int - $airtotal_int;
                        if($total_int != 0){
                            $sql = "SELECT * FROM roomdetail WHERE type = 'แอร์'";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                ?>
                <div class="card">
                    <img src="images/roomdetail/<?php echo $row['pic1']; ?>" alt="">
                    <div class="detail">
                        <div>
                            <h3>ห้องแอร์</h3>
                            <p>- รายเดือน : <?php echo number_format($row['price']); ?> บาท</p>
                            <p>- รายวัน : <?php echo number_format($row['daily_price']); ?> บาท</p>
                        </div>
                        <div style="display: flex;justify-content: space-between;">
                        <p>จำนวน : <?php echo $total_int; ?></p>
                            <a href="dailyForm.php?room_type=<?php echo $row['type']; ?>&check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out; ?>"><button>จองห้องพัก</button></a>
                        </div>
                    </div>
                </div>
                <?php }} ?>
                <?php
                    if(isset($check_in) || isset($check_out)){
                        $countFan = "SELECT * FROM daily WHERE room_type = 'พัดลม' AND ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out ))";
                        $fanresult = $conn->query($countFan);
                        $fantotal_int = 0;
                        if ($fanresult->num_rows > 0) {
                            while($fan = $fanresult->fetch_assoc()) {
                                $fantotal_int += $fan['room_count'];
                            }
                        }else{
                            $fantotal_int = 0;
                        }
                        $countroom2 = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal2 FROM roomlist WHERE room_type = 'พัดลม' AND (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
                        $roomdata2= mysqli_fetch_assoc($countroom2);  
                        $roomtotal_int2 = intval($roomdata2['roomtotal2']);
                        $total_int2 = $roomtotal_int2 - $fantotal_int;
                        if($total_int2 != 0){
                            $sql2 = "SELECT * FROM roomdetail WHERE type = 'พัดลม'";
                            $result2 = $conn->query($sql2);
                            $row2 = $result2->fetch_assoc();
                ?>
                <div class="card">
                    <img src="images/roomdetail/<?php echo $row2['pic1']; ?>" alt="">
                    <div class="detail">
                        <div>
                            <h3>ห้องพัดลม</h3>
                            <p>- รายเดือน <?php echo number_format($row2['price']); ?> บาท</p>
                            <p>- รายวัน <?php echo number_format($row2['daily_price']); ?> บาท</p>
                        </div>
                        <div style="display: flex;justify-content: space-between;">
                        <p>จำนวน : <?php echo $total_int2; ?></p>
                            <a href="dailyForm.php?room_type=<?php echo $row2['type']; ?>&check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out; ?>"><button>จองห้องพัก</button></a>
                        </div>
                    </div>
                </div>
                <?php }} ?>
            </div>
        </div>
    </div>
</body>

</html>