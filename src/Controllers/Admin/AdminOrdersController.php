<?php
class AdminOrdersController extends AdminBaseController
{
    public function index(): void
    {
        $this->requireAdmin();

        $orderModel = new Order();
        $all        = array_reverse($orderModel->all());

        // Фильтр по статусу
        $filterStatus = $_GET['status'] ?? '';
        if ($filterStatus) {
            $all = array_values(array_filter($all, fn($o) => $o['status'] === $filterStatus));
        }

        $this->render('orders', [
            'title'        => 'Заказы — Админ',
            'orders'       => $all,
            'filterStatus' => $filterStatus,
            'stats'        => $this->stats(),
        ]);
    }

    public function show(array $params): void
    {
        $this->requireAdmin();

        $order = (new Order())->findById($params['id']);
        if (!$order) { http_response_code(404); echo 'Заказ не найден'; return; }

        $this->render('order_detail', [
            'title' => 'Заказ ' . $params['id'] . ' — Админ',
            'order' => $order,
            'stats' => $this->stats(),
        ]);
    }

    public function updateStatus(array $params): void
    {
        $this->requireAdmin();
        if (!csrfVerify()) { echo 'CSRF error'; return; }

        $status     = $_POST['status'] ?? '';
        $validStatuses = ['new', 'processing', 'shipped', 'done', 'cancelled'];

        if (in_array($status, $validStatuses)) {
            (new Order())->updateStatus($params['id'], $status);
        }

        header('Location: /admin/orders/' . $params['id']); exit;
    }
}
