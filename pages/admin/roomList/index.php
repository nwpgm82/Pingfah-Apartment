<?php 
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
    $check = @$_REQUEST['Status'];
    // $page
    $num = 1;
    function DateThai($strDate)
    {
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
    <link rel="stylesheet" href="../../../css/roomList.css">
    <link rel="stylesheet" href="../../../css/my-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datedropper.com/get/f81yq0gdfse6par55j0enfmfmlk99n5y"></script>
    <script src="../../../js/datedropper.pro.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="box" id="roomList">
        <div style="padding:24px;">
            <div class="box-grid">
                <div class="roomList-box">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <h3>รายการห้องพักทั้งหมด</h3>
                        <div>
                            <div style="display:flex;justify-content:flex-end;" id="addRoom-btn">
                                <button onclick="addRoom()" class="addRoom-btn">เพิ่มห้องพัก</button>
                            </div>
                            <div id="addRoom">
                                <form action="../roomList/function/addRoom.php" method="POST">
                                    <div style="padding-right:8px">
                                        <label>ห้อง</label>
                                        <input type="text" name="room" required>
                                    </div>
                                    <div style="padding-right:8px">
                                        <label>ประเภท</label>
                                        <select name="type">
                                            <option value="พัดลม">พัดลม</option>
                                            <option value="แอร์">แอร์</option>
                                        </select>
                                    </div>
                                    <div style="display:block;margin-top:auto">
                                        <button type="submit">ยืนยัน</button>
                                        <button type="button" class="cancel-btn" onclick="canceladdRoom()">ยกเลิก</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="hr"></div>
                    <div style="display:flex;align-items:center;">
                        <div style="padding:32px 16px;display:flex;align-items:center;">
                            <input type="checkbox" id="available" onchange="searchCheck(this.id)"
                                <?php if(isset($check)){ if($check == "available"){ echo "checked";}} ?>>
                            <label for="scales">ว่าง</label>
                        </div>
                        <div style="padding:32px 16px;display:flex;align-items:center;">
                            <input type="checkbox" id="unavailable" onchange="searchCheck(this.id)"
                                <?php if(isset($check)){ if($check == "unavailable"){ echo "checked";}} ?>>
                            <label for="scales">รายเดือน (ไม่ว่าง)</label>
                        </div>
                        <div style="padding:32px 16px;display:flex;align-items:center;">
                            <input type="checkbox" id="daily" onchange="searchCheck(this.id)"
                                <?php if(isset($check)){ if($check == "daily"){ echo "checked";}} ?>>
                            <label for="scales">รายวัน (ไม่ว่าง)</label>
                        </div>
                        <button onclick="unCheckAll()">ยกเลิกการกรองทั้งหมด</button>
                    </div>


                    <?php
                    $perpage = 8;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $perpage;
                    if($check == "available"){
                        $status = "ว่าง";
                        $roomlist = "SELECT * FROM  roomList WHERE room_status = '$status' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else if($check == "unavailable"){
                        $status = "ไม่ว่าง";
                        $roomlist = "SELECT * FROM  roomList WHERE room_status = '$status' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else if($check == "daily"){
                        $status = "เช่ารายวัน";
                        $roomlist = "SELECT * FROM  roomList WHERE room_status = '$status' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else{
                        $roomlist = "SELECT * FROM  roomList ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }
                    $result = $conn->query($roomlist);
                    if ($result->num_rows > 0) {
                    ?>
                    <table>
                        <tr>
                            <th>ลำดับ</th>
                            <th>เลขห้อง</th>
                            <th>ประเภท</th>
                            <th>วันที่เข้าอยู่</th>
                            <th>สถานะ</th>
                            <th>เพิ่มเติม</th>
                        </tr>
                        <?php
                            while($row = mysqli_fetch_array($result)) { 
                        ?>
                        <form action="../roomList/function/editType.php?ID=<?php echo $row["room_id"]; ?>"
                            method='POST'>
                            <tr>
                                <td><?php echo $num; ?></td>
                                <td><a
                                        href="../roomList/room_id.php?ID=<?php echo $row[0] ?>"><?php echo $row["room_id"]; ?></a>
                                </td>
                                <td <?php echo "id='typeShow" .$row["room_id"] . "'" ?>><?php echo $row["room_type"]; ?>
                                </td>
                                <td <?php echo "id='typeEdit" .$row["room_id"] . "'" ."style='display:none'"; ?>>
                                    <select name="type">
                                        <option value="พัดลม">พัดลม</option>
                                        <option value="แอร์">แอร์</option>
                                    </select>
                                </td>
                                <td>
                                    <?php if($row['come'] != null && $row['room_status'] != 'เช่ารายวัน'){ echo DateThai($row['come']); }; ?>
                                    <?php if($row['check_in'] != null && $row['come'] == null){ echo DateThai($row['check_in']) ." ~ " .DateThai($row['check_out']); } ?>
                                </td>
                                <td>
                                    <?php
                                        if($row["room_status"] == 'ว่าง'){
                                            echo "<div class='status-available'></div>";
                                        }else if($row["room_status"] == 'ไม่ว่าง'){
                                            echo "<div class='status-unavailable'></div>";
                                        }else if($row["room_status"] == 'เช่ารายวัน'){
                                            echo "<div class='status-daily'></div>";
                                        }
                                    ?>
                                </td>
                                <td <?php echo "id='typeShow-btn" .$row["room_id"] . "'" ?>>
                                    <button type="button" class="edit-btn"
                                        <?php echo "onclick='editType(" .$row["room_id"] .")'" ?>>แก้ไข</button>
                                    <button type="button" class="del-btn"
                                        <?php echo "onclick='del(" .$row["room_id"] .")'" ?>>ลบ</button>
                                </td>
                                <td <?php echo "id='typeEdit-btn" .$row["room_id"] . "' style='display:none' " ?>>
                                    <button type="submit" class="accept-btn"
                                        <?php echo "onclick='acceptEdit(" .$row["room_id"] .")'" ?>>ยืนยัน</button>
                                    <button type="button" class="cancel-btn"
                                        <?php echo "onclick='cancelEdit(" .$row["room_id"] .")'" ?>>ยกเลิก</button>
                                </td>
                            </tr>
                        </form>
                        <?php  $num++; }?>
                    </table>
                    <?php
                    ///////pagination
                    if($check == "available"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'ว่าง'";
                    }else if($check == "unavailable"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'ไม่ว่าง'";
                    }else if($check == "daily"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'เช่ารายวัน'";
                    }else{
                        $sql2 = "SELECT * FROM roomlist";
                    }
                    $query2 = mysqli_query($conn, $sql2);
                    $total_record = mysqli_num_rows($query2);
                    $total_page = ceil($total_record / $perpage);
                    ?>
                    <div style="display:flex;justify-content:flex-end">
                        <div class="pagination">
                            <?php
                            if($check == "available"){
                            ?>
                            <a href="index.php?Status=available&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=available&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=available&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else if($check == "unavailable"){
                            ?>
                            <a href="index.php?Status=unavailable&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=unavailable&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=unavailable&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php 
                            }else if($check == "daily"){
                            ?>
                            <a href="index.php?Status=daily&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=daily&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=daily&page=<?php echo $total_page; ?>">&raquo;</a>
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
                        echo "0 result";
                    }
                    mysqli_close($conn);
                    ?>
                    <div style="display:flex;justify-content:flex-end;">
                        <div class="status-grid">
                            <div class="sub-grid">
                                <div class='status-available'></div>
                                <label>ว่าง</label>
                            </div>
                            <div class="sub-grid">
                                <div class='status-unavailable'></div>
                                <label>รายเดือน (ไม่ว่าง)</label>
                            </div>
                            <div class="sub-grid">
                                <div class='status-daily'></div>
                                <label>รายวัน (ไม่ว่าง)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="roomList-box">
                    <h3>ค้นหาห้องว่าง</h3>
                    <div class="hr"></div>
                    <label>ค้นหาตามวันที่</label>
                    <div style="display:flex;align-items:center;padding-top:8px;">
                        <div style="position:relative;">
                            <input type="text" class="roundtrip-input" id="check_in" required>
                            <p id="check_in_date" class="dateText"></p>
                        </div>
                        <label style="padding:0 8px;">~</label>
                        <div style="position:relative;">
                            <input type="text" class="roundtrip-input" id="check_out" required>
                            <p id="check_out_date" class="dateText"></p>
                        </div>
                        <button type="button" style="margin-left:8px;" onclick="searchDate()">ค้นหา</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/roomList.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>