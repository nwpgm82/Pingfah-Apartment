<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
    $dailycost_id = $_REQUEST['dailycost_id'];
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
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
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="dailyCostDetail-box">
                <h3>รายละเอียดการจอง</h3>
                <div class="hr"></div>
                <div>
                    <label><strong>เลขที่ในการจอง : </strong><?php echo $code; ?></label>
                    <div class="row">
                        <div class="col-4">
                            <p>เลขห้องที่จอง</p>
                            <input type="text" value="<?php echo $room_id ?>" disabled>
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
                        <div class="col-2">
                            <p>ราคารวม</p>
                            <input type="text" value="<?php echo $price_total ?>" disabled>
                        </div>
                        <div class="col-2">
                            <p>สถานะการชำระเงิน</p>
                            <input type="text" value="<?php echo $daily_status ?>" disabled>
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