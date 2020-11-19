<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../components/sidebar.php'); 
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
                <h3>ประเภทห้องพัก</h3>
                <div class="grid">
                    <?php while($row = $result->fetch_assoc()) { ?>
                    <div class="card">
                        <div>
                            <img src="<?php if(isset($row['pic1'])){ echo "../../images/roomdetail/" .$row['pic1']; }else{ echo "https://i.pinimg.com/originals/c5/45/2a/c5452a51a5bd54f08b5b3bfb80882cf5.jpg"; } ?>"
                                alt="">
                        </div>
                        <div class="detail">
                            <div>
                                <h3>ห้อง<?php echo $row['type'];?></h3>
                                <p>ค่าเช่า : <?php echo number_format($row['price']); ?> บาท / เดือน</p>
                            </div>
                            <div style="display:flex;justify-content:flex-end;">
                                <a href="detail.php?type=<?php echo $row['type'];?>"><button>ดูข้อมูลเพิ่มเติม</button></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
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