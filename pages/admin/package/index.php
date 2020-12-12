<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
    $from = @$_REQUEST['from'];
    $to = @$_REQUEST['to'];
    $check = @$_REQUEST['Status'];
    function DateThai($strDate){
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/package.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="package-box">
                <div>
                    <h3>ค้นหารายการพัสดุ</h3>
                    <div style="padding-top:32px">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <div style="display:flex;align-items:center;">
                                <label>ค้นหาตามวันที่</label>
                                <div style="position:relative;">
                                    <input type="text" id="date_from" class="roundtrip-input"
                                        value="<?php echo $from; ?>">
                                    <p id="from_date" class="dateText"></p>
                                </div>
                                <label>~</label>
                                <div style="position:relative;">
                                    <input type="text" id="date_to" class="roundtrip-input" value="<?php echo $to; ?>">
                                    <p id="to_date" class="dateText"></p>
                                </div>
                                <button type="button" onclick="searchDate()">ค้นหา</button>
                            </div>
                            <button onclick="addPackage()">เพิ่มรายการพัสดุ</button>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <h3>รายการพัสดุทั้งหมด</h3>
                    <div style="display:flex;align-items:center;">
                        <div style="padding:32px 16px;">
                            <input type="checkbox" id="success"
                                onchange="<?php if(isset($from) && isset($to)){ echo "searchCheck2('$from','$to',this.id)"; }else{ echo "searchCheck(this.id)"; } ?>"
                                <?php if(isset($check)){ if($check == "success"){ echo "checked";}} ?>>
                            <label for="scales">รับพัสดุแล้ว</label>
                        </div>
                        <div style="padding:32px 16px;">
                            <input type="checkbox" id="unsuccess"
                                onchange="<?php if(isset($from) && isset($to)){ echo "searchCheck2('$from','$to',this.id)"; }else{ echo "searchCheck(this.id)"; } ?>"
                                <?php if(isset($check)){ if($check == "unsuccess"){ echo "checked";}} ?>>
                            <label for="scales">ยังไม่ได้รับพัสดุ</label>
                        </div>
                        <button onclick="unCheckAll()">ยกเลิกการกรองทั้งหมด</button>
                    </div>
                    <?php
                    $perpage = 5;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $perpage;
                    if(isset($from) && isset($to) && !isset($check)){
                        $sql = "SELECT * FROM package WHERE (package_arrived BETWEEN '$from' AND '$to') ORDER BY package_arrived LIMIT {$start} , {$perpage}";
                    }else if(!isset($from) && !isset($to) && isset($check)){
                        if($check == "success"){
                            $check = "รับพัสดุแล้ว";
                        }else if($check == "unsuccess"){
                            $check = "ยังไม่ได้รับพัสดุ";
                        }
                        $sql = "SELECT * FROM package WHERE package_status = '$check' ORDER BY package_arrived LIMIT {$start} , {$perpage}";
                    }else if(isset($from) && isset($to) && isset($check)){
                        if($check == "success"){
                            $check = "รับพัสดุแล้ว";
                        }else if($check == "unsuccess"){
                            $check = "ยังไม่ได้รับพัสดุ";
                        }
                        $sql = "SELECT * FROM package WHERE (package_arrived BETWEEN '$from' AND '$to') AND package_status = '$check' ORDER BY package_arrived LIMIT {$start} , {$perpage}";   
                    }else{
                        $sql = "SELECT * FROM package ORDER BY package_arrived LIMIT {$start} , {$perpage} ";
                    }
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                    ?>
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
                        <form action="../package/function/receivedPackage.php?ID=<?php echo $row["package_num"]; ?>"
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
                                                echo "<a href='../package/function/delPackage.php?ID=" .$row["package_num"] ."'><button type='button' class='del-btn'>ลบ</button></a>";
                                            }else{
                                                echo "<a href='../package/function/delPackage.php?ID=" .$row["package_num"] ."'><button type='button' class='del-btn'>ลบ</button></a>";
                                            }
                                        ?>

                                </td>
                            </tr>
                        </form>
                        <?php } ?>
                    </table>
                    <?php
                    ///////pagination
                    if(isset($date) && !isset($check)){
                        $sql2 = "SELECT * FROM package WHERE package_arrived = '$date'";
                    }else if(!isset($date) && isset($check)){
                        $sql2 = "SELECT * FROM package WHERE package_status = '$check'";
                    }else if(isset($date) && isset($check)){
                        $sql2 = "SELECT * FROM package WHERE package_arrived = '$date' AND package_status = '$check'";   
                    }else{
                        $sql2 = "SELECT * FROM package";
                    }
                    
                    $query2 = mysqli_query($conn, $sql2);
                    $total_record = mysqli_num_rows($query2);
                    $total_page = ceil($total_record / $perpage);
                    ?>
                    <div style="display:flex;justify-content:flex-end">
                        <div class="pagination">
                            <?php
                            if(isset($date) && !isset($check)){
                            ?>
                            <a href="index.php?Date=<?php echo $date; ?>&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Date=<?php echo $date; ?>&page=<?php echo $i; ?>"
                            <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Date=<?php echo $date; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else if(!isset($date) && isset($check)){
                            ?>
                            <a href="index.php?Status=<?php echo $check; ?>&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=<?php echo $check; ?>&page=<?php echo $i; ?>"
                            <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=<?php echo $check; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else if(isset($date) && isset($check)){
                            ?>
                            <a href="index.php?Date=<?php echo $date; ?>&Status=<?php echo $check; ?>&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Date=<?php echo $date; ?>&Status=<?php echo $check; ?>&page=<?php echo $i; ?>"
                            <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Date=<?php echo $date; ?>&Status=<?php echo $check; ?>&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else{
                            ?>
                            <a href="index.php?page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?page=<?php echo $i; ?>"
                            <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }else{
                    echo "<div style='margin:32px 0'>ไม่มีรายการพัสดุ</div>";
                }
                ?>
                </div>

            </div>
        </div>
    </div>
    <script src="../../../js/admin/package.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>