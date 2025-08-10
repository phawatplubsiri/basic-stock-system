<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

require 'php/db.php';

$sql = "SELECT * FROM product ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/manage_products.css" />

    <title>จัดการข้อมูลสินค้า</title>
</head>

<body>
    <p><a href="admin.php">กลับหน้าหลัก</a></p>
    <h2>จัดการข้อมูลสินค้า</h2>

    <h3>เพิ่มสินค้าใหม่</h3>
    <form class="add-product" method="POST" action="php/product_action.php">
        <input type="hidden" name="action" value="add" />
        <div class="form-group"><input type="text" name="name" placeholder="ชื่อสินค้า" required /></div>
        <div class="form-group"><input type="text" name="img_url" placeholder="URL รูปภาพ (หรือ base64)" /></div>
        <div class="form-group"><input type="number" name="price" placeholder="ราคา" step="0.01" min="0" required /></div>
        <div class="form-group"><input type="number" name="amount" placeholder="จำนวนสินค้า" min="0" required /></div>
        <div class="form-group"><textarea name="description" placeholder="รายละเอียดสินค้า"></textarea></div>
        <div class="form-group"><input type="text" name="category" placeholder="หมวดหมู่สินค้า" /></div>
        <button type="submit">เพิ่มสินค้า</button>
    </form>

    <h3>สินค้าที่มีอยู่</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>รูปภาพ</th>
                <th>ชื่อ</th>
                <th>ราคา</th>
                <th>จำนวน</th>
                <th>หมวดหมู่</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td>
                        <?php if (!empty($row['img_url'])): ?>
                            <img src="<?= htmlspecialchars($row['img_url']) ?>" alt="รูปสินค้า" />
                        <?php else: ?>
                            ไม่มีรูป
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= number_format($row['price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['amount']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td>
               <button class="btn-change" onclick="fillEditForm(
            '<?= htmlspecialchars($row['id']) ?>',
            '<?= htmlspecialchars(addslashes($row['name'])) ?>',
            '<?= htmlspecialchars(addslashes($row['img_url'])) ?>',
            '<?= htmlspecialchars($row['price']) ?>',
            '<?= htmlspecialchars($row['amount']) ?>',
            `<?= htmlspecialchars(addslashes($row['description'])) ?>`,
            '<?= htmlspecialchars(addslashes($row['category'])) ?>'
          )">แก้ไข</button>

                        <form class="inline" method="POST" action="php/product_action.php" onsubmit="return confirm('ต้องการลบสินค้านี้หรือไม่?');">
                            <input type="hidden" name="action" value="delete" />
                            <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                            <button type="submit" class="btn-delete">ลบ</button>
             
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <form method="POST" action="php/product_action.php" id="editForm" style="display:none;">
        <input type="hidden" name="action" value="edit" />
        <input type="hidden" name="id" name="id" />
        <div class="form-group"><input type="text" name="name" placeholder="ชื่อสินค้า" required /></div>
        <div class="form-group"><input type="text" name="img_url" placeholder="URL รูปภาพ (หรือ base64)" /></div>
        <div class="form-group"><input type="number" name="price" placeholder="ราคา" step="0.01" min="0" required /></div>
        <div class="form-group"><input type="number" name="amount" placeholder="จำนวนสินค้า" min="0" required /></div>
        <div class="form-group"><textarea name="description" placeholder="รายละเอียดสินค้า"></textarea></div>
        <div class="form-group"><input type="text" name="category" placeholder="หมวดหมู่สินค้า" /></div>
        <button type="submit">บันทึกการแก้ไข</button>
        <button type="button" onclick="cancelEdit()">ยกเลิก</button>
    </form>




    <script src="js/manage_products.js"></script>
</body>

</html>