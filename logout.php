<?php
require 'auth.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_auth_token();
    
    $_SESSION = array(); 
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    
    header("Location: login.php?logged_out=1");
    exit();
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>Logout</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="panel">
        <h1>ต้องการออกจากระบบใช่หรือไม่?</h1>
        <form method="post">
            <input type="hidden" name="auth_auth_token" value="<?=auth_escape(auth_token())?>">
            <button type="submit">ยืนยันการออกจากระบบ</button>
        </form>
        <p><a href="index.php">ย้อนกลับ</a></p>
    </div>
</body>
</html>