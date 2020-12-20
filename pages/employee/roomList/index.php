<?php 
session_start();
if($_SESSION['level'] == 'employee'){
    include('../../connection.php');
    include('../../../components/sidebarEPY.php');
    $from = @$_REQUEST['from'];
    $to = @$_REQUEST['to'];
    $check = @$_REQUEST['Status'];
    $check_in = @$_REQUEST['check_in'];
    $check_out = @$_REQUEST['check_out'];
    $people = @$_REQUEST['people'];
    // $page
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
    <link rel="stylesheet" href="../../../css/roomList.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box" id="roomList">
        <div style="padding:24px;">
            <div class="box-grid">
                <div class="roomList-box">
                    <div>
                        <h3>รายการห้องพักทั้งหมด</h3>
                    </div>
                    <div class="hr"></div>
                    <div style="display:flex;align-items:center;">
                        <div style="padding:16px 16px 32px 0px;display:flex;align-items:center;">
                            <input type="checkbox" id="all" onchange="searchCheck(this.id)"
                                <?php if(!isset($check)){ echo "checked"; } ?>>
                            <label for="scales">ทั้งหมด</label>
                        </div>
                        <div style="padding:16px 16px 32px 16px;display:flex;align-items:center;">
                            <input type="checkbox" id="available" onchange="searchCheck(this.id)"
                                <?php if(isset($check)){ if($check == "available"){ echo "checked";}} ?>>
                            <label for="scales">ว่าง</label>
                        </div>
                        <div style="padding:16px 16px 32px 16px;display:flex;align-items:center;">
                            <input type="checkbox" id="unavailable" onchange="searchCheck(this.id)"
                                <?php if(isset($check)){ if($check == "unavailable"){ echo "checked";}} ?>>
                            <label for="scales">รายเดือน (ไม่ว่าง)</label>
                        </div>
                        <div style="padding:16px 16px 32px 16px;display:flex;align-items:center;">
                            <input type="checkbox" id="daily" onchange="searchCheck(this.id)"
                                <?php if(isset($check)){ if($check == "daily"){ echo "checked";}} ?>>
                            <label for="scales">รายวัน (ไม่ว่าง)</label>
                        </div>
                        <!-- <button onclick="unCheckAll()">ยกเลิกการกรองทั้งหมด</button> -->
                    </div>
                    <?php
                    if($check == "daily"){
                    ?>
                    <div style="display:flex;align-items:center;padding:16px 0;">
                        <label style="padding-right:8px;">ค้นหาตามวันที่</label>
                        <div style="position:relative;">
                            <input type="text" class="roundtrip-input1" id="date_from" value="<?php echo $from; ?>">
                            <p id="from_date" class="dateText"></p>
                        </div>
                        <label style="padding: 0 8px;">~</label>
                        <div style="position:relative;">
                            <input type="text" class="roundtrip-input1" id="date_to" value="<?php echo $to; ?>">
                            <p id="to_date" class="dateText"></p>
                            <button type="button" style="margin:0 8px;" onclick="searchDate2()">ค้นหา</button>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <?php } ?>
                    <?php
                    $perpage = 8;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $perpage;
                    if($check == "available"){
                        $status = "ว่าง";
                        $roomlist = "SELECT * FROM  roomList WHERE room_status = '$status' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else if($check == "unavailable"){
                        $status = "ไม่ว่าง";
                        $roomlist = "SELECT * FROM  roomList WHERE room_status = '$status' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else if($check == "daily"){
                        $status = "เช่ารายวัน";
                        if(isset($from) && isset($to)){
                            $roomlist = "SELECT * FROM  roomList WHERE room_status = '$status' AND ((check_in BETWEEN '$from' AND '$to') OR (check_out BETWEEN '$from' AND '$to') OR ('$from' BETWEEN check_in AND check_out) OR ('$to' BETWEEN check_in AND check_out )) ORDER BY room_id LIMIT {$start} , {$perpage}";
                        }else{
                            $roomlist = "SELECT * FROM  roomList WHERE room_status = '$status' ORDER BY room_id LIMIT {$start} , {$perpage}";
                        }
                    }else{
                        $roomlist = "SELECT * FROM  roomList ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }
                    $room_result = $conn->query($roomlist);
                    if ($room_result->num_rows > 0) {
                    ?>
                    <table>
                        <tr>
                            <th>เลขห้อง</th>
                            <th>ประเภท</th>
                            <th>วันที่เข้าอยู่</th>
                            <th>สถานะ</th>
                        </tr>
                        <?php
                            while($row = mysqli_fetch_array($room_result)) { 
                        ?>
                        <form action="../roomList/function/editType.php?ID=<?php echo $row["room_id"]; ?>"
                            method='POST'>
                            <tr>
                                <td><a
                                        href="../roomList/room_id.php?ID=<?php echo $row[0] ?>"><?php echo $row["room_id"]; ?></a>
                                </td>
                                <td <?php echo "id='typeShow" .$row["room_id"] . "'" ?>><?php echo $row["room_type"]; ?>
                                </td>
                                <td <?php echo "id='typeEdit" .$row["room_id"] . "'" ."style='display:none'"; ?>>
                                    <select name="type">
                                        <option value="พัดลม">พัดลม</option>
                                        <option value="แอร์">แอร์</option>
                                    </select>
                                </td>
                                <td>
                                    <?php if($row['come'] != null && $row['room_status'] != 'เช่ารายวัน'){ echo DateThai($row['come']); }; ?>
                                    <?php if($row['check_in'] != null && $row['come'] == null){ echo DateThai($row['check_in']) ." ~ " .DateThai($row['check_out']); } ?>
                                </td>
                                <td>
                                    <?php
                                        if($row["room_status"] == 'ว่าง'){
                                            echo "<div class='status-available'></div>";
                                        }else if($row["room_status"] == 'ไม่ว่าง'){
                                            echo "<div class='status-unavailable'></div>";
                                        }else if($row["room_status"] == 'เช่ารายวัน'){
                                            echo "<div class='status-daily'></div>";
                                        }
                                    ?>
                                </td>
                            </tr>
                        </form>
                        <?php  $num++; }?>
                    </table>
                    <?php
                    ///////pagination
                    if($check == "available"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'ว่าง'";
                    }else if($check == "unavailable"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'ไม่ว่าง'";
                    }else if($check == "daily"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'เช่ารายวัน'";
                    }else{
                        $sql2 = "SELECT * FROM roomlist";
                    }
                    $query2 = mysqli_query($conn, $sql2);
                    $total_record = mysqli_num_rows($query2);
                    $total_page = ceil($total_record / $perpage);
                    ?>
                    <div style="display:flex;justify-content:flex-end">
                        <div class="pagination">
                            <?php
                            if($check == "available"){
                            ?>
                            <a href="index.php?Status=available&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=available&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=available&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else if($check == "unavailable"){
                            ?>
                            <a href="index.php?Status=unavailable&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=unavailable&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=unavailable&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php 
                            }else if($check == "daily"){
                            ?>
                            <a href="index.php?Status=daily&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=daily&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=daily&page=<?php echo $total_page; ?>">&raquo;</a>
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
                        echo "<div style='padding:32px 0'>ไม่มีรายการห้องพัก</div>";
                    }
                    // mysqli_close($conn);
                    ?>
                    <div style="display:flex;justify-content:flex-end;">
                        <div class="status-grid">
                            <div class="sub-grid">
                                <div class='status-available'></div>
                                <label>ว่าง</label>
                            </div>
                            <div class="sub-grid">
                                <div class='status-unavailable'></div>
                                <label>รายเดือน (ไม่ว่าง)</label>
                            </div>
                            <div class="sub-grid">
                                <div class='status-daily'></div>
                                <label>รายวัน (ไม่ว่าง)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="roomList-box">
                    <h3>ค้นหาห้องว่าง</h3>
                    <div class="hr"></div>
                    <label>ค้นหาตามวันที่</label>
                    <div style="display:flex;align-items:center;padding-top:8px;">
                        <div style="position:relative;">
                            <input type="text" class="roundtrip-input2" id="check_in" value="<?php echo $check_in ?>"
                                required>
                            <p id="check_in_date" class="dateText"></p>
                        </div>
                        <label style="padding:0 8px;">~</label>
                        <div style="position:relative;">
                            <input type="text" class="roundtrip-input2" id="check_out" value="<?php echo $check_out ?>"
                                required>
                            <p id="check_out_date" class="dateText"></p>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;padding-top:16px;">
                        <div style="display:flex;align-items:center;">
                            <label>จำนวนผู้พัก : </label>
                            <div style="position:relative;padding:0 8px;height:40px;">
                                <input type="number" id="people" name="people" min="1" max="10"
                                    value="<?php echo $people; ?>"
                                    oninput="this.value = this.value > 10 ? 10 : Math.abs(this.value)">
                            </div>
                            <label>(สูงสุด : 10)</label>
                        </div>
                        <button type="button" style="margin-left:8px;" onclick="searchDate()">ค้นหา</button>
                    </div>
                    <div class="hr"></div>
                    <div>
                        <div>
                            <?php
                            $countDailyAll = mysqli_query($conn,"SELECT SUM(air_room+fan_room) AS dailyTotal FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out )) AND daily_status != 'ยกเลิกการจอง'");
                            $roomDailyAlldata= mysqli_fetch_assoc($countDailyAll);  
                            $roomDailyAlltotal_int = intval($roomDailyAlldata['dailyTotal']);
                            $countroomAll = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal FROM roomlist WHERE (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
                            $roomAlldata= mysqli_fetch_assoc($countroomAll);  
                            $roomAlltotal_int = intval($roomAlldata['roomtotal']);
                            $totalAll_int = $roomAlltotal_int - $roomDailyAlltotal_int;

                            if($people <= ($totalAll_int * 2)){
                                if(isset($check_in) || isset($check_out)){
                                    $countAir = mysqli_query($conn,"SELECT SUM(air_room) AS airTotal FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out )) AND daily_status != 'ยกเลิกการจอง'");
                                    $roomDailyAirdata= mysqli_fetch_assoc($countAir);  
                                    $roomDailyAirtotal_int = intval($roomDailyAirdata['airTotal']);
                                    $countroom = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal FROM roomlist WHERE room_type = 'แอร์' AND (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
                                    $roomdata= mysqli_fetch_assoc($countroom);  
                                    $roomtotal_int = intval($roomdata['roomtotal']);
                                    $total_int = $roomtotal_int - $roomDailyAirtotal_int;
                                    if($total_int > 3){
                                        $sql = "SELECT * FROM roomdetail WHERE type = 'แอร์'";
                                        $result = $conn->query($sql);
                                        $row2 = $result->fetch_assoc();
                            ?>
                            <div class="card">
                                <div class="container">
                                    <?php
                                    $getImg = "SELECT * FROM air_gal";
                                    $resultImg = $conn->query($getImg);
                                    if ($resultImg->num_rows > 0) {
                                        while($row3 = $resultImg->fetch_assoc()) {
                                    ?>
                                    <div class="mySlides1">
                                        <img src="../../images/roomdetail/air/<?php echo $row3['gal_name']; ?>"
                                            style="width:100%">
                                    </div>
                                    <?php }}else{ ?>
                                        <div class="mySlides1">
                                        <img src="../../../img/tool/no-img.png"
                                            style="width:100%">
                                    </div>
                                    <?php } ?>
                                    <?php
                                    if ($resultImg->num_rows > 1){
                                    ?>
                                    <a class="prev" onclick="plusSlides1(-1)">&#10094;</a>
                                    <a class="next" onclick="plusSlides1(1)">&#10095;</a>
                                    <?php } ?>
                                </div>
                                <div class="detail">
                                    <div>
                                        <h3>ห้องแอร์</h3>
                                        <div class="user-grid">
                                            <img src="../../../img/tool/user.png" alt="">
                                            <label>2 คน</label>
                                        </div>
                                        <p>รายเดือน : <label
                                                style="font-size:20px;color: rgb(131, 120, 47, 1);"><strong><?php echo number_format($row2['price']); ?></strong></label>
                                            บาท
                                        </p>
                                        <p>รายวัน : <label
                                                style="font-size:20px;color: rgb(131, 120, 47, 1);"><strong><?php echo number_format($row2['daily_price']); ?></strong></label>
                                            บาท
                                        </p>
                                    </div>
                                    <p>จำนวนห้องพักที่เหลือ : <?php echo $total_int; ?> ห้อง</p>
                                </div>
                            </div>
                            <?php }} ?>
                            <?php
                            if(isset($check_in) || isset($check_out)){
                                $countFan = mysqli_query($conn,"SELECT SUM(fan_room) AS fanTotal FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out )) AND daily_status != 'ยกเลิกการจอง'");
                                $roomDailyFandata= mysqli_fetch_assoc($countFan);  
                                $roomDailyFantotal_int = intval($roomDailyFandata['fanTotal']);
                                $countroom2 = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal2 FROM roomlist WHERE room_type = 'พัดลม' AND (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
                                $roomdata2= mysqli_fetch_assoc($countroom2);  
                                $roomtotal_int2 = intval($roomdata2['roomtotal2']);
                                $total_int2 = $roomtotal_int2 - $roomDailyFantotal_int;
                                if($total_int2 > 1){
                                    $sql2 = "SELECT * FROM roomdetail WHERE type = 'พัดลม'";
                                    $result2 = $conn->query($sql2);
                                    $row4 = $result2->fetch_assoc();
                            ?>
                            <div class="card">
                                <div class="container">
                                    <?php
                                    $getImg3 = "SELECT * FROM fan_gal";
                                    $resultImg3 = $conn->query($getImg3);
                                    if ($resultImg3->num_rows > 0) {
                                        while($row5 = $resultImg3->fetch_assoc()) {
                                    ?>
                                    <div class="mySlides2">
                                        <img src="../../images/roomdetail/fan/<?php echo $row5['gal_name']; ?>"
                                            style="width:100%">
                                    </div>
                                    <?php }}else{ ?>
                                        <div class="mySlides2">
                                        <img src="../../../img/tool/no-img.png"
                                            style="width:100%">
                                    </div>
                                    <?php } ?>
                                    <?php
                                    if ($resultImg3->num_rows > 1) {
                                    ?>
                                    <a class="prev" onclick="plusSlides2(-1)">&#10094;</a>
                                    <a class="next" onclick="plusSlides2(1)">&#10095;</a>
                                    <?php } ?>
                                </div>
                                <div class="detail">
                                    <div>
                                        <h3>ห้องพัดลม</h3>
                                        <div class="user-grid">
                                            <img src="../../../img/tool/user.png" alt="">
                                            <label>2 คน</label>
                                        </div>
                                        <p>รายเดือน : <label
                                                style="font-size:20px;color: rgb(131, 120, 47, 1);"><strong><?php echo number_format($row4['price']); ?></strong></label>
                                            บาท
                                        </p>
                                        <p>รายวัน : <label
                                                style="font-size:20px;color: rgb(131, 120, 47, 1);"><strong><?php echo number_format($row4['daily_price']); ?></strong></label>
                                            บาท
                                        </p>
                                    </div>

                                    <p>จำนวนห้องพักที่เหลือ : <?php echo $total_int2; ?> ห้อง</p>
                                </div>
                            </div>
                            <?php }}}else{ echo "ไม่มีห้องว่างให้เช่า";} ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../../js/employee/roomList.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>