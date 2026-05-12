<?php
class User extends JsonModel
{
    protected string $file = DATA_USERS;

    public function findByEmail(string $email): ?array
    {
        foreach ($this->readAll() as $user) {
            if ($user['email'] === $email) return $user;
        }
        return null;
    }

    public function findById(string $id): ?array
    {
        foreach ($this->readAll() as $user) {
            if ($user['id'] === $id) return $user;
        }
        return null;
    }

    public function create(array $data): array
    {
        $user = [
            'id'           => $this->generateId(),
            'name'         => $data['name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'] ?? '',
            'password'     => password_hash($data['password'], PASSWORD_BCRYPT),
            'client_type'  => $data['client_type'] ?? CLIENT_PRIVATE,
            'company'      => $data['company'] ?? '',
            'address'      => $data['address'] ?? '',
            'created_at'   => date('Y-m-d H:i:s'),
        ];

        $all   = $this->readAll();
        $all[] = $user;
        $this->writeAll($all);

        return $user;
    }

    public function update(string $id, array $fields): bool
    {
        $all = $this->readAll();
        foreach ($all as &$user) {
            if ($user['id'] === $id) {
                // Защита: не перезаписываем пароль и id напрямую
                unset($fields['id'], $fields['password']);
                $user = array_merge($user, $fields);
                $this->writeAll($all);
                return true;
            }
        }
        return false;
    }

    public function verify(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
