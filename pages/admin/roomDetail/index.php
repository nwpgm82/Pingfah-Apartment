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
                                <img src="<?php if(isset($row2['gal_name'])){ echo "../../images/roomdetail/$type_show/" .$row2['gal_name']; }else{ echo "https://i.pinimg.com/originals/c5/45/2a/c5452a51a5bd54f08b5b3bfb80882cf5.jpg"; } ?>">
                            </div>
                            <?php } } ?>
                            <a class="prev" onclick="plusSlides<?php echo $num; ?>(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides<?php echo $num; ?>(1)">&#10095;</a>
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