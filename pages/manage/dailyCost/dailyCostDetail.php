<?php
session_start();
if($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'employee'){
    include('../../connection.php');
    $dailycost_id = $_REQUEST['dailycost_id'];
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    $sql = "SELECT a.*, b.* FROM dailycost a INNER JOIN daily b ON a.dailycost_id = b.daily_id WHERE a.dailycost_id = $dailycost_id";
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
    <link rel="stylesheet" href="../../../css/dailyCostDetail.css">
    <link rel="stylesheet" href="../../../css/navbar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../../../js/sidebar.js"></script>
    <title>Pingfah Apartment</title>
</head>

<body>
    <?php include('../../../components/sidebar.php'); ?>
    <div class="box">
        <div id="box-padding" style="padding:24px;">
            <div class="dailyCostDetail-box">
                <h3>เลขที่ในการจอง : <?php echo $code; ?></h3>
                <div class="hr"></div>
                <div>
                    <div class="grid-container">
                        <div class="room_select">
                            <p>เลขห้องที่จอง</p>
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
                            <p>เลขบัตรประชาชน / Passport No.</p>
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
                            <p>เช็คเอาท์</p>
                            <input type="text" value="<?php echo DateThai($check_out); ?>" disabled>
                        </div>
                        <div class="daily_status">
                            <p>สถานะการเข้าพัก</p>
                            <input type="text" value="<?php echo $daily_status; ?>" disabled>
                        </div>
                        <div class="total_room_price">
                            <p>ค่าเช่าห้องพัก (บาท)</p>
                            <input type="text" value="<?php echo number_format($total_room_price,2); ?>" disabled>
                        </div>
                        <div class="vat">
                            <p>ภาษีมูลค่าเพิ่ม (VAT)</p>
                            <input type="text" value="<?php echo number_format($vat,2)."%"; ?>" disabled>
                        </div>
                        <div class="total_price">
                            <p>ยอดรวมหลังเพิ่มภาษีมูลค่าเพิ่ม (บาท)</p>
                            <input type="text" value="<?php echo number_format($total_price,2); ?>" disabled>
                        </div>
                        <div class="damages">
                            <p>ค่าปรับ (ค่าเสียหาย) (บาท)</p>
                            <input type="text" value="<?php echo number_format($damages,2); ?>" disabled>
                            <?php
                            if($damages != 0){
                            ?>
                            <a href="receipt_damages.php?code=<?php echo $code; ?>" class="print" target="_blank"></a>
                            <?php } ?>
                        </div>
                        <div class="total_allprice">
                            <p>จำนวนเงินรวมทั้งสิ้น (บาท)</p>
                            <input type="text" value="<?php echo number_format($total_allprice,2); ?>" disabled>
                        </div>
                        <div class="status">
                            <p>สถานะการชำระเงิน</p>
                            <input type="text" value="<?php echo $pay_status ?>" disabled>
                        </div>
                    </div>
                </div>
                <form action="function/addImage.php?dailycost_id=<?php echo $dailycost_id; ?>" method="POST"
                    enctype="multipart/form-data">
                    <div id="copy-box" style="padding-top:32px;">
                        <h3>หลักฐานการชำระเงินค่าห้องพัก</h3>
                        <div class="hr"></div>
                        <div class="pay_grid">
                            <div>
                                <p>หลักฐานชำระเงินค่าห้องพัก</p>
                                <div class="img-box" id="img-box">
                                    <?php
                                    if($pay_img != null || $pay_img != ""){
                                    ?>
                                    <img src="../../images/daily/<?php echo $code; ?>/payment/<?php echo $pay_img; ?>"
                                        alt="">
                                    <button type="button" class="del-btn" id="<?php echo $dailycost_id; ?>" name="payment"></button>
                                    <?php 
                                    }else{
                                    ?>
                                    <img id="img_payment" src="" alt="" style="display:none;">
                                    <?php
                                    } 
                                    ?>
                                </div>
                                <h5 id="pay_error" style="color:red;"></h5>
                                <?php
                                if($pay_img == null){
                                ?>
                                <div style="padding-top:16px;">
                                    <input type="file" name="file" id="file" class="inputfile" />
                                </div>
                                <?php } ?>
                            </div>
                            <!---------------------- ยังไม่เสร็จ ----------------------------------------->
                            <div>
                                <p>หลักฐานชำระเงินค่าห้องพัก (กรณีที่มีค่าเสียหาย)</p>
                                <div class="img-box" id="img-box2">
                                    <?php
                                    if($payafter_d_img != null || $payafter_d_img != ""){
                                    ?>
                                    <img src="../../images/daily/<?php echo $code; ?>/damages/<?php echo $payafter_d_img; ?>"
                                        alt="">
                                    <button type="button" class="del-btn" id="<?php echo $dailycost_id; ?>" name="damages"></button>
                                    <?php 
                                    }else{
                                    ?>
                                    <img id="img_d" src="" alt="" style="display:none;">
                                    <?php
                                    } 
                                    ?>
                                </div>
                                <h5 id="d_error" style="color:red;"></h5>
                                <?php
                                if($payafter_d_img == null){
                                ?>
                                <div style="padding-top:16px;">
                                    <input type="file" name="file2" id="file2" class="inputfile" />
                                </div>
                                <?php } ?>
                            </div>
                            <!-- ---------------------------------------------------------------------- -->
                        </div>
                    </div>
                    <?php
                    if($pay_img == null || $payafter_d_img == null){
                    ?>
                    <div class="hr"></div>
                    <div style="display:flex;justify-content:center;align-items:center;">
                        <button id="submitForm" disabled>ยืนยันการแก้ไข</button>
                    </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../js/manage/dailyCostDetail.js"></script>
</body>

</html>

<?php
}else{
    Header("Location: ../../login.php"); 
}

?>