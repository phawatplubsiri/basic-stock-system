<?php
// register_action.php
session_start();
require 'db.php';

// รับค่าจากฟอร์ม
$username = trim($_POST['username']);
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$role = $_POST['role'];

// เช็ค password กับ confirm_password (อีกครั้ง)
if ($password !== $confirm_password) {
    $_SESSION['register_error'] = "รหัสผ่านไม่ตรงกัน";
    header("Location: ../register.php");
    exit;
}

// เช็คว่ามี admin อยู่แล้วหรือยังถ้าเลือก role=admin
if ($role === 'admin') {
    $sql = "SELECT COUNT(*) AS count FROM users WHERE role='admin'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        $_SESSION['register_error'] = "มีผู้ดูแลระบบ (admin) อยู่แล้ว";
        header("Location: ../register.php");
        exit;
    }
}

// เช็คอีเมลซ้ำ
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $_SESSION['register_error'] = "อีเมลนี้ถูกใช้งานแล้ว";
    header("Location: ../register.php");
    exit;
}
$stmt->close();

// แฮชรหัสผ่าน
$hash = password_hash($password, PASSWORD_DEFAULT);

// เตรียมเพิ่มข้อมูลลงฐานข้อมูล
$stmt = $conn->prepare("INSERT INTO users (username, firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $username, $firstname, $lastname, $email, $hash, $role);

if ($stmt->execute()) {
    $_SESSION['register_success'] = "สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ";
    header("Location: ../index.php");
} else {
    $_SESSION['register_error'] = "เกิดข้อผิดพลาดในการสมัครสมาชิก";
    header("Location: ../register.php");
}
$stmt->close();
$conn->close();
exit;
