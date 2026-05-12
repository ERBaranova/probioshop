<?php
class Order extends JsonModel
{
    protected string $file = DATA_ORDERS;

    public function all(): array
    {
        return $this->readAll();
    }

    public function findById(string $id): ?array
    {
        foreach ($this->readAll() as $order) {
            if ($order['id'] === $id) return $order;
        }
        return null;
    }

    public function findByUserId(string $userId): array
    {
        return array_values(array_filter(
            $this->readAll(),
            fn($o) => $o['user_id'] === $userId
        ));
    }

    public function create(array $data): array
    {
        $order = [
            'id'          => $this->generateId(),
            'user_id'     => $data['user_id'] ?? null,
            'client_type' => $data['client_type'] ?? CLIENT_PRIVATE,
            'name'        => $data['name'],
            'phone'       => $data['phone'],
            'email'       => $data['email'],
            'address'     => $data['address'] ?? '',
            'company'     => $data['company'] ?? '',
            'comment'     => $data['comment'] ?? '',
            'items'       => $data['items'],
            'total'       => $data['total'],
            'status'      => 'new',       // new | processing | shipped | done | cancelled
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        $all   = $this->readAll();
        $all[] = $order;
        $this->writeAll($all);

        return $order;
    }

    public function updateStatus(string $id, string $status): bool
    {
        $all = $this->readAll();
        foreach ($all as &$order) {
            if ($order['id'] === $id) {
                $order['status'] = $status;
                $this->writeAll($all);
                return true;
            }
        }
        return false;
    }

    public static function statusLabel(string $status): string
    {
        return match($status) {
            'new'        => 'Новый',
            'processing' => 'В обработке',
            'shipped'    => 'Отправлен',
            'done'       => 'Выполнен',
            'cancelled'  => 'Отменён',
            default      => $status,
        };
    }
}
