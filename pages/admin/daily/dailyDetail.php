<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
    $daily_id = $_REQUEST['daily_id'];
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    $sql = "SELECT * FROM daily WHERE daily_id = $daily_id";
    $result = mysqli_query($conn, $sql)or die ("Error in query: $sql " . mysqli_error());
    $row = mysqli_fetch_array($result);
    if($row != null){
        extract($row);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/dailyDetail.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="dailyDetail-box">
                <!-- <h3>รายละเอียดการจอง</h3> -->
                <h3>เลขที่ในการจอง : </strong><?php echo $code; ?></h3>
                <div class="hr"></div>
                <div>
                    <div class="grid-container">
                        <div class="room_select">
                            <p>ห้องที่เลือก</p>
                            <input type="text" value="<?php echo $room_select; ?>" disabled>
                        </div>
                        <div class="name_title">
                            <p>คำนำหน้าชื่อ</p>
                            <input type="text" value="<?php echo $name_title; ?>" disabled>
                        </div>
                        <div class="firstname">
                            <p>ชื่อ</p>
                            <input type="text" value="<?php echo $firstname; ?>" disabled>
                        </div>
                        <div class="lastname">
                            <p>นามสกุล</p>
                            <input type="text" value="<?php echo $lastname; ?>" disabled>
                        </div>
                        <div class="id_card">
                            <p>เลขบัตรประชาชน / Passport</p>
                            <input type="text" value="<?php echo $id_card; ?>" disabled>
                        </div>
                        <div class="email">
                            <p>อีเมล</p>
                            <input type="email" value="<?php echo $email; ?>" disabled>
                        </div>
                        <div class="tel">
                            <p>เบอร์โทรศัพท์</p>
                            <input type="tel" value="<?php echo $tel; ?>" disabled>
                        </div>
                        <div class="check_in">
                            <p>เช็คอิน</p>
                            <input type="text" value="<?php echo DateThai($check_in); ?>" disabled>
                        </div>
                        <div class="check_out">
                            <p>เช็คเอ้าท์</p>
                            <input type="text" value="<?php echo DateThai($check_out); ?>" disabled>
                        </div>
                        <div class="night">
                            <p>จำนวนวันที่พัก (คืน)</p>
                            <input type="text" value="<?php echo $night; ?>" disabled>
                        </div>
                        <div class="people">
                            <p>จำนวน (ท่าน)</p>
                            <input type="number" value="<?php echo $people; ?>" disabled>
                        </div>
                        <div class="air">
                            <p>ห้องแอร์ (ห้อง)</p>
                            <input type="number" value="<?php echo $air_room; ?>" disabled>
                        </div>
                        <div class="fan">
                            <p>ห้องพัดลม (ห้อง)</p>
                            <input type="number" value="<?php echo $fan_room; ?>" disabled>
                        </div>
                        <div class="room_status">
                            <p>สถานะการเข้าพัก</p>
                            <input type="email" value="<?php if(isset($daily_status)){ echo $daily_status; }else{ echo "ยังไม่ได้เข้าพัก"; } ?>" disabled>
                        </div>
                    </div>
                    <div style="padding-top:32px;">
                        <h3>หลักฐานการชำระเงินค่ามัดจำห้องพัก</h3>
                        <div class="hr"></div>
                        <div class="img-box">
                            <?php
                            if($payment_img != null || $payment_img != ""){
                            ?>
                            <img src="../../../img/tool/bill.jpg" alt="">
                            <button class="del-btn"
                                onclick="delImg(<?php echo $daily_id; ?>,'<?php echo $payment_img; ?>')">X</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/dailyDetail.js"></script>
</body>

</html>

<?php
}else{
    Header("Location: ../../login.php"); 
}

?>