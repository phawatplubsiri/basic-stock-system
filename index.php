<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="css/login.css" />
  <title>Login</title>
</head>

<body>
  <div class="form-auth">
    <h2>เข้าสู่ระบบ</h2>
    <form method="POST" action="php/login.php">
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">เข้าสู่ระบบ</button>
    </form>
    <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
  </div>

  <?php
  session_start();
  if (!empty($_SESSION['login_error'])) {
    echo "<p style='color:red'>" . $_SESSION['login_error'] . "</p>";
    unset($_SESSION['login_error']);
  }
  ?>
</body>
</html>