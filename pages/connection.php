<?php
$conn= mysqli_connect("localhost","root","","Pingfah") or die("Error: " . mysqli_error($conn));
mysqli_query($conn, "SET NAMES 'utf8' ");
date_default_timezone_set('Asia/Bangkok');
if(date("d") == "6"){
    $get_cost = "SELECT fines, total FROM cost WHERE cost_status = 'ยังไม่ได้ชำระเงิน'";
    $get_result = $conn->query($get_cost);
    if ($get_result->num_rows > 0) {
        while($cost = $get_result->fetch_assoc()) {
            if($cost["room_type"] == "แอร์"){
                $get_detail = mysqli_query($conn, "SELECT fines FROM roomdetail WHERE type = 'แอร์'");
            }else if($cost["room_type"] == "พัดลม"){
                $get_detail = mysqli_query($conn, "SELECT fines FROM roomdetail WHERE type = 'พัดลม'");
            }
            $detail_result = mysqli_fetch_assoc($get_detail);
            $updatefines = "UPDATE cost SET fines = ".$detail_result["fines"].", total = total + ".$detail_result["fines"]." WHERE cost_status != 'ชำระเงินแล้ว' ";
            $conn->query($updatefines) === TRUE;
        }
    }
}else if(date("d") > "6" && date("d") <= "10"){
    $get_cost = "SELECT fines, total FROM cost WHERE cost_status = 'ยังไม่ได้ชำระเงิน'";
    $get_result = $conn->query($get_cost);
    if ($get_result->num_rows > 0) {
        while($cost = $get_result->fetch_assoc()) {
            if($cost["room_type"] == "แอร์"){
                $get_detail = mysqli_query($conn, "SELECT fines FROM roomdetail WHERE type = 'แอร์'");
            }else if($cost["room_type"] == "พัดลม"){
                $get_detail = mysqli_query($conn, "SELECT fines FROM roomdetail WHERE type = 'พัดลม'");
            }
            $detail_result = mysqli_fetch_assoc($get_detail);
            $updatefines = "UPDATE cost SET fines = fines + ".$detail_result["fines"].", total = total + ".$detail_result["fines"]." WHERE cost_status != 'ชำระเงินแล้ว' ";
            $conn->query($updatefines) === TRUE;
        }
    }
}
$sql = "SELECT * FROM daily";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if($row['daily_status'] == "รอการยืนยัน"){
        $date_paymentbefore = date("Y-m-d", strtotime($row['payment_datebefore']));
        if(date("Y-m-d") > $date_paymentbefore){
            $update = "UPDATE daily SET daily_status = 'ยกเลิกการจอง' WHERE daily_id = '".$row['daily_id']."'";
            $conn->query($update);
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
            $email_receiver = $row['email']; // เมล์ผู้รับ ***
    
            $subject = "ยกเลิกคำสั่งการจองห้องพัก"; // หัวข้อเมล์
    
    
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
                        <title>ยกเลิกคำสั่งการจองห้องพัก</title>
                    </head>
                    <body>
                        <div style='background-color: #edeadb;width:900px;height:60px;margin:0 auto;padding:16px;display:flex;align-items:center;' >
                            <img src='https://pingfah-apartment.000webhostapp.com/img/logo.png' style='width:250px;height:60px;'>
                        </div>
                        <div style='background-color: #f6f4ec;width:900px;margin:0 auto;padding:16px;'>
                            <p><strong>การจองห้องพักได้ถูกยกเลิกเนื่องจากไม่ได้วางเงินค่ามัดจำค่าห้องพักตามที่กำหนดไว้</strong></p>
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
    }else if($row['daily_status'] == "รอการเข้าพัก" && ($row['payment_img'] != null || $row['payment_img'] != "")){
        $date_paymentbefore = date("Y-m-d", strtotime($row['payment_datebefore']));
        if(date("Y-m-d") == $date_paymentbefore){
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
             $email_receiver = $row['email']; // เมล์ผู้รับ ***
     
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
                         <meta charset=utf-8'/>
                         <title>ยืนยันหลักฐานการชำระเงินค่ามัดจำห้องพัก</title>
                     </head>
                     <body>
                         <div style='background-color: #edeadb;width:900px;height:60px;margin:0 auto;padding:16px;display:flex;align-items:center;' >
                             <img src='https://pingfah-apartment.000webhostapp.com/img/logo.png' style='width:250px;height:60px;'>
                         </div>
                         <div style='background-color: #f6f4ec;width:900px;margin:0 auto;padding:16px;'>
                             <p><strong>หลักฐานการชำระเงินค่ามัดจำห้องพักได้รับการยืนยันแล้ว</strong></p>
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
    }
  }
}
?>