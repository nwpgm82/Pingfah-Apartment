<?php
session_start();
if($_SESSION['level'] == 'guest'){
    include("../../connection.php");
    include("../../../components/sidebarGuest.php");
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
                <div class="row">
                    <div class="col-2">
                        <label>เลขห้อง</label>
                        <input type="text" value="<?php echo $_SESSION['ID']; ?>" name="room_id" disabled>
                    </div>
                    <div class="col-5">
                        <label>หัวข้อร้องเรียน</label>
                        <input type="text" name="appeal_topic">
                    </div>
                    <div class="col-5">
                        <label>วันที่ร้องเรียน</label>
                        <input type="text" value="<?php echo date("Y-m-d"); ?>" name="appeal_date">
                    </div>
                </div>
                <div style="padding-top:32px;">
                <label>เนื้อหาการร้องเรียน</label>
                    <textarea name="appeal_detail"></textarea>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>