<?php
class Product extends JsonModel
{
    protected string $file = DATA_PRODUCTS;

    public function all(): array
    {
        return $this->readAll();
    }

    public function findBySlug(string $slug): ?array
    {
        foreach ($this->readAll() as $product) {
            if ($product['slug'] === $slug) return $product;
        }
        return null;
    }

    public function findById(string $id): ?array
    {
        foreach ($this->readAll() as $product) {
            if ($product['id'] === $id) return $product;
        }
        return null;
    }

    /** Фильтрация: audience=private|business, category=slug */
    public function filter(array $params = []): array
    {
        $products = $this->readAll();

        if (!empty($params['audience'])) {
            $products = array_filter($products, fn($p) =>
                in_array($params['audience'], $p['audience'] ?? [])
            );
        }

        if (!empty($params['category'])) {
            $products = array_filter($products, fn($p) =>
                $p['category'] === $params['category']
            );
        }

        if (!empty($params['search'])) {
            $q = mb_strtolower($params['search'], 'UTF-8');
            $products = array_filter($products, fn($p) =>
                str_contains(mb_strtolower($p['name'], 'UTF-8'), $q) ||
                str_contains(mb_strtolower($p['description'] ?? '', 'UTF-8'), $q)
            );
        }

        // Сортировка
        $sort = $params['sort'] ?? 'default';
        if ($sort === 'price_asc') {
            usort($products, fn($a, $b) => $a['price'] <=> $b['price']);
        } elseif ($sort === 'price_desc') {
            usort($products, fn($a, $b) => $b['price'] <=> $a['price']);
        }

        return array_values($products);
    }

    public function save(array $product): void
    {
        $all = $this->readAll();
        foreach ($all as &$p) {
            if ($p['id'] === $product['id']) {
                $p = $product;
                $this->writeAll($all);
                return;
            }
        }
        $all[] = $product;
        $this->writeAll($all);
    }
}
