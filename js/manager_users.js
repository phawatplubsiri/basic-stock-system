function fillEditForm(id, username, firstname, lastname, email) {
            const form = document.getElementById('editForm');
            form.style.display = 'block';
            form.id.value = id;
            form.username.value = username;
            form.firstname.value = firstname;
            form.lastname.value = lastname;
            form.email.value = email;
            window.scrollTo(0, document.body.scrollHeight);
        }

function cancelEdit() {
            const form = document.getElementById('editForm');
            form.style.display = 'none';
            form.reset();
        }