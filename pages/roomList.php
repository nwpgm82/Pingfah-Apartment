<?php
include('connection.php');
include('../components/maintopbar.php');
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
                    <img src="images/roomdetail/<?php echo $row['pic1']; ?>" alt="">
                    <div class="detail">
                        <div>
                            <h3>ห้อง<?php echo $row['type']; ?></h3>
                            <p>- รายเดือน : <?php echo number_format($row['price']); ?> บาท</p>
                            <p>- รายวัน : <?php echo number_format($row['daily_price']); ?> บาท</p>
                        </div>
                    </div>
                </div>
                <?php
                    }
                }else{
                    echo "ไม่มีประเภทห้องพัก";
                }
                ?>
        </div>
    </div>
</body>

</html>