<?php
session_start();
if($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'employee' || $_SESSION['level'] == 'guest'){
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
    if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
        $sql = "SELECT * FROM cost WHERE cost_id = $cost_id";
    }else if($_SESSION["level"] == "guest"){
        $sql = "SELECT * FROM cost WHERE cost_id = $cost_id AND member_id = ".$_SESSION["member_id"];
    }
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
    <link rel="stylesheet" href="../../../css/navbar.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../../../js/manage/costDetail.js"></script>
    <script src="../../../js/sidebar.js"></script>
    <title>Pingfah Apartment</title>
</head>

<body>
    <?php include('../../../components/sidebar.php'); ?>
    <?php 
    if($row != null){
    ?>
    <div class="box">
        <div id="box-padding" style="padding:24px;display:grid;grid-template-columns: 1fr 1fr;column-gap:16px;">
            <div id="c">
                <div class="costDetail-box" id="c_detail">
                    <form action="function/editcost.php?cost_id=<?php echo $cost_id; ?>" method="POST">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <h3>ข้อมูลการชำระเงิน</h3>
                            <?php
                        if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
                            if($cost_status != "ชำระเงินแล้ว"){
                        ?>
                            <button type="button" class="edit-btn" title="แก้ไขข้อมูล"></button>
                            <?php } ?>
                            <div class="edit-option" style="display:none;">
                                <button type="submit" class="correct-btn" id="accept-edit" name="accept-edit"
                                    title="ยืนยันการแก้ไข"></button>
                                <button type="button" class="cancel-btn" id="cancel-edit"
                                    title="ยกเลิกการแก้ไข"></button>
                            </div>
                            <?php } ?>
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
                                <input type="text" id="room_price" name="room_price" value="<?php echo $room_cost; ?>"
                                    disabled>
                                <h5 id="room_error" style="color:red;"></h5>
                            </div>
                            <div class="cable_charge">
                                <p>ค่าเคเบิล (บาท)</p>
                                <input type="text" id="cable_price" name="cable_price"
                                    value="<?php echo $cable_charge; ?>" disabled>
                                <h5 id="cable_error" style="color:red;"></h5>
                            </div>
                            <div class="water_bill">
                                <p>ค่าน้ำ (บาท)</p>
                                <input type="text" id="water_price" name="water_price"
                                    value="<?php echo $water_bill; ?>" disabled>
                                <h5 id="water_error" style="color:red;"></h5>
                            </div>
                            <div class="elec_bill">
                                <p>ค่าไฟ (บาท)</p>
                                <input type="text" id="elec_price" name="elec_price" value="<?php echo $elec_bill; ?>"
                                    disabled>
                                <h5 id="elec_error" style="color:red;"></h5>
                            </div>
                            <div class="total">
                                <p>ยอดรวม (บาท)</p>
                                <input type="text" id="total_price" name="total_price" value="<?php echo $total; ?>"
                                    disabled>
                            </div>
                            <div class="cost_status">
                                <p>สถานะการชำระเงิน</p>
                                <input type="text" id="cost_status" value="<?php echo $cost_status; ?>" disabled>
                            </div>
                            <div class="pay_date">
                                <p>วันที่ชำระเงิน</p>
                                <input type="text" id="pay_date"
                                    value="<?php if(isset($pay_date)){ echo DateThai2($pay_date); } ?>" disabled>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="pay">
                <form id="pay_form" action="function/addImage.php?cost_id=<?php echo $cost_id; ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="costDetail-box" id="sub-pay">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <h3>อัปโหลดรูปภาพหลักฐานการชำระเงิน</h3>
                            <button type="button" class="edit-btn" id="edit-btn2" title="แก้ไขข้อมูล"></button>
                            <div class="edit-option" id="edit-option2" style="display:none;">
                                <button type="submit" class="correct-btn" id="accept-edit2" name="accept-edit"
                                    title="ยืนยันการแก้ไข"></button>
                                <button type="button" class="cancel-btn" id="cancel-edit2"
                                    title="ยกเลิกการแก้ไข"></button>
                            </div>
                        </div>
                        <div class="hr"></div>
                        <div class="img-box">
                            <img src="<?php if($pay_img != null){ echo "../../images/cost/$date/$room_id/payment/$pay_img"; } ?>"
                                id="img_pay" <?php if($pay_img == null){ echo "style='display:none;'"; } ?>>
                        </div>
                        <h5 id="pay_error" style="color:red;"></h5>
                        <input type="file" id="pay_img" name="pay_img" style="margin-top:8px;" disabled>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>
</body>

</html>

<?php
}else{
   Header("Location: ../../login.php"); 
}

?>