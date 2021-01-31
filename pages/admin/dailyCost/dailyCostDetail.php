<?php
session_start();
if($_SESSION['level'] == 'admin'){
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
    $sql = "SELECT * FROM dailycost WHERE dailycost_id = $dailycost_id";
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
                            <input type="text" value="<?php echo $room_id; ?>" disabled>
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
                            <p>เช็คเอ้าท์</p>
                            <input type="text" value="<?php echo DateThai($check_out); ?>" disabled>
                        </div>
                        <div class="total_price">
                            <p>ราคารวม (บาท)</p>
                            <input type="text" value="<?php echo $total_price ?>" disabled>
                        </div>
                        <div class="status">
                            <p>สถานะการชำระเงิน</p>
                            <input type="text" value="<?php echo $pay_status ?>" disabled>
                        </div>
                    </div>
                </div>
                <div id="copy-box" style="padding-top:32px;">
                    <h3>หลักฐานการชำระเงินค่าห้องพัก</h3>
                    <div class="hr"></div>
                    <div class="img-box">
                        <?php
                        if($pay_img != null || $pay_img != ""){
                        ?>
                        <img src="../../images/daily/<?php echo $dailycost_id; ?>/<?php echo $pay_img; ?>" alt="">
                        <button class="del-btn" onclick="delImg(<?php echo $dailycost_id; ?>,'<?php echo $pay_img; ?>')">X</button>
                        <?php } ?>
                    </div>
                    <?php
                    if($pay_img == null){
                    ?>
                    <div style="padding-top:16px;">
                        <form id="submitForm" enctype="multipart/form-data">
                            <input type="file" name="file" id="file" class="inputfile" />
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/dailyCostDetail.js"></script>
</body>

</html>

<?php
}else{
    Header("Location: ../../login.php"); 
}

?>