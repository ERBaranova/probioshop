<?php
class JsonModel
{
    protected string $file;

    protected function readAll(): array
    {
        if (!file_exists($this->file)) return [];
        $json = file_get_contents($this->file);
        return json_decode($json, true) ?? [];
    }

    protected function writeAll(array $data): void
    {
        $dir = dirname($this->file);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents(
            $this->file,
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            LOCK_EX
        );
    }

    protected function generateId(): string
    {
        return date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
    }
}
