<?php 
include('../../connection.php');
include('../../components/sidebar.php'); 
$date = @$_REQUEST['Date'];
$sql = "SELECT * FROM cost WHERE date = '$date'";
$result = $conn->query($sql);
function DateThai($strDate){
	$strYear = date("Y",strtotime($strDate))+543;
	$strMonth= date("n",strtotime($strDate));
	$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$strMonthThai=$strMonthCut[$strMonth];
	return "$strMonthThai $strYear";
}
if($_SESSION['level'] == 'admin'){
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pingfah/css/admin/cost.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="cost-box">
                <h3>รายชื่อห้อง</h3>
                <div style="margin-top:32px">
                    <label>ประจำเดือน</label>
                    <input type="month" id="cost_date" value="<?php if(isset($date)){ echo $date; }else{ echo ""; } ?>"
                        onchange="searchDate(value)">
                    <!-- <button class="search-btn" onclick="searchDate(value)">ค้นหา</button> -->
                </div>
                <hr />
                <?php
                if(!isset($date)){
                $sql = "SELECT * FROM cost WHERE cost_status != 'ชำระเงินแล้ว' ";
                $costCount = "SELECT COUNT(*) FROM cost WHERE cost_status != 'ชำระเงินแล้ว' ";
                $resultCount = $conn->query($costCount);
                $rowCount = $resultCount->fetch_row();
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                ?>
                <h3>รายการชำระคงค้างทั้งหมด <?php echo $rowCount[0] ?> รายการ</h3>
                <table>
                    <tr>
                        <th>เลขห้อง</th>
                        <!-- <th>ประเภท</th> -->
                        <th>เวลาที่ออกบิล</th>
                        <th>ค่าห้อง</th>
                        <th>ค่าน้ำ</th>
                        <th>ค่าไฟ</th>
                        <th>ค่าเคเบิล</th>
                        <th>ค่าปรับ</th>
                        <th>ราคารวม</th>
                        <th>สถานะการจ่ายเงิน</th>
                        <th>เพิ่มเติม</th>

                    </tr>
                    <?php 
                        while($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row["room_id"];?></td>
                        <!-- <td><?php echo $row["type"]?></td> -->
                        <td><?php echo DateThai($row["date"]);?></td>
                        <td><?php echo $row["room_cost"];?></td>
                        <td><?php echo $row["water_bill"];?></td>
                        <td><?php echo $row["elec_bill"];?></td>
                        <td><?php echo $row["cable_charge"];?></td>
                        <td><?php echo $row["fines"];?></td>
                        <td><?php echo $row["total"];?></td>
                        <?php
                        if($row['cost_status'] == 'ชำระเงินแล้ว'){
                        ?>
                        <td>
                            <div class="status-success">
                                <p><?php echo $row["cost_status"]?></p>
                            </div>
                        </td>
                        <?php
                        }else{
                        ?>
                        <td>
                            <div class="status-nosuccess">
                                <p><?php echo $row["cost_status"]?></p>
                            </div>
                        </td>
                        <?php } ?>
                        <?php
                            if($row['cost_status'] != 'ชำระเงินแล้ว'){
                            ?>
                        <td>
                            <button class="confirm-status"
                                onclick="confirmStatus(<?php echo $row['room_id'] .",'" .$row['date'] ."'"; ?>)">ยืนยันการชำระ</button>
                        </td>
                        <?php 
                            }else{
                            ?>
                        <td>
                            <button class="confirmed-status">ยืนยันการชำระ</button>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </table>
                <?php
                }
                    }else{
                        $costData = "SELECT * FROM cost WHERE date = '$date' ORDER BY room_id";
                        $costCount2 = "SELECT COUNT(*) FROM cost WHERE date = '$date' ";
                        $resultCount2 = $conn->query($costCount2);
                        $rowCount2 = $resultCount2->fetch_row();
                        $result = $conn->query($costData);
                        if ($result->num_rows > 0) {
                                 
                ?>
                <h3>รายการห้องพักทั้งหมด <?php echo $rowCount2[0] ?> รายการ</h3>
                <table>
                    <tr>
                        <th>เลขห้อง</th>
                        <!-- <th>ประเภท</th> -->
                        <th>เวลาที่ออกบิล</th>
                        <th>ค่าห้อง</th>
                        <th>ค่าน้ำ</th>
                        <th>ค่าไฟ</th>
                        <th>ค่าเคเบิล</th>
                        <th>ค่าปรับ</th>
                        <th>ราคารวม</th>
                        <th>สถานะการจ่ายเงิน</th>
                        <th>เพิ่มเติม</th>

                    </tr>
                    <?php 
                        while($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row["room_id"];?></td>
                        <!-- <td><?php echo $row["type"]?></td> -->
                        <td><?php echo DateThai($row["date"]);?></td>
                        <td><?php echo $row["room_cost"];?></td>
                        <td><?php echo $row["water_bill"];?></td>
                        <td><?php echo $row["elec_bill"];?></td>
                        <td><?php echo $row["cable_charge"];?></td>
                        <td><?php echo $row["fines"];?></td>
                        <td><?php echo $row["total"];?></td>
                        <?php
                        if($row['cost_status'] == 'ชำระเงินแล้ว'){
                        ?>
                        <td>
                            <div class="status-success">
                                <p><?php echo $row["cost_status"]?></p>
                            </div>
                        </td>
                        <?php
                        }else{
                        ?>
                        <td>
                            <div class="status-nosuccess">
                                <p><?php echo $row["cost_status"]?></p>
                            </div>
                        </td>
                        <?php } ?>
                        <?php
                            if($row['cost_status'] != 'ชำระเงินแล้ว'){
                            ?>
                        <td>
                            <button class="confirm-status"
                                onclick="confirmStatus(<?php echo $row['room_id'] .",'" .$row['date'] ."'"; ?>)">ยืนยันการชำระ</button>
                        </td>
                        <?php 
                            }else{
                            ?>
                        <td>
                            <button class="confirmed-status">ยืนยันการชำระ</button>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </table>
                <div style="padding: 16px 0;">
                    <div style="margin: 16px 0">
                        <label>ยอดรวมทั้งหมด :</label>
                        <label>
                            <?php 
                                    $calsum = mysqli_query($conn, "SELECT sum(total) AS value_sum FROM cost WHERE date = '$date' ");  
                                    $sumrow = mysqli_fetch_assoc($calsum); 
                                    $sum = $sumrow['value_sum'];
                                    if(isset($sum)){
                                        echo $sum;
                                    }else{
                                        echo 0;
                                    }
                                ?>
                        </label>
                    </div>
                    <div style="margin: 16px 0">
                        <label>รายได้ทั้งหมด :</label>
                        <label>
                            <?php
                                    $calsum_status = mysqli_query($conn, "SELECT sum(total) AS value_sum2 FROM cost WHERE cost_status = 'ชำระเงินแล้ว' AND date = '$date' ");  
                                    $sumrow2 = mysqli_fetch_assoc($calsum_status); 
                                    $sum2 = $sumrow2['value_sum2'];
                                    if(isset($sum2)){
                                        echo $sum2;
                                    }else{
                                        echo 0;
                                    }
                                ?>
                        </label>
                    </div>
                </div><?php } } ?>
                <div style="margin-top:32px;">
                    <a href="/Pingfah/pages/admin/cost/addcost.php"><button>เพิ่มห้อง</button></a>
                </div>           
            </div>
        </div>
    </div>
    <script src="/Pingfah/js/costDate.js"></script>
</body>

</html>
<?php
}else{
    if($_SESSION['level'] == 'employee'){
        Header("Location: /Pingfah/pages/employee/cost/index.php");
    }else{
       Header("Location: ../login.php"); 
    }
}
?>