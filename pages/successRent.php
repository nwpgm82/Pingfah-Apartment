<?php
function DateThai($strDate)
{
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/successRent.css">
    <title>Document</title>
</head>

<body>
    <?php
    // include("../components/maintopbar.php")
    ?>
    <div class="box">
        <div class="success-box">
            <div style="line-height:60px;">
                <h1 style="text-align:center;color:rgb(131, 120, 47, 1)">จองห้องพักสำเร็จ</h1>
                <h2 style="text-align:center;color:rgb(131, 120, 47, 1)">เลขที่ในการจอง : <?php if(isset($_REQUEST['code'])){ echo $_REQUEST['code'];} ?></h2>
                <div style="padding:32px 0;width:480px;">
                    <p style="color:rgb(131, 120, 47, 1);text-align:center;"><strong>*** เมื่อวางเงินมัดจำแล้วให้อัปโหลดสลิปได้ที่เมนู <a href="checkCode.php" style="color:">ตรวจสอบการจอง</a> ***</strong></p>
                </div>
                <div style="display:flex;justify-content:center;align-items:center;">
                    <button id="close-window">ปิดหน้านี้</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    document.getElementById("close-window").addEventListener("click", function() {
        window.close();
    });
    </script>
</body>

</html>