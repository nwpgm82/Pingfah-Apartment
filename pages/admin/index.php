<?php 
session_start();
if($_SESSION['level'] == 'admin'){
    include('../connection.php');
    include('../../components/sidebar.php');
    function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strMonthThai $strYear";
    }
    $query = "SELECT date ,SUM(case WHEN cost_status = 'ชำระเงินแล้ว' THEN total ELSE 0 END) as total_price, SUM(case WHEN cost_status = 'ยังไม่ได้ชำระ' THEN total ELSE 0 END) as untotal_price FROM cost GROUP BY date";
    $result = mysqli_query($conn, $query);

    //echo $query;
    $datax = array();
    foreach ($result as $k) {
      $datax[] = "['".DateThai($k['date'])."'".", ".$k['total_price'] ."," .$k['untotal_price'] ."]";
    }

    //cut last commar
    $datax = implode(",", $datax);
    echo $datax;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/home.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="home-box">
                <h3>Overview</h3>
                <div class="hr"></div>
                <div class="grid">
                <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['เดือน', 'ชำระเงินแล้ว','ยังไม่ได้ชำระ'],
          <?php echo $datax;?>
        ]);

        var options = {
          title: 'รายการชำระรายเดือน',
          colors: ['rgb(131, 120, 47)', '#a8a06d']
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <!-- <script src="../../js/costGraph.js"></script> -->
</body>

</html>
<?php
}else{
    Header("Location: ../login.php");   
}