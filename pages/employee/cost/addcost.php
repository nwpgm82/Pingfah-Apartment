<?php
session_start();
if($_SESSION['level'] == 'employee'){
    include('../../connection.php');
    include('../../../components/sidebarEPY.php'); 
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
                <div class="hr"></div>
                <form action="function/addcostData.php" method="POST">
                    <div>
                        <p>เลขห้อง</p>
                        <select name="room_select" id="room_select" onChange="searchroom()" required>
                            <option value="---">--</option>
                            <?php
                            $select = $_REQUEST['room_select'];
                            $sql = "SELECT * FROM roomlist WHERE room_status = 'ไม่ว่าง' ";
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
                    if($select != ""){
                        $searchRoom = mysqli_query($conn,"SELECT * FROM roomlist WHERE room_id = '$select'");
                        $row2 = mysqli_fetch_assoc($searchRoom);
                        $searchDetail = mysqli_query($conn,"SELECT * FROM roomdetail WHERE type = '".$row2['room_type']."'");
                        $row3 = mysqli_fetch_assoc($searchDetail);
                    }
                    ?>
                    <div class="grid">
                        <div>
                            <p>ค่าห้องพัก</p>
                            <input type="text" id="room_price" name="room_price" value="<?php echo @$row3['price']; ?>" readonly>
                        </div>
                        <div>
                            <p>ค่าเคเบิล</p>
                            <input type="text" id="cable_price" name="cable_price" value="<?php echo @$row3['cable_charge']; ?>" readonly>
                        </div>
                        <div>
                            <p>ค่าน้ำ</p>
                            <div style="display:flex;">
                                <input type="text" id="water_people" style="width:60px;margin-right:8px;"
                                    placeholder="คน">
                                <input type="text" id="water_price" name="water_price" placeholder="รวม (ค่าน้ำ)" readonly>
                            </div>
                        </div>
                        <div>
                            <p>ค่าไฟ</p>
                            <div style="display:flex;">
                                <input type="text" id="elec_unit" style="width:80px;margin-right:8px;"
                                    placeholder="หน่วย">
                                <input type="text" id="elec_price" name="elec_price" placeholder="รวม (ค่าไฟ)" readonly>
                            </div>

                        </div>
                    </div>
                    <div style="display:flex;justify-content:flex-end;align-items:center;">
                    <label>ยอดรวม</label>
                        <input id="total_price" name="total_price" style="width:100px;margin:0 8px;" readonly>
                        <label>บาท</label>
                    </div>
                    <div class="hr"></div>
                    <div style="display:flex;justify-content:center;align-items:center;">
                        <button type="submit">ยืนยัน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/addcost.js"></script>
    <script>
    let room_price = document.getElementById("room_price")
    let cable_price = document.getElementById("cable_price")
    let water_people = document.getElementById("water_people")
    let water_price = document.getElementById("water_price")
    let elec_unit = document.getElementById("elec_unit")
    let elec_price = document.getElementById("elec_price")
    let water_total = 0
    let elec_total = 0
    let total_price = document.getElementById("total_price")
    total_price.value = parseFloat(room_price.value) + parseFloat(cable_price.value) + water_total + elec_total
    water_people.addEventListener("change", function() {
        water_total = <?php echo $row3["water_bill"]; ?> * parseFloat(water_people.value);
        water_price.value = water_total
        total_price.value = parseFloat(room_price.value) + parseFloat(cable_price.value) + water_total + elec_total
    })
    elec_unit.addEventListener("change", function() {
        elec_total = parseFloat(elec_unit.value) * <?php echo $row3["elec_bill"]; ?>;
        elec_price.value = elec_total
        total_price.value = parseFloat(room_price.value) + parseFloat(cable_price.value) + water_total + elec_total
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