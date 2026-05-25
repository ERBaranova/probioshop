<?php
/**
 * Webhook для автодеплоя с GitHub.
 * GitHub вызывает этот URL при каждом push в main.
 *
 * НАСТРОЙКА:
 * 1. В GitHub → Settings → Webhooks → Add webhook
 *    Payload URL: https://ВАШ_ДОМЕН/deploy.php
 *    Secret: придумай строку и вставь в DEPLOY_SECRET ниже
 * 2. Замени DEPLOY_SECRET на свой секрет
 * 3. Замени REPO_PATH на путь к папке проекта на хостинге
 */

define('DEPLOY_SECRET', 'bioclean2025secret');
define('REPO_PATH',     '/home/c/cr087350/bioclean');   // путь на хостинге
define('LOG_FILE',      REPO_PATH . '/storage/logs/deploy.log');
define('BRANCH',        'main');

// Проверяем подпись GitHub
$payload   = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$expected  = 'sha256=' . hash_hmac('sha256', $payload, DEPLOY_SECRET);

if (!hash_equals($expected, $signature)) {
    http_response_code(403);
    die('Forbidden: invalid signature');
}

$data   = json_decode($payload, true);
$branch = $data['ref'] ?? '';

// Деплоим только из main
if ($branch !== 'refs/heads/' . BRANCH) {
    http_response_code(200);
    die('Skipped: not ' . BRANCH);
}

// Выполняем git pull
$output = shell_exec(sprintf(
    'cd %s && git fetch origin %s && git reset --hard origin/%s 2>&1',
    escapeshellarg(REPO_PATH),
    escapeshellarg(BRANCH)
));

// Права на data/ после pull
shell_exec('chmod -R 755 ' . escapeshellarg(REPO_PATH . '/data'));

// Логируем
$log = sprintf("[%s] Push from %s\n%s\n---\n",
    date('Y-m-d H:i:s'),
    $data['pusher']['name'] ?? 'unknown',
    $output
);
file_put_contents(LOG_FILE, $log, FILE_APPEND);

http_response_code(200);
echo 'Deployed: ' . date('Y-m-d H:i:s');
