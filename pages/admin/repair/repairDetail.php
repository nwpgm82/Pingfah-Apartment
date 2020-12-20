<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
    $repair_id = $_REQUEST["repair_id"];
    function DateThai($strDate)
    {
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
    <link rel="stylesheet" href="../../../css/repairDetail.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <title>Document</title>
</head>

<body>
    <?php
    $sql = "SELECT * FROM repair WHERE repair_id = $repair_id ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    ?>
    <div class="box">
        <div style="padding:24px;">
            <div class="repairDetail-box">
                <h3>รายละเอียดความเสียหาย</h3>
                <div class="hr"></div>
                <div style="margin-top: 32px;">
                    <p>เลขห้อง</p>
                    <input type="text" value="<?php echo $row['room_id']; ?>" disabled>
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
                            <select name="status" id="status" <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "disabled"; } ?>>
                                <option value="รอดำเนินการ"
                                    <?php if($row['repair_status'] == 'รอดำเนินการ'){ echo "selected";} ?>>รอดำเนินการ
                                </option>
                                <option value="กำลังดำเนินการ"
                                    <?php if($row['repair_status'] == 'กำลังดำเนินการ'){ echo "selected";} ?>>
                                    กำลังดำเนินการ
                                </option>
                                <option value="ซ่อมเสร็จแล้ว"
                                    <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "selected";} ?>>
                                    ซ่อมเสร็จแล้ว
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="flex-detail2" id="success_status" <?php if($row['repair_status'] != "ซ่อมเสร็จแล้ว"){ echo "style='display:none;'"; } ?>>
                        <div style="position:relative;">
                            <p>เวลาที่ซ่อมเสร็จ</p>
                            <input type="text" id="success_date" value="<?php echo $row['repair_successdate']; ?>"
                                name="success_date" <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "style='background: #fafafa' disabled"; } ?>>
                            <p class="dateText" id="repair_successdate" <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "style='background: #fafafa'"; } ?>></p>
                        </div>
                        <div>
                            <p>รายได้จากการซ่อม</p>
                            <input type="text" name="income" value="<?php echo $row['repair_income']; ?>" <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "disabled"; } ?>>
                        </div>
                        <div>
                            <p>รายจ่ายจากการซ่อม</p>
                            <input type="text" name="expenses" value="<?php echo $row['repair_expenses']; ?>" <?php if($row['repair_status'] == 'ซ่อมเสร็จแล้ว'){ echo "disabled"; } ?>>
                        </div>
                    </div>
                    <div class="hr" style="margin:32px 0;"></div>
                    <?php
                    if($row['repair_status'] != 'ซ่อมเสร็จแล้ว'){
                    ?>
                    <div style="display:flex;justify-content:center;align-items:center;">
                        <button type="submit">ยืนยัน</button>
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