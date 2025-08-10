function fillEditForm(id, name, img_url, price, amount, description, category) {
  const form = document.getElementById('editForm');
  form.style.display = 'block';
  form.id.value = id;
  form.name.value = name;
  form.img_url.value = img_url;
  form.price.value = price;
  form.amount.value = amount;
  form.description.value = description;
  form.category.value = category;
  window.scrollTo(0, document.body.scrollHeight);
}

function cancelEdit() {
  const form = document.getElementById('editForm');
  form.style.display = 'none';
  form.reset();
}
