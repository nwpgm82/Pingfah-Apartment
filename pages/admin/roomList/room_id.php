<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php'); 
    $room_id = $_REQUEST["ID"]; 
    $path1 = "../../images/roommember/$room_id";
    if(is_dir($path1)){
        echo "<script>alert('มีโฟลเดอร์ $path1')</script>";
    }else{
        echo "ไม่มีโฟลเดอร์";
    }
    $check_status = "SELECT room_status FROM roomlist WHERE room_id = '$room_id'";
    $check_result = $conn->query($check_status);
    $status = $check_result->fetch_assoc();
    // echo $status['room_status'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/roomform.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <?php
        if($status['room_status'] != 'เช่ารายวัน'){
        ?>
            <div id="month" class="roomform-box">
                <div id="first">
                    <?php
                $sql = "SELECT room_member, name_title, firstname, lastname, nickname, id_card, phone, email, birthday, age, race, nationality, job, address, pic_idcard, pic_home, id_line FROM roommember WHERE room_member='$room_id' ";
                $result = mysqli_query($conn, $sql)or die ("Error in query: $sql " . mysqli_error());
                $row = mysqli_fetch_array($result);
                if($row != null){
                extract($row);
                }    
                ?>
                    <form action='room_member_add_DB.php?ID=<?php echo $room_id; ?>' method='POST' id="form"
                        enctype="multipart/form-data">
                        <h3>ห้อง <?php echo $room_id; ?></h3>
                        <div class="hr"></div>
                        <div class="row">
                            <div class="col-2 select-box">
                                <p>คำนำหน้าชื่อ</p>
                                <?php
                            if(!isset($name_title)){
                            ?>
                                <select name="name_title" id="name_title" disabled>
                                    <option value="นาย">นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                </select>
                                <?php 
                            }else{
                            ?>
                                <select name="name_title" id="name_title" disabled>
                                    <option value="นาย" <?php if($name_title == 'นาย'){ echo "selected";} ?>>นาย
                                    </option>
                                    <option value="นาง" <?php if($name_title == 'นาง'){ echo "selected";} ?>>นาง
                                    </option>
                                    <option value="นางสาว" <?php if($name_title == 'นางสาว'){ echo "selected";} ?>>
                                        นางสาว</option>
                                </select>
                                <?php } ?>
                            </div>
                            <div class="col-4 input-box">
                                <p>ชื่อ</p>
                                <input type="text" required name="firstname" id="firstname"
                                    value="<?php if(isset($firstname)){echo $firstname;}; ?>" placeholder="ชื่อ"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                            <div class="col-4 input-box">
                                <p>นามสกุล</p>
                                <input type="text" required name="lastname" id="lastname"
                                    value="<?php if(isset($lastname)){echo $lastname;}; ?>" placeholder="นามสกุล"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                            <div class="col-2 input-box">
                                <p>ชื่อเล่น</p>
                                <input type="text" required name="nickname" id="nickname"
                                    value="<?php if(isset($nickname)){echo $nickname;}; ?>" placeholder="ชื่อเล่น"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 input-box">
                                <p>เลขบัตรประชาชน</p>
                                <input type="text" required name="id_card" id="id_card"
                                    value="<?php if(isset($id_card)){echo $id_card;}; ?>" placeholder="เลขบัตรประชาชน"
                                    minlength="2" disabled>
                            </div>
                            <div class="col-3 input-box">
                                <p>เบอร์โทรศัพท์</p>
                                <input type="text" required name="phone" id="phone"
                                    value="<?php if(isset($phone)){echo $phone;}; ?>" placeholder="เบอร์โทรศัพท์"
                                    minlength="2" disabled>
                            </div>
                            <div class="col-3 input-box">
                                <p>อีเมล์</p>
                                <input type="text" required name="email" id="email"
                                    value="<?php if(isset($email)){echo $email;}; ?>" placeholder="Email" minlength="2" disabled>
                            </div>
                            <div class="col-3 input-box">
                                <p>Line</p>
                                <input type="text" required name="line" id="line"
                                    value="<?php if(isset($id_line)){echo $id_line;}; ?>" placeholder="Line ID"
                                    minlength="2" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 input-box">
                                <p>เกิดวันที่</p>
                                <input type="date" required name="birthday" id="birthday"
                                    value="<?php if(isset($birthday)){echo $birthday;}; ?>" disabled>
                            </div>
                            <div class="col-2 input-box">
                                <p>อายุ</p>
                                <input type="text" required name="age" id="age"
                                    value="<?php if(isset($age)){echo $age;}; ?>" placeholder="อายุ"
                                    title="ตัวเลขเท่านั้น" minlength="2" disabled>
                            </div>
                            <div class="col-2 input-box">
                                <p>เชื้อชาติ</p>
                                <input type="text" required name="race" id="race"
                                    value="<?php if(isset($race)){echo $race;}; ?>" placeholder="เชื้อชาติ"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                            <div class="col-2 input-box">
                                <p>สัญชาติ</p>
                                <input type="text" required name="nationality" id="nationality"
                                    value="<?php if(isset($nationality)){echo $nationality;}; ?>" placeholder="สัญชาติ"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                            <div class="col-3 input-box">
                                <p>อาชีพ</p>
                                <input type="text" required name="job" id="job"
                                    value="<?php if(isset($job)){echo $job;}; ?>" placeholder="อาชีพ"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                        </div>
                        <div style="padding:32px 8px 0 0;">
                            <p>ที่อยู่</p>
                            <textarea cols="30" rows="10" required name="address" id="address" placeholder="ที่อยู่"
                                minlength="2" disabled><?php if(isset($address)){echo $address;} ?>
                        </textarea>
                        </div>
                        <div style="padding-top:32px;">
                            <h3>สำเนาเอกสาร</h3>
                            <div class="grid">
                                <div>
                                    <p>สำเนาบัตรประชาชน</p>
                                    <div class="img-box">
                                        <img id="output_imagepic1"
                                            src="../../images/roommember/<?php echo $room_id; ?>/1/<?php echo $pic_idcard; ?>" />
                                        <?php
                                        if(isset($pic_idcard)){ ?>
                                        <button class="del-btn" type="button" id="del-btn1" style="display:none;"
                                            onclick="delImg('<?php echo $room_id ?>','pic_idcard',1)">X</button>
                                        <?php } ?>
                                    </div>
                                    <?php
                                    if(!isset($pic_idcard)){ ?>
                                    <input type="file" id="pic_idcard1" accept="image/*" onchange="preview_image(event,'pic1')"
                                        name="pic_idcard" disabled>
                                    <?php } ?>
                                </div>
                                <div>
                                    <p>สำเนาทะเบียนบ้าน</p>
                                    <div class="img-box">
                                        <img id="output_imagepic2"
                                            src="../../images/roommember/<?php echo $room_id; ?>/1/<?php echo $pic_home; ?>" />
                                        <?php
                                    if(isset($pic_home)){ ?>
                                        <button class="del-btn" type="button" id="del-btn2" style="display:none;"
                                            onclick="delImg('<?php echo $room_id; ?>','pic_home',1)">X</button>
                                        <?php } ?>
                                    </div>
                                    <?php
                                if(!isset($pic_home)){ ?>
                                    <input type="file" id="pic_home1" accept="image/*" onchange="preview_image(event,'pic2')"
                                        name="pic_home" disabled>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="hr" style="margin: 32px 0;"></div>
                        <?php if($row != null){ ?>
                        <div style="display:flex;justify-content:flex-end;">
                            <button type="button" onclick="navigation()">คนที่ 2</button>
                        </div>
                        <div id="edit-1" style="padding-top:32px;display:flex;justify-content:center;">
                            <button type="button" class="edit-btn" onclick="editData(1)">แก้ไข</button>
                        </div>
                        <div id="btn-1" style="padding-top:32px;display:none;justify-content:center;">
                            <button type="submit" name='formSubmit' class="confirm">ยืนยัน</button>
                            <button type="button" class="delData" onclick="cancelEditData(1)">ยกเลิก</button>
                        </div>
                        <hr />
                        <div style="padding-top:32px;display:flex;justify-content:flex-end">
                            <button type="button" class="delData"
                                onclick="delData(<?php echo $room_id; ?>)">ลบข้อมูล</button>
                        </div>
                        <?php }else{ ?>
                            <div id="edit-1" style="padding-top:32px;display:flex;justify-content:center;">
                            <button type="button" class="edit-btn" onclick="editData(1)">แก้ไข</button>
                        </div>
                        <div id="btn-1" style="padding-top:32px;display:none;justify-content:center;">
                            <button type="submit" name='formSubmit' class="confirm">ยืนยัน</button>
                            <button type="button" class="delData" onclick="cancelEditData(1)">ยกเลิก</button>
                        </div>
                        <!-- <div style="display:flex;justify-content:center;">
                            <button type="submit" name='formSubmit' class="confirm">ยืนยัน</button>
                        </div> -->
                        <?php } ?>

                    </form>
                </div>
                <!--  -->
                <?php if($row != null){ ?>
                <div id="second" style="display:none">
                    <?php
                $room_id2 = $_REQUEST["ID"]; 
                $sql2 = "SELECT room_member, name_title2, firstname2, lastname2, nickname2, id_card2, phone2, email2, birthday2, age2, race2, nationality2, job2, address2, pic_idcard2, pic_home2, id_line2 FROM roommember WHERE room_member='$room_id2' ";
                $result2 = mysqli_query($conn, $sql2)or die ("Error in query: $sql2 " . mysqli_error());
                $row2 = mysqli_fetch_array($result2);
                if($row2 != null){
                extract($row2);
                }     
                ?>
                    <form action='room_member_add_DB.php?ID=<?php echo $room_id; ?>' method='POST' id="form"
                        enctype="multipart/form-data">
                        <h3>ห้อง <?php echo $room_id; ?></h3>
                        <div class="hr"></div>
                        <div class="row">
                            <div class="col-2 select-box">
                                <p>คำนำหน้าชื่อ</p>
                                <?php
                            if(!isset($name_title2)){
                            ?>
                                <select name="name_title2" id="name_title2" disabled>
                                    <option value="นาย">นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                </select>
                                <?php 
                            }else{
                            ?>
                                <select name="name_title2" id="name_title2" disabled>
                                    <option value="นาย" <?php if($name_title2 == 'นาย'){ echo "selected";} ?>>นาย
                                    </option>
                                    <option value="นาง" <?php if($name_title2 == 'นาง'){ echo "selected";} ?>>นาง
                                    </option>
                                    <option value="นางสาว" <?php if($name_title2 == 'นางสาว'){ echo "selected";} ?>>
                                        นางสาว</option>
                                </select>
                                <?php } ?>
                            </div>
                            <div class="col-4 input-box">
                                <p>ชื่อ</p>
                                <input type="text" required name="firstname2" id="firstname2"
                                    value="<?php if(isset($firstname2)){echo $firstname2;}; ?>" placeholder="ชื่อ"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                            <div class="col-4 input-box">
                                <p>นามสกุล</p>
                                <input type="text" required name="lastname2" id="lastname2"
                                    value="<?php if(isset($lastname2)){echo $lastname2;}; ?>" placeholder="นามสกุล"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                            <div class="col-2 input-box">
                                <p>ชื่อเล่น</p>
                                <input type="text" required name="nickname2" id="nickname2"
                                    value="<?php if(isset($nickname2)){echo $nickname2;}; ?>" placeholder="ชื่อเล่น"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 input-box">
                                <p>เลขบัตรประชาชน</p>
                                <input type="text" required name="id_card2" id="id_card2"
                                    value="<?php if(isset($id_card2)){echo $id_card2;}; ?>" placeholder="เลขบัตรประชาชน"
                                    minlength="2" disabled>
                            </div>
                            <div class="col-3 input-box">
                                <p>เบอร์โทรศัพท์</p>
                                <input type="text" required name="phone2" id="phone2"
                                    value="<?php if(isset($phone2)){echo $phone2;}; ?>" placeholder="เบอร์โทรศัพท์"
                                    minlength="2" disabled>
                            </div>
                            <div class="col-3 input-box">
                                <p>อีเมล์</p>
                                <input type="text" required name="email2" id="email2"
                                    value="<?php if(isset($email2)){echo $email2;}; ?>" placeholder="Email"
                                    minlength="2" disabled>
                            </div>
                            <div class="col-3 input-box">
                                <p>Line</p>
                                <input type="text" required name="line2" id="line2"
                                    value="<?php if(isset($id_line2)){echo $id_line2;}; ?>" placeholder="Line ID"
                                    minlength="2" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 input-box">
                                <p>เกิดวันที่</p>
                                <input type="date" required name="birthday2" id="birthday2"
                                    value="<?php if(isset($birthday2)){echo $birthday2;}; ?>" disabled>
                            </div>
                            <div class="col-2 input-box">
                                <p>อายุ</p>
                                <input type="text" required name="age2" id="age2"
                                    value="<?php if(isset($age2)){echo $age2;}; ?>" placeholder="อายุ"
                                    title="ตัวเลขเท่านั้น" minlength="2" disabled>
                            </div>
                            <div class="col-2 input-box">
                                <p>เชื้อชาติ</p>
                                <input type="text" required name="race2" id="race2"
                                    value="<?php if(isset($race2)){echo $race2;}; ?>" placeholder="เชื้อชาติ"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                            <div class="col-2 input-box">
                                <p>สัญชาติ</p>
                                <input type="text" required name="nationality2" id="nationality2"
                                    value="<?php if(isset($nationality2)){echo $nationality2;}; ?>"
                                    placeholder="สัญชาติ" title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                            <div class="col-3 input-box">
                                <p>อาชีพ</p>
                                <input type="text" required name="job2" id="job2"
                                    value="<?php if(isset($job2)){echo $job2;}; ?>" placeholder="อาชีพ"
                                    title="ภาษาอังกฤษหรือภาษาไทยเท่านั้น" minlength="2" disabled>
                            </div>
                        </div>
                        <div style="padding:32px 8px 0 0;">
                            <p>ที่อยู่</p>
                            <textarea cols="30" rows="10" required name="address2" id="address2" placeholder="ที่อยู่"
                                minlength="2" disabled><?php if(isset($address2)){echo $address2;} ?>
                        </textarea>
                        </div>
                        <div style="padding-top:32px;">
                            <h3>สำเนาเอกสาร</h3>
                            <div class="grid">
                                <div>
                                    <p>สำเนาบัตรประชาชน</p>
                                    <div class="img-box">
                                        <img id="output_imagepic3"
                                            src="../../images/roommember/<?php echo $room_id; ?>/2/<?php echo $pic_idcard2; ?>" />
                                        <?php
                                    if(isset($pic_idcard2)){ ?>
                                        <button class="del-btn" type="button" id="del-btn3" style="display:none;"
                                            onclick="delImg('<?php echo $room_id ?>','pic_idcard2',2)">X</button>
                                        <?php } ?>
                                    </div>
                                    <?php
                                if(!isset($pic_idcard2)){ ?>
                                    <input type="file" id="pic_idcard2" accept="image/*" onchange="preview_image(event,'pic3')"
                                        name="pic_idcard2" disabled>
                                    <?php } ?>
                                </div>
                                <div>
                                    <p>สำเนาทะเบียนบ้าน</p>
                                    <div class="img-box">
                                        <img id="output_imagepic4"
                                            src="../../images/roommember/<?php echo $room_id; ?>/2/<?php echo $pic_home2; ?>" />
                                        <?php
                                    if(isset($pic_home2)){ ?>
                                        <button class="del-btn" type="button" id="del-btn4" style="display:none;"
                                            onclick="delImg('<?php echo $room_id; ?>','pic_home2',2)">X</button>
                                        <?php } ?>
                                    </div>
                                    <?php
                                if(!isset($pic_home2)){ ?>
                                    <input type="file" id="pic_home2" accept="image/*" onchange="preview_image(event,'pic4')"
                                        name="pic_home2" disabled>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div style="display:flex;justify-content:flex-start;">
                            <button type="button" onclick="navigation()">คนที่ 1</button>
                        </div>
                        <div id="edit-2" style="padding-top:32px;display:flex;justify-content:center;">
                            <button type="button" class="edit-btn" onclick="editData(2)">แก้ไข</button>
                        </div>
                        <div id="btn-2" style="padding-top:32px;display:none;justify-content:center">
                            <button type="submit" name='formSubmit2'>ยืนยัน</button>
                            <button type="button" class="delData" onclick="cancelEditData(2)">ยกเลิก</button>
                        </div>
                        <div class="hr" style="margin: 32px 0;"></div>
                        <div style="padding-top:32px;display:flex;justify-content:flex-end">
                            <button type="button" class="delData"
                                onclick="delData(<?php echo $room_id; ?>)">ลบข้อมูล</button>
                        </div>
                    </form>
                </div>
                <?php } ?>
            </div>
            <?php
        }else if($status['room_status'] == 'เช่ารายวัน'){
            $sql = "SELECT * FROM roommember WHERE room_member = '$room_id'";
            $result = mysqli_query($conn, $sql)or die ("Error in query: $sql " . mysqli_error());
            $row = mysqli_fetch_array($result);
            if($row != null){
                extract($row);
            }    
            $sql2 =  "SELECT * FROM daily WHERE id_card = '$id_card'";
            $result2 = mysqli_query($conn, $sql2)or die ("Error in query: $sql2 " . mysqli_error());
            $row2 = mysqli_fetch_array($result2);
            if($row2 != null){
                extract($row2);
            } 
        ?>

            <div id="daily" class="roomform-box">
                <form action='room_member_add_DB.php?ID=<?php echo $room_id; ?>' method='POST' id="form"
                    enctype="multipart/form-data">
                    <h3>ห้อง <?php echo $room_id; ?></h3>
                    <div class="hr"></div>
                    <div class="row">
                        <div class="col-2 input-box">
                            <label>เช็คอิน</label>
                            <input type="text" value="<?php echo $check_in; ?>" disabled>
                        </div>
                        <div class="col-2 input-box">
                            <label>เช็คเอ้าท์</label>
                            <input type="text" value="<?php echo $check_out; ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 input-box">
                            <label>ชื่อ</label>
                            <input type="text" value="<?php echo $firstname; ?>" disabled>
                        </div>
                        <div class="col-4 input-box">
                            <label>นามสกุล</label>
                            <input type="text" value="<?php echo $lastname; ?>" disabled>
                        </div>
                        <div class="col-4 input-box">
                            <label>เลขบัตรประชาชน / Passport</label>
                            <input type="text" value="<?php echo $id_card; ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 input-box">
                            <label>อีเมล</label>
                            <input type="text" value="<?php echo $email; ?>" disabled>
                        </div>
                        <div class="col-4 input-box">
                            <label>เบอร์โทรศัพท์</label>
                            <input type="text" value="<?php echo $phone; ?>" disabled>
                        </div>
                        <div class="col-4 input-box">
                            <label>เลขในการจอง</label>
                            <input type="text" value="<?php echo $code; ?>" disabled>
                        </div>
                    </div>
                    <div style="padding-top:32px;">
                        <h3>สำเนาเอกสาร</h3>
                        <div class="grid">
                            <div>
                                <p>สำเนาบัตรประชาชน</p>
                                <div class="img-box">
                                    <img id="output_imagepic1"
                                        src="../../images/roommember/<?php echo $room_id; ?>/1/<?php echo $pic_idcard; ?>" />
                                    <?php
                                        if(isset($pic_idcard)){ ?>
                                    <button class="del-btn" type="button"
                                        onclick="delImg('<?php echo $room_id ?>','pic_idcard',1)">X</button>
                                    <?php } ?>
                                </div>
                                <?php
                                    if(!isset($pic_idcard)){ ?>
                                <input type="file" accept="image/*" onchange="preview_image(event,'pic1')"
                                    name="pic_idcard">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if($pic_idcard == null){
                    ?>
                    <div style="padding-top:32px;display:flex;justify-content:center">
                        <button type="submit" name='formSubmit3' class="confirm">ยืนยัน</button>
                    </div>
                    <?php } ?>
                </form>
                <div class="hr" style="margin: 32px 0;"></div>
                <div style="padding-top:32px;display:flex;justify-content:flex-end">
                    <button type="button" class="delData" onclick="delData(<?php echo $room_id; ?>)">ลบข้อมูล</button>
                </div>
            </div>
            <?php 
        }
        ?>
        </div>
    </div>
    <script src="../../../js/admin/room_id_form.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>