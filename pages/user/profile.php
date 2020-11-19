<?php include '../components/user_topbar.php' ?>
<?php include '../connection.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pingfah/css/user/profile.css">
    <title>Document</title>
</head>

<body>
    <div style="margin-top:80px;padding:24px;">
        <div class="profile">
            <h2>ข้อมูลส่วนตัว</h2>
            <form action='room_member_add_DB.php?ID=<?php echo $room_id; ?>' method='POST' style="margin-top:24px;">
                <!-- <h2>ห้อง <?php echo  $room_id; ?></h2> -->
                <div class="row">
                    <div class="col-2 select-box">
                        <p>คำนำหน้าชื่อ</p>
                        <select name="name_title" id="name_title" value="<?= $name_title; ?>" disabled>
                            <option value="นาย">นาย</option>
                            <option value="นาง">นาง</option>
                            <option value="นางสาว">นางสาว</option>
                        </select>
                    </div>
                    <div class="col-4 input-box">
                        <p>ชื่อ</p>
                        <input type="text" required name="firstname" id="firstname" value="<?= $firstname; ?>" disabled>
                    </div>
                    <div class="col-4 input-box">
                        <p>นามสกุล</p>
                        <input type="text" required name="lastname" id="lastname" value="<?= $lastname; ?>" disabled>
                    </div>
                    <div class="col-2 input-box">
                        <p>ชื่อเล่น</p>
                        <input type="text" required name="nickname" id="nickname" value="<?= $nickname; ?>" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 input-box">
                        <p>เลขบัตรประชาชน</p>
                        <input type="text" required name="id_card" id="id_card" value="<?= $id_card; ?>" disabled>
                    </div>
                    <div class="col-4 input-box">
                        <p>เบอร์โทรศัพท์</p>
                        <input type="text" required name="phone" id="phone" value="<?= $phone; ?>" disabled>
                    </div>
                    <div class="col-4 input-box">
                        <p>อีเมล์</p>
                        <input type="text" required name="email" id="email" value="<?= $email; ?>" placeholder="Email" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2 input-box">
                        <p>เกิดวันที่</p>
                        <input type="date" required name="birthday" id="birthday" value="<?= $birthday; ?>" disabled>
                    </div>
                    <div class="col-2 input-box">
                        <p>อายุ</p>
                        <input type="text" required name="age" id="age" value="<?= $age; ?>" disabled>
                    </div>
                    <div class="col-2 input-box">
                        <p>เชื้อชาติ</p>
                        <input type="text" required name="race" id="race" value="<?= $race; ?>" disabled>
                    </div>
                    <div class="col-2 input-box">
                        <p>สัญชาติ</p>
                        <input type="text" required name="nationality" id="nationality" value="<?= $nationality; ?>" disabled>
                    </div>
                    <div class="col-4 input-box">
                        <p>อาชีพ</p>
                        <input type="text" required name="job" id="job" value="<?= $job; ?>" disabled>
                    </div>
                </div>
                <div>
                    <p>ที่อยู่</p>
                    <textarea cols="30" rows="10" name="address" id="address" value="<?= $address; ?>" disabled></textarea>
                </div>
                <h3>เอกสารสำเนา</h3>
                <div class="grid">
                    <div>
                        <p>สำเนาบัตรประชาชน</p>
                        <div class="card">
                            <!-- ใส่รูป -->
                        </div>
                    </div>
                    <div>
                        <p>สำเนาทะเบียนบ้าน</p>
                        <div class="card">
                            <!-- ใส่รูป -->
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

</body>

</html>