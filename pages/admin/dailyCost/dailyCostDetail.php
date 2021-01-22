<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="dailyCostDetail-box">
                <h3>เลขที่ในการจอง : <?php echo $code; ?></h3>
                <div class="hr"></div>
                <div>
                    <div class="row">
                        <div class="col-3">
                            <p>เลขห้องที่จอง</p>
                            <input type="text" value="<?php echo $room_id; ?>" disabled>
                        </div>
                        <div class="col-1">
                            <p>คำนำหน้าชื่อ</p>
                            <input type="text" value="<?php echo $name_title; ?>" disabled>
                        </div>
                        <div class="col-4">
                            <p>ชื่อ</p>
                            <input type="text" value="<?php echo $firstname; ?>" disabled>
                        </div>
                        <div class="col-4">
                            <p>นามสกุล</p>
                            <input type="text" value="<?php echo $lastname; ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p>เลขบัตรประชาชน / Passport</p>
                            <input type="text" value="<?php echo $id_card; ?>" disabled>
                        </div>
                        <div class="col-4">
                            <p>อีเมล</p>
                            <input type="email" value="<?php echo $email; ?>" disabled>
                        </div>
                        <div class="col-4">
                            <p>เบอร์โทรศัพท์</p>
                            <input type="tel" value="<?php echo $tel; ?>" disabled>
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
                        <div class="col-2">
                            <p>ราคารวม</p>
                            <input type="text" value="<?php echo $total_price ?>" disabled>
                        </div>
                        <div class="col-2">
                            <p>สถานะการชำระเงิน</p>
                            <input type="text" value="<?php echo $pay_status ?>" disabled>
                        </div>
                    </div>
                </div>
                <div style="padding-top:32px;">
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