<?php 
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    $type = $_REQUEST['type'];
    if($type == "fan"){
        $type_show = "พัดลม";
    }else if($type == "air"){
        $type_show = "แอร์";
    }
    $num = 1;
    $sql = "SELECT * FROM roomdetail WHERE type = '$type_show'";
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
    <link rel="stylesheet" href="../../../css/navbar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../../../js/sidebar.js"></script>
    <title>Pingfah Apartment</title>
</head>

<body>
    <?php include('../../../components/sidebar.php'); ?>
    <div class="box">
        <div id="box-padding" style="padding:24px;">
            <div class="detail-box">
                <form action="function/addData.php?type=<?php echo $type; ?>" method="POST" enctype="multipart/form-data">
                    <div class="header">
                        <h3>ห้อง<?php echo $type_show; ?></h3>
                        <div id="edit" style="display:flex;">
                            <button type="button" class="edit-btn"></button>
                        </div>
                        <div id="accept" style="display:none;">
                            <button type="submit" name="accept" class="correct-btn"></button>
                            <button type="button" class="cancel-btn"></button>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div style="padding:32px 0;">
                        <h3>รายละเอียดของลักษณะการเข้าพัก</h3>
                        <div class="roomDetail">
                            <div class="roomDetail-box">
                                <div class="topic-box">
                                    <h3>รายวัน</h3>
                                </div>
                                <div class="hr" style="margin:0;"></div>
                                <div class="content">
                                    <div>
                                        <p>ค่าเช่าห้อง(รายวัน) | <strong>บาท/วัน</strong></p>
                                        <input type="text" name="daily_price" value="<?php echo $row['daily_price']; ?>" disabled>
                                    </div>
                                    <div>
                                        <p>ค่ามัดจำห้องพัก | <strong>บาท/ห้อง</strong></p>
                                        <input type="text" name="daily_deposit" value="<?php echo $row['daily_deposit']; ?>" disabled>
                                    </div>
                                    <div>
                                        <p>ภาษีมูลค่าเพิ่ม(VAT) | <strong>%</strong></p>
                                        <input type="text" name="daily_tax" value="<?php echo $row['daily_tax']; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- ------------------ -->
                            <div class="roomDetail-box">
                                <div class="topic-box">
                                    <h3>รายเดือน</h3>
                                </div>
                                <div class="hr" style="margin:0;"></div>
                                <div class="content">
                                    <div>
                                        <p>ค่าเช่าห้อง(รายเดือน) | <strong>บาท/เดือน</strong></p>
                                        <input type="text" name="price" value="<?php echo $row['price']; ?>" disabled>
                                    </div>
                                    <div>
                                        <p>ค่าน้ำ | <strong>บาท/คน</strong></p>
                                        <input type="text" name="water_bill" value="<?php echo $row['water_bill']; ?>" disabled>
                                    </div>
                                    <div>
                                        <p>ค่าไฟ (หน่วย) | <strong>บาท/เดือน</strong></p>
                                        <input type="text" name="elec_bill"
                                            value="<?php echo $row['elec_bill']; ?>" disabled>
                                    </div>
                                    <div>
                                        <p>ค่าเคเบิล | <strong>บาท/เดือน</strong></p>
                                        <input type="text" name="cable_charge"
                                            value="<?php echo $row['cable_charge']; ?>" disabled>
                                    </div>
                                    <div>
                                        <p>ค่าปรับ | <strong>บาท/วัน</strong></p>
                                        <input type="text" name="fines"
                                            value="<?php echo $row['fines']; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3>สิ่งอำนวยความสะดวก</h3>
                        <div class="detail-grid">
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_air" <?php if($row['sv_air'] == 'on'){ echo "checked"; }?> disabled>
                                <label>เครื่องปรับอากาศ</label>
                                <img src="../../../img/tool/air2.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_fan" <?php if($row['sv_fan'] == 'on'){ echo "checked"; }?> disabled>
                                <label>พัดลม</label>
                                <img src="../../../img/tool/fan.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_wifi" <?php if($row['sv_wifi'] == 'on'){ echo "checked"; }?> disabled>
                                <label>WI-FI</label>
                                <img src="../../../img/tool/wifi2.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_furniture" <?php if($row['sv_furniture'] == 'on'){ echo "checked"; }?> disabled>
                                <label>เฟอร์นิเจอร์ - ตู้เสื้อผ้า, เตียง</label>
                                <img src="../../../img/tool/clothes.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_readtable" <?php if($row['sv_readtable'] == 'on'){ echo "checked"; }?> disabled>
                                <label>โต๊ะอ่านหนังสือ</label>
                                <img src="../../../img/tool/table.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_telephone" <?php if($row['sv_telephone'] == 'on'){ echo "checked"; }?> disabled>
                                <label>โทรศัพท์</label>
                                <img src="../../../img/tool/telephone.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_television" <?php if($row['sv_television'] == 'on'){ echo "checked"; }?> disabled>
                                <label>โทรทัศน์ดาวเทียม / เคเบิล</label>
                                <img src="../../../img/tool/television.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_refrigerator" <?php if($row['sv_refrigerator'] == 'on'){ echo "checked"; }?> disabled>
                                <label>ตู้เย็น</label>
                                <img src="../../../img/tool/refrigerator.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_waterbottle" <?php if($row['sv_waterbottle'] == 'on'){ echo "checked"; }?> disabled>
                                <label>น้ำบรรจุขวด</label>
                                <img src="../../../img/tool/waterbottle.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_toilet" <?php if($row['sv_toilet'] == 'on'){ echo "checked"; }?> disabled>
                                <label>ของใช้ในห้องน้ำ</label>
                                <img src="../../../img/tool/toilet-items.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_hairdryer" <?php if($row['sv_hairdryer'] == 'on'){ echo "checked"; }?> disabled>
                                <label>ไดร์เป่าผม</label>
                                <img src="../../../img/tool/hairdryer.png">
                            </div>
                            <div class="sub-grid">
                                <input type="checkbox" name="sv_towel" <?php if($row['sv_towel'] == 'on'){ echo "checked"; }?> disabled>
                                <label>ผ้าเช็ดตัว</label>
                                <img src="../../../img/tool/towel.png">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="detail-box" style="margin-top:32px;">
                <div class="header">
                    <h3>รูปภาพ</h3>
                    <div>
                        <input type="file" name="file" id="file" class="inputfile" accept="images/*" />
                        <label for="file">เพิ่มรูปภาพ</label>
                    </div>
                </div>
                <div class="hr"></div>
                <div class="grid">
                    <?php
                    $perpage = 8;
                    if(isset($_GET['gal_page'])){
                        $page = $_GET['gal_page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $perpage;
                    if($type == "fan"){
                        $sql = "SELECT * FROM fan_gal ORDER BY gal_id DESC LIMIT {$start} , {$perpage}";
                    }else if($type == "air"){
                        $sql = "SELECT * FROM air_gal ORDER BY gal_id DESC LIMIT {$start} , {$perpage}";
                    }
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="img-box">
                        <img src="../../images/roomdetail/<?php echo $type; ?>/<?php echo $row['gal_name']; ?>">
                        <button type="button" class="del-btn" name="<?php echo $row['gal_name']; ?>"></button>
                    </div>
                    <?php
                            $num++;
                        }
                    }else{
                        echo "ไม่มีรูปภาพ";
                    }
                    ?>
                </div>
                <?php
                ///////pagination
                if($type == "fan"){
                    $sql2 = "SELECT * FROM fan_gal";
                }else if($type == "air"){
                    $sql2 = "SELECT * FROM air_gal";
                }
                $query2 = mysqli_query($conn, $sql2);
                $total_record = mysqli_num_rows($query2);
                $total_page = ceil($total_record / $perpage);
                if($total_page != 0){
                ?>
                <div style="display:flex;justify-content:flex-end">
                    <div class="pagination">
                        <?php
                        if($type == "fan"){
                        ?>
                        <a href="detail.php?type=fan">&laquo;</a>
                        <?php for($i=1;$i<=$total_page;$i++){ ?>
                        <a href="detail.php?type=fan&gal_page=<?php echo $i; ?>" <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                        <?php } ?>
                        <a href="detail.php?type=fan&gal_page=<?php echo $total_page; ?>">&raquo;</a>
                        <?php
                        }else if($type == "air"){
                        ?>
                        <a href="detail.php?type=air">&laquo;</a>
                        <?php for($i=1;$i<=$total_page;$i++){ ?>
                        <a href="detail.php?type=air&gal_page=<?php echo $i; ?>" <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                        <?php } ?>
                        <a href="detail.php?type=air&gal_page=<?php echo $total_page; ?>">&raquo;</a>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
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
    Header("Location: ../../login.php"); 
}
?>