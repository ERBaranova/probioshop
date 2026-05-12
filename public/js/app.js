// Добавить товар в корзину (AJAX)
document.addEventListener('click', async (e) => {
    const btn = e.target.closest('[data-add-cart]');
    if (!btn) return;

    const id   = btn.dataset.addCart;
    const csrf = document.querySelector('meta[name="csrf"]')?.content ?? '';

    btn.disabled = true;
    const orig = btn.textContent;
    btn.textContent = '...';

    try {
        const res  = await fetch('/cart/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${encodeURIComponent(id)}&qty=1&_csrf=${encodeURIComponent(csrf)}`,
        });
        const data = await res.json();

        if (data.ok) {
            btn.textContent = '✓ В корзине';
            // Обновляем счётчик в шапке
            const badge = document.querySelector('.cart-badge');
            if (badge) {
                badge.textContent = data.count;
            } else {
                const cartBtn = document.querySelector('.btn-cart');
                if (cartBtn) {
                    const b = document.createElement('span');
                    b.className = 'cart-badge';
                    b.textContent = data.count;
                    cartBtn.appendChild(b);
                }
            }
            setTimeout(() => { btn.textContent = orig; btn.disabled = false; }, 2000);
        }
    } catch {
        btn.textContent = orig;
        btn.disabled = false;
    }
});
