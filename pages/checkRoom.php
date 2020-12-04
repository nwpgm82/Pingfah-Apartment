<?php
    include("connection.php");
    @$check_in = $_REQUEST['check_in'];
    @$check_out = $_REQUEST['check_out'];
    @$people = $_REQUEST['people'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/checkRoom.css">
    <title>Document</title>
</head>

<body onload="checkRoomLoad()">
    <?php include("../components/maintopbar.php"); ?>
    <div class="box">
        <div class="checkRoom">
            <form
                action="checkRoom.php?check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out; ?>&people=<?php echo $_POST['people']; ?>">
                <div class="searchDate">
                    <div>
                        <div style="display:flex;align-items:center;">
                            <label class="checkText">Check In : </label>
                            <div style="position:relative;padding-left:8px;height:40px;">
                                <input type="date" id="check_in" value="<?php echo $check_in; ?>" name="check_in"
                                    onchange="checkInDate(value)">
                                <p id="check_in_date" class="dateText"></p>
                            </div>
                        </div>
                    </div>
                    <div style="padding:0 16px">
                        <div style="display:flex;align-items:center;">
                            <label class="checkText">Check Out : </label>
                            <div style="position:relative;padding-left:8px;height:40px;">
                                <input type="date" id="check_out" value="<?php echo $check_out; ?>" name="check_out"
                                    onchange="checkInDate2(value)">
                                <p id="check_out_date" class="dateText"></p>
                            </div>
                        </div>
                    </div>
                    <div style="padding:0 16px">
                        <div style="display:flex;align-items:center;">
                            <label>จำนวนผู้พัก : </label>
                            <div style="position:relative;padding-left:8px;height:40px;">
                                <input type="number" id="people" name="people" min="1" max="10"
                                    value="<?php echo $people; ?>">
                                <p id="check_out_date" class="dateText"></p>
                            </div>
                        </div>
                    </div>
                    <button type="submit">ค้นหา</button>
                </div>
            </form>
            <div class="hr"></div>
            <?php 
            if(isset($check_in) || isset($check_out)){
                echo "<h3>ประเภทห้องพักที่ว่างให้บริการ</h3>";
            }
            
            ?>
            <div style="padding-top: 32px;">
                <form action="dailyForm.php?check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out; ?>&people=<?php echo $people; ?>" method="POST">
                <?php
                $countAll = "SELECT * FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out ))";
                $allresult = $conn->query($countAll);
                $alltotal_int = 0;
                if ($allresult->num_rows > 0) {
                    while($all = $allresult->fetch_assoc()) {
                        $alltotal_int += $all['room_count'];
                    }
                }else{
                    $alltotal_int = 0;
                }
                $countroomAll = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal FROM roomlist WHERE (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
                $roomAlldata= mysqli_fetch_assoc($countroomAll);  
                $roomAlltotal_int = intval($roomAlldata['roomtotal']);
                $totalAll_int = $roomAlltotal_int - $alltotal_int;
                if($people <= ($totalAll_int * 2)){
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
                                <p>- จำนวนผู้พัก : 2 คน</p>
                                <p>- รายวัน : <?php echo number_format($row['daily_price']); ?> บาท</p>
                            </div>
                            <div style="display: flex;justify-content: space-between;">
                                <p>จำนวนห้องพักที่เหลือ : <?php echo $total_int; ?> ห้อง</p>
                                <div>
                                    <label>จำนวนห้องพักที่ต้องการ : </label>
                                    <button type="button" onclick="decrease(1)">-</button>
                                    <input type="number" id="people1" min="0" max="<?php echo $total_int; ?>" value="0" name="air">
                                    <button type="button" onclick="increase(1)">+</button>
                                    <label>ห้อง</label>
                                </div>
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
                                <p>- จำนวนผู้พัก : 2 คน</p>
                                <p>- รายวัน : <?php echo number_format($row2['daily_price']); ?> บาท</p>
                            </div>
                            <div style="display: flex;justify-content: space-between;">
                                <p>จำนวนห้องพักที่เหลือ : <?php echo $total_int2; ?> ห้อง</p>
                                <div>
                                    <label>จำนวนห้องพักที่ต้องการ : </label>
                                    <button type="button" onclick="decrease(2)">-</button>
                                    <input type="number" id="people2" min="0" max="<?php echo $total_int2; ?>" value="0" name="fan">
                                    <button type="button" onclick="increase(2)">+</button>
                                    <label>ห้อง</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top:32px;display:flex;justify-content:flex-end;align-items:center">
                        <button class="rent">จองเลย</button>
                    </div>
                </form>
                <?php }}}else{
                echo "ไม่มีห้องว่างให้เช่า";
                } ?>
            </div>
            <?php
            
            ?>
        </div>
    </div>
    <script src="../js/checkRoom.js"></script>
</body>

</html>