<?php 
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../components/sidebar.php');
    $type = $_REQUEST['type'];
    $sql = "SELECT * FROM roomdetail WHERE type = '$type'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/detail.css">
    <title>Document</title>
</head>

<body>
    <div style="padding:24px;">
        <div class="box">
            <div class="detail-box">
                <h3>ห้อง<?php echo $row['type']; ?></h3>
                <form action="function/addData.php?type=<?php echo $type; ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="roomDetail">
                        <div>
                            <p>ค่าเช่าห้อง(รายเดือน)</p>
                            <input type="text" name="price"
                                value="<?php if(isset($row['price'])){ echo $row['price']; }else{ echo 0; } ?>" disabled>
                            <label>บาท/เดือน</label>
                        </div>
                        <div>
                            <p>ค่าเช่าห้อง(รายวัน)</p>
                            <input type="text" name="price"
                                value="<?php if(isset($row['daily_price'])){ echo $row['daily_price']; }else{ echo 0; } ?>" disabled>
                            <label>บาท/วัน</label>
                        </div>
                        <div>
                            <p>ค่าน้ำ</p>
                            <input type="text" name="water_bill"
                                value="<?php if(isset($row['water_bill'])){ echo $row['water_bill']; }else{ echo 0; } ?>" disabled>
                            <label>บาท/คน</label>
                        </div>
                        <div>
                            <p>ค่าไฟ (หน่วย)</p>
                            <input type="text" name="elec_bill"
                                value="<?php if(isset($row['elec_bill'])){ echo $row['elec_bill']; }else{ echo 0; } ?>" disabled>
                            <label>บาท/เดือน</label>
                        </div>
                        <div>
                            <p>ค่าเคเบิล</p>
                            <input type="text" name="cable_charge"
                                value="<?php if(isset($row['cable_charge'])){ echo $row['cable_charge']; }else{ echo 0; } ?>" disabled>
                            <label>บาท/เดือน</label>
                        </div>
                        <div>
                            <p>ค่าปรับ</p>
                            <input type="text" name="fines"
                                value="<?php if(isset($row['fines'])){ echo $row['fines']; }else{ echo 0; } ?>" disabled>
                            <label>บาท/วัน</label>
                        </div>
                    </div>
                    <div style="padding-top:32px;">
                        <p>รายละเอียดห้องพัก</p>
                        <textarea name="detail" id="textarea" cols="30"
                            rows="10" disabled><?php if(isset($row['detail'])){ echo $row['detail']; }else{ echo "-";}; ?></textarea>
                    </div>
                    <div style="padding-top:32px;">
                        <p>รูปภาพ</p>
                        <div class="grid">
                            <div>
                                <div class="img-box">
                                    <img id="output_imagepic1"
                                        src="../../images/roomdetail/<?php echo $row['pic1']; ?>" />
                                    <?php
                                    if(isset($row['pic1'])){ ?>
                                    <button class="del-btn" type="button" id="delimg-btn1" style="display:none;"
                                        onclick="delImg('<?php echo $type; ?>','pic1')">X</button>
                                    <?php } ?>
                                </div>
                                <?php
                                if(!isset($row['pic1'])){ ?>
                                <input type="file" accept="image/*" onchange="preview_image(event,'pic1')" name="pic1" disabled>
                                <?php } ?>
                            </div>
                            <div>
                                <div class="img-box">
                                    <img id="output_imagepic2"
                                        src="../../images/roomdetail/<?php echo $row['pic2']; ?>" />
                                    <?php
                                    if(isset($row['pic2'])){ ?>
                                    <button class="del-btn" type="button" id="delimg-btn2" style="display:none;"
                                        onclick="delImg('<?php echo $type; ?>','pic2')">X</button>
                                    <?php } ?>
                                </div>
                                <?php
                                if(!isset($row['pic2'])){ ?>
                                <input type="file" accept="image/*" onchange="preview_image(event,'pic2')" name="pic2" disabled>
                                <?php } ?>
                            </div>
                            <div>
                                <div class="img-box">
                                    <img id="output_imagepic3"
                                        src="../../images/roomdetail/<?php echo $row['pic3']; ?>" />
                                    <?php
                                    if(isset($row['pic3'])){ ?>
                                    <button class="del-btn" type="button" id="delimg-btn3" style="display:none;"
                                        onclick="delImg('<?php echo $type; ?>','pic3')">X</button>
                                    <?php } ?>
                                </div>
                                <?php
                                if(!isset($row['pic3'])){ ?>
                                <input type="file" accept="image/*" onchange="preview_image(event,'pic3')" name="pic3" disabled>
                                <?php } ?>
                            </div>
                            <div>
                                <div class="img-box">
                                    <img id="output_imagepic4"
                                        src="../../images/roomdetail/<?php echo $row['pic4']; ?>" />
                                    <?php
                                    if(isset($row['pic4'])){ ?>
                                    <button class="del-btn" type="button" id="delimg-btn4" style="display:none;"
                                        onclick="delImg('<?php echo $type; ?>','pic4')">X</button>
                                    <?php } ?>
                                </div>
                                <?php
                                if(!isset($row['pic4'])){ ?>
                                <input type="file" accept="image/*" onchange="preview_image(event,'pic4')" name="pic4" disabled>
                                <?php } ?>
                            </div>
                            <div>
                                <div class="img-box">
                                    <img id="output_imagepic5"
                                        src="../../images/roomdetail/<?php echo $row['pic5']; ?>" />
                                    <?php
                                    if(isset($row['pic5'])){ ?>
                                    <button class="del-btn" type="button" id="delimg-btn5" style="display:none;"
                                        onclick="delImg('<?php echo $type; ?>','pic5')">X</button>
                                    <?php } ?>
                                </div>
                                <?php
                                if(!isset($row['pic5'])){ ?>
                                <input type="file" accept="image/*" onchange="preview_image(event,'pic5')" name="pic5" disabled>
                                <?php } ?>
                            </div>
                            <div>
                                <div class="img-box">
                                    <img id="output_imagepic6"
                                        src="../../images/roomdetail/<?php echo $row['pic6']; ?>" />
                                    <?php
                                    if(isset($row['pic6'])){ ?>
                                    <button class="del-btn" type="button" id="delimg-btn6" style="display:none;"
                                        onclick="delImg('<?php echo $type; ?>','pic6')">X</button>
                                    <?php } ?>
                                </div>
                                <?php
                                if(!isset($row['pic6'])){ ?>
                                <input type="file" accept="image/*" onchange="preview_image(event,'pic6')" name="pic6" disabled>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div id="edit" style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                        <button type="button" class="edit-btn" onclick="edit()">แก้ไข</button>
                    </div>
                    <div id="accept" style="padding-top:32px;display:none;justify-content:center;align-items:center;">
                        <button type="submit" name="accept">ยืนยัน</button>
                        <button type="button" class="cancel-btn" onclick="cancelEdit()">ยกเลิก</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/detail.js"></script>
</body>

</html>
<?php
}
    }else{
        echo "0 results";
    }
}else{
    Header("Location: ../../../login.php"); 
}
?>