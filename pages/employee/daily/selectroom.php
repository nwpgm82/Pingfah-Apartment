<?php
    session_start();
    if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebarEPY.php');
    $daily_id = $_REQUEST['daily_id'];
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
    <link rel="stylesheet" href="../../../css/selectroom.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="selectroom-box">
                <?php
                    $sql = "SELECT * FROM daily WHERE daily_id = $daily_id";
                    $result = mysqli_query($conn, $sql)or die ("Error in query: $sql " . mysqli_error());
                    $row = mysqli_fetch_array($result);
                    if($row != null){
                        extract($row);
                    }
                ?>
                <h3>เลือกห้องพัก</h3>
                <div class="hr"></div>
                <div class="grid">
                    <div style="line-height:60px;">
                        <p><strong>ชื่อ : </strong> <?php echo $firstname ." " .$lastname; ?></p>
                        <p><strong>เลขบัตรประชาชน : </strong> <?php echo $id_card ?></p>
                        <p><strong>อีเมล : </strong> <?php echo $email; ?></p>
                        <p><strong>เบอร์โทรศัพท์ : </strong> <?php echo $tel; ?></p>
                        <p><strong>หัองแอร์ : </strong> <?php echo $air_room; ?> ห้อง</p>
                        <p><strong>ห้องพัดลม : </strong> <?php echo $fan_room; ?> ห้อง</p>
                        <p><strong>วันที่เข้าพัก : </strong> <?php echo DateThai($check_in); ?> <strong>ถึง</strong>
                            <?php echo DateThai($check_out); ?></p>
                    </div>
                    <div style="padding: 0 24px;border-left:1px solid rgb(131, 120, 47, 0.7);">
                        <h3>รายการห้องที่ว่าง</h3>
                        <div style="padding-top:32px;">
                            <h3>ห้องแอร์</h3>
                            <div style="padding-top:16px;">
                                <label><strong>จำนวนที่เลือกได้คงเหลือ : </strong>&nbsp;<label id="air"></label>&nbsp; ห้อง</label>
                                <div style="padding-top:32px;">
                                    <?php
                                    $select_room = "SELECT * FROM roomlist WHERE room_type = 'แอร์' AND room_status = 'ว่าง'";
                                    $result2 = $conn->query($select_room);
                                    if ($result2->num_rows > 0) {
                                        while($row2 = $result2->fetch_assoc()) {
                                    ?>
                                    <button id="room<?php echo $row2['room_id']; ?>" type="button"
                                        onclick="count('<?php echo $row2['room_id']; ?>')"><?php echo $row2['room_id']; ?></button>
                                    <?php
                                        }
                                    } else {
                                        echo "*** ไม่มีห้องว่างให้เช่า ***";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="hr" style="margin:16px 0;"></div>
                        <div>
                            <h3>ห้องพัดลม</h3>
                            <div style="padding-top:16px;">
                                <label><strong>จำนวนที่เลือกได้คงเหลือ : </strong>&nbsp;<label id="fan"></label>&nbsp; ห้อง</label>
                                <div style="padding-top:32px;">
                                    <?php
                                    $select_room = "SELECT * FROM roomlist WHERE room_type = 'พัดลม' AND room_status = 'ว่าง'";
                                    $result2 = $conn->query($select_room);
                                    if ($result2->num_rows > 0) {
                                        while($row2 = $result2->fetch_assoc()) {
                                    ?>
                                    <button id="room<?php echo $row2['room_id']; ?>" type="button"
                                        onclick="count2('<?php echo $row2['room_id']; ?>')"><?php echo $row2['room_id']; ?></button>
                                    <?php
                                        }
                                    } else {
                                        echo "*** ไม่มีห้องว่างให้เช่า ***";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            
                        </div>
                    </div>
                </div>
                <div class="hr"></div>
                <div style="display:flex;justify-content:center;">
                    <button type="button" onclick="accept_select(<?php echo $daily_id; ?>)">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    let room_arr = []
    let air = <?php echo $air_room;?>;
    let fan = <?php echo $fan_room;?>;
    document.getElementById("air").innerHTML = air;
    document.getElementById("fan").innerHTML = fan;

    function accept_select(id) {
        if (air == 0 && fan == 0) {
            if (confirm('คุณต้องการยืนยันการเลือกห้องใช่หรือไม่ ?')) {
                let str = JSON.stringify(room_arr)
                console.log(str)
                location.href = `function/addSelectRoom.php?daily_id=${id}&room_select=${str}`
            }
        } else {
            alert("กรุณาเลือกห้องให้ครบ")
        }
    }

    function count(room) {
        let room_select = document.getElementById(`room${room}`)
        if (room_select.style.backgroundColor != "grey") {
            if (air > 0) {
                air = air - 1
                room_select.style.backgroundColor = "grey"
                room_arr.push(room)
                console.log(room_arr)

            } else {
                alert("ไม่สามารถเลือกห้องได้")
            }
        } else {
            room_select.style.backgroundColor = ""
            air = air + 1
        }
        document.getElementById("air").innerHTML = air;
    }
    function count2(room) {
        let room_select = document.getElementById(`room${room}`)
        if (room_select.style.backgroundColor != "grey") {
            if (fan > 0) {
                fan = fan - 1
                room_select.style.backgroundColor = "grey"
                room_arr.push(room)
                console.log(room_arr)

            } else {
                alert("ไม่สามารถเลือกห้องได้")
            }
        } else {
            room_arr.splice(room_arr.findIndex((el) => el === room),1)
            console.log(room_arr)
            room_select.style.backgroundColor = ""
            fan = fan + 1
        }
        document.getElementById("fan").innerHTML = fan;
    }
    </script>
</body>

</html>
<?php
    }else{
        Header("Location: ../../login.php"); 
    }
?>