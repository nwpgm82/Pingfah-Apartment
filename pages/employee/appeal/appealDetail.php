<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../connection.php");
    include("../../../components/sidebar.php");
    $id = $_REQUEST["appeal_id"];
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/appealDetail.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="appealDetail-box">
                <h3>รายละเอียดการร้องเรียน</h3>
                <div class="hr"></div>
                <?php
                $sql = "SELECT * FROM appeal WHERE appeal_id = $id";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()) {
                ?>
                <div class="row">
                    <div class="col-2">
                        <label>เลขห้อง</label>
                        <input type="text" value="<?php echo $row['room_id']; ?>" disabled>
                    </div>
                    <div class="col-5">
                        <label>หัวข้อร้องเรียน</label>
                        <input type="text" value="<?php echo $row['appeal_topic']; ?>" disabled>
                    </div>
                    <div class="col-5">
                        <label>วันที่ร้องเรียน</label>
                        <input type="text" value="<?php echo $row['appeal_date']; ?>" disabled>
                    </div>
                </div>
                <div style="padding-top:32px;">
                <label>เนื้อหาการร้องเรียน</label>
                    <textarea disabled><?php echo $row['appeal_detail']; ?></textarea>
                </div>
                <?php
                    }
                }else{
                    echo "ไม่มีรายละเอียดการร้องเรียน";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
<?php
}else{
    Header("Location: ../login.php"); 
}
?>