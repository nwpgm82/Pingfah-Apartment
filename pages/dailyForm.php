<?php
    session_start();
    include('connection.php');
    include('../components/maintopbar.php');
    require_once("../lib/PromptPayQR.php");
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    $getAir_price = mysqli_query($conn,"SELECT daily_price, daily_deposit FROM roomdetail WHERE type='แอร์'");
    $getAir_result = mysqli_fetch_assoc($getAir_price); 
    $getFan_price = mysqli_query($conn,"SELECT daily_price, daily_deposit FROM roomdetail WHERE type='พัดลม'");
    $getFan_result = mysqli_fetch_assoc($getFan_price);
    $getVAT = mysqli_query($conn, "SELECT daily_vat FROM roomdetail WHERE type = 'แอร์' OR type = 'พัดลม'");
    $getVAT_result = mysqli_fetch_assoc($getVAT);
    $_SESSION["check_in"] = @$_POST['check_in'];
    $_SESSION["check_out"] = @$_POST['check_out'];
    $_SESSION["people"] = @$_POST['people'];
    if(isset($_POST["air"])){
        $_SESSION["air"] = $_POST['air'];
    }else{
        $_SESSION["air"] = 0;
    }
    if(isset($_POST["fan"])){
        $_SESSION["fan"] = $_POST['fan'];
    }else{
        $_SESSION["fan"] = 0;
    }
    $_SESSION["vat"] = $getVAT_result["daily_vat"];
    $_SESSION["total_room_price"] = ((intval($_SESSION["air"]) * $getAir_result["daily_price"]) + (intval($_SESSION["fan"]) * $getFan_result["daily_price"])) * $_SESSION["night"];
    $cal_vat = ($_SESSION["total_room_price"] * $_SESSION["vat"])/100;
    $_SESSION["total_price"] = ceil($_SESSION["total_room_price"] + $cal_vat);
    // $date1 = date_create($_SESSION["check_in"]);
    // $date2 = date_create($_SESSION["check_out"]);
    // $diff= date_diff($date1,$date2);
    // $checkdate_result = $diff->format("%R%a days");
    // if(date("Y-m-d") == $_SESSION["check_in"]){
    //     $_SESSION["payment_datebefore"] = $_SESSION["check_in"];
    //     $datetime_result = DateThai($_SESSION["check_in"]);
    // }else{
    //     $datetime = new DateTime('tomorrow');
    //     $_SESSION["payment_datebefore"] = $datetime->format('Y-m-d');
    //     $datetime_result = DateThai($datetime->format('Y-m-d'));
    // }
    $_SESSION["total_room"] = (intval($_SESSION["air"]) * $getAir_result["daily_deposit"]) + (intval($_SESSION["fan"]) * $getFan_result["daily_deposit"]);
    $getPrompt = mysqli_query($conn, "SELECT * FROM promptpay");
    $getPrompt_result = mysqli_fetch_assoc($getPrompt);
    $PromptPayQR = new PromptPayQR(); // new object
    $PromptPayQR->size = 6;
    $PromptPayQR->id = $getPrompt_result["prompt_num"]; // PromptPay ID
    $PromptPayQR->amount = $_SESSION["total_room"]; // Set amount (not necessary)
    // echo '<img src="' . $PromptPayQR->generate() . '" />';
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
            <form action="mainpage_function/addDailyForm.php" method="POST" enctype="multipart/form-data">
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
                        <input type="text" name="firstname" id="firstname" placeholder="ชื่อของท่าน">
                        <h5 id="fs_error" style="color:red;"></h5>
                    </div>
                    <div class="lastname">
                        <p>นามสกุล</p>
                        <input type="text" name="lastname" id="lastname" placeholder="นามสกุลของท่าน">
                        <h5 id="ls_error" style="color:red;"></h5>
                    </div>
                    <div class="id_card">
                        <p>เลขบัตรประชาชน / Passport No.</p>
                        <input type="text" name="id_card" id="id_card" placeholder="เลขบัตรประชาชน / Passport No. ของท่าน">
                        <h5 id="id_error" style="color:red;"></h5>
                    </div>
                    <div class="email">
                        <p>อีเมล</p>
                        <input type="text" name="email" id="email" placeholder="อีเมลของท่าน">
                        <h5 id="em_error" style="color:red;"></h5>
                    </div>
                    <div class="tel">
                        <p>เบอร์โทรศัพท์</p>
                        <input type="text" name="tel" id="tel" placeholder="เบอร์โทรศัพท์ของท่าน">
                        <h5 id="tel_error" style="color:red;"></h5>
                    </div>
                    <div class="check_in">
                        <p>เช็คอิน</p>
                        <input type="text" name="check_in" id="check_in" value="<?php echo DateThai($_SESSION["check_in"]); ?>" disabled>
                    </div>
                    <div class="check_out">
                        <p>เช็คเอาท์</p>
                        <input type="text" name="check_out" id="check_out" value="<?php echo DateThai($_SESSION["check_out"]); ?>" disabled>
                    </div>
                    <div class="night">
                        <p>จำนวนวันที่พัก (คืน)</p>
                        <input type="text" name="night" id="night" value="<?php echo $_SESSION["night"]; ?>" disabled>
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
                    <div class="total_room">
                        <p>ราคาห้องพักรวม (บาท)</p>
                        <input type="text" id="total_room_price" value="<?php echo $_SESSION["total_room_price"]; ?>" disabled>
                    </div>
                    <div class="vat">
                        <p>ภาษีมูลค่าเพิ่ม (VAT)</p>
                        <input type="text" name="vat" id="vat" value="<?php echo $_SESSION["vat"]."%"; ?>" disabled>
                    </div>
                    <div class="total_price">
                        <p>ราคารวม (บาท)</p>
                        <input type="text" name="total_price" id="total_price" value="<?php echo $_SESSION["total_price"]; ?>" disabled>
                    </div>
                </div>
                <div style="padding-top:32px;">
                    <h3>การมัดจำค่าห้องพัก</h3>
                    <div class="hr"></div>
                    <div class="payment-grid">
                        <div>
                            <h3>1. โปรดชำระเงินจำนวน <?php echo $_SESSION["total_room"]; ?> บาท เพื่อเป็นค่ามัดจำค่าห้องพักผ่าน QR Code ด้านล่าง</h3>
                            <div class="qr-box">
                                <div>
                                  <?php
                                    echo '<img src="' . $PromptPayQR->generate() . '" />';
                                    ?>
                                    <div style="line-height:30px;text-align:center;">
                                        <p><strong>จำนวนเงิน <?php echo $_SESSION["total_room"]; ?> บาท</strong></p>
                                        <p><strong>( <?php echo $getPrompt_result["prompt_num"]." : ".$getPrompt_result["prompt_name"]; ?> )</strong></p>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3>2. เมื่อชำระเงินค่ามัดจำค่าห้องพักแล้ว ให้อัปโหลดหลักฐานการชำระเงินด้านล่าง</h3>
                            <div class="qr-box2">
                                <div class="img-box">
                                    <img src="" alt="" id="img_id" style="display:none;">
                                </div>
                                <h5 id="qr_error" style="color:red;"></h5>
                                <input type="file" name="deposit_img" id="deposit_img">
                            </div>
                        </div>
                    </div>
                    <!-- <h3>ขั้นตอนในการจองห้องพัก</h3>
                    <div style="line-height:40px;padding-top:16px;">
                        <p>1. เมื่อจองห้องพักแล้ว ให้โอนเงินจำนวน <strong style="color:red;"><?php echo number_format($_SESSION["total_room"]); ?> บาท</strong> มาที่บัญชีพร้อมเพย์ <strong><?php echo $getPrompt_result["prompt_num"]; ?> (<?php echo $getPrompt_result["prompt_name"]; ?>)</strong> หรือ สแกน QR code ได้<a href="../img/tool/qr-code.png" target="_blank">ที่นี่</a> ก่อนวันที่ <strong style="color:red;"><?php echo $datetime_result; ?></strong> มิเช่นนั้นการจองห้องพักจะถือว่าเป็นโมฆะ</p>
                        <p>2. เมื่อโอนเงินแล้วให้อัปโหลดสลิปในเมนู <a href="checkCode.php" target="_blank">ตรวจสอบการจอง</a> </p>
                        <p>3. เมื่ออัปโหลดสลิปแล้วให้แจ้งเจ้าของหอพัก หรือพนักงานเพื่อแจ้งให้ทราบว่าท่านได้โอนเงินแล้ว</p>
                        <p>4. รอการยืนยันจากเจ้าของหอพัก หรือพนักงาน</p>
                        <p>5. เมื่อได้รับการยืนยันแล้ว ให้ท่านชำระเงิน ณ ที่พัก และเข้าพักตามวันที่ท่านได้จองห้องพักไว้ <strong>(เข้าพักได้ในเวลา 14.00 น. เป็นต้นไป)</strong></p>
                    </div> -->
                </div>
                <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                    <input type="checkbox" name="" id="confirm_check">
                    <label>ท่านได้กรอกข้อมูลถูกต้อง และครบถ้วนแล้ว</label>
                </div>
                <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                    <button type="submit" id="confirm" name="accept_daily" disabled>ยืนยันการจองห้องพัก</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>