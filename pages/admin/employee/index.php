<?php 
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../../components/sidebar.php');
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/employee.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="employee-box">
                <h3>รายชื่อพนักงาน</h3>
                <div class="hr"></div>
                <?php
                $perpage = 5;
                if (isset($_GET['page'])) {
                $page = $_GET['page'];
                } else {
                $page = 1;
                }
                
                $start = ($page - 1) * $perpage;
                $num = 1;
                $sql = "SELECT * FROM employee limit {$start} , {$perpage}";
                $result = $conn->query($sql);  
                if ($result->num_rows > 0) {
                ?>
                <table>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อพนักงาน</th>
                        <th>ตำแหน่ง</th>
                        <th>เบอร์โทรศัพท์</th>
                        <th>อีเมล์</th>
                        <th>เพิ่มเติม</th>
                    </tr>
                    <?php while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td>
                            <div style="display:flex;justify-content:center;">
                                <?php echo $num; ?>
                            </div>
                        </td>
                        <td>
                            <div class="grid">
                                <img src="../../images/employee/<?php echo $row['username']; ?>/<?php echo $row["profile_img"]; ?>"
                                    alt="">
                                <p><?php echo $row["firstname"]; ?> <?php echo $row["lastname"]; ?></p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><?php echo $row["position"]; ?></p>
                            </div>
                        </td>
                        <td><?php echo textFormat($row["tel"],"___-_______"); ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td>
                            <div class="grid-btn">
                                <a href="../employee/emDetail.php?username=<?php echo $row['username']; ?>"><button
                                        type="button" class="more-btn">แสดงข้อมูลเพิ่มเติม</button></a>
                                <button type="button" class="del-btn"
                                    onclick="delEm(<?php echo $row['id']; ?>,'<?php echo $row['username']; ?>')">ลบ</button>
                            </div>
                        </td>
                    </tr>
                    <?php $num++; } ?>
                </table>
                <?php
                $sql2 = "SELECT * FROM employee";
                $query2 = mysqli_query($conn, $sql2);
                $total_record = mysqli_num_rows($query2);
                $total_page = ceil($total_record / $perpage);
                ?>
                <div style="display:flex;justify-content:flex-end">
                    <div class="pagination">
                        <a href="index.php?page=1">&laquo;</a>
                        <?php for($i=1;$i<=$total_page;$i++){ ?>
                        <a href="index.php?page=<?php echo $i; ?>" <?php if($page == $i){ echo "style='background-color: rgb(131, 120, 47, 1);color:#fff;'"; }?>><?php echo $i; ?></a>
                        <?php } ?>
                        <a href="index.php?page=<?php echo $total_page; ?>">&raquo;</a>
                    </div>
                </div>
                <?php }else{
                    echo "ไม่มีรายชื่อพนักงาน";
                } ?>
                <div style="display:flex;justify-content:flex-end;">
                    <a href="../employee/addemployee.php"><button>เพิ่มพนักงาน</button></a>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/delEm.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>