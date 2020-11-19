<?php 
session_start();
if($_SESSION['level'] == 'admin'){
    include('../components/sidebar.php');
    include('../connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pingfah/css/home.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="home-box">
                <h3>Overview</h3>
                <div class="grid">
                    <div class="chart-container">
                        <canvas id="graphCanvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src="../../js/costGraph.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../login.php");   
}