<?php 
    include('../../components/sidebar.php'); 
    include('../../connection.php');
    $date = @$_REQUEST['Date'];
    function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
    }
    if($_SESSION['level'] == 'admin'){
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pingfah/css/admin/package.css">
    <title>Document</title>
</head>

<body>
    <div class="box" id="package">
        <div style="padding:24px;">
            <div class="package-box">
                <h3>รายการพัสดุในแต่ละห้อง</h3>
                <div style="margin-top:32px">
                    <label>วันที่</label>
                    <input type="date" id="package_date" value="<?php if(isset($date)){ echo $date; }else{ echo ""; } ?>"
                        onchange="searchDate(value)">
                </div>
                <hr />
                <?php
                if(!isset($date)){
                    $packageData = "SELECT * FROM package WHERE package_status != 'รับพัสดุแล้ว' ORDER BY package_room";
                    $packageCount = "SELECT COUNT(*) FROM package WHERE package_status != 'รับพัสดุแล้ว' ";
                    $resultCount = $conn->query($packageCount);
                    $rowCount = $resultCount->fetch_row();
                    $result = $conn->query($packageData);
                    if ($result->num_rows > 0) {
                ?>
                <h3>รายการพัสดุคงค้างทั้งหมด <?php echo $rowCount[0]; ?> รายการ</h3>
                <table>
                    <tr>
                        <th>เลขพัสดุ</th>
                        <th>บริษัท</th>
                        <th>พัสดุมาถึง</th>
                        <th>สถานะ</th>
                        <th>เจ้าของพัสดุ</th>
                        <th>เลขห้อง</th>
                        <th>รับโดย</th>
                        <th>เพิ่มเติม</th>
                    </tr>
                    <?php
                    while($row = $result->fetch_assoc()) {
                    ?>
                    <form
                        action="/Pingfah/pages/admin/package/function/receivedPackage.php?ID=<?php echo $row["package_num"]; ?>"
                        method="POST">
                        <tr>
                            <!-- <td style="width:70px;text-align:center"></td> -->
                            <td><?php echo $row["package_num"] ?></td>
                            <td><?php echo $row["package_company"] ?></td>
                            <td><?php echo DateThai($row["package_arrived"]) ?></td>
                            <td style="width:200px">
                                <?php 
                                    if($row["package_status"] == 'รับพัสดุแล้ว'){
                                        echo "<div class='status_received'>";
                                        echo "<p>" .$row["package_status"] ."</p>";
                                        echo "</div>";
                                    }else{
                                        echo "<div class='status_pending'>";
                                        echo "<p>" .$row["package_status"] ."</p>";
                                        echo "</div>";
                                    }
                                ?>
                            </td>
                            <td><?php echo $row["package_name"] ?></td>
                            <td><?php echo $row["package_room"] ?></td>
                            <td>
                                <?php
                                    if(strlen($row["package_received"]) == 0){
                                        echo "<input type='text' name='received' required>";
                                    }else{
                                        echo $row["package_received"];
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                        if(strlen($row["package_received"]) == 0){
                                            echo "<button type='submit' class='received-btn'>รับ</button>";
                                        }else{
                                            echo "<a href='/Pingfah/pages/admin/package/function/delPackage.php?ID=" .$row["package_num"] ."'><button type='button' class='del-btn'>ลบ</button></a>";
                                        }
                                    ?>

                            </td>
                        </tr>
                    </form>
                    <?php } ?>
                </table>
                <?php
                }
                    }else{
                        $packageData = "SELECT * FROM package WHERE package_arrived = '$date' ORDER BY package_room";
                        $packageCount2 = "SELECT COUNT(*) FROM package WHERE package_arrived = '$date' ";
                        $resultCount2 = $conn->query($packageCount2);
                        $rowCount2 = $resultCount2->fetch_row();
                        $result = $conn->query($packageData);
                        if ($result->num_rows > 0) {
                                 
                ?>

                <h3>รายการพัสดุทั้งหมด <?php echo $rowCount2[0]; ?> รายการ</h3>
                <table>
                    <tr>
                        <th>เลขพัสดุ</th>
                        <th>บริษัท</th>
                        <th>พัสดุมาถึง</th>
                        <th>สถานะ</th>
                        <th>เจ้าของพัสดุ</th>
                        <th>เลขห้อง</th>
                        <th>รับโดย</th>
                        <th>เพิ่มเติม</th>
                    </tr>
                    <?php
                    while($row = $result->fetch_assoc()) {
                    ?>
                    <form
                        action="/Pingfah/pages/admin/package/function/receivedPackage.php?ID=<?php echo $row["package_num"]; ?>"
                        method="POST">
                        <tr>
                            <!-- <td style="width:70px;text-align:center"></td> -->
                            <td><?php echo $row["package_num"] ?></td>
                            <td><?php echo $row["package_company"] ?></td>
                            <td><?php echo DateThai($row["package_arrived"]) ?></td>
                            <td style="width:200px">
                                <?php 
                                    if($row["package_status"] == 'รับพัสดุแล้ว'){
                                        echo "<div class='status_received'>";
                                        echo "<p>" .$row["package_status"] ."</p>";
                                        echo "</div>";
                                    }else{
                                        echo "<div class='status_pending'>";
                                        echo "<p>" .$row["package_status"] ."</p>";
                                        echo "</div>";
                                    }
                                ?>
                            </td>
                            <td><?php echo $row["package_name"] ?></td>
                            <td><?php echo $row["package_room"] ?></td>
                            <td>
                                <?php
                                    if(strlen($row["package_received"]) == 0){
                                        echo "<input type='text' name='received' required>";
                                    }else{
                                        echo $row["package_received"];
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                        if(strlen($row["package_received"]) == 0){
                                            echo "<button type='submit' class='received-btn'>รับ</button>";
                                        }else{
                                            echo "<a href='/Pingfah/pages/admin/package/function/delPackage.php?ID=" .$row["package_num"] ."'><button type='button' class='del-btn'>ลบ</button></a>";
                                        }
                                    ?>

                            </td>
                        </tr>
                    </form>
                    <?php } ?>
                </table>
                <?php }else{
                    echo "<div style='margin:32px 0'>0 results</div>";
                }} ?>
                <div style="padding: 16px 0">
                    <div id="addPackage">
                        <form action="/Pingfah/pages/admin/package/function/addPackage.php" method="POST">
                            <div style="padding-right:8px">
                                <p>เลขพัสดุ</p>
                                <input type="text" name="num" required>
                            </div>
                            <div style="padding-right:8px">
                                <p>บริษัท</p>
                                <input type="text" name="company" required>
                            </div>
                            <div style="padding-right:8px">
                                <p>เวลาที่พัสดุมาถึง</p>
                                <input type="date" name="arrived" required>
                            </div>
                            <div style="padding-right:8px">
                                <p>ชื่อเจ้าของ</p>
                                <input type="text" name="name" required>
                            </div>
                            <div style="padding-right:8px">
                                <p>เลขห้อง</p>
                                <input type="text" name="room" required>
                            </div>
                            <div style="display:block;margin-top:auto">
                                <button type="submit">ยืนยัน</button>
                            </div>
                        </form>
                    </div>
                    <button onclick="addPackage()" class="addPackage-btn">เพิ่มรายการพัสดุ</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="/Pingfah/js/package.js"></script>
</body>

</html>
<?php
}else{
    if($_SESSION['level'] == 'employee'){
        Header("Location: /Pingfah/pages/employee/package/index.php");
    }else{
       Header("Location: ../login.php"); 
    }
}
?>