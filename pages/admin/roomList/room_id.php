<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../connection.php");
    $room_id = $_REQUEST["ID"];
    $sql = "SELECT * FROM roommember WHERE member_status = 'เข้าพักอยู่'";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/roomform.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <script src="../../../js/admin/room_id_form.js"></script>
    <title>Document</title>
</head>

<body>
    <?php include("../../../components/sidebar.php"); ?>
    <div class="box">
        <div style="padding:24px;">
            <div class="roomform-box">
                <div class="new_customer">
                    <div>
                        <h3>ห้อง <?php echo $room_id; ?> ยังว่างอยู่ ต้องการเพิ่มข้อมูลผู้พักใช่หรือไม่ ?</h3>
                        <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                            <button id="add-btn">เพิ่มผู้พัก</button>
                        </div>
                    </div>
                </div>
                <div id="form-box" style="display:none;">
                    <form action="">
                        <h3>ห้อง <?php echo $room_id; ?></h3>
                        <div class="hr"></div>
                        <div class="grid-container">
                            <div class="come">
                                <p>วันที่เริ่มเข้าพัก</p>
                                <input type="text" id="come_date">
                            </div>
                            <!-- <div class="status">
                                <p>สถานะการเข้าพัก</p>
                                <input type="text">
                            </div> -->
                            <div class="title_name">
                                <p>คำนำหน้าชื่อ</p>
                                <select name="" id="">
                                    <option value="นาย" selected>นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                </select>
                            </div>
                            <div class="firstname">
                                <p>ชื่อ</p>
                                <input type="text" placeholder="ชื่อ">
                            </div>
                            <div class="lastname">
                                <p>นามสกุล</p>
                                <input type="text" placeholder="นามสกุล">
                            </div>
                            <div class="nickname">
                                <p>ชื่อเล่น</p>
                                <input type="text" placeholder="ชื่อเล่น">
                            </div>
                            <div class="id_card">
                                <p>เลขบัตรประชาชน / Passport No.</p>
                                <input type="text" placeholder="เลขบัตรประชาชน / Passport No." maxlength="13">
                            </div>
                            <div class="birthday">
                                <p>วัน / เดือน / ปีเกิด</p>
                                <input type="text">
                            </div>
                            <div class="age">
                                <p>อายุ</p>
                                <input type="number" min="23" max="60" oninput="this.value = this.value > 60 ? 60 : Math.abs(this.value)" placeholder="อายุ" readonly>
                            </div>
                            <div class="phone">
                                <p>เบอร์โทรศัพท์</p>
                                <input type="text" maxlength="10" placeholder="เบอร์โทรศัพท์">
                            </div>
                            <div class="email">
                                <p>อีเมล</p>
                                <input type="email" placeholder="อีเมล">
                            </div>
                            <div class="race">
                                <p>เชื้อชาติ</p>
                                <input type="text" placeholder="เชื้อชาติ">
                            </div>
                            <div class="nationality">
                                <p>สัญชาติ</p>
                                <input type="text" placeholder="สัญชาติ">
                            </div>
                            <div class="job">
                                <p>อาชีพ</p>
                                <input type="text" placeholder="อาชีพ">
                            </div>
                        </div>
                        <div style="padding-top:16px;">
                            <p>ที่อยู่</p>
                            <textarea name="" id="" placeholder="ที่อยู่"></textarea>
                        </div>
                        <div style="padding-top:32px;">
                            <h3>สำเนาเอกสาร</h3>
                            <div class="hr"></div>
                            <div class="img-grid">
                                <div>
                                    <p>สำเนาบัตรประชาชน</p>
                                    <div class="img-box">

                                    </div>
                                    <input type="file" name="" id="">
                                </div>
                                <div>
                                    <p>สำเนาทะเบียนบ้าน</p>
                                    <div class="img-box">

                                    </div>
                                    <input type="file" name="" id="">
                                </div>
                            </div>
                        </div>
                        <div class="hr"></div>
                        <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                            <button>เพิ่มผู้พัก</button>
                        </div>
                    </form>
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