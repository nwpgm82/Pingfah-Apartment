<?php 
include('../../components/sidebar.php'); 
include('../../connection.php');
if($_SESSION['level'] == 'admin'){
?>

<!DOCTYPE html>
<html lang="en">
<?php 
$room_id = $_REQUEST["ID"]; 
$sql1 = "SELECT * FROM roommember WHERE room_member='$room_id' ";
$result1 = mysqli_query($conn, $sql1)or die ("Error in query: $sql " . mysqli_error());
$row1 = mysqli_fetch_array($result1);
if($row1 != null){
    extract($row1);
}       
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pingfah/css/admin/roomform.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="roomform-box">
                <!-- เงื่อนไข 'ถ้าไม่มีข้อมูลผู้ใช้ -->
                <form action='room_member_add_DB.php?ID=<?php echo $room_id; ?>' method='POST' id="form"
                    enctype="multipart/form-data">
                    <h2>ห้อง <?php echo  $room_id; ?></h2>
                    <div class="row">
                        <div class="col-2 select-box">
                            <p>คำนำหน้าชื่อ</p>
                            <?php
                            if(!isset($name_title)){
                            ?>
                            <select name="name_title" id="name_title">
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                            <?php 
                            }else{
                            ?>
                            <select name="name_title" id="name_title">
                                <option value="นาย" <?php if($name_title == 'นาย'){ echo "selected";} ?>>นาย</option>
                                <option value="นาง" <?php if($name_title == 'นาง'){ echo "selected";} ?>>นาง</option>
                                <option value="นางสาว" <?php if($name_title == 'นางสาว'){ echo "selected";} ?>>นางสาว</option>
                            </select>
                            <?php } ?>
                        </div>
                        <div class="col-4 input-box">
                            <p>ชื่อ</p>
                            <input type="text" required name="firstname" id="firstname"
                                value="<?php if(isset($firstname)){echo $firstname;}; ?>" placeholder="ชื่อ"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                        <div class="col-4 input-box">
                            <p>นามสกุล</p>
                            <input type="text" required name="lastname" id="lastname"
                                value="<?php if(isset($lastname)){echo $lastname;}; ?>" placeholder="นามสกุล"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                        <div class="col-2 input-box">
                            <p>ชื่อเล่น</p>
                            <input type="text" required name="nickname" id="nickname"
                                value="<?php if(isset($nickname)){echo $nickname;}; ?>" placeholder="ชื่อเล่น"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3 input-box">
                            <p>เลขบัตรประชาชน</p>
                            <input type="text" required name="id_card" id="id_card"
                                value="<?php if(isset($id_card)){echo $id_card;}; ?>" placeholder="เลขบัตรประชาชน"
                                minlength="2">
                        </div>
                        <div class="col-3 input-box">
                            <p>เบอร์โทรศัพท์</p>
                            <input type="text" required name="phone" id="phone"
                                value="<?php if(isset($phone)){echo $phone;}; ?>" placeholder="เบอร์โทรศัพท์"
                                minlength="2">
                        </div>
                        <div class="col-3 input-box">
                            <p>อีเมล์</p>
                            <input type="text" required name="email" id="email"
                                value="<?php if(isset($email)){echo $email;}; ?>" placeholder="Email" minlength="2">
                        </div>
                        <div class="col-3 input-box">
                            <p>Line</p>
                            <input type="text" required name="line" id="line"
                                value="<?php if(isset($id_line)){echo $id_line;}; ?>" placeholder="Line ID"
                                minlength="2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3 input-box">
                            <p>เกิดวันที่</p>
                            <input type="date" required name="birthday" id="birthday"
                                value="<?php if(isset($birthday)){echo $birthday;}; ?>">
                        </div>
                        <div class="col-2 input-box">
                            <p>อายุ</p>
                            <input type="text" required name="age" id="age"
                                value="<?php if(isset($age)){echo $age;}; ?>" placeholder="อายุ" title="ตัวเลขเท่านั้น"
                                minlength="2">
                        </div>
                        <div class="col-2 input-box">
                            <p>เชื้อชาติ</p>
                            <input type="text" required name="race" id="race"
                                value="<?php if(isset($race)){echo $race;}; ?>" placeholder="เชื้อชาติ"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                        <div class="col-2 input-box">
                            <p>สัญชาติ</p>
                            <input type="text" required name="nationality" id="nationality"
                                value="<?php if(isset($nationality)){echo $nationality;}; ?>" placeholder="สัญชาติ"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                        <div class="col-3 input-box">
                            <p>อาชีพ</p>
                            <input type="text" required name="job" id="job"
                                value="<?php if(isset($job)){echo $job;}; ?>" placeholder="อาชีพ"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                    </div>
                    <div>
                        <p>ที่อยู่</p>
                        <textarea cols="30" rows="10" required name="address" id="address" placeholder="ที่อยู่"
                            minlength="2"><?php if(isset($address)){echo $address;}; ?></textarea>
                    </div>
                    <h3>เอกสารสำเนา</h3>
                    <div class="img-flex">
                        <div>
                            <p>สำเนาบัตรประชาชน</p>
                            <?php
                            if(isset($pic_home)){
                                echo "<img src='/Pingfah/pages/images/$pic_idcard' alt='' id='idcard_img'>";
                            }else{
                                echo "<canvas id='canvas'></canvas>";
                            }
                        ?>
                            <canvas id="canvas" style='display:none'></canvas>
                            <input type="file" name="pic_idcard" id="pic_idcard" value="<?= $pic_idcard; ?>">
                        </div>
                        <div>
                            <p>สำเนาทะเบียนบ้าน</p>
                            <?php
                            if(isset($pic_home)){
                                echo "<img src='/Pingfah/pages/images/$pic_home' alt='' id='home_img'>";
                            }else{
                                echo "<canvas id='canvas' style='display:block'></canvas>";
                            }
                        ?>
                            <canvas id="canvas2" style="display:none"></canvas>
                            <input type="file" name="pic_home" id="pic_home" value="<?= $pic_home; ?>">

                        </div>
                    </div>

                <!-------------------------->
                <?php
                if($row1 != null){
                ?>
                    <div class="row">
                        <div class="col-2 select-box">
                            <p>คำนำหน้าชื่อ</p>
                            <?php
                            if(!isset($name_title)){
                            ?>
                            <select name="name_title" id="name_title">
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                            <?php 
                            }else{
                            ?>
                            <select name="name_title2" id="name_title2">
                            <option value="นาย" <?php if($name_title2 == ''){ echo "selected";} ?>>นาย</option>
                                <option value="นาง" <?php if($name_title2 == 'นาง'){ echo "selected";} ?>>นาง</option>
                                <option value="นางสาว" <?php if($name_title2 == 'นางสาว'){ echo "selected";} ?>>นางสาว</option>
                            </select>
                            <?php } ?>
                        </div>
                        <div class="col-4 input-box">
                            <p>ชื่อ</p>
                            <input type="text" name="firstname2" id="firstname2"
                                value="<?php if(isset($firstname2)){echo $firstname2;}; ?>" placeholder="ชื่อ"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                        <div class="col-4 input-box">
                            <p>นามสกุล</p>
                            <input type="text" name="lastname2" id="lastname2"
                                value="<?php if(isset($lastname2)){echo $lastname2;}; ?>" placeholder="นามสกุล"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                        <div class="col-2 input-box">
                            <p>ชื่อเล่น</p>
                            <input type="text" name="nickname2" id="nickname2"
                                value="<?php if(isset($nickname2)){echo $nickname2;}; ?>" placeholder="ชื่อเล่น"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3 input-box">
                            <p>เลขบัตรประชาชน</p>
                            <input type="text" name="id_card2" id="id_card2"
                                value="<?php if(isset($id_card2)){echo $id_card2;}; ?>" placeholder="เลขบัตรประชาชน"
                                minlength="2">
                        </div>
                        <div class="col-3 input-box">
                            <p>เบอร์โทรศัพท์</p>
                            <input type="text" name="phone2" id="phone2"
                                value="<?php if(isset($phone2)){echo $phone2;}; ?>" placeholder="เบอร์โทรศัพท์"
                                minlength="2">
                        </div>
                        <div class="col-3 input-box">
                            <p>อีเมล์</p>
                            <input type="text" name="email2" id="email2"
                                value="<?php if(isset($email2)){echo $email2;}; ?>" placeholder="Email" minlength="2">
                        </div>
                        <div class="col-3 input-box">
                            <p>Line</p>
                            <input type="text" name="line2" id="line2"
                                value="<?php if(isset($id_line2)){echo $id_line2;}; ?>" placeholder="Line ID"
                                minlength="2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3 input-box">
                            <p>เกิดวันที่</p>
                            <input type="date" name="birthday2" id="birthday2"
                                value="<?php if(isset($birthday2)){echo $birthday2;}; ?>">
                        </div>
                        <div class="col-2 input-box">
                            <p>อายุ</p>
                            <input type="text" name="age2" id="age2"
                                value="<?php if(isset($age2)){echo $age2;}; ?>" placeholder="อายุ" title="ตัวเลขเท่านั้น"
                                minlength="2">
                        </div>
                        <div class="col-2 input-box">
                            <p>เชื้อชาติ</p>
                            <input type="text" name="race2" id="race2"
                                value="<?php if(isset($race2)){echo $race2;}; ?>" placeholder="เชื้อชาติ"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                        <div class="col-2 input-box">
                            <p>สัญชาติ</p>
                            <input type="text" name="nationality2" id="nationality2"
                                value="<?php if(isset($nationality2)){echo $nationality2;}; ?>" placeholder="สัญชาติ"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                        <div class="col-3 input-box">
                            <p>อาชีพ</p>
                            <input type="text" name="job2" id="job2"
                                value="<?php if(isset($job2)){echo $job2;}; ?>" placeholder="อาชีพ"
                                title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2">
                        </div>
                    </div>
                    <div>
                        <p>ที่อยู่</p>
                        <textarea cols="30" rows="10" name="address2" id="address2" placeholder="ที่อยู่"
                            minlength="2"><?php if(isset($address2)){echo $address2;}; ?></textarea>
                    </div>
                    <h3>เอกสารสำเนา</h3>
                    <div class="img-flex">
                        <div>
                            <p>สำเนาบัตรประชาชน</p>
                            <?php
                            if($pic_idcard2 != ""){
                                echo "<img src='/Pingfah/pages/images/$pic_idcard2' alt='' id='idcard_img2'>";
                            }else{
                                echo "<canvas id='canvas3'></canvas>";
                            }
                        ?>
                            <canvas id="canvas3" style='display:none'></canvas>
                            <input type="file" name="pic_idcard2" id="pic_idcard2" value="<?= $pic_idcard2; ?>">
                        </div>
                        <div>
                            <p>สำเนาทะเบียนบ้าน</p>
                            <?php
                        if($pic_home2 != ""){
                                echo "<img src='/Pingfah/pages/images/$pic_home2' alt='' id='home_img2'>";
                            }else{
                                echo "<canvas id='canvas4'></canvas>";
                            }
                        ?>
                            <canvas id="canvas4" style="display:none"></canvas>
                            <input type="file" name="pic_home2" id="pic_home2" value="<?= $pic_home2; ?>">

                        </div>
                    </div>
                        <?php } ?>

                    <div style="margin-top:24px;">
                        <?php
                    if($row1 != null){
                        echo "<button type='submit' name='formEdit' class='edit-btn' id='btn'>ยืนยันการแก้ไข</button>";
                    }else{
                        echo "<button type='submit' name='formSubmit' class='accept-btn' id='btn'>ยืนยัน</button>";
                    }
                        // <button type="submit" name="formSubmit" class="accept-btn" id="btn">ยืนยัน</button>
                    ?>
                        <button type="button" class="del-btn"
                            <?php echo "onclick='delData(" .$room_id .")'" ?>>ลบข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="/Pingfah/js/room_id_form.js"></script>

</body>

</html>
<?php
}else{
    if($_SESSION['level'] == 'employee'){
        Header("Location: /Pingfah/pages/employee/roomList/room_id.php");
    }else{
       Header("Location: ../login.php"); 
    }
}
?>