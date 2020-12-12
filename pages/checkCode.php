<?php
@$code = $_REQUEST["code"];
function DateThai($strDate){
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
    <link rel="stylesheet" href="../css/checkCode.css">
    <title>Document</title>
</head>

<body>
    <?php
    include("../components/maintopbar.php");
    ?>
    <div class="box">
        <div class="search">
            <label>ค้นหาเลขที่การจอง : </label>
            <input type="text">
        </div>
        <div class="hr"></div>
        <?php
        if(isset($code)){
            include("connection.php");
            $sql = "SELECT * FROM daily WHERE code = '$code'";
            $result = mysqli_query($conn, $sql)or die ("Error in query: $sql " . mysqli_error());
            $row = mysqli_fetch_array($result);
            if($row != null){
            extract($row);
            }    
        ?>
        <div class="checkCode-box">
            <h3>รายละเอียดในการจองห้องพัก</h3>
            <form action="mainpage_function/addPayment_image.php?daily_id=<?php echo $daily_id; ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-4">
                        <p>ชื่อ</p>
                        <input type="text" value="<?php echo $firstname; ?>" disabled>
                    </div>
                    <div class="col-4">
                        <p>นามสกุล</p>
                        <input type="text" value="<?php echo $lastname; ?>" disabled>
                    </div>
                    <div class="col-4">
                        <p>เลขบัตรประชาชน / Passport</p>
                        <input type="text" value="<?php echo $id_card; ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <p>อีเมล</p>
                        <input type="email" value="<?php echo $email; ?>" disabled>
                    </div>
                    <div class="col-2">
                        <p>เบอร์โทรศัพท์</p>
                        <input type="tel" value="<?php echo $tel; ?>" disabled>
                    </div>
                    <div class="col-2">
                        <p>เช็คอิน</p>
                        <input type="text" value="<?php echo DateThai($check_in); ?>" disabled>
                    </div>
                    <div class="col-2">
                        <p>เช็คเอ้าท์</p>
                        <input type="text" value="<?php echo DateThai($check_out); ?>" disabled>
                    </div>
                    <div class="col-1">
                        <p>จำนวนผู้พัก</p>
                        <input type="text" value="<?php echo $people; ?>" disabled>
                    </div>
                    <div class="col-1">
                        <p>ห้องแอร์</p>
                        <input type="number" value="<?php echo $air_room; ?>" disabled>
                    </div>
                    <div class="col-1">
                        <p>ห้องพัดลม</p>
                        <input type="number" value="<?php echo $fan_room; ?>" disabled>
                    </div>
                </div>
                <div style="line-height:40px;">
                    <p style="color:red;"><strong>*** โปรดวางเงินมัดจำค่าห้องเป็นจำนวน 1,000 บาท ก่อนวันที่
                            <?php echo DateThai($payment_datebefore); ?> มิเช่นนั้นการจองห้องพักจะถูกยกเลิก ***</strong>
                    </p>
                    <p style="color:red;"><strong>*** เงินมัดจำจะได้คืนก็ต่อเมื่อเช็คเอ้าท์เรียบร้อยแล้ว ***</strong>
                    </p>
                </div>
                <div style="padding-top:32px;">
                    <h3>หลักฐานการชำระเงินค่ามัดจำห้องพัก</h3>
                    <div class="hr"></div>
                    <div class="img-box">
                        <img id="output_imagepic1" src="images/daily/<?php echo $daily_id; ?>/<?php echo $payment_img; ?>" />
                        <?php
                        if(isset($payment_img)){ ?>
                        <button class="del-btn" type="button" id="del-btn1" onclick="delImg('<?php echo $daily_id; ?>','<?php echo $payment_img; ?>')">X</button>
                        <?php } ?>
                    </div>
                    <?php
                    if(!isset($payment_img)){ ?>
                    <input type="file" id="pic_idcard1" accept="image/*" onchange="preview_image(event,'pic1')" name="payment_img">
                    <?php } ?>
                </div>
                <div class="hr"></div>
                <div style="padding-top:64px;display:flex;justify-content:center;">
                    <button type="submit">ยืนยันการจอง</button>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
    <script src="../js/checkCode.js"></script>
</body>

</html>