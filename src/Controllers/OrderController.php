<?php
class OrderController extends BaseController
{
    public function index(): void
    {
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) redirect('/cart');

        $productModel = new Product();
        $items = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $p = $productModel->findById($id);
            if ($p) {
                $items[] = array_merge($p, ['qty' => $item['qty']]);
                $total  += $p['price'] * $item['qty'];
            }
        }

        $user = currentUser();
        $this->render('pages/order', [
            'title'  => 'Оформление заказа — ' . APP_NAME,
            'items'  => $items,
            'total'  => $total,
            'user'   => $user,
        ]);
    }

    public function place(): void
    {
        if (!csrfVerify()) { flashSet('error', 'Ошибка безопасности'); redirect('/order'); }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) redirect('/cart');

        // Собираем items
        $productModel = new Product();
        $items = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $p = $productModel->findById($id);
            if ($p) {
                $items[] = [
                    'id'    => $id,
                    'name'  => $p['name'],
                    'price' => $p['price'],
                    'qty'   => $item['qty'],
                ];
                $total += $p['price'] * $item['qty'];
            }
        }

        $user = currentUser();
        $orderModel = new Order();
        $order = $orderModel->create([
            'user_id'     => $user['id'] ?? null,
            'client_type' => $_POST['client_type'] ?? CLIENT_PRIVATE,
            'name'        => trim($_POST['name']    ?? ''),
            'phone'       => trim($_POST['phone']   ?? ''),
            'email'       => trim($_POST['email']   ?? ''),
            'address'     => trim($_POST['address'] ?? ''),
            'company'     => trim($_POST['company'] ?? ''),
            'comment'     => trim($_POST['comment'] ?? ''),
            'items'       => $items,
            'total'       => $total,
        ]);

        // Очищаем корзину
        Mailer::newOrder($order);
        Mailer::orderConfirmation($order);
        unset($_SESSION['cart']);
        $_SESSION['last_order_id'] = $order['id'];

        redirect('/order/success');
    }

    public function success(): void
    {
        $orderId = $_SESSION['last_order_id'] ?? null;
        $this->render('pages/order_success', [
            'title'   => 'Заказ оформлен — ' . APP_NAME,
            'orderId' => $orderId,
        ]);
    }
}
