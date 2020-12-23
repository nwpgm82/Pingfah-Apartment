<?php
session_start();
if($_SESSION["level"] == "admin"){
    include("../../connection.php");
    $check = @$_REQUEST['Status'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/roomList2.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../../../js/admin/roomList2.js"></script>
    <title>Document</title>
</head>

<body>
    <?php include("../../../components/sidebar.php"); ?>
    <div class="box">
        <div style="padding:24px;">
            <div class="box-grid">
                <div class="roomList-box">
                    <div class="header">
                        <h3>รายการห้องพักทั้งหมด</h3>
                        <div style="position:relative;">
                            <button id="addRoom">เพิ่มห้องพัก</button>
                            <div id="add" style="position:absolute;top:45px;right:0;display:none;">
                                <div class="arrow-up"></div>
                                <div class="popover">
                                    <h3>เพิ่มห้องพัก</h3>
                                    <div class="hr"></div>
                                    <form action="function/addRoom.php" method="POST">
                                        <div class="input-grid">
                                            <div>
                                                <p>เลขห้อง</p>
                                                <input type="text" id="room_id" name="room_id" maxlength="3"
                                                    placeholder="เลขห้อง">
                                            </div>
                                            <div>
                                                <p>ประเภทห้องพัก</p>
                                                <select name="room_type" id="">
                                                    <option value="แอร์">แอร์</option>
                                                    <option value="พัดลม">พัดลม</option>
                                                </select>
                                            </div>
                                            <div>
                                                <p>ลักษณะห้องพัก</p>
                                                <select name="room_cat" id="">
                                                    <option value="รายวัน">รายวัน</option>
                                                    <option value="รายเดือน">รายเดือน</option>
                                                </select>
                                            </div>
                                            <div>
                                                <button type="submit">เพิ่ม</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="checkbox-grid">
                        <div class="sub-checkbox-grid">
                            <input type="checkbox" name="" id="all" <?php if($check == ""){ echo "checked"; }?>>
                            <label>ทั้งหมด</label>
                        </div>
                        <div class="sub-checkbox-grid">
                            <input type="checkbox" name="" id="avai_all"
                                <?php if($check == "avai_all"){ echo "checked"; }?>>
                            <label>ว่าง (ทั้งหมด)</label>
                        </div>
                        <div class="sub-checkbox-grid">
                            <input type="checkbox" name="" id="unavai_all"
                                <?php if($check == "unavai_all"){ echo "checked"; }?>>
                            <label>ไม่ว่าง (ทั้งหมด)</label>
                        </div>
                        <div class="sub-checkbox-grid">
                            <input type="checkbox" name="" id="avai_daily"
                                <?php if($check == "avai_daily"){ echo "checked"; }?>>
                            <label>รายวัน (ว่าง)</label>
                        </div>
                        <div class="sub-checkbox-grid">
                            <input type="checkbox" name="" id="unavai_daily"
                                <?php if($check == "unavai_daily"){ echo "checked"; }?>>
                            <label>รายวัน (ไม่ว่าง)</label>
                        </div>
                        <div class="sub-checkbox-grid">
                            <input type="checkbox" name="" id="avai_month"
                                <?php if($check == "avai_month"){ echo "checked"; }?>>
                            <label>รายเดือน (ว่าง)</label>
                        </div>
                        <div class="sub-checkbox-grid">
                            <input type="checkbox" name="" id="unavai_month"
                                <?php if($check == "unavai_month"){ echo "checked"; }?>>
                            <label>รายเดือน (ไม่ว่าง)</label>
                        </div>
                    </div>
                    <?php
                    $perpage = 8;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $perpage;
                    if($check == "avai_all"){
                        $sql = "SELECT room_id, room_type, room_cat, room_status FROM roomlist WHERE room_status = 'ว่าง' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else if($check == "unavai_all"){
                        $sql = "SELECT room_id, room_type, room_cat, room_status FROM roomlist WHERE room_status = 'ไม่ว่าง' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else if($check == "avai_daily"){
                        $sql = "SELECT room_id, room_type, room_cat, room_status FROM roomlist WHERE room_status = 'ว่าง' AND room_cat = 'รายวัน' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else if($check == "unavai_daily"){
                        $sql = "SELECT room_id, room_type, room_cat, room_status FROM roomlist WHERE room_status = 'ไม่ว่าง' AND room_cat = 'รายวัน' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else if($check == "avai_month"){
                        $sql = "SELECT room_id, room_type, room_cat, room_status FROM roomlist WHERE room_status = 'ว่าง' AND room_cat = 'รายเดือน' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else if($check == "unavai_month"){
                        $sql = "SELECT room_id, room_type, room_cat, room_status FROM roomlist WHERE room_status = 'ไม่ว่าง' AND room_cat = 'รายเดือน' ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }else{
                        $sql = "SELECT room_id, room_type, room_cat, room_status FROM roomlist ORDER BY room_id LIMIT {$start} , {$perpage}";
                    }
                    
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    ?>
                    <table>
                        <tr>
                            <th>เลขห้อง</th>
                            <th>ประเภท</th>
                            <th>ลักษณะ</th>
                            <th>สถานะ</th>
                            <th>เพิ่มเติม</th>
                        </tr>
                        <?php
                        while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><a
                                    href="room_id.php?ID=<?php echo $row['room_id']; ?>"><?php echo $row["room_id"]; ?></a>
                            </td>
                            <td><?php echo $row["room_type"]; ?></td>
                            <td><?php echo $row["room_cat"]; ?></td>
                            <td><?php if($row["room_status"] == "ว่าง"){ echo "<div class='status-available'></div>"; }else{ echo "<div class='status-unavailable'></div>"; } ?>
                            </td>
                            <td>
                                <div style="display:flex;justify-content:center;">
                                    <button id="<?php echo $row['room_id']; ?>" class="edit-btn"></button>
                                    <button id="<?php echo $row['room_id']; ?>" class="del-btn"></button>
                                </div>

                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                    <?php
                    ///////pagination
                    if($check == "avai_all"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'ว่าง'";
                    }else if($check == "unavai_all"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'ไม่ว่าง'";
                    }else if($check == "avai_daily"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'ว่าง' AND room_cat = 'รายวัน'";
                    }else if($check == "unavai_daily"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'ไม่ว่าง' AND room_cat = 'รายวัน'";
                    }else if($check == "avai_month"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'ว่าง' AND room_cat = 'รายเดือน'";
                    }else if($check == "unavai_month"){
                        $sql2 = "SELECT * FROM roomlist WHERE room_status = 'ว่าง' AND room_cat = 'รายเดือน'";
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
                            if($check == "avai_all"){
                            ?>
                            <a href="index.php?Status=avai_all&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=avai_all&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=avai_all&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else if($check == "unavai_all"){
                            ?>
                            <a href="index.php?Status=unavai_all&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=unavai_all&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=unavai_all&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php 
                            }else if($check == "avai_daily"){
                            ?>
                            <a href="index.php?Status=avai_daily&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=avai_daily&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=avai_daily&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else if($check == "unavai_daily"){
                            ?>
                            <a href="index.php?Status=unavai_daily&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=unavai_daily&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=unavai_daily&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php 
                            }else if($check == "avai_month"){
                            ?>
                            <a href="index.php?Status=avai_month&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=avai_month&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=avai_month&page=<?php echo $total_page; ?>">&raquo;</a>
                            <?php
                            }else if($check == "unavai_month"){
                            ?>
                            <a href="index.php?Status=unavai_month&page=1">&laquo;</a>
                            <?php for($i=1;$i<=$total_page;$i++){ ?>
                            <a href="index.php?Status=unavai_month&page=<?php echo $i; ?>"
                                <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                            <?php } ?>
                            <a href="index.php?Status=unavai_month&page=<?php echo $total_page; ?>">&raquo;</a>
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
                        if($check == "avai_all"){
                            echo "ไม่มีรายการห้องพักที่ว่าง";
                        }else if($check == "unavai_all"){
                            echo "ไม่มีรายการห้องพักที่ไม่ว่าง";
                        }else if($check == "avai_daily"){
                            echo "ไม่มีรายการห้องพักรายวัน";
                        }else if($check == "unavai_daily"){
                            echo "ไม่มีรายการห้องพักรายวันที่ไม่ว่าง";
                        }else if($check == "avai_month"){
                            echo "ไม่มีรายการห้องพักรายเดือน";
                        }else if($check == "unavai_month"){
                            echo "ไม่มีรายการห้องพักรายเดือนที่ไม่ว่าง";
                        }else{
                            echo "ไม่มีรายการห้องพัก";
                        }
                    }
                    ?>
                </div>



                <div class="roomList-box"></div>
                <div class="roomList-box"></div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
}else{
    Header("Location: ../../login.php");
}