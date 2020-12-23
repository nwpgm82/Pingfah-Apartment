<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/addNewRoom.css">
    <title>Document</title>
</head>
<body>
    <?php include("../../../components/sidebar.php"); ?>
    <div class="box">
        <div style="padding:32px;">
            <div class="addNewRoom-box">
                <h3>เพิ่มห้องพัก</h3>
                <div class="hr"></div>
                <div class="input-grid">
                    <div>
                        <p>เลขห้อง</p>
                        <input type="text">
                    </div>
                    <div>
                        <p>ประเภทห้องพัก</p>
                        <select name="room_type" id="">
                            <option value="">แอร์</option>
                            <option value="">พัดลม</option>
                        </select>
                    </div>
                    <div>
                        <p>ลักษณะห้องพัก</p>
                        <select name="room_cat" id="">
                            <option value="">รายวัน</option>
                            <option value="">รายเดือน</option>
                        </select>
                    </div>
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