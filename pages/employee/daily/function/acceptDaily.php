<?php
session_start();
function DateThai($strDate){
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
if($_SESSION['level'] == 'employee'){
    include('../../../connection.php');
    $search = "SELECT * FROM daily WHERE code = '$re_code'";
    $result = mysqli_query($conn, $search)or die ("Error in query: $search " . mysqli_error());
    $row = mysqli_fetch_array($result);
    if($row != null){
        extract($row);
    }
    if($daily_status != "ยืนยันการเช่าแล้ว"){
        $re_code = $_REQUEST['code'];
        echo $re_code;  
        $sql = "UPDATE daily SET daily_status = 'ยืนยันการเช่าแล้ว' WHERE code = '$re_code'";
        
        $check_in_show = DateThai($check_in);
        $check_out_show = DateThai($check_out);  
        ////////////////////////// อีเมล ////////////////////////////
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
                            <p style='color:#000'><strong>ประเภทห้องพัก :</strong> ห้อง$room_type</p>
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
        if($email_receiver){
            $mail->msgHTML($email_content);
            if (mysqli_query($conn, $sql) && $mail->send()) {
                echo "<script>";
                echo "alert('จองห้องเรียบร้อยแล้ว กรุณาดูคำสั่งในการจองได้ในอีเมล์');";
                echo "location.href = '../index.php'";
                echo "</script>";
            } else {
                echo "Error: " .$conn->error;
                echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
            }
        }
    }else{
        echo "<script>";
        echo "alert('ไม่สามารถยืนยันการจองห้องพักได้เนื่องห้องนี้ได้ยืนยันการจองห้องพักแล้ว');";
        echo "window.history.back();";
        echo "</script>";
    }  
}
?>