<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="css/register.css" />

  <title>Register</title>
</head>

<body>
  <div class="form-auth">
    <h2>สมัครสมาชิก</h2>
    <form id="registerForm" method="POST" action="php/register_action.php">
      <input type="text" id="username" name="username" placeholder="Username" required />
      <input type="text" id="firstname" name="firstname" placeholder="First Name" required />
      <input type="text" id="lastname" name="lastname" placeholder="Last Name" required />
      <input type="email" id="email" name="email" placeholder="Email" required />
      <input type="password" id="password" name="password" placeholder="Password" required />
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required />

      <select name="role" id="roleSelect" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>

      <button type="submit">สมัครสมาชิก</button>
    </form>

    <p>มีบัญชีแล้ว? <a href="index.php">เข้าสู่ระบบ</a></p>
  </div>

  <script src="js/register.js"></script>
</body>

</html>
