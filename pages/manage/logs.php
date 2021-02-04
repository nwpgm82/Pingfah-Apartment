<?php
session_start();
if($_SESSION["level"] == "admin" || $_SESSION["level"] == "employee"){
  include("../connection.php");
  function DateThai($strDate){
    $strYear = date("Y",strtotime($strDate));
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("","มกราคม", "กุมภาพันธ์", "มีนาคม","เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม","สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
  }
  $topic = @$_REQUEST["topic"];
  if($topic == "employee"){
    $topic_str = "พนักงาน";
  }else if($topic == "month"){
    $topic_str = "รายเดือน";
  }else if($topic == "daily"){
    $topic_str = "รายวัน";
  }else if($topic == "repair"){
    $topic_str = "การซ่อมแซม";
  }else if($topic == "package"){
    $topic_str = "พัสดุ";
  }
  $date = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/logs.css">
    <title>Document</title>
</head>

<body>
    <?php include("../../components/sidebar.php"); ?>
    <div class="box">
        <div style="padding:24px;">
            <div class="logs-box">
                <div class="logs-detail">
                    <?php
                    if(isset($topic)){
                      $sql_logs = "SELECT * FROM logs WHERE log_topic = '$topic'";
                    }else{
                      $sql_logs = "SELECT * FROM logs";
                    }
                    $result = $conn->query($sql_logs);
                    if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        $datetime = explode(" ",$row["log_timestamp"]);
                        $time = $datetime[1];
                        $dt =  new DateTime($row["log_timestamp"]);
                        $current_date = $dt->format("Y-m-d");
                        if($date == null){
                          $date = $current_date;
                          echo "<h3>".DateThai($date)."</h3>";
                        }else if($date != $current_date){
                          $date = $current_date;
                          echo "------------------------------------------------------------------";
                          echo "<h3>".DateThai($date)."</h3>";
                        }
                    ?>
                    <p><strong><?php echo "[$time] ".$row["log_name"]."(".$row["log_position"].") : "?>&nbsp;&nbsp;[หมวด<?php echo $row["log_topic"]; ?>]&nbsp;&nbsp;</strong><?php echo $row["log_detail"]; ?></p>
                    <?php
                      }
                    }else{
                      echo "ไม่มีข้อมูล";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
}else{
  Header("Location: login.php");
}
?>