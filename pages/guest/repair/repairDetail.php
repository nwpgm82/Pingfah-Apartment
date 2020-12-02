<?php
session_start();
if($_SESSION['level'] == 'guest'){
    include('../../connection.php');
    include("../rule-modal.php");
    include('../../../components/sidebarGuest.php');
    $room_id = $_REQUEST['room_id'];
    $appliance = $_REQUEST['repairappliance'];
    $category = $_REQUEST['repaircategory'];
    $date = $_REQUEST['repairdate']; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/repairDetail.css">
    <title>Document</title>
</head>

<body>
    <?php
    $sql = "SELECT * FROM repair WHERE room_id = '".$_SESSION['ID']."' AND repair_appliance = '$appliance' AND repair_category = '$category' AND repair_date = '$date' ";
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
                <div class="flex-detail">
                    <div>
                        <p>เวลาที่ลง</p>
                        <input type="text" value="<?php echo $row['repair_date']; ?>" disabled>
                    </div>
                    <div>
                        <p>สถานะ</p>
                        <select name="status" id="status" disabled>
                                <option value="รอดำเนินการ" <?php if($row['repair_status'] == 'รอดำเนินการ'){ echo "selected";} ?>>รอดำเนินการ</option>
                                <option value="กำลังดำเนินการ" <?php if($row['repair_status'] == 'กำลังดำเนินการ'){ echo "selected";} ?>>กำลังดำเนินการ</option>
                                <option value="ดำเนินการเสร็จสิ้น" <?php if($row['repair_status'] == 'ดำเนินการเสร็จสิ้น'){ echo "selected";} ?>>ดำเนินการเสร็จสิ้น</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <?php } } ?>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>