<?php
// admin.php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/admin.css" />

    <title>Admin Dashboard</title>
</head>

<body>
    <h2>สวัสดี คุณ <?php echo htmlspecialchars($_SESSION['username']); ?> (Admin)</h2>
    <a href="manage_users.php">จัดการข้อมูลลูกค้า</a>
    <a href="manage_products.php">จัดการข้อมูลสินค้า</a>
    <a href="php/logout.php" style="background:#dc3545;">ออกจากระบบ</a>
</body>

</html>