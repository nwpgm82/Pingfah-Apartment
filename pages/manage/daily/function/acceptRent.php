<?php
session_start();
if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
    include("../../../connection.php");
    $daily_id = $_REQUEST["daily_id"];
    $sql = "UPDATE daily SET daily_status = 'รอการเข้าพัก' WHERE daily_id = $daily_id";
    $search = mysqli_query($conn,"SELECT name_title, firstname, lastname, email FROM daily WHERE daily_id = $daily_id");
    $result_search = mysqli_fetch_assoc($search);
    $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('ข้อมูลลูกค้า', 'เปลี่ยนสถานะเป็น รอการเข้าพัก (".$result_search["name_title"].$result_search["firstname"]." ".$result_search["lastname"].")', '".$_SESSION["name"]."', '".$_SESSION["level"]."')";
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
    $email_receiver = $result_search['email']; // เมล์ผู้รับ ***

    $subject = "ยืนยันหลักฐานการชำระเงินค่ามัดจำห้องพัก"; // หัวข้อเมล์


    $mail->Username = $gmail_username;
    $mail->Password = $gmail_password;
    $mail->setFrom($email_sender, $sender);
    $mail->addAddress($email_receiver);
    $mail->Subject = $subject;

    $email_content = "
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset='utf-8'/>
                <title>ยืนยันหลักฐานการชำระเงินค่ามัดจำห้องพัก</title>
            </head>
            <body>
                <div style='background-color: #edeadb;width:900px;height:60px;margin:0 auto;padding:16px;display:flex;align-items:center;' >
                    <img src='https://pingfah-apartment.000webhostapp.com/img/logo.png' style='width:250px;height:60px;'>
                </div>
                <div style='background-color: #f6f4ec;width:900px;margin:0 auto;padding:16px;'>
                    <p>หลักฐานการชำระเงินค่ามัดจำห้องพักได้รับการยืนยันแล้ว สามารถเข้าพักในวันที่ท่านได้จองห้องพักไว้ได้ในเวลา 14.00 น. เป็นต้นไป</p>
                    <p>*** ท่านสามารถดาวน์โหลดหลักฐานการชำระเงินค่ามัดจำห้องพักได้ที่เมนูตรวจสอบการจอง ***</p>
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
        if ($mail->send() && $conn->query($sql) === TRUE && $conn->query($addLogs) === TRUE) {
            echo "<script>";
            echo "alert('ยืนยันการเข้าพักเรียบร้อยแล้ว');";
            echo "location.href = '../index.php';";
            echo "</script>";
        } else {
            echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
        }
    }
}