<?php
    include('../components/maintopbar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/gallery.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div class="gallery">
            <h2>แกลอรี่</h2>
            <div class="hr"></div>
            <div class="grid">
                <div class="img-box" onclick="showImg(1)">
                    <img src="../img/tool/sub1.jpg" alt="">

                </div>
                <div class="img-box">
                    <img src="../img/tool/sub1.jpg" alt="">
                </div>
                <div class="img-box">
                    <img src="../img/tool/sub1.jpg" alt="">
                </div>
                <div class="img-box">
                    <img src="../img/tool/sub1.jpg" alt="">
                </div>
                <div class="img-box">
                    <img src="../img/tool/sub1.jpg" alt="">
                </div>
                <div class="img-box">
                    <img src="../img/tool/sub1.jpg" alt="">
                </div>
                <div class="img-box">
                    <img src="../img/tool/sub1.jpg" alt="">
                </div>
                <div class="img-box">
                    <img src="../img/tool/sub1.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="img-modal" id="modal1" style="display:none;" onclick="close_modal(1)">
        <div class="card">
            <div class="card-header">
                <button onclick="close_modal(1)">X</button>
            </div>
            <div class="card-img-box">
                <img src="../img/tool/sub1.jpg" alt="">
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
    <script src="../js/gallery.js"></script>
</body>

</html>