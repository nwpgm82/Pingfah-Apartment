<?php
session_start();
if($_SESSION['level'] == 'guest'){ 
    include('../../connection.php');
    include('../../../components/sidebarGuest.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/addRepair.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="addRepair-box">
                <h3>รายละเอียดความเสียหาย</h3>
                <div class="hr"></div>
                <form action="function/repairAccept.php" method="POST">
                    <div style="margin-top: 32px;">
                        <p>เลขห้อง</p>
                        <select id="room_select" name="room_select" required>
                            <?php
                            $roomlist = "SELECT * FROM roomlist WHERE room_id = '".$_SESSION['ID']."'";
                            $result = mysqli_query($conn,$roomlist) or die(mysql_error());
                            while($row = mysqli_fetch_array($result)) {
                                if($row['room_status'] == 'ไม่ว่าง'){
                                    echo "<option value='" .$row['room_id'] ."'>" .$row['room_id'] ."</option>";
                                }
                            }
                        ?>
                        </select>
                    </div>
                    <div class="flex-detail">
                        <div>
                            <p>ประเภท</p>
                            <select type="text" id="select" name="repair_category" onchange="categoryList()" required>
                                <option value="">---</option>
                                <option value="เครื่องใช้ไฟฟ้า">เครื่องใช้ไฟฟ้า</option>
                                <option value="เฟอร์นิเจอร์">เฟอร์นิเจอร์</option>
                                <option value="สุขภัณฑ์">สุขภัณฑ์</option>
                            </select>
                        </div>
                        <div>
                            <p>อุปกรณ์</p>
                            <select type="text" id="list" name="repair_appliance">
                                <!-- <option value=""></option>
                            <option value=""></option>
                            <option value=""></option> -->
                            </select>
                        </div>
                    </div>
                    <div style="margin-top: 32px;">
                        <p>รายละเอียด</p>
                        <textarea name="repair_detail" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="flex-detail">
                        <div>
                            <p>เวลาที่ลง</p>
                            <input type="date" value="<?php echo date("Y-m-d") ?>" name="repair_date" readonly>
                        </div>
                        <div>
                            <p>สถานะ</p>
                            <select name="repair_status" id="status">
                                <option value="รอดำเนินการ">รอดำเนินการ</option>
                                <!-- <option value="กำลังดำเนินการ">กำลังดำเนินการ</option>
                                <option value="ดำเนินการเสร็จสิ้น">ดำเนินการเสร็จสิ้น</option> -->
                            </select>
                        </div>
                    </div>
                    <div style="margin-top:32px">
                        <button type="submit" name="repair_accept">ยืนยัน</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script src="../../../js/admin/addRepair.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>