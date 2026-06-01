<?php
function e(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    return APP_URL . '/' . ltrim($path, '/');
}

function redirect(string $path): void
{
    header('Location: ' . url($path));
    exit;
}

function isLoggedIn(): bool
{
    return isset($_SESSION[SESSION_USER_KEY]);
}

function currentUser(): ?array
{
    return $_SESSION[SESSION_USER_KEY] ?? null;
}

function requireAuth(): void
{
    if (!isLoggedIn()) {
        redirect('/login');
    }
}

function formatPrice(int|float $price): string
{
    return number_format($price, 0, ',', ' ') . ' ' . CURRENCY;
}

function flashSet(string $type, string $message): void
{
    $_SESSION['_flash'][$type] = $message;
}

function flashGet(string $type): ?string
{
    $msg = $_SESSION['_flash'][$type] ?? null;
    unset($_SESSION['_flash'][$type]);
    return $msg;
}

function csrfToken(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrfVerify(): bool
{
    $token = $_POST['_csrf'] ?? '';
    return hash_equals($_SESSION['_csrf'] ?? '', $token);
}

function formatDate(string $date): string
{
    $months = ['','января','февраля','марта','апреля','мая','июня',
               'июля','августа','сентября','октября','ноября','декабря'];
    [$y, $m, $d] = explode('-', $date);
    return (int)$d . ' ' . $months[(int)$m] . ' ' . $y;
}

function nounForm(int $n, string $f1, string $f2, string $f5): string
{
    $n  = abs($n) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) return $f5;
    if ($n1 > 1  && $n1 < 5) return $f2;
    if ($n1 === 1) return $f1;
    return $f5;
}

function slug(string $str): string
{
    $str = mb_strtolower($str, 'UTF-8');
    $str = strtr($str, [
        'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'yo',
        'ж'=>'zh','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m',
        'н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u',
        'ф'=>'f','х'=>'kh','ц'=>'ts','ч'=>'ch','ш'=>'sh','щ'=>'sch',
        'ъ'=>'','ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya',' '=>'-',
    ]);
    return preg_replace('/[^a-z0-9\-]/', '', $str);
}
