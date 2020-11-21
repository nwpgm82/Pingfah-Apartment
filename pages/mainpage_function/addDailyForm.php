<?php
include("../connection.php");
if(isset($_POST['accept_daily'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $id_card = $_POST['id_card'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $room_type = $_REQUEST['room_type'];
    $room_count = $_POST['room_count'];
    $check_in = $_REQUEST['check_in'];
    $check_in_show = DateThai($check_in);
    $check_out = $_REQUEST['check_out'];
    $check_out_show = DateThai($check_out);
    $code = createRandomPassword();
    // echo $firstname ."/" .$lastname ."/" .$id_card ."/" .$email ."/" .$tel ."/" .$room_type ."/ " .$check_in ."/" .$check_out;
    $searchroom = mysqli_query($conn,"SELECT COUNT(*) AS total FROM roomlist WHERE room_type = '$room_type' AND room_status = 'ว่าง'");
    $data= mysqli_fetch_assoc($searchroom);  
    $total_int = intval($data['total']);
    if($total_int != 0){
        // $searchfreeroom = "SELECT * FROM roomlist WHERE room_status = 'ว่าง' LIMIT 1";
        // $result = $conn->query($searchfreeroom);
        // $row = $result->fetch_assoc();
        // $room_select = $row['room_id'];
        $sql = "INSERT INTO daily (firstname, lastname, id_card, email, tel, room_type,room_count, code, check_in, check_out) VALUES ('$firstname', '$lastname', '$id_card', '$email', '$tel', '$room_type', '1', '$code', '$check_in', '$check_out')";
        // $sql2 = "INSERT INTO roommember (room_member, firstname, lastname, id_card, phone, email) VALUE ('$room_select', '$firstname','$lastname','$id_card','$tel','$email') LIMIT 1";
        // $update = "UPDATE roomlist SET room_status = 'เช่ารายวัน', check_in = '$check_in', check_out = '$check_out' WHERE room_id = '$room_select'";
        ///////////////////// อีเมล ////////////////////////
        require($_SERVER['DOCUMENT_ROOT']."/Pingfah/phpmailer/PHPMailerAutoload.php");
        header('Content-Type: text/html; charset=utf-8');

        $mail = new PHPMailer;
        $mail->CharSet = "utf-8";
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;


        $gmail_username = "pingfah.apartment@gmail.com"; // gmail ที่ใช้ส่ง
        $gmail_password = "Cresta82"; // รหัสผ่าน gmail
        // ตั้งค่าอนุญาตการใช้งานได้ที่นี่ https://myaccount.google.com/lesssecureapps?pli=1


        $sender = "Pingfah Apartment"; // ชื่อผู้ส่ง
        $email_sender = "noreply.pingfah@gmail.com"; // เมล์ผู้ส่ง 
        $email_receiver = "$email"; // เมล์ผู้รับ ***

        $subject = "คำสั่งในการจองห้องพัก"; // หัวข้อเมล์


        $mail->Username = $gmail_username;
        $mail->Password = $gmail_password;
        $mail->setFrom($email_sender, $sender);
        $mail->addAddress($email_receiver);
        $mail->Subject = $subject;

        $email_content = "
        	<!DOCTYPE html>
        	<html>
        		<head>
        			<meta charset=utf-8'/>
        			<title>คำสั่งในการจองห้องพัก</title>
        		</head>
        		<body>
        			<div style='background-color: #edeadb;width:900px;height:60px;margin:0 auto;padding:16px;display:flex;align-items:center;' >
        				<img src='https://pingfah-apartment.000webhostapp.com/img/logo.png' style='width:250px;height:60px;'>
        			</div>
        			<div style='background-color: #f6f4ec;width:900px;margin:0 auto;padding:16px;'>
                        <h3>คำสั่งในการจองห้องพัก</h3>
                        <div>
                            <p style='color:#000'><strong>ชื่อ :</strong> $firstname  $lastname</p>
                            <p style='color:#000'><strong>เลขบัตรประชาชน :</strong> $id_card</p>
                            <p style='color:#000'><strong>อีเมล :</strong> $email</p>
                            <p style='color:#000'><strong>เบอร์โทรศัพท์ :</strong> $tel</p>
                            <p style='color:#000'><strong>ประเภทห้องพัก :</strong> $room_type</p>
                            <p style='color:#000'><strong>จำนวน :</strong> $room_count</p>
                            <p style='color:#000'><strong>วันที่เข้าพัก :</strong> $check_in_show <strong>ถึง</strong> $check_out_show</p>
                            <p style='color:#000'><strong>*** ลูกค้าสามารถเข้าพักได้หลัง 12:00 น. เท่านั้น ***</strong></p>
                            <h3 style='text-align:center;color:#000'><strong>เลขที่ในการจอง :</strong> $code</h3>
                        </div>
        			</div>
        			<div style='background-color: #edeadb;width:900px;height:60px;margin:0 auto;padding:16px;display:flex;align-items:center;'>
        				<p style='color:#000'><strong>ติดต่อสอบถาม :</strong> 098-9132002 (เจ้าของหอพัก), 093-2266753 (แม่บ้าน)</p>
        			</div>
        		</body>
        	</html>
        ";
        ///////////////////////////////////////////////////
        //  ถ้ามี email ผู้รับ
        if($email_receiver){
            $mail->msgHTML($email_content);
            for($i = 1 ; $i <= $room_count ; $i++){
                if(mysqli_query($conn, $sql)){
    
                }else{
                    echo "Error: " .$conn->error .$i;
                }
            }
            if ($mail->send()) {
                echo "<script>";
                echo "alert('จองห้องเรียบร้อยแล้ว กรุณาดูคำสั่งในการจองได้ในอีเมล์');";
                echo "location.href = '../index.php'";
                echo "</script>";
            } else {
                echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
            }
        }
    }else{
        echo "<script>";
        echo "alert('ไม่สามารถจองห้องได้เนื่องจากห้องเต็มแล้ว');";
        echo "window.history.back();";
        echo "</script>";
    }
}

function createRandomPassword() { 
    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 
    while ($i <= 10) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 
    return $pass; 
}

function DateThai($strDate){
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
}
?>