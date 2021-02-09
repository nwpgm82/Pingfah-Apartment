<?php
include("connection.php");
$code_request = $_REQUEST["code"];
$sql = "SELECT *, SUM(air_room + fan_room) AS total_room FROM daily WHERE code = '$code_request' AND daily_status != 'รอการยืนยัน'";
$result = mysqli_query($conn, $sql)or die ("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result);
if($row != null){
extract($row);
$calculate = strtotime($check_out) - strtotime($check_in);
$night = floor($calculate / 86400);
}
function DateThai($strDate){
    $strYear = date("Y",strtotime($strDate));
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
function textFormat( $text = '', $pattern = '', $ex = '' ) {
    $cid = ( $text == '' ) ? '0000000000000' : $text;
    $pattern = ( $pattern == '' ) ? '_-____-_____-__-_' : $pattern;
    $p = explode( '-', $pattern );
    $ex = ( $ex == '' ) ? '-' : $ex;
    $first = 0;
    $last = 0;
    for ( $i = 0; $i <= count( $p ) - 1; $i++ ) {
       $first = $first + $last;
       $last = strlen( $p[$i] );
       $returnText[$i] = substr( $cid, $first, $last );
    }
  
    return implode( $ex, $returnText );
 }
 function bathformat($number) {
    $numberstr = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
    $digitstr = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
  
    $number = str_replace(",","",$number); // ลบ comma
    $number = explode(".",$number); // แยกจุดทศนิยมออก
  
    // เลขจำนวนเต็ม
    $strlen = strlen($number[0]);
    $result = '';
    for($i=0;$i<$strlen;$i++) {
      $n = substr($number[0], $i,1);
      if($n!=0) {
        if($i==($strlen-1) AND $n==1){ $result .= 'เอ็ด'; }
        elseif($i==($strlen-2) AND $n==2){ $result .= 'ยี่'; }
        elseif($i==($strlen-2) AND $n==1){ $result .= ''; }
        else{ $result .= $numberstr[$n]; }
        $result .= $digitstr[$strlen-$i-1];
      }
    }
    
    // จุดทศนิยม
    $strlen = strlen($number[1]);
    if ($strlen>2) { // ทศนิยมมากกว่า 2 ตำแหน่ง คืนค่าเป็นตัวเลข
      $result .= 'จุด';
      for($i=0;$i<$strlen;$i++) {
        $result .= $numberstr[(int)$number[1][$i]];
      }
    } else { // คืนค่าเป็นจำนวนเงิน (บาท)
      $result .= 'บาท';
      if ($number[1]=='0' OR $number[1]=='00' OR $number[1]=='') {
        $result .= 'ถ้วน';
      } else {
        // จุดทศนิยม (สตางค์)
        for($i=0;$i<$strlen;$i++) {
          $n = substr($number[1], $i,1);
          if($n!=0){
            if($i==($strlen-1) AND $n==1){$result .= 'เอ็ด';}
            elseif($i==($strlen-2) AND $n==2){$result .= 'ยี่';}
            elseif($i==($strlen-2) AND $n==1){$result .= '';}
            else{ $result .= $numberstr[$n];}
            $result .= $digitstr[$strlen-$i-1];
          }
        }
        $result .= 'สตางค์';
      }
    }
    return $result;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/receipt_deposit.css">
    <title>Pingfah Apartment</title>
</head>
<body>
    <div class="letter">
        <div>
            <div class="header">
                <img src="../img/main_logo.png" alt="">
                <strong><p style="text-align:center;font-size:16px;">ใบเสร็จค่ามัดจำห้องพัก</p></strong>
                <div style="text-align:right;position:relative;">
                    <p>เลขที่ในการจอง : ..................................</p>
                    <p class="code_text"><?php echo $code_request; ?></p>
                </div>
            </div>
            <div style="position:relative;padding-bottom:20px;line-height:30px;">
                <p>ชื่อ : ............................................................... อีเมล : .................................................................... เบอร์โทรศัพท์ : ......................................</p>
                <p>เช็คอิน : ........................................... เช็คเอาท์ : ........................................... (<?php echo $night; ?> คืน)</p>
                <p class="name"><?php echo $name_title.$firstname." ".$lastname; ?></p>
                <p class="email"><?php echo $email; ?></p>
                <p class="tel"><?php echo textFormat($tel,'___-_______','-'); ?></p>
                <p class="check_in"><?php echo DateThai($check_in); ?></p>
                <p class="check_out"><?php echo DateThai($check_out); ?></p>
            </div>
            <table>
                <tr>
                    <th>ลำดับ</th>
                    <th>รายการ</th>
                    <th>จำนวนห้องพัก</th>
                    <th>จำนวนเงิน</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>เงินค่ามัดจำห้องพัก</td>
                    <td><?php echo $total_room; ?></td>
                    <td><?php echo number_format($payment_price,2); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo bathformat($payment_price) ?></td>
                    <td style="text-align:center;">รวมเป็นเงิน</td>
                    <td><?php echo number_format($payment_price,2); ?></td>
                </tr>
            </table>
            <div style="padding-top:40px;">
                <div style="display:flex;justify-content:flex-end;align-items:center;">
                    <p>ลายเซ็นเจ้าของหอพัก ......................................................</p>
                </div>
                <div style="padding-top:8px;display:flex;justify-content:flex-end;align-items:center;">
                    <p style="padding-right:26px;">(นายนวพล นรเดชานันท์)</p>
                </div>
            </div>
        </div>
        <p style="font-size:12px;">สอบถามเพิ่มเติม : 098-9132002 (เจ้าของหอพักบ้านพิงฟ้า) หรือ 087-5777192 (พนักงาน)</p>
    </div>
</body>
</html>