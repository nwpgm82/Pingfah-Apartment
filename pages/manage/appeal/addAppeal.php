<?php
session_start();
if($_SESSION["level"] == "guest"){
    include("../../connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/appealDetail.css">
    <link rel="stylesheet" href="../../../css/navbar.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../../../js/sidebar.js"></script>
    <title>Pingfah Apartment</title>
</head>

<body>
    <?php include("../../../components/sidebar.php"); ?>
    <div class="box">
        <div id="box-padding" style="padding:24px;">
            <form action="">
                <div class="appealDetail-box">
                    <h3>รายละเอียดการร้องเรียน</h3>
                    <div class="hr"></div>
                    <div class="grid-container">
                        <div>
                            <p>เลขห้อง</p>
                            <input type="text" value="<?php echo $_SESSION["name"]; ?>" disabled>
                        </div>
                        <div>
                            <p>หัวข้อร้องเรียน</p>
                            <input type="text">
                        </div>
                    </div>
                    <div style="padding-top:32px;">
                        <label>เนื้อหาการร้องเรียน</label>
                        <textarea></textarea>
                    </div>
                    <div class="hr"></div>
                    <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                        <button>ยืนยัน</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php
}else{
    header("Location: ../../login.php");
}