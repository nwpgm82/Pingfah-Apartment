<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pingfah/css/login.css">
    <title>Document</title>
</head>

<body>
    <div class="login">
        <img src="/Pingfah/img/main_logo.png" alt="">
        <form action="checklogin.php" method="POST">
            <div>
                <p>บัญชีผู้ใช้ / Username</p>
                <input type="text" name="username" required>
            </div>
            <div>
                <p>รหัสผ่าน / Password</p>
                <input type="password" name="password" required>
            </div>
            <div style="margin-top: 16px;display:flex;justify-content:flex-end;">
               <button type="submit" name="login">เข้าสู่ระบบ / Login</button> 
            </div>
        </form>
    </div>
</body>

</html>