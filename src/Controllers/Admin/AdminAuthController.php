<?php
class AdminAuthController extends AdminBaseController
{
    public function loginForm(): void
    {
        if (!empty($_SESSION[SESSION_ADMIN_KEY])) {
            header('Location: /admin'); exit;
        }
        $error = flashGet('error');
        include SRC . '/Views/admin/pages/login.php';
    }

    public function login(): void
    {
        if (!csrfVerify()) { flashSet('error', 'Ошибка безопасности'); header('Location: /admin/login'); exit; }

        $login    = trim($_POST['login']    ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($login === ADMIN_LOGIN && password_verify($password, ADMIN_PASSWORD_HASH)) {
            $_SESSION[SESSION_ADMIN_KEY] = ['login' => $login, 'at' => time()];
            header('Location: /admin'); exit;
        }

        flashSet('error', 'Неверный логин или пароль');
        header('Location: /admin/login'); exit;
    }

    public function logout(): void
    {
        unset($_SESSION[SESSION_ADMIN_KEY]);
        header('Location: /admin/login'); exit;
    }
}
