<?php
    include('connection.php');
    include('../components/maintopbar.php');
    @$check_in = $_POST['check_in'];
    @$check_out = $_POST['check_out'];
    @$people = $_POST['people'];
    @$air = $_POST['air'];
    @$fan = $_POST['fan'];
    $date1 = date_create($check_in);
    $date2 = date_create($check_out);
    $diff= date_diff($date1,$date2);
    $checkdate_result = $diff->format("%R%a days");
    if(date("Y-m-d") == $check_in){  
        $datetime_result = DateThai($check_in);
    }else{
        $datetime = new DateTime('tomorrow');
        $datetime_result = DateThai($datetime->format('Y-m-d'));
    }
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
            <form action="mainpage_function/addDailyForm.php?check_in=<?php echo $check_in;?>&check_out=<?php echo $check_out;?>&people=<?php echo $people;?>&air=<?php echo $air;?>&fan=<?php echo $fan;?>" method="POST" onsubmit="return confirm('คุณต้องการจองห้องพักใช่หรือไม่ ?');">
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
                    <div class="col-3">
                        <p>อีเมล</p>
                        <input type="email" name="email" required>
                    </div>
                    <div class="col-2">
                        <p>เบอร์โทรศัพท์</p>
                        <input type="tel" name="tel" required>
                    </div>
                    <div class="col-2">
                        <p>เช็คอิน</p>
                        <input type="text" name="check_in_input" value="<?php echo DateThai($check_in); ?>" readonly>
                    </div>
                    <div class="col-2">
                        <p>เช็คเอ้าท์</p>
                        <input type="text" name="check_out_input" value="<?php echo DateThai($check_out); ?>" readonly>
                    </div>
                    <div class="col-1">
                        <p>จำนวนผู้พัก</p>
                        <input type="text" name="people" value="<?php echo $people; ?>" readonly>
                    </div>
                    <div class="col-1">
                        <p>ห้องแอร์</p>
                        <input type="number" name="air" value="<?php echo $air; ?>" readonly>
                    </div>
                    <div class="col-1">
                        <p>ห้องพัดลม</p>
                        <input type="number" name="fan" value="<?php echo $fan; ?>" readonly>
                    </div>
                </div>
                <div style="line-height:40px;">
                    <p style="color:red;"><strong>*** โปรดวางเงินมัดจำค่าห้องเป็นจำนวน 1,000 บาท ก่อนวันที่ <?php echo $datetime_result; ?> มิเช่นนั้นการจองห้องพักจะถูกยกเลิก ***</strong></p>
                <p style="color:red;"><strong>*** เงินมัดจำจะได้คืนก็ต่อเมื่อเช็คเอ้าท์เรียบร้อยแล้ว ***</strong></p>
                </div>
                <div style="padding-top:64px;display:flex;justify-content:center;">
                    <button type="submit" name="accept_daily">ยืนยันการจอง</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>