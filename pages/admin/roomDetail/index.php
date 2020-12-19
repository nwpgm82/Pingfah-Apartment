<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php'); 
    $num = 1;
    $sql = "SELECT * FROM roomDetail";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/roomDetail.css">
</head>

<body>
    <div style="padding:24px;">
        <div class="box">
            <div class="roomDetail-box">
                <h3>ประเภทห้องพักทั้งหมด</h3>
                <div class="hr"></div>
                <div class="grid">
                    <?php while($row = $result->fetch_assoc()) { ?>
                    <div class="card">
                        <div class="container">
                            <?php
                            if($row['type'] == "พัดลม"){
                                $type_show = "fan";
                                $getImg = "SELECT gal_name FROM fan_gal";
                            }else if($row['type'] == "แอร์"){
                                $type_show = "air";
                                $getImg = "SELECT gal_name FROM air_gal";
                            }
                            $resultImg = $conn->query($getImg);
                            if ($resultImg->num_rows > 0) {
                                while($row2 = $resultImg->fetch_assoc()) { 
                            ?>
                            <div class="mySlides<?php echo $num; ?>">
                                <img src="../../images/roomdetail/<?php echo $type_show; ?>/<?php echo $row2['gal_name']; ?>">
                            </div>
                            <?php } }else{ ?>
                            <div class="mySlides<?php echo $num; ?>">
                                <img src="../../../img/tool/no-img.png">
                            </div>
                            <?php } ?>
                            <?php
                            if($resultImg->num_rows > 1){
                            ?>
                            <a class="prev" onclick="plusSlides<?php echo $num; ?>(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides<?php echo $num; ?>(1)">&#10095;</a>
                            <?php } ?>
                        </div>
                        <div class="detail">
                            <div>
                                <h3>ห้อง<?php echo $row['type'];?></h3>
                                <p>รายเดือน : <?php echo number_format($row['price']); ?> บาท / เดือน</p>
                                <p>รายวัน : <?php echo number_format($row['daily_price']); ?> บาท / คืน</p>
                            </div>
                            <div style="display:flex;justify-content:flex-end;">
                                <a
                                    href="detail.php?type=<?php if($row['type'] == 'พัดลม'){ echo 'fan'; }else if($row['type'] == 'แอร์'){ echo 'air'; }?>"><button>ดูข้อมูลเพิ่มเติม</button></a>
                            </div>
                        </div>
                    </div>
                    <?php $num++; } ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/roomDetail.js"></script>
</body>

</html>
<?php
    }else{
        echo "0 results";
    }
}else{
    Header("Location: ../../login.php"); 
}
?>