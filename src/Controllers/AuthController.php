<?php
class AuthController extends BaseController
{
    public function loginForm(): void
    {
        if (isLoggedIn()) redirect('/account');
        $this->render('pages/login', [
            'title' => 'Войти — ' . APP_NAME,
            'error' => flashGet('error'),
        ]);
    }

    public function login(): void
    {
        if (!csrfVerify()) { flashSet('error', 'Ошибка безопасности'); redirect('/login'); }

        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        $userModel = new User();
        $user      = $userModel->verify($email, $password);

        if (!$user) {
            flashSet('error', 'Неверный email или пароль');
            redirect('/login');
        }

        unset($user['password']);
        $_SESSION[SESSION_USER_KEY] = $user;
        redirect('/account');
    }

    public function registerForm(): void
    {
        if (isLoggedIn()) redirect('/account');
        $this->render('pages/register', [
            'title' => 'Регистрация — ' . APP_NAME,
            'error' => flashGet('error'),
        ]);
    }

    public function register(): void
    {
        if (!csrfVerify()) { flashSet('error', 'Ошибка безопасности'); redirect('/register'); }

        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');
        $name     = trim($_POST['name']     ?? '');

        if (!$email || !$password || !$name) {
            flashSet('error', 'Заполните все обязательные поля');
            redirect('/register');
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            flashSet('error', 'Этот email уже зарегистрирован');
            redirect('/register');
        }

        $user = $userModel->create([
            'name'        => $name,
            'email'       => $email,
            'phone'       => $_POST['phone'] ?? '',
            'password'    => $password,
            'client_type' => $_POST['client_type'] ?? CLIENT_PRIVATE,
        ]);

        unset($user['password']);
        $_SESSION[SESSION_USER_KEY] = $user;
        redirect('/account');
    }

    public function logout(): void
    {
        unset($_SESSION[SESSION_USER_KEY]);
        redirect('/');
    }
}
