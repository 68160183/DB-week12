<?php
<<<<<<< HEAD
require_once __DIR__ . '/auth.php';
require_login();
require_once __DIR__ . '/config/db.php';
=======
require_once __DIR__ . '/config/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
>>>>>>> 6b8792f2f8d3b414c8e32e7a1d95e37703a37afc
if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function csrf_field() { echo '<input type="hidden" name="csrf" value="'.h($_SESSION['csrf']).'">'; }
function verify_csrf() { if (!hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) { http_response_code(403); exit('Invalid CSRF token'); } }
function valid_id($value) { $n = filter_var($value, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]); return $n === false ? null : $n; }
<<<<<<< HEAD
function profile_id($conn) { return (int)$_SESSION['profile_id']; }
function page_start($title) { echo '<!doctype html><html lang="th"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.h($title).'</title><link rel="stylesheet" href="assets/css/crud.css"></head><body><main class="wrap"><nav><a href="index.php">Resume</a><a href="skills.php">Manage Skills</a><a href="skill_create.php">+ Add Skill</a><a href="logout.php">Logout</a></nav><div class="panel"><h1>'.h($title).'</h1>'; }
=======
function profile_id($conn) { $r=mysqli_query($conn,'SELECT id FROM profile ORDER BY id LIMIT 1'); $p=$r?mysqli_fetch_assoc($r):null; return $p?(int)$p['id']:0; }
function page_start($title) { echo '<!doctype html><html lang="th"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.h($title).'</title><link rel="stylesheet" href="assets/css/crud.css"></head><body><main class="wrap"><nav><a href="index.php">Resume</a><a href="skills.php">Manage Skills</a><a href="skill_create.php">+ Add Skill</a></nav><div class="panel"><h1>'.h($title).'</h1>'; }
>>>>>>> 6b8792f2f8d3b414c8e32e7a1d95e37703a37afc
function page_end() { echo '</div></main></body></html>'; }
