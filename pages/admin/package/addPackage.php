<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
    function DateThai($strDate){
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
    <link rel="stylesheet" href="../../../css/addPackage.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="addPackage-box">
                <h3>เพิ่มรายการพัสดุ</h3>
                <div class="hr"></div>
                <form action="function/addPackage.php" method="POST">
                    <div class="flex-detail">
                        <div style="padding-right:8px">
                            <p>เลขพัสดุ</p>
                            <input type="text" name="num" required>
                        </div>
                        <div style="padding-right:8px">
                            <p>บริษัท</p>
                            <input type="text" name="company" required>
                        </div>
                    </div>
                    <div class="flex-detail">
                        <div style="padding-right:8px">
                            <p>ชื่อเจ้าของ</p>
                            <input type="text" name="name" required>
                        </div>
                        <div style="padding-right:8px">
                            <p>เลขห้อง</p>
                            <input type="text" name="room" required>
                        </div>
                    </div>
                    <div class="flex-detail">
                        <div style="position:relative;">
                            <p>เวลาที่พัสดุมาถึง</p>
                            <input type="text" id="arrived" style="width:200px;" name="arrived" required>
                            <p id="arrived_date" class="dateText"></p>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                        <button type="submit">ยืนยัน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/addPackage.js"></script>
</body>

</html>
<?php
}else{
    header("Location : ../../login.php");
}
?>