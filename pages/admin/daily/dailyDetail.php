<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
    $daily_id = $_REQUEST['daily_id'];
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
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
                <h3>รายละเอียดการจอง</h3>
                <div class="hr"></div>
                <div>
                    <h3>เลขที่ในการจอง : </strong><?php echo $code; ?></h3>
                    <div class="row">
                        <div class="col-4">
                            <p>ห้องที่เลือก</p>
                            <input type="text" value="<?php echo $room_select ?>" disabled>
                        </div>
                        <div class="col-4">
                            <p>ชื่อ</p>
                            <input type="text" value="<?php echo $firstname ?>" disabled>
                        </div>
                        <div class="col-4">
                            <p>นามสกุล</p>
                            <input type="text" value="<?php echo $lastname ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p>เลขบัตรประชาชน / Passport</p>
                            <input type="text" value="<?php echo $id_card ?>" disabled>
                        </div>
                        <div class="col-4">
                            <p>อีเมล</p>
                            <input type="email" value="<?php echo $email ?>" disabled>
                        </div>
                        <div class="col-4">
                            <p>เบอร์โทรศัพท์</p>
                            <input type="tel" value="<?php echo $tel ?>" disabled>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p>เช็คอิน</p>
                            <input type="text" value="<?php echo DateThai($check_in); ?>" disabled>
                        </div>
                        <div class="col-2">
                            <p>เช็คเอ้าท์</p>
                            <input type="text" value="<?php echo DateThai($check_out); ?>" disabled>
                        </div>
                        <div class="col-1">
                            <p>ห้องแอร์</p>
                            <input type="number" value="<?php echo $air_room; ?>" disabled>
                        </div>
                        <div class="col-1">
                            <p>ห้องพัดลม</p>
                            <input type="number" value="<?php echo $fan_room; ?>" disabled>
                        </div>
                        <div class="col-2">
                            <p>สถานะการเข้าพัก</p>
                            <input type="email"
                                value="<?php if(isset($daily_status)){ echo $daily_status; }else{ echo "ยังไม่ได้เข้าพัก"; } ?>"
                                disabled>
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
                            <button class="del-btn" onclick="delImg(<?php echo $daily_id; ?>,'<?php echo $payment_img; ?>')">X</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
}else{
    Header("Location: ../../login.php"); 
}

?>