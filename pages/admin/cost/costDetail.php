<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strMonthThai $strYear";
    }
    function DateThai2($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    $cost_id = $_REQUEST["cost_id"];
    $sql = "SELECT * FROM cost WHERE cost_id = $cost_id";
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
    <link rel="stylesheet" href="../../../css/costDetail.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <script src="../../../js/admin/costDetail.js"></script>
    <title>Document</title>
</head>

<body>
    <?php include('../../../components/sidebar.php'); ?>
    <div class="box">
        <div style="padding:24px;">
            <div class="costDetail-box">
                <form action="function/editcost.php?cost_id=<?php echo $cost_id; ?>" method="POST">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <h3>รายละเอียดการชำระเงิน</h3>
                        <button type="button" class="edit-btn"></button>
                        <div class="edit-option" style="display:none;">
                            <button type="submit" class="correct-btn" id="accept-edit" name="accept-edit" title="ยืนยันการแก้ไข"></button>
                            <button type="button" class="cancel-btn" id="cancel-edit" title="ยกเลิกการแก้ไข"></button>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="grid-container">
                        <div class="room_id">
                            <p>เลขห้อง</p>
                            <input type="text" id="room_id" value="<?php echo $room_id; ?>" disabled>
                        </div>
                        <div class="room_type">
                            <p>ประเภทห้องพัก</p>
                            <input type="text" id="room_type" value="<?php echo $room_type; ?>" disabled>
                        </div>
                        <div class="date">
                            <p>ประจำเดือน</p>
                            <input type="text" id="cost_date" value="<?php echo DateThai($date); ?>" disabled>
                        </div>
                        <div class="room_cost">
                            <p>ค่าห้องพัก (บาท)</p>
                            <input type="text" id="room_price" value="<?php echo $room_cost; ?>" disabled>
                        </div>
                        <div class="cable_charge">
                            <p>ค่าเคเบิล (บาท)</p>
                            <input type="text" id="cable_price" value="<?php echo $cable_charge; ?>" disabled>
                        </div>
                        <div class="water_bill">
                            <p>ค่าน้ำ (บาท)</p>
                            <input type="text" id="water_price" value="<?php echo $water_bill; ?>" disabled>
                        </div>
                        <div class="elec_bill">
                            <p>ค่าไฟ (บาท)</p>
                            <input type="text" id="elec_price" value="<?php echo $elec_bill; ?>" disabled>
                        </div>
                        <div class="total">
                            <p>ยอดรวม (บาท)</p>
                            <input type="text" id="total_price" value="<?php echo $total; ?>" disabled>
                        </div>
                        <div class="cost_status">
                            <p>สถานะการชำระเงิน</p>
                            <input type="text" id="cost_status" value="<?php echo $cost_status; ?>" disabled>
                        </div>
                        <div class="pay_date">
                            <p>วันที่ชำระเงิน</p>
                            <input type="text" id="pay_date" value="<?php if(isset($pay_date)){ echo DateThai2($pay_date); } ?>"
                                disabled>
                        </div>
                    </div>
                </form>
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