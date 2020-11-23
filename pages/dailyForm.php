<?php
    include('connection.php');
    include('../components/maintopbar.php');
    @$get_checkin = $_REQUEST['check_in'];
    @$get_checkout = $_REQUEST['check_out'];
    $room_type = $_REQUEST['room_type'];
    $count = "SELECT * FROM daily WHERE room_type = '$room_type' AND ((check_in BETWEEN '$get_checkin' AND '$get_checkout') OR (check_out BETWEEN '$get_checkin' AND '$get_checkout') OR ('$get_checkin' BETWEEN check_in AND check_out) OR ('$get_checkout' BETWEEN check_in AND check_out ))";
    $countresult = $conn->query($count);
    $typetotal_int = 0;
    if ($countresult->num_rows > 0) {
        while($data = $countresult->fetch_assoc()) {
            $typetotal_int += $data["room_count"];
        }
    } else {
        $typetotal_int = 0;
    }
    $countroom = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal FROM roomlist WHERE room_type = '$room_type' AND (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
    $roomdata= mysqli_fetch_assoc($countroom);  
    $roomtotal_int = intval($roomdata['roomtotal']);
    $total_int = $roomtotal_int - $typetotal_int;
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
    <link rel="stylesheet" href="../css/dailyForm.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div class="dailyForm">
            <h2>แบบฟอร์มจองห้องพัก</h2>
            <div class="hr"></div>
            <h3>ประเภทห้องพัก : <label style="color: #b3994c;font-weight: bold;">ห้อง<?php echo $room_type; ?></label>
            </h3>
            <form
                action="mainpage_function/addDailyForm.php?room_type=<?php echo $room_type; ?>&check_in=<?php echo $get_checkin; ?>&check_out=<?php echo $get_checkout; ?>"
                method="POST" onsubmit="return confirm('คุณต้องการจองห้องพักใช่หรือไม่ ?');">
                <div class="row">
                    <div class="col-4">
                        <p>ชื่อ</p>
                        <input type="text" name="firstname" required>
                    </div>
                    <div class="col-4">
                        <p>นามสกุล</p>
                        <input type="text" name="lastname" required>
                    </div>
                    <div class="col-4">
                        <p>เลขบัตรประชาชน / Passport</p>
                        <input type="text" name="id_card" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <p>อีเมล</p>
                        <input type="email" name="email" required>
                    </div>
                    <div class="col-3">
                        <p>เบอร์โทรศัพท์</p>
                        <input type="tel" name="tel" required>
                    </div>
                    <div class="col-2">
                        <p>เช็คอิน</p>
                        <input type="text" name="check_in_input" value="<?php echo DateThai($get_checkin); ?>" readonly>
                    </div>
                    <div class="col-2">
                        <p>เช็คเอ้าท์</p>
                        <input type="text" name="check_out_input" value="<?php echo DateThai($get_checkout); ?>"
                            readonly>
                    </div>
                    <div class="col-1">
                        <p>จำนวนห้อง</p>
                        <input type="number" name="room_count" min="1" max="<?php echo $total_int; ?>" required>
                    </div>
                </div>
                <div style="padding-top:64px;display:flex;justify-content:center;">
                    <button type="submit" name="accept_daily">ยืนยันการจอง</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>