document.getElementById('registerForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const form = e.target;
      const pwd = form.password.value;
      const cpwd = form.confirm_password.value;

      if (pwd !== cpwd) {
        alert('รหัสผ่านไม่ตรงกัน!');
        return;
      }

      fetch('php/check_admin.php')
        .then(res => res.json())
        .then(data => {
          if (data.admin_exists && form.role.value === 'admin') {
            alert('มีผู้ดูแลระบบ (admin) อยู่แล้ว ไม่สามารถลงทะเบียนใหม่เป็น admin ได้');
          } else {
            form.submit();
          }
        })
        .catch(() => alert('เกิดข้อผิดพลาด ตรวจสอบการเชื่อมต่อ'));
    });