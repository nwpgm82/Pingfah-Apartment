<?php
$code = @$_REQUEST["code"];
function DateThai($strDate)
{
    $strYear = date("Y",strtotime($strDate));
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/checkCode.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <title>Document</title>
</head>

<body>
    <?php
    include("../components/maintopbar.php");
    ?>
    <div class="box">
        <div class="search">
            <label style="padding:9px 8px 0 0">ค้นหาเลขที่การจอง : </label>
            <div>
               <input type="text" id="code" value="<?php echo $code; ?>"> 
               <h5 id="code_error" style="color:red;"></h5>
            </div>
            
            <button style="margin: 0 8px;" id="searchCode">ค้นหา</button>
        </div>
        <div class="hr"></div>
        <?php
        if(isset($code)){
            include("connection.php");
            $sql = "SELECT * FROM daily WHERE code = '$code' LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
        ?>
        <div class="checkCode-box">
            <h3>รายละเอียดในการจองห้องพัก</h3>
            <div class="grid-container">
                <div class="name_title">
                    <p>คำนำหน้าชื่อ</p>
                    <input type="text" value="<?php echo $row["name_title"]; ?>" disabled>
                </div>
                <div class="firstname">
                    <p>ชื่อ</p>
                    <input type="text" value="<?php echo $row["firstname"]; ?>" disabled>
                </div>
                <div class="lastname">
                    <p>นามสกุล</p>
                    <input type="text" value="<?php echo $row["lastname"]; ?>" disabled>
                </div>
                <div class="id_card">
                    <p>เลขบัตรประชาชน / Passport No.</p>
                    <input type="text" value="<?php echo $row["id_card"]; ?>" disabled>
                </div>
                <div class="email">
                    <p>อีเมล</p>
                    <input type="text" value="<?php echo $row["email"]; ?>" disabled>
                </div>
                <div class="tel">
                    <p>เบอร์โทรศัพท์</p>
                    <input type="text" value="<?php echo $row["tel"]; ?>" disabled>
                </div>
                <div class="check_in">
                    <p>เช็คอิน</p>
                    <input type="text" value="<?php echo DateThai($row["check_in"]); ?>" disabled>
                </div>
                <div class="check_out">
                    <p>เช็คเอ้าท์</p>
                    <input type="text" value="<?php echo DateThai($row["check_in"]); ?>" disabled>
                </div>
                <div class="night">
                    <p>จำนวนคืนที่พัก (คืน)</p>
                    <input type="text" name="night" id="night" value="<?php echo $row["night"]; ?>" disabled>
                </div>
                <div class="people">
                    <p>จำนวนผู้พัก(คน)</p>
                    <input type="text" name="people" id="people" value="<?php echo $row["people"]; ?>" disabled>
                </div>
                <div class="air">
                    <p>ห้องแอร์(ห้อง)</p>
                    <input type="text" name="air" id="air" value="<?php echo $row["air_room"]; ?>" disabled>
                </div>
                <div class="fan">
                    <p>ห้องพัดลม(ห้อง)</p>
                    <input type="text" name="fan" id="fan" value="<?php echo $row["fan_room"]; ?>" disabled>
                </div>
                <div class="total_price">
                    <p>ราคารวม (บาท)</p>
                    <input type="text" value="<?php echo number_format($row["total_price"]); ?>" disabled>
                </div>
                <div class="vat">
                    <p>ภาษีมูลค่าเพิ่ม (VAT)</p>
                    <input type="text" name="total_price" id="total_price" value="7%" disabled>
                </div>
                <div class="status">
                    <label>สถานะการจอง :</label>
                    <input type="text" class="input-status" value="<?php echo $row['daily_status']; ?>" disabled>
                </div>
            </div>
            <div style="padding-top:32px;">
                <h3>ขั้นตอนในการจองห้องพัก</h3>
                <div style="line-height:40px;padding-top:16px;">
                    <p>1. เมื่อจองห้องพักแล้ว ให้โอนเงินจำนวน <strong style="color:red;"><?php echo number_format($row['payment_price']); ?> บาท (จำนวนห้องพัก x 300)</strong> มาที่บัญชีพร้อมเพย์ <strong>095-6722914 (นวพล นรเดชานันท์)</strong> หรือ สแกน QR code ได้<a href="../img/tool/qr-code.png" target="_blank">ที่นี่</a> ก่อนวันที่ <strong style="color:red;"><?php echo DateThai($row['payment_datebefore']); ?></strong> มิเช่นนั้นการจองห้องพักจะถือว่าเป็นโมฆะ</p>
                    <p>2. เมื่อโอนเงินแล้วให้อัปโหลดสลิปในเมนู <a href="checkCode.php" target="_blank">ตรวจสอบการจอง</a> </p>
                    <p>3. เมื่ออัปโหลดสลิปแล้วให้แจ้งเจ้าของหอพัก หรือพนักงานเพื่อแจ้งให้ทราบว่าท่านได้โอนเงินแล้ว</p>
                    <p>4. รอการยืนยันจากเจ้าของหอพัก หรือพนักงาน</p>
                    <p>5. เมื่อได้รับการยืนยันแล้ว ให้ท่านชำระเงิน ณ ที่พัก และเข้าพักตามวันที่ท่านได้จองห้องพักไว้ <strong>(เข้าพักได้ในเวลา 14.00 น. เป็นต้นไป)</strong></p>
                </div>
            </div>
            <form action="mainpage_function/addPayment_image.php?daily_id=<?php echo $row['daily_id']; ?>" method="POST" enctype="multipart/form-data">
                <div style="padding-top:32px;height:659px;">
                    <h3>หลักฐานการชำระเงินค่ามัดจำห้องพัก</h3>
                    <div class="hr"></div>
                    <div>
                        <div class="img-box" id="id_box">
                            <img id="img_id" <?php if(isset($row['payment_img'])){ echo "src='images/daily/".$row['daily_id']."/".$row['payment_img']."'"; } ?> <?php if(!isset($row['payment_img'])){ echo "style='display:none;'"; }?> />
                            <?php
                            if(isset($row['payment_img']) && $row['daily_status'] == 'รอการยืนยัน'){ ?>
                            <button class="del-btn" type="button" id="del-btn1" style="margin:0;" onclick="delImg('<?php echo $row['daily_id']; ?>','<?php echo $row['payment_img']; ?>')"></button>
                            <?php } ?>
                        </div>
                        <h5 id="idimg_error" style="color:red;"></h5>
                        <?php
                        if(!isset($row['payment_img']) && $row['daily_status'] == 'รอการยืนยัน'){ ?>
                        <input type="file" id="pic_idcard1" style="padding-top:16px;" name="payment_img">
                        <?php } ?>
                    </div>
                </div>
                <?php
                if($row["daily_status"] != "ยกเลิกการจอง" && $row["daily_status"] != "เช็คเอ้าท์แล้ว" && $row["daily_status"] != "เข้าพักแล้ว"){
                ?>
                <div class="hr"></div>
                <div style="display:flex;justify-content:center;">
                <?php
                if(!isset($row['payment_img']) && $row['daily_status'] == 'รอการยืนยัน'){
                ?>
                    <button type="submit" disabled>ยืนยัน</button>
                <?php } ?>
                    <button type="button" class="cancel-btn" id="cancel_daily">ยกเลิกการจองห้องพัก</button>
                </div>
                <?php } ?>
            </form>
        </div>
        <?php 
        }}else{
            echo "ไม่พบข้อมูล";
        }}
        ?>
    </div>
    <script src="../js/checkCode.js"></script>
</body>

</html>