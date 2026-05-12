<?php
class CartController extends BaseController
{
    public function index(): void
    {
        $cart     = $_SESSION['cart'] ?? [];
        $products = [];
        $total    = 0;

        if (!empty($cart)) {
            $productModel = new Product();
            foreach ($cart as $id => $item) {
                $p = $productModel->findById($id);
                if ($p) {
                    $products[] = array_merge($p, ['qty' => $item['qty']]);
                    $total += $p['price'] * $item['qty'];
                }
            }
        }

        $this->render('pages/cart', [
            'title'    => 'Корзина — ' . APP_NAME,
            'products' => $products,
            'total'    => $total,
        ]);
    }

    public function add(): void
    {
        if (!csrfVerify()) $this->renderJson(['error' => 'Ошибка безопасности'], 403);

        $id  = $_POST['id']  ?? '';
        $qty = (int)($_POST['qty'] ?? 1);

        $productModel = new Product();
        if (!$productModel->findById($id)) {
            $this->renderJson(['error' => 'Товар не найден'], 404);
        }

        $_SESSION['cart'][$id]['qty'] = ($_SESSION['cart'][$id]['qty'] ?? 0) + $qty;
        $this->renderJson(['count' => $this->cartCount(), 'ok' => true]);
    }

    public function remove(): void
    {
        if (!csrfVerify()) $this->renderJson(['error' => 'Ошибка безопасности'], 403);
        $id = $_POST['id'] ?? '';
        unset($_SESSION['cart'][$id]);
        redirect('/cart');
    }

    public function update(): void
    {
        if (!csrfVerify()) $this->renderJson(['error' => 'Ошибка безопасности'], 403);
        $id  = $_POST['id']  ?? '';
        $qty = (int)($_POST['qty'] ?? 0);

        if ($qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['qty'] = $qty;
        }
        redirect('/cart');
    }
}
