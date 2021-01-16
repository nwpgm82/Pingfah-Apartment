<?php
    session_start();
    include('connection.php');
    include('../components/maintopbar.php');
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    $_SESSION["check_in"] = @$_POST['check_in'];
    $_SESSION["check_out"] = @$_POST['check_out'];
    $_SESSION["people"] = @$_POST['people'];
    $_SESSION["air"] = @$_POST['air'];
    $_SESSION["fan"] = @$_POST['fan'];
    $date1 = date_create($_SESSION["check_in"]);
    $date2 = date_create($_SESSION["check_out"]);
    $diff= date_diff($date1,$date2);
    $checkdate_result = $diff->format("%R%a days");
    if(date("Y-m-d") == $_SESSION["check_in"]){
        $_SESSION["payment_datebefore"] = $_SESSION["check_in"];
        $datetime_result = DateThai($_SESSION["check_in"]);
    }else{
        $datetime = new DateTime('tomorrow');
        $_SESSION["payment_datebefore"] = $datetime->format('Y-m-d');
        $datetime_result = DateThai($datetime->format('Y-m-d'));
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dailyForm.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../js/dailyForm.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div class="dailyForm">
            <h2>แบบฟอร์มจองห้องพัก</h2>
            <div class="hr"></div>
            <form action="mainpage_function/addDailyForm.php" method="POST">
                <div class="grid-container">
                    <div class="name_title">
                        <p>คำนำหน้าชื่อ</p>
                        <select name="name_title" id="">
                            <option value="นาย">นาย</option>
                            <option value="นาง">นาง</option>
                            <option value="นางสาว">นางสาว</option>
                        </select>
                    </div>
                    <div class="firstname">
                        <p>ชื่อ</p>
                        <input type="text" name="firstname" id="firstname">
                        <h5 id="fs_error" style="color:red;"></h5>
                    </div>
                    <div class="lastname">
                        <p>นามสกุล</p>
                        <input type="text" name="lastname" id="lastname">
                        <h5 id="ls_error" style="color:red;"></h5>
                    </div>
                    <div class="id_card">
                        <p>เลขบัตรประชาชน / Passport No.</p>
                        <input type="text" name="id_card" id="id_card">
                        <h5 id="id_error" style="color:red;"></h5>
                    </div>
                    <div class="email">
                        <p>อีเมล</p>
                        <input type="text" name="email" id="email">
                        <h5 id="em_error" style="color:red;"></h5>
                    </div>
                    <div class="tel">
                        <p>เบอร์โทรศัพท์</p>
                        <input type="text" name="tel" id="tel">
                        <h5 id="tel_error" style="color:red;"></h5>
                    </div>
                    <div class="check_in">
                        <p>เช็คอิน</p>
                        <input type="text" name="check_in" id="check_in" value="<?php echo DateThai($_SESSION["check_in"]); ?>" disabled>
                    </div>
                    <div class="check_out">
                        <p>เช็คเอ้าท์</p>
                        <input type="text" name="check_out" id="check_out" value="<?php echo DateThai($_SESSION["check_out"]); ?>" disabled>
                    </div>
                    <div class="people">
                        <p>จำนวนผู้พัก(คน)</p>
                        <input type="text" name="people" id="people" value="<?php echo $_SESSION["people"]; ?>" disabled>
                    </div>
                    <div class="air">
                        <p>ห้องแอร์(ห้อง)</p>
                        <input type="text" name="air" id="air" value="<?php echo $_SESSION["air"]; ?>" disabled>
                    </div>
                    <div class="fan">
                        <p>ห้องพัดลม(ห้อง)</p>
                        <input type="text" name="fan" id="fan" value="<?php echo $_SESSION["fan"]; ?>" disabled>
                    </div>
                </div>
                <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                    <button type="submit" id="confirm" name="accept_daily">ยืนยันการจองห้องพัก</button>
                </div>
            </form>
            <?php echo $datetime_result ."/" .$_SESSION["payment_datebefore"];?>
        </div>
    </div>
</body>

</html>