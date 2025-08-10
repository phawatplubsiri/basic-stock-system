<?php
// login.php
session_start();
require 'db.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: ../admin.php");
        } else {
            header("Location: ../products.php");
        }
        exit;
    }
}
$_SESSION['login_error'] = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
header("Location: ../index.php");
exit;
