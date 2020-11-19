<?php include '../components/user_topbar.php' ?>
<?php include '../connection.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pingfah/css/user/package.css">
    <title>Document</title>
</head>

<body>
    <div style="margin-top:80px;padding:24px;">
        <div class="package">
            <h2>รายการพัสดุ</h2>
            <div class="table-box">
                <table>
                <tr>
                    <th style="width:70px;text-align:center">ลำดับ</th>
                    <th>เลขพัสดุ</th>
                    <th>บริษัท</th>
                    <th>เวลาที่พัสดุมาถึง</th>
                    <th>สถานะ</th>
                    <th>รับโดย</th>
                </tr>
                <tr>
                    <td style="width:70px;text-align:center">1</td>
                    <td>THAAABBBCCCDDDEEEFFF</td>
                    <td>Thai post</td>
                    <td>14/08/2020</td>
                    <td style="width:200px">
                        <div class="status_receive">
                            <p>รับของแล้ว</p>
                        </div>
                    </td>
                    <td>นวพล</td>
                </tr>
                <tr>
                    <td style="width:70px;text-align:center">2</td>
                    <td>THGGGHHHIIIJJJKKKLLL</td>
                    <td>Kerry</td>
                    <td>14/08/2020</td>
                    <td style="width:200px">
                        <div class="status_pending">
                            <p>รอมารับของ</p>
                        </div>
                    </td>
                    <td>พงศธร</td>
                </tr>
                <tr>
                    <td style="width:70px;text-align:center"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            </div>
            
        </div>
    </div>

</body>

</html>