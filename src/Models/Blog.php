<?php

class Blog
{
    private string $dataDir;
    private string $indexFile;
    private array $index;

    public function __construct()
    {
        $this->dataDir   = dirname(__DIR__, 2) . '/data/blog/articles/';
        $this->indexFile = dirname(__DIR__, 2) . '/data/blog/index.json';
        $this->index     = $this->loadIndex();
    }

    // ── Index ──────────────────────────────────────────────────────────────

    private function loadIndex(): array
    {
        if (!file_exists($this->indexFile)) {
            return ['categories' => [], 'articles' => []];
        }
        return json_decode(file_get_contents($this->indexFile), true) ?? ['categories' => [], 'articles' => []];
    }

    private function saveIndex(): void
    {
        file_put_contents(
            $this->indexFile,
            json_encode($this->index, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }

    // ── Public read methods ────────────────────────────────────────────────

    /**
     * Все опубликованные статьи (только мета, без content).
     */
    public function getAll(string $category = '', string $search = ''): array
    {
        $articles = array_filter(
            $this->index['articles'],
            fn($a) => $a['published'] === true
        );

        if ($category) {
            $articles = array_filter($articles, fn($a) => $a['category'] === $category);
        }

        if ($search) {
            $q = mb_strtolower($search);
            $articles = array_filter($articles, function ($a) use ($q) {
                return str_contains(mb_strtolower($a['title']), $q)
                    || str_contains(mb_strtolower($a['preview']), $q)
                    || !empty(array_filter($a['tags'], fn($t) => str_contains(mb_strtolower($t), $q)));
            });
        }

        // Сортировка: свежие сверху
        usort($articles, fn($a, $b) => strcmp($b['published_at'], $a['published_at']));

        return array_values($articles);
    }

    /**
     * Статья с полным content по slug.
     */
    public function getBySlug(string $slug): ?array
    {
        $file = $this->dataDir . $slug . '.json';
        if (!file_exists($file)) {
            return null;
        }
        $article = json_decode(file_get_contents($file), true);
        if (!$article || !($article['published'] ?? false)) {
            return null;
        }
        return $article;
    }

    /**
     * Для админки — все статьи включая неопубликованные.
     */
    public function getAllAdmin(): array
    {
        $articles = $this->index['articles'];
        usort($articles, fn($a, $b) => strcmp($b['published_at'], $a['published_at']));
        return $articles;
    }

    /**
     * Статья по slug без проверки published (для редактирования).
     */
    public function getBySlugAdmin(string $slug): ?array
    {
        $file = $this->dataDir . $slug . '.json';
        if (!file_exists($file)) {
            return null;
        }
        return json_decode(file_get_contents($file), true);
    }

    /**
     * Список категорий.
     */
    public function getCategories(): array
    {
        return $this->index['categories'] ?? [];
    }

    /**
     * Соседние статьи (prev/next) для навигации внутри статьи.
     */
    public function getAdjacentArticles(string $slug): array
    {
        $published = array_values(array_filter(
            $this->index['articles'],
            fn($a) => $a['published'] === true
        ));
        usort($published, fn($a, $b) => strcmp($b['published_at'], $a['published_at']));

        $idx = array_search($slug, array_column($published, 'slug'));
        return [
            'prev' => ($idx !== false && $idx > 0) ? $published[$idx - 1] : null,
            'next' => ($idx !== false && $idx < count($published) - 1) ? $published[$idx + 1] : null,
        ];
    }

    // ── Write methods ──────────────────────────────────────────────────────

    public function save(array $data): bool
    {
        $slug = $data['slug'];
        $file = $this->dataDir . $slug . '.json';

        // Сохраняем полный файл статьи
        $saved = file_put_contents(
            $file,
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        if ($saved === false) {
            return false;
        }

        // Обновляем index.json (только мета, без content)
        $meta = $this->buildMeta($data);
        $existing = array_search($slug, array_column($this->index['articles'], 'slug'));

        if ($existing !== false) {
            $this->index['articles'][$existing] = $meta;
        } else {
            $this->index['articles'][] = $meta;
        }

        $this->saveIndex();
        return true;
    }

    public function delete(string $slug): bool
    {
        $file = $this->dataDir . $slug . '.json';
        if (file_exists($file)) {
            unlink($file);
        }

        $this->index['articles'] = array_values(array_filter(
            $this->index['articles'],
            fn($a) => $a['slug'] !== $slug
        ));

        $this->saveIndex();
        return true;
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    private function buildMeta(array $data): array
    {
        return [
            'id'           => $data['id'],
            'slug'         => $data['slug'],
            'title'        => $data['title'],
            'category'     => $data['category'],
            'tags'         => $data['tags'] ?? [],
            'published_at' => $data['published_at'],
            'updated_at'   => $data['updated_at'] ?? date('Y-m-d'),
            'published'    => (bool)($data['published'] ?? false),
            'preview'      => $data['preview'],
        ];
    }

    public static function generateSlug(string $title): string
    {
        $map = [
            'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'yo',
            'ж'=>'zh','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m',
            'н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u',
            'ф'=>'f','х'=>'h','ц'=>'ts','ч'=>'ch','ш'=>'sh','щ'=>'sch',
            'ъ'=>'','ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya',
            ' '=>'-','_'=>'-',
        ];
        $slug = mb_strtolower($title);
        $slug = strtr($slug, $map);
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }

    public static function generateId(): string
    {
        return 'blog-' . date('YmdHis') . '-' . substr(md5(uniqid()), 0, 6);
    }
}
