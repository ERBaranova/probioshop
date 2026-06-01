<?php
class Mailer
{
    private static function send(string $to, string $subject, string $body): bool
    {
        $host     = MAIL_HOST;
        $port     = MAIL_PORT;
        $user     = MAIL_USER;
        $password = MAIL_PASSWORD;
        $from     = MAIL_FROM;
        $name     = MAIL_NAME;

        // Подключаемся по SSL
        $socket = fsockopen("ssl://{$host}", $port, $errno, $errstr, 10);
        if (!$socket) return false;

        $read = fn() => fgets($socket, 512);
        $write = fn($s) => fputs($socket, $s . "\r\n");

        $read(); // приветствие
        $write("EHLO probio-clean.ru"); while (($r = $read()) && substr($r, 3, 1) === '-');
        $write("AUTH LOGIN");          $read();
        $write(base64_encode($user));  $read();
        $write(base64_encode($password)); $read();
        $write("MAIL FROM:<{$from}>"); $read();
        $write("RCPT TO:<{$to}>");     $read();
        $write("DATA");                $read();

        $boundary = md5(uniqid());
        $headers  = implode("\r\n", [
            "From: =?UTF-8?B?" . base64_encode($name) . "?= <{$from}>",
            "To: {$to}",
            "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=",
            "MIME-Version: 1.0",
            "Content-Type: text/html; charset=UTF-8",
            "Content-Transfer-Encoding: base64",
        ]);

        $write($headers . "\r\n\r\n" . chunk_split(base64_encode($body)) . "\r\n.");
        $read();
        $write("QUIT");
        fclose($socket);
        return true;
    }

    // Уведомление о новом заказе — тебе
    public static function newOrder(array $order): void
    {
        $items = '';
        foreach ($order['items'] as $item) {
            $items .= "<tr>
                <td style='padding:6px 10px;border-bottom:1px solid #e5e7eb'>{$item['name']}</td>
                <td style='padding:6px 10px;border-bottom:1px solid #e5e7eb;text-align:center'>{$item['qty']}</td>
                <td style='padding:6px 10px;border-bottom:1px solid #e5e7eb;text-align:right'>" . number_format($item['price'] * $item['qty'], 0, ',', ' ') . " ₽</td>
            </tr>";
        }

        $delivery = match($order['delivery'] ?? '') {
            'courier' => 'Курьер', 'post' => 'Почта России',
            'sdek'    => 'СДЭК',   'pickup' => 'Самовывоз', default => '—'
        };
        $payment = match($order['payment'] ?? '') {
            'cash'        => 'Наличными при получении',
            'card_courier'=> 'Картой курьеру', default => '—'
        };

        $body = "
        <div style='font-family:sans-serif;max-width:600px;margin:0 auto'>
            <div style='background:#3d9e68;padding:20px;border-radius:8px 8px 0 0'>
                <h2 style='color:#fff;margin:0'>🛒 Новый заказ #{$order['id']}</h2>
            </div>
            <div style='background:#f9fafb;padding:20px;border:1px solid #e5e7eb'>
                <table style='width:100%;border-collapse:collapse;margin-bottom:16px'>
                    <tr><td style='padding:6px 0;color:#6b7280;width:140px'>Клиент</td><td style='padding:6px 0;font-weight:600'>{$order['name']}</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Телефон</td><td style='padding:6px 0'>{$order['phone']}</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Email</td><td style='padding:6px 0'>{$order['email']}</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Адрес</td><td style='padding:6px 0'>{$order['address']}</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Доставка</td><td style='padding:6px 0'>{$delivery}</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Оплата</td><td style='padding:6px 0'>{$payment}</td></tr>
                    " . (!empty($order['comment']) ? "<tr><td style='padding:6px 0;color:#6b7280'>Комментарий</td><td style='padding:6px 0'>{$order['comment']}</td></tr>" : "") . "
                </table>
                <table style='width:100%;border-collapse:collapse;background:#fff;border-radius:6px;overflow:hidden;border:1px solid #e5e7eb'>
                    <thead><tr style='background:#f3f4f6'>
                        <th style='padding:8px 10px;text-align:left;font-size:12px;color:#6b7280'>Товар</th>
                        <th style='padding:8px 10px;text-align:center;font-size:12px;color:#6b7280'>Кол-во</th>
                        <th style='padding:8px 10px;text-align:right;font-size:12px;color:#6b7280'>Сумма</th>
                    </tr></thead>
                    <tbody>{$items}</tbody>
                    <tfoot><tr style='background:#f9fafb'>
                        <td colspan='2' style='padding:10px;font-weight:700;text-align:right'>Итого:</td>
                        <td style='padding:10px;font-weight:700;text-align:right;color:#1a5235'>" . number_format($order['total'], 0, ',', ' ') . " ₽</td>
                    </tr></tfoot>
                </table>
                <div style='margin-top:16px;text-align:center'>
                    <a href='https://probio-clean.ru/admin/orders/{$order['id']}' 
                       style='background:#3d9e68;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-weight:600'>
                        Открыть в админке →
                    </a>
                </div>
            </div>
        </div>";

        self::send(ADMIN_EMAIL, "Новый заказ #{$order['id']} — Probio-Clean", $body);
    }

    // Уведомление о новой B2B заявке — тебе
    public static function newB2bLead(array $lead): void
    {
        $interests = implode(', ', array_map(
            fn($i) => B2bLead::interestOptions()[$i] ?? $i,
            $lead['interests'] ?? []
        ));

        $body = "
        <div style='font-family:sans-serif;max-width:600px;margin:0 auto'>
            <div style='background:#1a5235;padding:20px;border-radius:8px 8px 0 0'>
                <h2 style='color:#fff;margin:0'>💼 Новая B2B заявка</h2>
            </div>
            <div style='background:#f9fafb;padding:20px;border:1px solid #e5e7eb'>
                <table style='width:100%;border-collapse:collapse'>
                    <tr><td style='padding:6px 0;color:#6b7280;width:160px'>Компания</td><td style='padding:6px 0;font-weight:600'>{$lead['company']}</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Контакт</td><td style='padding:6px 0'>{$lead['name']}</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Телефон</td><td style='padding:6px 0'>{$lead['phone']}</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Email</td><td style='padding:6px 0'>{$lead['email']}</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Тип объекта</td><td style='padding:6px 0'>" . (B2bLead::objectTypes()[$lead['object_type']] ?? '—') . "</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Интересует</td><td style='padding:6px 0'>{$interests}</td></tr>
                    <tr><td style='padding:6px 0;color:#6b7280'>Объём/мес.</td><td style='padding:6px 0'>" . (B2bLead::volumeOptions()[$lead['volume']] ?? '—') . "</td></tr>
                    " . (!empty($lead['comment']) ? "<tr><td style='padding:6px 0;color:#6b7280'>Комментарий</td><td style='padding:6px 0'>{$lead['comment']}</td></tr>" : "") . "
                </table>
                <div style='margin-top:16px;text-align:center'>
                    <a href='https://probio-clean.ru/admin/b2b' 
                       style='background:#1a5235;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-weight:600'>
                        Открыть в админке →
                    </a>
                </div>
            </div>
        </div>";

        self::send(ADMIN_EMAIL, "Новая B2B заявка — {$lead['company']}", $body);
    }

    // Подтверждение покупателю
    public static function orderConfirmation(array $order): void
    {
        if (empty($order['email'])) return;

        $body = "
        <div style='font-family:sans-serif;max-width:600px;margin:0 auto'>
            <div style='background:#3d9e68;padding:20px;border-radius:8px 8px 0 0'>
                <h2 style='color:#fff;margin:0'>✅ Ваш заказ принят!</h2>
            </div>
            <div style='background:#f9fafb;padding:24px;border:1px solid #e5e7eb'>
                <p style='margin-bottom:16px'>Здравствуйте, <strong>{$order['name']}</strong>!</p>
                <p style='margin-bottom:16px'>Ваша заявка <strong>#{$order['id']}</strong> успешно принята. Наш менеджер свяжется с вами в течение рабочего дня для подтверждения заказа и уточнения деталей доставки.</p>
                <div style='background:#eaf7ef;border-radius:6px;padding:16px;margin-bottom:16px'>
                    <div style='font-size:13px;color:#1a5235;font-weight:600;margin-bottom:8px'>Сумма заказа: " . number_format($order['total'], 0, ',', ' ') . " ₽</div>
                    <div style='font-size:12px;color:#2a7d50'>Номер заказа: #{$order['id']}</div>
                </div>
                <p style='font-size:13px;color:#6b7280'>С уважением,<br>Команда Probio-Clean</p>
            </div>
        </div>";

        self::send($order['email'], "Заказ #{$order['id']} принят — Probio-Clean", $body);
    }
}
