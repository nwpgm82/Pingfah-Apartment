<?php
    include('connection.php');
    include('../components/maintopbar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/gallery.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div class="gallery">
            <h2>แกลอรี่</h2>
            <div class="hr"></div>
            <div class="grid">
                <?php
                    $sql = "SELECT * FROM gallery ORDER BY gallery_id DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                ?>
                <div class="img-box" onclick="showImg(<?php echo $row['gallery_id']; ?>)" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
                    <img src="images/gallery/<?php echo $row['gallery_name']; ?>" alt="">
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
    <?php
    $sql2 = "SELECT * FROM gallery ORDER BY gallery_id DESC";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
    ?>
    <div class="img-modal" id="modal<?php echo $row2['gallery_id']; ?>" style="display:none;">
        <div class="card">
            <img src="images/gallery/<?php echo $row2['gallery_name']; ?>" alt="">
            <button onclick="close_modal(<?php echo $row2['gallery_id']; ?>)">X</button>
        </div>
    </div>
    <?php
        }
    }
    ?>
    <script src="../js/gallery.js"></script>
</body>

</html>