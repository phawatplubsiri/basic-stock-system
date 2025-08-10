<?php
// manage_users.php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

require 'php/db.php';

// ดึงข้อมูลลูกค้าทั้งหมด ยกเว้น admin
$sql = "SELECT id, username, firstname, lastname, email, role FROM users WHERE role='user' ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/manage_users.css" />
    <title>จัดการข้อมูลลูกค้า</title>
</head>

<body>
    <p><a href="admin.php">กลับหน้าหลัก</a></p>
    <h2>จัดการข้อมูลลูกค้า (User)</h2>

    <h3>เพิ่มลูกค้าใหม่</h3>
    <form class="add-user-form" method="POST" action="php/user_action.php">
        <input type="hidden" name="action" value="add" />
        <input type="text" name="username" placeholder="Username" required />
        <input type="text" name="firstname" placeholder="First Name" required />
        <input type="text" name="lastname" placeholder="Last Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">เพิ่มลูกค้า</button>
    </form>

    <h3>รายชื่อลูกค้า</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['firstname']) ?></td>
                    <td><?= htmlspecialchars($row['lastname']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <form class="inline" method="POST" action="php/user_action.php" onsubmit="return confirm('ต้องการลบลูกค้าคนนี้หรือไม่?');">
                            <input type="hidden" name="action" value="delete" />
                            <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                            <button type="submit" class="btn-delete">ลบ</button>
                        </form>
                        <button class="btn-change" onclick="fillEditForm('<?= htmlspecialchars($row['id']) ?>', '<?= htmlspecialchars($row['username']) ?>', '<?= htmlspecialchars($row['firstname']) ?>', '<?= htmlspecialchars($row['lastname']) ?>', '<?= htmlspecialchars($row['email']) ?>')">แก้ไข</button>

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <form method="POST" action="php/user_action.php" id="editForm" style="display:none;">
        <input type="hidden" name="action" value="edit" />
        <input type="hidden" name="id" name="id" />
        <input type="text" name="username" placeholder="Username" required />
        <input type="text" name="firstname" placeholder="First Name" required />
        <input type="text" name="lastname" placeholder="Last Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <button type="submit">บันทึกการแก้ไข</button>
        <button type="button" onclick="cancelEdit()">ยกเลิก</button>
    </form>

   

    <script src="js/manager_users.js"></script>
</body>

</html>