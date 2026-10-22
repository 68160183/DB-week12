<?php
require 'auth.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
// TODO 6: After CSRF verification, clear $_SESSION, expire session cookie,
// call session_destroy(), redirect to login.php, then exit.
// Hint: see lecture slide "Logout flow".


// TODO 6: ตรวจสอบ CSRF และทำลาย Session อย่างปลอดภัย
    check_auth_token();
    
    $_SESSION = array(); // ล้างค่าตัวแปร Session ทั้งหมด
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy(); // ทำลาย Session
    
    // เปลี่ยนเส้นทางกลับไปหน้า login พร้อมแจ้งเตือน
    header("Location: login.php?logged_out=1");
    exit();
}


?>
<!doctype html><html lang="th"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Logout</title><link rel="stylesheet" href="assets/css/crud.css"></head><body><main class="wrap"><div class="panel"><h1>Log out?</h1><?php if(!empty($error)): ?><p class="err"><?=auth_escape($error)?></p><?php endif; ?><form method="post"><input type="hidden" name="auth_csrf" value="<?=auth_escape(auth_token())?>"><button type="submit">Confirm logout</button></form><p><a href="skills.php">Back</a></p></div></main></body></html>

