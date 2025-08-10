<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

require 'php/db.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: products.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/product_detail.css" />
    <title>รายละเอียดสินค้า: <?= htmlspecialchars($product['name']) ?></title>
</head>
<body>

    <div class="card">
        <?php if (!empty($product['img_url'])): ?>
            <img src="<?= htmlspecialchars($product['img_url']) ?>" alt="รูปสินค้า" />
        <?php else: ?>
            <div style="height:300px; background:#eee; display:flex;align-items:center;justify-content:center;">ไม่มีรูป</div>
        <?php endif; ?>

        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <div class="price"><?= number_format($product['price'], 2) ?> บาท</div>
        <div class="desc"><?= nl2br(htmlspecialchars($product['description'])) ?></div>
        <div class="category">หมวดหมู่: <?= htmlspecialchars($product['category']) ?></div>
        <div>จำนวนสินค้า: <?= htmlspecialchars($product['amount']) ?></div>

        <p><a class="button" href="products.php">กลับไปหน้าสินค้า</a></p>
    </div>

</body>

</html>