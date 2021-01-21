<?php
session_start();
include("../connection.php");
if(isset($_POST['accept_daily'])){
    function createRandomPassword() {
        global $tel;
        $date_split = explode("-",$_SESSION["check_in"]);
        $tel_split = str_split($tel);
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789"; 
        srand((double)microtime()*1000000); 
        $i = 0;
        $pass = "" ;
        while ($i < 3) { 
            $num = rand() % 33; 
            $tmp = substr($chars, $num, 1); 
            $pass = $pass . $tmp; 
            $i++; 
        } 
        if(intval($_SESSION["air"]) != 0 && intval($_SESSION["fan"]) == 0){
            return "AIR".$pass.$date_split[2].$date_split[1].$tel_split[2].$tel_split[4].$tel_split[6]; 
        }else if(intval($_SESSION["air"]) == 0 && intval($_SESSION["fan"]) != 0){
            return "FAN".$pass.$date_split[2].$date_split[1].$tel_split[2].$tel_split[4].$tel_split[6];
        }else{
            return "ALL".$pass.$date_split[2].$date_split[1].$tel_split[2].$tel_split[4].$tel_split[6];
        }
    }
    $name_title = $_POST["name_title"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $id_card = $_POST["id_card"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $total_room = intval($_SESSION["air"]) + intval($_SESSION["fan"]);
    $code = createRandomPassword();
    do{
        $checkCode_repeat = "SELECT * FROM daily WHERE code = '$code'";
        $checkCode_result = $conn->query($checkCode_repeat);
        if ($checkCode_result->num_rows > 0) {
            $code = createRandomPassword();
        }
    }while($checkCode_result->num_rows > 0);
    $countRoom = mysqli_query($conn,"SELECT SUM(room_type = 'แอร์') AS airTotal, SUM(room_type = 'พัดลม') AS fanTotal FROM roomlist WHERE room_cat = 'รายวัน'");
    $roomData= mysqli_fetch_assoc($countRoom);  
    $countDaily = mysqli_query($conn,"SELECT SUM(air_room) AS daily_airTotal, SUM(fan_room) AS daily_fanTotal FROM daily WHERE ((check_in BETWEEN '".$_SESSION["check_in"]."' AND '".$_SESSION["check_out"]."') OR (check_out BETWEEN '".$_SESSION["check_in"]."' AND '".$_SESSION["check_out"]."') OR ('".$_SESSION["check_in"]."' BETWEEN check_in AND check_out) OR ('".$_SESSION["check_out"]."' BETWEEN check_in AND check_out ))");
    $dailyData= mysqli_fetch_assoc($countDaily);  
    $airTotal = intval($roomData["airTotal"]) - intval($dailyData["daily_airTotal"]);
    $fanTotal = intval($roomData["fanTotal"]) - intval($dailyData["daily_fanTotal"]);
    if(intval($_SESSION["air"]) <= $airTotal && intval($_SESSION["fan"]) <= $fanTotal){
        $sql = "INSERT INTO daily (name_title, firstname, lastname, id_card, email, tel, code, check_in, check_out, night, people, air_room, fan_room, daily_status, total_price, payment_price, payment_datebefore) VALUES ('$name_title', '$firstname', '$lastname', '$id_card', '$email', '$tel', '$code', '".$_SESSION["check_in"]."', '".$_SESSION["check_out"]."',".$_SESSION["night"].",".$_SESSION["people"].",".$_SESSION["air"].",".$_SESSION["fan"].", 'รอการยืนยัน',".ceil($_SESSION["total_price"]).",".$_SESSION["total_room"].", '".$_SESSION["payment_datebefore"]."')";
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
        $mail->AddEmbeddedImage("../../img/logo.png","logo","logo.png");
        $mail->addEmbeddedImage("../../img/tool/qr-code.png","qr_code","qr-code.png");
        $email_content = "
        	<!DOCTYPE html>
        	<html>
        		<head>
        			<meta charset=utf-8'/>
                    <title>คำสั่งในการจองห้องพัก</title>
                    <style>
                    *{
                        padding: 0;
                        margin: 0;
                        box-sizing: border-box;
                        line-height: 30px;
                    }
                    </style>                
                </head>
                <body>
        			<div style='background-color: #edeadb;width:1000px;margin:0 auto;padding:16px;display:flex;align-items:center;' >
        				<img src='cid:logo' style='width:250px;height:60px;'>
        			</div>
        			<div style='background-color: #f6f4ec;width:1000px;margin:0 auto;padding:16px;'>
                        <h2 style='color:#000'>คำสั่งในการจองห้องพัก</h2>
                        <div>
                            <p style='font-size:16px;color:#000'><strong>ชื่อ :</strong> $name_title$firstname  $lastname</p>
                            <p style='font-size:16px;color:#000'><strong>เลขบัตรประชาชน / Passport No. :</strong> $id_card</p>
                            <p style='font-size:16px;color:#000'><strong>อีเมล :</strong> $email</p>
                            <p style='font-size:16px;color:#000'><strong>เบอร์โทรศัพท์ :</strong> $tel</p>
                            <p style='font-size:16px;color:#000'><strong>จำนวนผู้พัก :</strong> ".$_SESSION["people"]." ท่าน</p>
                            <p style='font-size:16px;color:#000'><strong>จำนวนห้องพัก : ห้องแอร์ </strong>".$_SESSION["air"]." ห้อง <strong>| ห้องพัดลม : </strong>".$_SESSION["fan"]." ห้อง</p>
                            <p style='font-size:16px;color:#000'><strong>วันที่เข้าพัก :</strong> ".DateThai($_SESSION["check_in"])." <strong>ถึง</strong> ".DateThai($_SESSION["check_out"])." (".$_SESSION["night"]." คืน)</p>
                        </div>
                        <div style='padding-top:32px;'>
                            <h2 style='color:#000'>ขั้นตอนในการจองห้องพัก</h2>
                            <p style='font-size:16px;color:#000'>1. เมื่อจองห้องพักแล้ว ให้โอนเงินจำนวน <strong style='color:red;'>".$_SESSION["total_room"]." บาท (จำนวนห้องพัก x 300)</strong> มาที่บัญชีพร้อมเพย์ <strong>095-6722914 (นวพล นรเดชานันท์) หรือสแกน QR code ได้ที่ข้างล่าง</strong> ก่อนวันที่ <strong style='color:red;'>".DateThai($_SESSION["payment_datebefore"])."</strong> มิเช่นนั้นการจองห้องพักจะถือว่าเป็นโมฆะ</p>
                            <p style='font-size:16px;color:#000'>2. เมื่อโอนเงินแล้วให้อัปโหลดสลิปในเมนู <a href='/Pingfah/pages/checkCode.php' target='_blank'>ตรวจสอบการจอง</a> </p>
                            <p style='font-size:16px;color:#000'>3. เมื่ออัปโหลดสลิปแล้วให้แจ้งเจ้าของหอพัก หรือพนักงานเพื่อแจ้งให้ทราบว่าท่านได้โอนเงินแล้ว</p>
                            <p style='font-size:16px;color:#000'>4. รอการยืนยันจากเจ้าของหอพัก หรือพนักงาน</p>
                            <p style='font-size:16px;color:#000'>5. เมื่อได้รับการยืนยันแล้ว ให้ท่านชำระเงิน ณ ที่พัก และเข้าพักตามวันที่ท่านได้จองห้องพักไว้ <strong>(เข้าพักได้ในเวลา 14.00 น. เป็นต้นไป)</strong></p>
                        </div>
                        <div style='padding-top:32px;text-align:center;'>
                            <div>
                                <img src='cid:qr_code' style='width:113;height:128;'>
                                <p style='font-size:16px;color:#000'>เลขบัญชีพร้อมเพย์ : 095-6722914 (นวพล นรเดชานันท์)</p>
                            </div>
                        </div>
                        <div style='padding-top:32px;'>
                            <h2 style='text-align:center;color:#000'><strong>เลขที่ในการจอง :</strong> $code</h2>
                        </div>
        			</div>
        			<div style='background-color: #edeadb;width:1000px;height:60px;margin:0 auto;padding:16px;display:flex;align-items:center;'>
        				<p style='font-size:16px;color:#000'><strong>ติดต่อสอบถาม :</strong> 098-9132002 (เจ้าของหอพัก), 093-2266753 (แม่บ้าน)</p>
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
                echo "alert('จองห้องเรียบร้อยแล้ว กรุณาดูคำสั่งในการจองได้ในอีเมล');";
                echo "location.href = '../successRent.php?code=$code'";
                echo "</script>";
            } else {
                echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }else{
        echo "<script>";
        echo "alert('ไม่สามารถจองพักได้เนื่องจากห้องพักเต็มแล้ว');";
        echo "location.href = '../checkRoom.php?check_in=".$_SESSION["check_in"]."&check_out=".$_SESSION["check_out"]."&people=".$_SESSION["people"]."';";
        echo "</script>";
    }
    // $check_in = $_REQUEST['check_in'];
    // $check_in_show = DateThai($check_in);
    // $check_out = $_REQUEST['check_out'];
    // $check_out_show = DateThai($check_out);
    // $people = $_REQUEST['people'];
    // $air = $_REQUEST['air'];
    // $fan = $_REQUEST['fan'];
    // $room_total = intval($air) + intval($fan);
    // $date1 = date_create($_SESSION["check_in"]);
    // $date2 = date_create($_SESSION["check_out"]);
    // $diff=date_diff($date1,$date2);
    // $checkdate_result = $diff->format("%R%a days");
    // if(date("Y-m-d") == $check_in){
    //     $payment_datebefore = $_SESSION["check_in"];
    //     $payment_datebeforeEmail = DateThai($_SESSION["check_in"]);
    // }else{
    //     $paymentBefore = new DateTime('tomorrow');
    //     $payment_datebefore = $paymentBefore->format('Y-m-d');
    //     $payment_datebeforeEmail = DateThai($payment_datebefore);
    // }
    // echo $payment_datebefore;
    // // echo "$room_total";
    
    // // echo $firstname ."/" .$lastname ."/" .$id_card ."/" .$email ."/" .$tel ."/" .$room_type ."/ " .$check_in ."/" .$check_out;
    // $countAir = mysqli_query($conn,"SELECT SUM(air_room) AS airTotal FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out ))");
    // $roomDailyAirdata= mysqli_fetch_assoc($countAir);  
    // $roomDailyAirtotal_int = intval($roomDailyAirdata['airTotal']);
    // $countroom = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal FROM roomlist WHERE room_type = 'แอร์' AND (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
    // $roomdata= mysqli_fetch_assoc($countroom);  
    // $roomtotal_int = intval($roomdata['roomtotal']);
    // $total_int = $roomtotal_int - $roomDailyAirtotal_int;

    // $countFan = mysqli_query($conn,"SELECT SUM(fan_room) AS fanTotal FROM daily WHERE ((check_in BETWEEN '$check_in' AND '$check_out') OR (check_out BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN check_in AND check_out) OR ('$check_out' BETWEEN check_in AND check_out ))");
    // $roomDailyFandata= mysqli_fetch_assoc($countFan);  
    // $roomDailyFantotal_int = intval($roomDailyFandata['fanTotal']);
    // $countroom2 = mysqli_query($conn,"SELECT COUNT(*) AS roomtotal2 FROM roomlist WHERE room_type = 'พัดลม' AND (room_status = 'ว่าง' OR room_status = 'เช่ารายวัน')");
    // $roomdata2= mysqli_fetch_assoc($countroom2);  
    // $roomtotal_int2 = intval($roomdata2['roomtotal2']);
    // $total_int2 = $roomtotal_int2 - $roomDailyFantotal_int;

    // if(intval($air) != 0 && intval($fan) == 0){
    //     if($total_int != 0 && $total_int > 0){
    //         sendEmail();
    //     }else{
    //         echo "<script>";
    //         echo "alert('ไม่สามารถจองห้องได้เนื่องจากห้องเต็มแล้ว');";
    //         echo "window.history.back();";
    //         echo "</script>";
    //     }
    // }else if(intval($air) == 0 && intval($fan) != 0){
    //     if($total_int2 != 0 && $total_int2 > 0){
    //         sendEmail();
    //     }else{
    //         echo "<script>";
    //         echo "alert('ไม่สามารถจองห้องได้เนื่องจากห้องเต็มแล้ว');";
    //         echo "window.history.back();";
    //         echo "</script>";
    //     }
    // }else if(intval($air) != 0 && intval($fan) != 0){
    //     if($total_int != 0 && $total_int > 0 && $total_int2 != 0 && $total_int2 > 0){
    //         sendEmail();
    //     }else{
    //         echo "<script>";
    //         echo "alert('ไม่สามารถจองห้องได้เนื่องจากห้องเต็มแล้ว');";
    //         echo "window.history.back();";
    //         echo "</script>";
    //     }
    // }else{
    //     echo "<script>";
    //     echo "alert('ข้อมูลไม่เพียงพอ');";
    //     echo "window.history.back();";
    //     echo "</script>";
    // }
}
    


function DateThai($strDate){
    $strYear = date("Y",strtotime($strDate));
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}


function sendEmail(){
    global $conn, $firstname, $lastname, $id_card, $email, $tel, $check_in, $check_in_show, $check_out, $check_out_show, $people, $air, $fan, $payment_datebefore, $payment_datebeforeEmail, $code;
    $sql = "INSERT INTO daily (firstname, lastname, id_card, email, tel, code, check_in, check_out, people, air_room, fan_room, daily_status, payment_datebefore) VALUES ('$firstname', '$lastname', '$id_card', '$email', '$tel', '$code', '$check_in', '$check_out', '$people', $air, $fan , 'รอการยืนยัน', '$payment_datebefore')";
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