let currentCategory = '';

function filterProducts() {
  const input = document.getElementById('searchInput').value.toLowerCase();
  const cards = document.querySelectorAll('#productList .card');
  cards.forEach(card => {
    const name = card.getAttribute('data-name');
    const category = card.getAttribute('data-category');
    if (name.includes(input) && (currentCategory === '' || category === currentCategory)) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}

function filterByCategory(cat) {
  currentCategory = cat.toLowerCase();
  filterProducts();
}

function viewDetail(id) {
  window.location.href = 'product_detail.php?id=' + id;
}
