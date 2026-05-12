<?php
class AdminUsersController extends AdminBaseController
{
    public function index(): void
    {
        $this->requireAdmin();
        $users = file_exists(DATA_USERS)
            ? json_decode(file_get_contents(DATA_USERS), true) ?? []
            : [];

        // Считаем заказов на каждого пользователя
        $orderModel = new Order();
        $allOrders  = $orderModel->all();
        $ordersByUser = [];
        foreach ($allOrders as $o) {
            if ($o['user_id']) $ordersByUser[$o['user_id']] = ($ordersByUser[$o['user_id']] ?? 0) + 1;
        }

        $this->render('users', [
            'title'        => 'Пользователи — Админ',
            'users'        => array_reverse($users),
            'ordersByUser' => $ordersByUser,
            'stats'        => $this->stats(),
        ]);
    }
}
