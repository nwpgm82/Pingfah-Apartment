<?php
    include('connection.php');
    include('components/maintopbar.php');
    @$get_checkin = $_REQUEST['check_in'];
    @$get_checkout = $_REQUEST['check_out'];
    $room_type = $_REQUEST['room_type'];
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    // if($check_in && $check_out && $room_type != null){
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
            <h3>ประเภทห้องพัก : <label style="color: #b3994c;font-weight: bold;">ห้อง<?php echo $room_type; ?></label></h3>
            <form action="mainpage_function/addDailyForm.php?room_type=<?php echo $room_type; ?>&check_in=<?php echo $get_checkin; ?>&check_out=<?php echo $get_checkout; ?>" method="POST" onsubmit="return confirm('คุณต้องการจองห้องพักใช่หรือไม่ ?');">
                <div class="row">
                    <div class="col-4">
                        <p>ชื่อ</p>
                        <input type="text" name="firstname">
                    </div>
                    <div class="col-4">
                        <p>นามสกุล</p>
                        <input type="text" name="lastname">
                    </div>
                    <div class="col-4">
                        <p>เลขบัตรประชาชน / Passport</p>
                        <input type="text" name="id_card">
                    </div>
                </div>
                <div class="row">
                <div class="col-4">
                        <p>อีเมล</p>
                        <input type="email" name="email">
                    </div>
                    <div class="col-4">
                        <p>เบอร์โทรศัพท์</p>
                        <input type="tel" name="tel">
                    </div>
                    <div class="col-2">
                        <p>เช็คอิน</p>
                        <input type="text" name="check_in_input" value="<?php echo DateThai($get_checkin); ?>" readonly>
                    </div>
                    <div class="col-2">
                        <p>เช็คเอ้าท์</p>
                        <input type="text" name="check_out_input" value="<?php echo DateThai($get_checkout); ?>" readonly>
                    </div>
                </div>
                <div style="padding-top:64px;display:flex;justify-content:center;">
                    <button type="submit" name="accept_daily">ยืนยันการจอง</button>
                </div>
            </form>
        </div>
    </div>
    <!-- <script>
        var el = document.getElementById('myCoolForm');
    </script> -->
</body>

</html>
<?php
    // }else{
    //     Header("Location: checkRoom.php"); 
    // }
?>