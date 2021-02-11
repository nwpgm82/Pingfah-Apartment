<!-- หน้าลูกค้าแจ้งออกจากที่พัก ***ทำพรุ่งนี้*** -->
<?php
session_start();
if ($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee") {
    include "../../connection.php";
    // function dateDifference($date_1, $date_2, $differenceFormat = '%h')
    // {
    //     $datetime1 = date_create($date_1);
    //     $datetime2 = date_create($date_2);

    //     $interval = date_diff($datetime1, $datetime2);

    //     return $interval->format($differenceFormat);

    // }
    function DateThai($strDate)
    {
        $strYear = date("Y", strtotime($strDate));
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("d", strtotime($strDate));
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    $id = $_REQUEST["ID"];
    $member_data = mysqli_query($conn, "SELECT a.*, b.room_type, c.price, c.water_bill, c.elec_bill, c.cable_charge, c.deposit FROM roommember a INNER JOIN roomlist b ON a.room_id = b.room_id INNER JOIN roomdetail c ON b.room_type = c.type WHERE a.room_id = '$id' AND a.member_status = 'กำลังเข้าพัก'");
    $member_result = mysqli_fetch_assoc($member_data);
    $d1 = $member_result["come_date"];
    $d2 = date("Y-m-d");
    $month_count = (int)abs((strtotime($d1) - strtotime($d2))/(60*60*24*30));
    if ($month_count >= 6) {
        $room_deposit = "ได้";
        $deposit = $member_result["deposit"];
    } else {
        $room_deposit = "ไม่ได้";
        $deposit = 0;
    }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/member_quit.css">
    <link rel="stylesheet" href="../../../css/navbar.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../../../js/sidebar.js"></script>
    <script src="../../../js/manage/member_quit.js"></script>
    <title>Pingfah Apartment</title>
</head>

<body>
    <?php include "../../../components/sidebar.php";?>
    <div class="box">
        <div id="box-padding" style="padding:24px;">
            <form action="function/action.php?ID=<?php echo $id?>" method="POST">
                <div class="quit-box">
                    <h3>ห้อง <?php echo $member_result["room_id"]; ?></h3>
                    <div class="hr"></div>
                    <div class="grid-container">
                        <div>
                            <p>วันที่เริ่มเข้าพัก</p>
                            <input type="text" id="come_date" value="<?php echo DateThai($member_result["come_date"]); ?>" disabled>
                        </div>
                        <div>
                            <p>จำนวนเดือนที่เข้าพัก (เดือน)</p>
                            <input type="text" id="month_count" value="<?php echo $month_count; ?>" disabled>
                        </div>
                        <div>
                            <p>สิทธิ์การได้เงินประกันคืน</p>
                            <input type="text" id="room_deposit" value="<?php echo $room_deposit; ?> (<?php echo $deposit;?>)" disabled>
                        </div>
                        <div>
                            <p>ค่าห้องพัก</p>
                            <input type="text" id="room_price" name="room_cost" value="<?php echo $member_result["price"]; ?>" readonly>
                        </div>
                        <div>
                            <p>ค่าเคเบิล</p>
                            <input type="text" id="cable_price" name="cable_charge" value="<?php echo $member_result["cable_charge"]; ?>" readonly>
                        </div>
                        <div>
                            <p>ค่าน้ำ (จำนวนคน | บาท)</p>
                            <div style="display:flex;">
                                <input type="text" id="water_people" style="width:100px;margin-right:8px;"
                                    value="<?php echo $member_result["people"]; ?>" placeholder="คน" disabled>
                                <input type="text"
                                    value="<?php echo $member_result["water_bill"] * $member_result["people"]; ?>"
                                    id="water_price" name="water_price" placeholder="รวม (ค่าน้ำ)" readonly>
                            </div>
                        </div>
                        <div>
                            <p>ค่าไฟ (หน่วย | บาท)</p>
                            <div style="display:flex;">
                                <input type="text" id="elec_unit" style="width:100px;margin-right:8px;"
                                    placeholder="หน่วย">
                                <input type="text" id="elec_price" name="elec_price" placeholder="รวม (ค่าไฟ)"
                                    value="0.00" readonly>
                            </div>
                        </div>
                        <div>
                            <p>ค่าปรับ (ค่าเสียหายหักจากเงินประกัน)</p>
                            <div style="display:flex;">
                                <input type="text" id="fines" name="fines" style="width:100px;margin-right:8px;" placeholder="บาท">
                                <input type="text" id="deposit" name="deposit" placeholder="เงินประกัน" value="<?php echo $deposit; ?>" readonly>
                            </div>
                            <!-- <input type="text" id="fines" name="fines" value="0"> -->
                        </div>
                    </div>
                    <div style="padding-top:32px;display:flex;justify-content:flex-end;align-items:center;">
                        <label>ยอดรวม</label>
                        <input id="total_price" name="total_price" style="width:100px;margin:0 8px;" readonly>
                        <label>บาท</label>
                    </div>
                    <div class="hr"></div>
                    <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                        <input type="checkbox" name="" id="checkbox">
                        <p>ยืนยันที่จะแจ้งออกพร้อมชำระค่าห้องพักตามที่ระบุไว้</p>
                    </div>
                    <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                        <button id="confirm_quit" name="quit" disabled>ยืนยันการแจ้งออก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
    let elec = $("#elec_price")
    const deposit = $("#deposit").val()
    $("total_price").val($("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) - parseFloat($("#deposit").val())).toFixed(2)))
    $("#elec_unit").keyup(function(event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#elec_unit").val() != "") {
            $("#elec_unit").css("border-color", "")
            elec.val(Math.ceil((parseFloat($("#elec_unit").val()) * <?php if(isset($member_result["elec_bill"])){ echo $member_result["elec_bill"]; }else{ echo 0; } ?>).toFixed(2)))
        } else {
            elec.val("0.00")
            $("#elec_unit").css("border-color", "red")
        }
        if(parseFloat($("#deposit").val()) <= 0){
            $("total_price").val($("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) + parseFloat(elec.val()) + Math.abs($("#deposit").val())).toFixed(2)))
        }else{
            $("total_price").val($("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) + parseFloat(elec.val()) - parseFloat($("#deposit").val())).toFixed(2)))
        }
    })
    $("#fines").keyup(function(event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        if ($("#fines").val() != "") {
            $("#fines").css("border-color", "")
            $("#deposit").val((parseFloat(deposit) - parseFloat($("#fines").val())).toFixed(2))
            if(parseFloat($("#deposit").val()) <= 0){
                $("total_price").val($("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) + parseFloat(elec.val()) + Math.abs($("#deposit").val())).toFixed(2)))
            }else{
                $("total_price").val($("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) + parseFloat(elec.val()) - parseFloat($("#deposit").val())).toFixed(2)))
            }
        }else{
            $("#fines").css("border-color", "red")
            $("#deposit").val(deposit)
            $("total_price").val($("#total_price").val((parseFloat($("#room_price").val()) + parseFloat($("#cable_price").val()) + parseFloat($("#water_price").val()) + parseFloat(elec.val()) - parseFloat($("#deposit").val())).toFixed(2)))
        }
    })
    </script>
</body>

</html>
<?php
} else {
    header("Location: ../../login.php");
}
?>