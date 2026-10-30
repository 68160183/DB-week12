<?php
require 'auth.php'; 
require 'config/db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_auth_token();
    $full_name = trim((string)($_POST['full_name'] ?? ''));
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    $confirm_password = (string)($_POST['confirm_password'] ?? '');

    if ($full_name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $error = 'กรุณากรอกข้อมูลให้ครบถ้วน (รหัสผ่านอย่างน้อย 6 ตัวอักษร)';
    } elseif ($password !== $confirm_password) {
        $error = 'รหัสผ่าน and ยืนยันรหัสผ่านไม่ตรงกัน';
    } else {
        // ตรวจสอบอีเมลซ้ำ
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = 'อีเมลนี้ถูกใช้งาน, กรุณาใช้อีเมลอื่น';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $full_name, $email, $password_hash);
            if ($insert->execute()) {
                header("Location: login.php?registered=1");
                exit();
            } else {
                $error = 'เกิดข้อผิดพลาดในการสมัครสมาชิก';
            }
        }
    }
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>สมัครสมาชิก - Find my meow meow</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- ปรับ CSS ตามธีมชมพู/แมว -->
</head>
<body>
    <div class="panel">
        <h1>🐾 สมัครสมาชิก</h1>
        <p>ร่วมเป็นส่วนหนึ่งในการดูแลแมวไปด้วนกัน 💖</p>
        <?php if($error): ?><p class="err"><?=auth_escape($error)?></p><?php endif; ?>
        <form method="post">
            <input type="hidden" name="auth_csrf" value="<?=auth_escape(auth_token())?>">
            <label>ชื่อ-นามสกุล</label>
            <input type="text" name="full_name" required>
            <label>อีเมล</label>
            <input type="email" name="email" required>
            <label>รหัสผ่าน</label>
            <input type="password" name="password" required>
            <label>ยืนยันรหัสผ่าน</label>
            <input type="password" name="confirm_password" required>
            <button type="submit">สมัครสมาชิก</button>
        </form>
        <p>มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบที่นี่</a></p>
    </div>
</body>
</html>