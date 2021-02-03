<?php
session_start();
if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
    include("../../../connection.php");
    $id = $_REQUEST["daily_id"];
    $name = $_REQUEST["name"];
    $search = mysqli_query($conn, "SELECT * FROM daily WHERE daily_id = $id");
    $result = mysqli_fetch_assoc($search);
    $pic_location = "../../../images/daily/$id/$name";
    function DateThai($strDate){
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    function sendEmail(){
        global $conn, $id;
        $sql = "SELECT * FROM daily WHERE daily_id = $id";
        $result = mysqli_query($conn, $sql)or die ("Error in query: $sql " . mysqli_error());
        $row = mysqli_fetch_array($result);
        if($row != null){
        extract($row);
        }
        $payment_datebeforeEmail = DateThai($payment_datebefore);  
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
    
        $subject = "โปรดอัปโหลดหลักฐานการชำระเงินค่ามันจำห้องพักใหม่"; // หัวข้อเมล์
    
    
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
                    <title>โปรดอัปโหลดหลักฐานการชำระเงินค่ามันจำห้องพักใหม่</title>
                </head>
                <body>
                    <div style='background-color: #edeadb;width:900px;height:60px;margin:0 auto;padding:16px;display:flex;align-items:center;' >
                        <img src='https://pingfah-apartment.000webhostapp.com/img/logo.png' style='width:250px;height:60px;'>
                    </div>
                    <div style='background-color: #f6f4ec;width:900px;margin:0 auto;padding:16px;'>
                        <p><strong>กรุณาโปรดอัปโหลดหลักฐานการชำระเงินใหม่อีกครั้ง เนื่องจากข้อมูลเป็นเท็จ</strong></p>
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
            if ($mail->send()) {
                // echo "<script>";
                // echo "alert('จองห้องเรียบร้อยแล้ว กรุณาดูคำสั่งในการจองได้ในอีเมล์');";
                // echo "location.href = '../dailyDetail.php?daily_id=$id'";
                // echo "</script>";
            } else {
                echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
            }
        }
    }
    $del = "UPDATE daily SET payment_img = NULL WHERE daily_id = $id";
    $addLogs = "INSERT INTO logs (log_topic, log_detail, log_name, log_position) VALUES ('ข้อมูลลูกค้า', 'ลบหลักฐานค่ามัดจำห้องพัก (".$result["name_title"].$result["firstname"]." ".$result["lastname"].")', '".$_SESSION["name"]."', '".$_SESSION["level"]."')";
    if($conn->query($del) === TRUE && unlink($pic_location) && $conn->query($addLogs) === TRUE){
        sendEmail();
        echo "<script>";
        echo "alert('ลบรูปภาพเรียบร้อยแล้ว');";
        echo "window.location.assign('../dailyDetail.php?daily_id=$id');";
        echo "</script>";
    }else{
        echo "Error deleting record: " . $conn->error;
    } 
}else{
    Header("Location: ../../../login.php");
}

?>