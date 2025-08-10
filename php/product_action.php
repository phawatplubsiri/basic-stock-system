<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

require 'db.php';

$action = $_POST['action'] ?? '';

if ($action === 'add') {
    $name = trim($_POST['name']);
    $img_url = trim($_POST['img_url']);
    $price = floatval($_POST['price']);
    $amount = intval($_POST['amount']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);

    $stmt = $conn->prepare("INSERT INTO product (name, img_url, price, amount, description, category) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiss", $name, $img_url, $price, $amount, $description, $category);
    $stmt->execute();
    $stmt->close();

    $_SESSION['product_action_success'] = "เพิ่มสินค้าสำเร็จ";
    header("Location: ../manage_products.php");
    exit;

} elseif ($action === 'edit') {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $img_url = trim($_POST['img_url']);
    $price = floatval($_POST['price']);
    $amount = intval($_POST['amount']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);

    $stmt = $conn->prepare("UPDATE products SET name=?, img_url=?, price=?, amount=?, description=?, category=? WHERE id=?");
    $stmt->bind_param("ssdissi", $name, $img_url, $price, $amount, $description, $category, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['product_action_success'] = "แก้ไขสินค้าสำเร็จ";
    header("Location: ../manage_products.php");
    exit;

} elseif ($action === 'delete') {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM product WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['product_action_success'] = "ลบสินค้าสำเร็จ";
    header("Location: ../manage_products.php");
    exit;

} else {
    header("Location: ../manage_products.php");
    exit;
}
