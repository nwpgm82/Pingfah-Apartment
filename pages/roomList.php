<?php
include('connection.php');
include('../components/maintopbar.php');
$num = 1;
$column_num1 = 1;
$column_num2 = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/roomPage.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div class="roomPage">
            <h2>ประเภทห้องพัก</h2>
            <div class="hr"></div>
            <?php
            $sql = "SELECT * FROM roomdetail";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
            ?>
            <div class="card">
                <div class="container">
                    <?php
                    if($row['type'] == 'พัดลม'){
                        $type_show = 'fan';
                        $getImg = "SELECT * FROM fan_gal";
                    }else if($row['type'] == 'แอร์'){
                        $type_show = 'air';
                        $getImg = "SELECT * FROM air_gal";
                    }
                    $resultImg = $conn->query($getImg);
                    if ($resultImg->num_rows > 0) {
                        while($row2 = $resultImg->fetch_assoc()) {
                    ?>
                    <div class="mySlides<?php echo $num ?>">
                        <img src="images/roomdetail/<?php echo $type_show; ?>/<?php echo $row2['gal_name']; ?>" alt="">
                    </div>
                    <?php } } ?>
                    <a class="prev" onclick="plusSlides<?php echo $num;?>(-1)">❮</a>
                    <a class="next" onclick="plusSlides<?php echo $num;?>(1)">❯</a>
                    <div class="row" id="row<?php echo $num; ?>">
                        <?php
                        if($row['type'] == 'พัดลม'){
                            $type_show2 = 'fan';
                            $getImg2 = "SELECT * FROM fan_gal";
                        }else if($row['type'] == 'แอร์'){
                            $type_show2 = 'air';
                            $getImg2 = "SELECT * FROM air_gal";
                        }
                        $resultImg2 = $conn->query($getImg2);
                        if ($resultImg2->num_rows > 0) {
                            while($row3 = $resultImg2->fetch_assoc()) {
                        ?>
                        <div class="column">
                            <img class="demo<?php echo $num; ?> cursor"
                                src="images/roomdetail/<?php echo $type_show; ?>/<?php echo $row3['gal_name']; ?>"
                                style="width:100%"
                                onclick="currentSlide<?php echo $num; ?>(<?php echo ${'column_num'.$num}; ?>)">
                        </div>
                        <?php ${'column_num'.$num}++; } } ?>
                    </div>
                </div>
                <div class="detail">
                    <div>
                        <h2>ห้อง<?php echo $row['type']; ?></h2>
                        <div class="hr"></div>
                        <h3>รายละเอียดห้องพัก</h3>
                        <div class="user-grid">
                            <img src="../img/tool/user.png" alt="">
                            <label>2 คน</label>
                        </div>
                        <p>รายเดือน : <label style="font-size:24px;color: rgb(131, 120, 47, 1);"><strong><?php echo number_format($row['price']); ?></strong></label> บาท</p>
                        <p>รายวัน : <label style="font-size:24px;color: rgb(131, 120, 47, 1);"><strong><?php echo number_format($row['daily_price']); ?></strong></label> บาท</p>
                    </div>
                    <div style="padding-top: 30px;">
                        <h3 style="color:#000">สิ่งอำนวยความสะดวก</h3>
                        <div class="detail-grid">
                            <?php
                            if($row["sv_air"] == "on"){
                            ?>
                            <div class="sub-grid">
                                <img src="../img/tool/air2.png">
                                <label>เครื่องปรับอากาศ</label>
                            </div>
                            <?php } ?>
                            <?php
                            if($row["sv_fan"] == "on"){
                            ?>
                            <div class="sub-grid">
                                <img src="../img/tool/fan.png">
                                <label>พัดลม</label>
                            </div>
                            <?php } ?>
                            <?php
                            if($row["sv_wifi"] == "on"){
                            ?>
                            <div class="sub-grid">
                                <img src="../img/tool/wifi2.png">
                                <label>WI-FI</label>
                            </div>
                            <?php } ?>
                            <?php
                            if($row["sv_furniture"] == "on"){
                            ?>
                            <div class="sub-grid">
                                <img src="../img/tool/clothes.png">
                                <label>เฟอร์นิเจอร์ - ตู้เสื้อผ้า, เตียง</label>
                            </div>
                            <?php } ?>
                            <?php
                            if($row["sv_readtable"] == "on"){
                            ?>
                            <div class="sub-grid">
                                <img src="../img/tool/table.png">
                                <label>โต๊ะอ่านหนังสือ</label>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                  $num++;  }
                }else{
                    echo "ไม่มีประเภทห้องพัก";
                }
                ?>
        </div>
    </div>
    <script src="../js/roomListPages.js"></script>
</body>

</html>