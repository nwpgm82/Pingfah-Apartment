<?php
include("../connection.php");
if(isset($_POST['accept_daily'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $id_card = $_POST['id_card'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $check_in = $_REQUEST['check_in'];
    $check_in_show = DateThai($check_in);
    $check_out = $_REQUEST['check_out'];
    $check_out_show = DateThai($check_out);
    $people = $_REQUEST['people'];
    $air = $_REQUEST['air'];
    $fan = $_REQUEST['fan'];
    $room_total = intval($air) + intval($fan);
    $date1 = date_create($check_in);
    $date2 = date_create($check_out);
    $diff=date_diff($date1,$date2);
    $checkdate_result = $diff->format("%R%a days");
    if(date("Y-m-d") == $check_in){
        $payment_datebefore = $check_in;
        $payment_datebeforeEmail = DateThai($check_in);
    }else{
        $paymentBefore = new DateTime('tomorrow');
        $payment_datebefore = $paymentBefore->format('Y-m-d');
        $payment_datebeforeEmail = DateThai($payment_datebefore);
    }
    // echo "$room_total";
    $code = createRandomPassword();
    // echo $firstname ."/" .$lastname ."/" .$id_card ."/" .$email ."/" .$tel ."/" .$room_type ."/ " .$check_in ."/" .$check_out;
    $countAir = mysqli_query($conn,"SELECT SUM(air_room) AS airTotal FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out ))");
    $roomDailyAirdata= mysqli_fetch_assoc($countAir);  
    $roomDailyAirtotal_int = intval($roomDailyAirdata['airTotal']);
    $countroom = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal FROM roomlist WHERE room_type = 'แอร์' AND (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
    $roomdata= mysqli_fetch_assoc($countroom);  
    $roomtotal_int = intval($roomdata['roomtotal']);
    $total_int = $roomtotal_int - $roomDailyAirtotal_int;

    $countFan = mysqli_query($conn,"SELECT SUM(fan_room) AS fanTotal FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out ))");
    $roomDailyFandata= mysqli_fetch_assoc($countFan);  
    $roomDailyFantotal_int = intval($roomDailyFandata['fanTotal']);
    $countroom2 = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal2 FROM roomlist WHERE room_type = 'พัดลม' AND (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
    $roomdata2= mysqli_fetch_assoc($countroom2);  
    $roomtotal_int2 = intval($roomdata2['roomtotal2']);
    $total_int2 = $roomtotal_int2 - $roomDailyFantotal_int;

    if(intval($air) != 0 && intval($fan) == 0){
        if($total_int != 0 && $total_int > 0){
            sendEmail();
        }else{
            echo "<script>";
            echo "alert('ไม่สามารถจองห้องได้เนื่องจากห้องเต็มแล้ว');";
            echo "window.history.back();";
            echo "</script>";
        }
    }else if(intval($air) == 0 && intval($fan) != 0){
        if($total_int2 != 0 && $total_int2 > 0){
            sendEmail();
        }else{
            echo "<script>";
            echo "alert('ไม่สามารถจองห้องได้เนื่องจากห้องเต็มแล้ว');";
            echo "window.history.back();";
            echo "</script>";
        }
    }else if(intval($air) != 0 && intval($fan) != 0){
        if($total_int != 0 && $total_int > 0 && $total_int2 != 0 && $total_int2 > 0){
            sendEmail();
        }else{
            echo "<script>";
            echo "alert('ไม่สามารถจองห้องได้เนื่องจากห้องเต็มแล้ว');";
            echo "window.history.back();";
            echo "</script>";
        }
    }else{
        echo "<script>";
        echo "alert('ข้อมูลไม่เพียงพอ');";
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


function sendEmail(){
    global $conn, $firstname, $lastname, $id_card, $email, $tel, $check_in, $check_in_show, $check_out, $check_out_show, $people, $air, $fan, $payment_datebefore, $payment_datebeforeEmail, $code;
    $sql = "INSERT INTO daily (firstname, lastname, id_card, email, tel, code, check_in, check_out, people, air_room, fan_room, daily_status, payment_datebefore) VALUES ('$firstname', '$lastname', '$id_card', '$email', '$tel', '$code', '$check_in', '$check_out', '$people', $air, $fan , 'รอการเข้าพัก', '$payment_datebefore')";
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
                        <p style='color:#000'><strong>จำนวนผู้พัก :</strong> $people ท่าน</p>
                        <p style='color:#000'><strong>จำนวนห้องพัก : ห้องแอร์ </strong>$air ห้อง <strong>| ห้องพัดลม : </strong>$fan ห้อง</p>
                        <p style='color:#000'><strong>วันที่เข้าพัก :</strong> $check_in_show <strong>ถึง</strong> $check_out_show</p>
                        <p style='color:#000'><strong>*** ลูกค้าสามารถเข้าพักได้หลัง 12:00 น. เท่านั้น ***</strong></p>
                        <p style='color:red;'><strong>*** โปรดวางเงินมัดจำค่าห้องเป็นจำนวน 1,000 บาท ก่อนวันที่ $payment_datebeforeEmail มิเช่นนั้นการจองห้องพักจะถูกยกเลิก ***</strong></p>
                        <p style='color:black;'><strong>เลขบัญชี :</strong> 123-456789-0 <strong>หรือ</strong> สแกน QR code ได้<a>ที่นี่</a></p>
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
        if ($mail->send() && $conn->query($sql) === TRUE) {
            echo "<script>";
            echo "alert('จองห้องเรียบร้อยแล้ว กรุณาดูคำสั่งในการจองได้ในอีเมล์');";
            echo "location.href = '../successRent.php?code=$code'";
            echo "</script>";
        } else {
            echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>