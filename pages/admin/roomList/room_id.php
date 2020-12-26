<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../connection.php");
    $room_id = $_REQUEST["ID"];
    $sql = "SELECT * FROM roommember WHERE room_id = '$room_id' LIMIT 1";
    $result = mysqli_query($conn, $sql)or die ("Error in query: $sql " . mysqli_error());
    $row = mysqli_fetch_array($result);
    if($row != null){
    extract($row);
    }    
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
                <?php if($row == null){ ?>
                <div class="new_customer">
                    <div>
                        <h3>ห้อง <?php echo $room_id; ?> ยังว่างอยู่ ต้องการเพิ่มข้อมูลผู้พักใช่หรือไม่ ?</h3>
                        <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                            <button id="add-btn">เพิ่มผู้พัก</button>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div id="form-box" <?php if($row == null){ echo "style='display:none;'"; }?> >
                    <form action="function/addData.php?ID=<?php echo $room_id; ?>" method="POST"
                        enctype="multipart/form-data">
                        <h3>ห้อง <?php echo $room_id; ?></h3>
                        <div class="hr"></div>
                        <div class="grid-container">
                            <div class="come" style="position:relative;">
                                <p>วันที่เริ่มเข้าพัก</p>
                                <input type="text" name="come" id="come_date" placeholder="วันที่เริ่มเข้าพัก">
                                <h5 id="come_error" style="color:red;"></h5>
                            </div>
                            <!-- <div class="status">
                                <p>สถานะการเข้าพัก</p>
                                <input type="text">
                            </div> -->
                            <div class="title_name">
                                <p>คำนำหน้าชื่อ</p>
                                <select name="title_name" id="title_name">
                                    <option value="นาย" selected>นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                </select>
                            </div>
                            <div class="firstname">
                                <p>ชื่อ</p>
                                <input type="text" name="firstname" id="firstname" placeholder="ชื่อ">
                                <h5 id="fs_error" style="color:red;"></h5>
                            </div>
                            <div class="lastname">
                                <p>นามสกุล</p>
                                <input type="text" name="lastname" id="lastname" placeholder="นามสกุล">
                                <h5 id="ls_error" style="color:red;"></h5>
                            </div>
                            <div class="nickname">
                                <p>ชื่อเล่น</p>
                                <input type="text" name="nickname" id="nickname" placeholder="ชื่อเล่น">
                                <h5 id="nk_error" style="color:red;"></h5>
                            </div>
                            <div class="id_card">
                                <p>เลขบัตรประชาชน / Passport No.</p>
                                <input type="text" name="id_card" id="id_card"
                                    placeholder="เลขบัตรประชาชน / Passport No." maxlength="13">
                                <h5 id="id_error" style="color:red;"></h5>
                            </div>
                            <div class="birthday">
                                <p>วัน / เดือน / ปีเกิด</p>
                                <input type="text" name="birthday" id="birthday" placeholder="วัน / เดือน / ปีเกิด">
                                <h5 id="bd_error" style="color:red;"></h5>
                            </div>
                            <div class="age">
                                <p>อายุ</p>
                                <input type="number" name="age" id="age" min="23" max="60"
                                    oninput="this.value = this.value > 60 ? 60 : Math.abs(this.value)"
                                    placeholder="อายุ" readonly>
                                <h5 id="ag_error" style="color:red;"></h5>
                            </div>
                            <div class="phone">
                                <p>เบอร์โทรศัพท์</p>
                                <input type="text" name="tel" id="tel" maxlength="10" placeholder="เบอร์โทรศัพท์">
                                <h5 id="tel_error" style="color:red;"></h5>
                            </div>
                            <div class="email">
                                <p>อีเมล</p>
                                <input type="email" name="email" id="email" placeholder="อีเมล">
                                <h5 id="em_error" style="color:red;"></h5>
                            </div>
                            <div class="race">
                                <p>เชื้อชาติ</p>
                                <input type="text" name="race" id="race" placeholder="เชื้อชาติ" value="ไทย">
                                <h5 id="rc_error" style="color:red;"></h5>
                            </div>
                            <div class="nationality">
                                <p>สัญชาติ</p>
                                <input type="text" name="nation" id="nation" placeholder="สัญชาติ" value="ไทย">
                                <h5 id="na_error" style="color:red;"></h5>
                            </div>
                            <div class="job">
                                <p>อาชีพ</p>
                                <input type="text" name="job" id="job" placeholder="อาชีพ">
                                <h5 id="job_error" style="color:red;"></h5>
                            </div>
                        </div>
                        <div style="padding-top:16px;height:146px;">
                            <p>ที่อยู่</p>
                            <textarea name="address" id="address" placeholder="ที่อยู่"></textarea>
                            <h5 id="ad_error" style="color:red;"></h5>
                        </div>
                        <div style="padding-top:32px;">
                            <h3>สำเนาเอกสาร</h3>
                            <div class="hr"></div>
                            <div class="img-grid">
                                <div>
                                    <p>สำเนาบัตรประชาชน</p>
                                    <div class="img-box" id="id_box">
                                        <img src="" id="img_id" alt="">
                                    </div>
                                    <h5 id="idimg_error" style="color:red;"></h5>
                                    <input type="file" name="id_img" id="id_img">
                                </div>
                                <div>
                                    <p>สำเนาทะเบียนบ้าน</p>
                                    <div class="img-box" id="home_box">
                                        <img src="" id="img_home" alt="">
                                    </div>
                                    <h5 id="homeimg_error" style="color:red;"></h5>
                                    <input type="file" name="home_img" id="home_img">
                                </div>
                            </div>
                        </div>
                        <div class="hr"></div>
                        <div style="padding-top:32px;display:flex;justify-content:center;align-items:center;">
                            <button type="submit">เพิ่มผู้พัก</button>
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