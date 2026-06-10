<?php
class AdminDashboardController extends AdminBaseController
{
    public function index(): void
    {
        $this->requireAdmin();

        $orderModel = new Order();
        $allOrders  = $orderModel->all();

        // Последние 5 заказов
        $recentOrders = array_slice(array_reverse($allOrders), 0, 5);

        // Статистика по статусам
        $byStatus = [];
        foreach ($allOrders as $o) {
            $byStatus[$o['status']] = ($byStatus[$o['status']] ?? 0) + 1;
        }

        $this->render('dashboard', [
            'title'        => 'Дашборд — Админ',
            'stats'        => $this->stats(),
            'recentOrders' => $recentOrders,
            'byStatus'     => $byStatus,
        ]);
    }
}
