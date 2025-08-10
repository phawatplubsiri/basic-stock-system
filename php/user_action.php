<?php
// user_action.php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require 'db.php';

$action = $_POST['action'] ?? '';

if ($action === 'add') {
    // เพิ่มลูกค้า
    $username = trim($_POST['username']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // เช็คอีเมลซ้ำ
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['user_action_error'] = "อีเมลนี้ถูกใช้งานแล้ว";
        header("Location: ../manage_users.php");
        exit;
    }
    $stmt->close();

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user';

    $stmt = $conn->prepare("INSERT INTO users (username, firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $firstname, $lastname, $email, $hash, $role);
    $stmt->execute();
    $stmt->close();

    $_SESSION['user_action_success'] = "เพิ่มลูกค้าสำเร็จ";
    header("Location: ../manage_users.php");
    exit;

} elseif ($action === 'edit') {
    // แก้ไขลูกค้า
    $id = intval($_POST['id']);
    $username = trim($_POST['username']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);

    // เช็ค email ซ้ำ (แต่ไม่รวม id ตัวเอง)
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['user_action_error'] = "อีเมลนี้ถูกใช้งานแล้ว";
        header("Location: ../manage_users.php");
        exit;
    }
    $stmt->close();

    $stmt = $conn->prepare("UPDATE users SET username=?, firstname=?, lastname=?, email=? WHERE id=? AND role='user'");
    $stmt->bind_param("ssssi", $username, $firstname, $lastname, $email, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['user_action_success'] = "แก้ไขลูกค้าสำเร็จ";
    header("Location: ../manage_users.php");
    exit;

} elseif ($action === 'delete') {
    // ลบลูกค้า
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id=? AND role='user'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['user_action_success'] = "ลบลูกค้าสำเร็จ";
    header("Location: ../manage_users.php");
    exit;
} else {
    header("Location: ../manage_users.php");
    exit;
}
