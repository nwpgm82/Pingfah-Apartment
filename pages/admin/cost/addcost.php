<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../components/sidebar.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/addcost.css">
    <title>Document</title>
</head>

<body onload="onloadpage()">
    <div class="box">
        <div style="padding:24px;">
            <div class="addcost-box">
                <h3>รายละเอียดการชำระ</h3>
                <form action="../cost/function/addcostData.php?" method="POST">
                    <div>
                        <p>เลขห้อง</p>
                        <select name="room_select" id="room_select" onChange="searchroom()" required>
                            <option value="---">--</option>
                            <?php
                            $select = $_REQUEST['room_select'];
                            $sql = "SELECT room_id FROM roomlist WHERE room_status = 'ไม่ว่าง' ";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                              while($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['room_id']; ?>"
                                <?php if($select == $row['room_id']){ echo "selected"; } ?>>
                                <?php echo $row['room_id']; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                    <?php
                    $searchID = "SELECT * FROM roomlist WHERE room_id = '$select'";
                    $resultID = $conn->query($searchID);
                    $rowID = $resultID->fetch_assoc();
                    $type = @$rowID['room_type'];
                    $searchDetail = "SELECT * FROM roomdetail WHERE type = '$type'";
                    $resultDetail = $conn->query($searchDetail);
                    $rowDetail = $resultDetail->fetch_assoc();
                    ?>
                    <?php if($select != ""){ ?>
                    <div class="grid">
                        <div>
                            <p>ค่าน้ำ <strong>(จำนวนคน)</strong></p>
                            <input type="number" name="water" id="water_count" min="1" max="2" required>
                        </div>
                        <div>
                            <p>ค่าไฟ <strong>(หน่วย)</strong></p>
                            <input type="text" name="elec" id="elec_count" required>
                        </div>
                        <div>
                            <button type="button"
                                onclick="calculate('<?php echo $select; ?>',<?php echo $rowDetail['water_bill'] ."," .$rowDetail['elec_bill'] ."," .$rowDetail['cable_charge'] ."," .$rowDetail['fines'] ."," .$rowDetail['price'];?>)">คำนวณ</button>
                        </div>
                    </div>
                    <div class="flex">
                        <div>
                            <h3>ราคารวม : <label id="total"></label> บาท</h3>
                        </div>
                    </div>
                    <button type="submit">ยืนยัน</button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/addcost.js"></script>
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