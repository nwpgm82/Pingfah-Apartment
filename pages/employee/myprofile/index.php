<?php
session_start();
if($_SESSION['level'] == 'employee'){
    include('../../connection.php');
    include('../../../components/sidebarEPY.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/emDetail.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="emDetail-box">
                <form action="function/editEm.php" method='POST' enctype="multipart/form-data">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <h3>รายละเอียดพนักงาน</h3>
                        <div>
                            <button type="button" id="edit_data" class="edit-btn" onclick="edit()">แก้ไข</button>
                            <div id="option" style="display:none;">
                                <button type="submit" name="accept_edit">ยืนยัน</button>
                                <button type="button" class="cancel-btn" onclick="cancel_edit()">ยกเลิก</button>
                            </div>
                        </div> 
                    </div>
                    <div class="hr"></div>
                    <?php
                    $sql = "SELECT * FROM employee WHERE username = '".$_SESSION['ID']."'";
                    $result = mysqli_query($conn, $sql)or die ("Error in query: $sql " . mysqli_error());
                    $row = mysqli_fetch_array($result);
                    if($row != null){
                    extract($row);
                    }     
                    ?>
                    <div class="row" style="padding-top: 32px;">
                        <div class="col-2">
                            <div style="padding-top:8px">
                                <div class="profile-box">
                                    <img src="<?php if(isset($profile_img)){ echo "../../images/employee/$username/$profile_img"; } ?>" id="output_imagepic1" class="profile">
                                    <div style="display:none" id="del1">
                                        <?php
                                        if(isset($profile_img)){ ?>
                                        <button class="del-btn" type="button"
                                            onclick="delImg('<?php echo $username ?>','profile_img')">X</button>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                                if(!isset($profile_img)){ ?>
                                <input type="file" accept="image/*" name="profile_img" id="profile_img"
                                    onchange="preview_image(event,'pic1')" style="padding-top:16px" disabled>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-2">
                                    <p>คำนำหน้าชื่อ</p>
                                    <select name="title_name" id="title_name" value="<?php echo $title_name ?>"
                                        disabled>
                                        <option value="นาย" <?php if($title_name == 'นาย'){ echo "selected"; } ?>>นาย
                                        </option>
                                        <option value="นาง" <?php if($title_name == 'นาง'){ echo "selected"; } ?>>นาง
                                        </option>
                                        <option value="นางสาว" <?php if($title_name == 'นางสาว'){ echo "selected"; } ?>>
                                            นางสาว</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <p>ชื่อ</p>
                                    <input type="text" value="<?php echo $firstname; ?>" name="firstname" id="firstname"
                                        placeholder="ชื่อ" disabled required>
                                </div>
                                <div class="col-3">
                                    <p>นามสกุล</p>
                                    <input type="text" value="<?php echo $lastname; ?>" name="lastname" id="lastname"
                                        placeholder="นามสกุล" disabled required>
                                </div>
                                <div class="col-2">
                                    <p>ชื่อเล่น</p>
                                    <input type="text" value="<?php echo $nickname; ?>" name="nickname" id="nickname"
                                        placeholder="ชื่อเล่น" disabled required>
                                </div>
                                <div class="col-2">
                                    <p>ตำแหน่ง</p>
                                    <input type="text" value="<?php echo $position; ?>" name="position" id="position"
                                        placeholder="ตำแหน่ง" disabled required>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 32px;">
                                <div class="col-3">
                                    <p>เลขบัตรประชาชน</p>
                                    <input type="text" value="<?php echo $id_card; ?>" name="id_card" id="id_card"
                                        placeholder="เลขบัตรประชาชน" disabled required>
                                </div>
                                <div class="col-3">
                                    <p>เบอร์โทรศัพท์</p>
                                    <input type="tel" value="<?php echo $tel; ?>" name="tel" id="tel"
                                        placeholder="เบอร์โทรศัพท์" disabled required>
                                </div>
                                <div class="col-3">
                                    <p>อีเมล์</p>
                                    <input type="email" value="<?php echo $email; ?>" name="email" id="email"
                                        placeholder="อีเมล์" disabled required>
                                </div>
                                <div class="col-3">
                                    <p>Line</p>
                                    <input type="text" value="<?php echo $id_line; ?>" name="id_line" id="id_line"
                                        placeholder="ID Line" disabled required>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 32px;">
                                <div class="col-3">
                                    <p>เกิดวันที่</p>
                                    <div style="position:relative;">
                                        <input id="birthday" name="birthday" type="text" value="<?php echo $birthday; ?>" disabled required>
                                        <p id="birth_date" class="dateText"></p>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <p>อายุ</p>
                                    <input type="text" value="<?php echo $age; ?>" name="age" id="age"
                                        placeholder="อายุ" disabled required>
                                </div>
                                <div class="col-3">
                                    <p>เชื้อชาติ</p>
                                    <input type="text" value="<?php echo $race; ?>" name="race" id="race"
                                        placeholder="เชื้อชาติ" disabled required>
                                </div>
                                <div class="col-3">
                                    <p>สัญชาติ</p>
                                    <input type="text" value="<?php echo $nationality; ?>" name="nationality"
                                        id="nationality" placeholder="สัญชาติ" disabled required>
                                </div>
                            </div>
                            <div style="padding: 32px 8px 0 0;">
                                <p>ที่อยู่</p>
                                <textarea name="address" id="address" placeholder="ที่อยู่" disabled
                                    required><?php echo $address; ?></textarea>
                            </div>
                            <div style="padding-top:32px;">
                                <h3>สำเนาเอกสาร</h3>
                                <div class="row" style="padding-top:16px">
                                    <div class="col-6">
                                        <p>สำเนาบัตรประชาชน</p>
                                        <div class="img-box">
                                            <img src="../../images/employee/<?php echo $username; ?>/<?php echo $pic_idcard; ?>"
                                                id="output_imagepic2">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <p>สำเนาทะเบียนบ้าน</p>
                                        <div class="img-box">
                                            <img src="../../images/employee/<?php echo $username; ?>/<?php echo $pic_home; ?>"
                                                id="output_imagepic3">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="padding-top:32px;">
                                <h3>บัญชีผู้ใช้</h3>
                                <div style="padding-top:16px;">
                                    <div class="col-6">
                                        <p>Username</p>
                                        <input type="text" value="<?php echo $username?>" name="username" id="username"
                                            placeholder="บัญชีผู้ใช้" disabled required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../js/employee/emDetail.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>