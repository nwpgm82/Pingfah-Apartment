<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    $repair_id = $_REQUEST["repair_id"];
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/repairDetail.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <link rel="stylesheet" href="../../../css/navbar.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <script src="../../../js/sidebar.js"></script>
    <title>Pingfah Apartment</title>
</head>

<body>
    <?php
    $sql = "SELECT * FROM repair WHERE repair_id = $repair_id ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    ?>
    <?php include("../../../components/sidebar.php"); ?>
    <div class="box">
        <div id="box-padding" style="padding:24px;">
            <div class="repairDetail-box">
                <h3>รายละเอียดความเสียหาย</h3>
                <div class="hr"></div>
                <div class="flex-detail">
                    <div>
                        <p>เลขห้อง</p>
                        <input type="text" value="<?php echo $row['room_id']; ?>" disabled>
                    </div>
                </div>
                <div class="flex-detail">
                    <div>
                        <p>อุปกรณ์</p>
                        <input type="text" value="<?php echo $row['repair_appliance']; ?>" disabled>
                    </div>
                    <div>
                        <p>ประเภท</p>
                        <input type="text" value="<?php echo $row['repair_category']; ?>" disabled>
                    </div>
                </div>
                <div style="margin-top: 32px;">
                    <p>รายละเอียด</p>
                    <textarea name="" id="" cols="30" rows="10" disabled><?php echo $row['repair_detail']; ?></textarea>
                </div>
                <form action="function/repairChangeStatus.php?repair_id=<?php echo $repair_id; ?>" method="POST">
                    <div class="flex-detail">
                        <div>
                            <p>เวลาที่ลง</p>
                            <input type="text" value="<?php echo DateThai($row['repair_date']); ?>" disabled>
                        </div>
                        <div>
                            <p>สถานะ</p>
                            <select name="status" id="status"
                                <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "disabled"; } ?>>
                                <option value="รอคิวซ่อม"
                                    <?php if($row['repair_status'] == 'รอคิวซ่อม'){ echo "selected";} ?>>รอคิวซ่อม
                                </option>
                                <option value="กำลังซ่อม"
                                    <?php if($row['repair_status'] == 'กำลังซ่อม'){ echo "selected";} ?>>
                                    กำลังซ่อม
                                </option>
                                <option value="ซ่อมเสร็จแล้ว"
                                    <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "selected";} ?>>
                                    ซ่อมเสร็จแล้ว
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="flex-detail2" id="success_status"
                        <?php if($row['repair_status'] != "ซ่อมเสร็จแล้ว"){ echo "style='display:none;'"; } ?>>
                        <div style="position:relative;">
                            <p>เวลาที่ซ่อมเสร็จ</p>
                            <input type="text" id="success_date" value="<?php echo DateThai($row['repair_successdate']); ?>" name="success_date" <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "style='background: #fafafa' disabled"; } ?>>
                            <h5 id="success_date_error" style="color:red;"></h5>
                        </div>
                        <div>
                            <p>รายได้จากการซ่อม</p>
                            <input type="text" name="income" id="income" value="<?php echo $row['repair_income']; ?>" <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "disabled"; } ?>>
                            <h5 id="income_error" style="color:red;"></h5>
                        </div>
                        <div>
                            <p>รายจ่ายจากการซ่อม</p>
                            <input type="text" name="expenses" id="expenses" value="<?php echo $row['repair_expenses']; ?>" <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "disabled"; } ?>>
                            <h5 id="expenses_error" style="color:red;"></h5>
                        </div>
                        <div>
                            <p>กำไรที่ได้</p>
                            <input type="text" name="profit" id="profit" value="<?php if(isset($row['repair_profit'])){ echo $row['repair_profit']; }else{ echo 0; } ?>" <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "disabled"; }else{ echo "readonly"; } ?>>
                        </div>
                    </div>
                    <div class="hr" style="margin:32px 0;"></div>
                    <?php
                    if($row['repair_status'] != 'ซ่อมเสร็จแล้ว'){
                    ?>
                    <div style="display:flex;justify-content:center;align-items:center;">
                        <button type="submit" id="">ยืนยันการแก้ไข</button>
                    </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
    <?php } } ?>
    <script src="../../../js/admin/repairDetail.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>