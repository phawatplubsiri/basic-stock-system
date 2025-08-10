<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

require 'php/db.php';

// ดึง category ทั้งหมดสำหรับกรอง
$categoryResult = $conn->query("SELECT DISTINCT category FROM product WHERE category IS NOT NULL AND category != ''");

// ดึงสินค้าทั้งหมด
$productResult = $conn->query("SELECT * FROM product ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/products.css" />
    <title>สินค้า</title>
</head>

<body>

    <h2>รายการสินค้า</h2>
    <p>สวัสดี คุณ <?php echo htmlspecialchars($_SESSION['username']); ?> (<a href="php/logout.php">ออกจากระบบ</a>)</p>

    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="ค้นหาสินค้าจากชื่อ..." onkeyup="filterProducts()" />
    </div>

    <div class="category-filter">
        <label>กรองหมวดหมู่: </label>
        <button onclick="filterByCategory('')">ทั้งหมด</button>
        <?php while ($cat = $categoryResult->fetch_assoc()): ?>
            <button onclick="filterByCategory('<?= htmlspecialchars($cat['category']) ?>')"><?= htmlspecialchars($cat['category']) ?></button>
        <?php endwhile; ?>
    </div>

    <div class="card-container" id="productList">
        <?php while ($product = $productResult->fetch_assoc()): ?>
            <div class="card" data-name="<?= strtolower(htmlspecialchars($product['name'])) ?>" data-category="<?= strtolower(htmlspecialchars($product['category'])) ?>">
                <?php if (!empty($product['img_url'])): ?>
                    <img src="<?= htmlspecialchars($product['img_url']) ?>" alt="รูปสินค้า" />
                <?php else: ?>
                    <div style="height:120px; background:#eee; display:flex;align-items:center;justify-content:center;">ไม่มีรูป</div>
                <?php endif; ?>
                <div class="name"><?= htmlspecialchars($product['name']) ?></div>
                <div class="price"><?= number_format($product['price'], 2) ?> บาท</div>
                <button onclick="viewDetail(<?= $product['id'] ?>)">ดูรายละเอียด</button>
            </div>
        <?php endwhile; ?>
    </div>

    <script src="js/products.js"></script>
</body>
</html>