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
                                style="width:100%" onclick="currentSlide<?php echo $num; ?>(<?php echo ${'column_num'.$num}; ?>)">
                        </div>
                        <?php ${'column_num'.$num}++; } } ?>
                    </div>
                </div>
                <div class="detail">
                    <div>
                        <h3>ห้อง<?php echo $row['type']; ?></h3>
                        <p>- รายเดือน : <?php echo number_format($row['price']); ?> บาท</p>
                        <p>- รายวัน : <?php echo number_format($row['daily_price']); ?> บาท</p>
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