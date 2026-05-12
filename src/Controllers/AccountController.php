<?php
class AccountController extends BaseController
{
    public function index(): void
    {
        requireAuth();
        $user = currentUser();
        $orderModel = new Order();
        $orders = array_slice(
            array_reverse($orderModel->findByUserId($user['id'])),
            0, 5
        );

        $this->render('pages/account', [
            'title'  => 'Личный кабинет — ' . APP_NAME,
            'user'   => $user,
            'orders' => $orders,
        ]);
    }

    public function orders(): void
    {
        requireAuth();
        $user = currentUser();
        $orderModel = new Order();
        $orders = array_reverse($orderModel->findByUserId($user['id']));

        $this->render('pages/account_orders', [
            'title'  => 'Мои заказы — ' . APP_NAME,
            'user'   => $user,
            'orders' => $orders,
        ]);
    }

    public function profile(): void
    {
        requireAuth();
        $this->render('pages/account_profile', [
            'title' => 'Мои данные — ' . APP_NAME,
            'user'  => currentUser(),
            'ok'    => flashGet('ok'),
            'error' => flashGet('error'),
        ]);
    }

    public function updateProfile(): void
    {
        requireAuth();
        if (!csrfVerify()) { flashSet('error', 'Ошибка безопасности'); redirect('/account/profile'); }

        $user      = currentUser();
        $userModel = new User();
        $userModel->update($user['id'], [
            'name'    => trim($_POST['name']    ?? ''),
            'phone'   => trim($_POST['phone']   ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'company' => trim($_POST['company'] ?? ''),
        ]);

        // Обновляем сессию
        $updated = $userModel->findById($user['id']);
        unset($updated['password']);
        $_SESSION[SESSION_USER_KEY] = $updated;

        flashSet('ok', 'Данные сохранены');
        redirect('/account/profile');
    }
}
