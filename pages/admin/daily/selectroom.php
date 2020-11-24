<?php
    session_start();
    if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
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

                <div class="grid">
                    <div>
                        <h3>เลือกห้องพัก</h3>
                        <div style="padding-top:32px;line-height:40px;">
                            <p><strong>ชื่อ : </strong> <?php echo $firstname ." " .$lastname; ?></p>
                            <p><strong>เลขบัตรประชาชน : </strong> <?php echo $id_card ?></p>
                            <p><strong>อีเมล : </strong> <?php echo $email; ?></p>
                            <p><strong>เบอร์โทรศัพท์ : </strong> <?php echo $tel; ?></p>
                            <p><strong>ประเภทห้องพัก : </strong> <?php echo $room_type; ?></p>
                            <p><strong>จำนวน : </strong> <?php echo $room_count; ?> ห้อง</p>
                            <p><strong>วันที่เข้าพัก : </strong> <?php echo DateThai($check_in); ?> <strong>ถึง</strong>
                                <?php echo DateThai($check_out); ?></p>
                        </div>
                    </div>
                    <div>
                    <form method="POST">
                    <h3>รายการห้องที่ว่าง</h3>
                        <h3>จำนวนห้องที่ต้องเลือกคงเหลือ <label id="count"></label></h3>
                        <div style="padding-top:32px;">
                            <?php
                            $select_room = "SELECT * FROM roomlist WHERE room_type = '$room_type' AND room_status = 'ว่าง'";
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
                        <input type="text" id="str" name="str">
                        <button name="send">++</button>
                    </form>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
    var room_arr = []
    var num = <?php echo $room_count;?>;
    document.getElementById("count").innerHTML = num;
    
    function count(room) {
        let room_select = document.getElementById(`room${room}`)
        if (room_select.style.backgroundColor != "grey") {
            if (num > 0) {
                num = num - 1
                room_select.style.backgroundColor = "grey"
                room_arr.push(room)
                console.log(room_arr)
                document.getElementById("str").value = JSON.stringify(room_arr)
            } else {
                alert("ไม่สามารถเลือกห้องได้")
            }
        }else{
            room_select.style.backgroundColor = ""
            num = num + 1
        }

        document.getElementById("count").innerHTML = num;
    }
    </script>
    <?php
    if(isset($_POST['send'])){
        $dd = json_decode($_POST['str'], true);
        var_dump($dd);
        // echo count($dd);
    }           
    ?>
</body>

</html>
<?php
    }else{
        Header("Location: ../../login.php"); 
    }
?>