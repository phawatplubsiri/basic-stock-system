<?php
// check_admin.php
require 'db.php';

$sql = "SELECT COUNT(*) as admin_count FROM users WHERE role='admin'";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

echo json_encode(['admin_exists' => $row['admin_count'] > 0]);
?>
