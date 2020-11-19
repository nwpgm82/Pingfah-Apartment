<?php
session_start();
if($_SESSION['level'] == 'admin'){
    include('../../connection.php');
    include('../../components/sidebar.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/rule.css">
    <title>Document</title>
</head>

<body>
    <div class="box">
        <div style="padding:24px;">
            <div class="rule-box">
                <h3>กฎระเบียบหอพัก " บ้านพิงฟ้า "</h3>
                <form action="../rule/function/ruleAccept.php" method="POST">
                    <textarea id="rule_detail" name="rule_detail" disabled><?php
                    $sql = "SELECT * FROM rule";
                    $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                          // output data of each row
                          while($row = $result->fetch_assoc()) {
                            echo $row['rule_detail'];
                          }
                        } else {
                          echo "0 results";
                        }
                    ?></textarea>
                    <div id="edit_btn" style="margin-top:32px;display:block">
                        <button type="button" class="edit_btn" onclick="edit_rule()">แก้ไข</button>
                    </div>
                    <div id="accept_btn" style="margin-top:32px;display:none">
                        <button type="submit" name="rule_accept">ยืนยันการแก้ไข</button>
                        <button type="button" class="cancel_btn" onclick="edit_rule()">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../js/admin/rule.js"></script>
</body>

</html>
<?php
}else{
    Header("Location: ../../login.php"); 
}
?>