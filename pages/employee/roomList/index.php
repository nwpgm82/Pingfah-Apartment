<?php 
session_start();
if($_SESSION['level'] == 'employee'){
    include('../../connection.php');
    include('../../../components/sidebarEPY.php');
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
    <title>Document</title>
</head>

<body>
    <div class="box" id="roomList">
        <div style="padding:24px;">
            <div class="roomList-box">
                <h3>รายการห้องพักทั้งหมด</h3>
                <div class="hr"></div>
                <?php
                    $perpage = 8;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $perpage;
                        $roomlist = "SELECT * FROM  roomList ORDER BY room_id LIMIT {$start} , {$perpage}";
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
                    </tr>
                    <?php
                            while($row = mysqli_fetch_array($result)) { 
                    ?>
                    <form action="../roomList/function/editType.php?ID=<?php echo $row["room_id"]; ?>" method='POST'>
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
                        </tr>
                    </form>
                    <?php  $num++; }?>
                </table>
                <?php
                ///////pagination
                $sql2 = "SELECT * FROM roomlist";
                $query2 = mysqli_query($conn, $sql2);
                $total_record = mysqli_num_rows($query2);
                $total_page = ceil($total_record / $perpage);
                ?>
                <div style="display:flex;justify-content:flex-end">
                    <div class="pagination">
                        <a href="index.php?page=1">&laquo;</a>
                        <?php for($i=1;$i<=$total_page;$i++){ ?>
                        <a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php } ?>
                        <a href="index.php?page=<?php echo $total_page; ?>">&raquo;</a>
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
                            <label>ไม่ว่าง</label>
                        </div>
                        <div class="sub-grid">
                            <div class='status-daily'></div>
                            <label>เช่ารายวัน</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/employee/roomList.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>