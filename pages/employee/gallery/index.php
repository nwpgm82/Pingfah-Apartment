<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../connection.php");
    include("../../../components/sidebar.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="../../../css/gallery_detail.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="gallery-card">
                <div class="header">
                    <h3>รายการแกลอรี่ทั้งหมด</h3>
                    <form id="submitForm" enctype="multipart/form-data">
                        <input type="file" name="file" id="file" class="inputfile"/>
                        <label for="file">เพิ่มรูปภาพ</label>
                    </form>
                </div>
                <div class="hr"></div>
                <div class="grid">
                    <?php
                    $sql = "SELECT * FROM gallery ORDER BY gallery_id DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="img-box">
                        <img src="../../images/gallery/<?php echo $row['gallery_name']; ?>" alt="">
                        <button class="del-btn" onclick="delImg(<?php echo $row['gallery_id']; ?>)">X</button>
                    </div>
                    <?php
                        }
                    }else{
                        echo "ไม่มีรูปภาพ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/gallery.js"></script>
</body>

</html>