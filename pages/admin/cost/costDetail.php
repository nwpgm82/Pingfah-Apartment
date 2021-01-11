<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
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
    <link rel="stylesheet" href="../../../css/addcost.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../../../js/admin/addcost.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="addcost-box">
                <h3>รายละเอียดการชำระ</h3>
                <div class="hr"></div>
                <form action="function/addcostData.php" method="POST">
                    <div class="grid">
                        <div>
                            <p>เลขห้อง</p>
                            <input type="text" value="<?php echo $room_id; ?>" disabled>
                        </div>
                        <div>
                            <p>ประจำเดือน</p>
                            <input type="text" value="<?php echo DateThai($date); ?>" disabled>
                        </div>
                        <div>
                            <p>ค่าห้องพัก (บาท)</p>
                            <input type="text" id="room_price" name="room_price"
                                value="<?php echo $room_cost; ?>" disabled>
                        </div>
                        <div>
                            <p>ค่าเคเบิล (บาท)</p>
                            <input type="text" id="cable_price" name="cable_price"
                                value="<?php echo $cable_charge; ?>" disabled>
                        </div>
                        <div>
                            <p>ค่าน้ำ (บาท)</p>
                            <input type="text" id="water_price" name="water_price" value="<?php echo $water_bill; ?>" placeholder="รวม (ค่าน้ำ)" disabled>
                        </div>
                        <div>
                            <p>ค่าไฟ (บาท)</p>
                            <input type="text" id="elec_price" name="elec_price" placeholder="รวม (ค่าไฟ)" value="<?php echo $elec_bill; ?>" disabled>
                        </div>
                        <div>
                            <p>ค่าปรับ (บาท)</p>
                            <input id="total_price" name="total_price" value="<?php if(isset($fines)){ echo $fines; }else{ echo "0.00"; } ?>" disabled>
                        </div>
                        <div>
                            <p>ยอดรวม (บาท)</p>
                            <input id="total_price" name="total_price" value="<?php echo $total; ?>" disabled>
                        </div>
                        <div>
                            <p>สถานะการชำระเงิน</p>
                            <input id="total_price" name="total_price" value="<?php echo $cost_status; ?>" disabled>
                        </div>
                        <div>
                            <p>วันที่ชำระเงิน</p>
                            <input id="total_price" name="total_price" value="<?php if(isset($pay_date)){ echo DateThai2($pay_date); } ?>" disabled>
                        </div>
                    </div>
                    <!-- <div class="hr"></div>
                    <div style="display:flex;justify-content:center;align-items:center;">
                        <button type="submit">ยืนยัน</button>
                    </div> -->
                </form>
            </div>
        </div>
    </div>

    <script>
    if ($("#room_select").val != "") {
        $("#water_price").val((parseFloat($("#water_people").val()) * <?php echo $detail_result["water_bill"]; ?>).toFixed(2))
    }
    $("#elec_unit").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#elec_unit").val() != "") {
            $("#elec_unit").css("border-color", "")
            $("#total_price").css("border-color", "")
            $("#elec_price").val((parseFloat($("#elec_unit").val()) * <?php echo $detail_result["elec_bill"]; ?>).toFixed(2))
            $("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) + parseFloat($("#elec_price").val())).toFixed(2))
        } else {
            $("#elec_price").val("0.00")
            $("#total_price").val("")
            $("#elec_unit").css("border-color", "red")
            $("#total_price").css("border-color", "red")
        }
    })
    </script>
</body>

</html>

<?php
}else if($_SESSION['level'] == 'employee'){
    Header("Location: ../../employee/cost/addcost.php");
}
else{
   Header("Location: ../../login.php"); 
}

?>