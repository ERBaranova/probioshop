<?php

class AdminBlogController extends AdminBaseController
{
    private Blog $blog;

    public function __construct()
    {
        parent::__construct();
        $this->blog = new Blog();
    }

    /** GET /admin/blog */
    public function index(): void
    {
        $articles   = $this->blog->getAllAdmin();
        $categories = $this->blog->getCategories();
        $this->render('blog', [
            'title'      => 'Блог — ' . APP_NAME,
            'articles'   => $articles,
            'categories' => $categories,
        ]);
    }

    /** GET /admin/blog/create */
    public function create(): void
    {
        $this->render('blog_form', [
            'title'      => 'Новая статья — ' . APP_NAME,
            'article'    => null,
            'categories' => $this->blog->getCategories(),
        ]);
    }

    /** POST /admin/blog/create */
    public function store(): void
    {
        $data = $this->validateAndBuild($_POST);
        if (!$data) {
            flashSet('error', 'Заполните все обязательные поля.');
            redirect('/admin/blog/create');
            return;
        }
        if ($this->blog->save($data)) {
            flashSet('success', 'Статья создана.');
            redirect('/admin/blog');
        } else {
            flashSet('error', 'Ошибка сохранения. Проверьте права на запись в data/blog/articles/.');
            redirect('/admin/blog/create');
        }
    }

    /** GET /admin/blog/edit/{slug} */
    public function edit(string $slug): void
    {
        $article = $this->blog->getBySlugAdmin($slug);
        if (!$article) {
            flashSet('error', 'Статья не найдена.');
            redirect('/admin/blog');
            return;
        }
        $this->render('blog_form', [
            'title'      => 'Редактировать — ' . APP_NAME,
            'article'    => $article,
            'categories' => $this->blog->getCategories(),
        ]);
    }

    /** POST /admin/blog/edit/{slug} */
    public function update(string $slug): void
    {
        $existing = $this->blog->getBySlugAdmin($slug);
        if (!$existing) { redirect('/admin/blog'); return; }

        $data = $this->validateAndBuild($_POST, $existing);
        if (!$data) {
            flashSet('error', 'Заполните все обязательные поля.');
            redirect('/admin/blog/edit/' . $slug);
            return;
        }

        if ($data['slug'] !== $slug) {
            $this->blog->delete($slug);
        }
        $data['updated_at'] = date('Y-m-d');

        if ($this->blog->save($data)) {
            flashSet('success', 'Статья обновлена.');
            redirect('/admin/blog');
        } else {
            flashSet('error', 'Ошибка сохранения.');
            redirect('/admin/blog/edit/' . $slug);
        }
    }

    /** POST /admin/blog/delete/{slug} */
    public function destroy(string $slug): void
    {
        $this->blog->delete($slug);
        flashSet('success', 'Статья удалена.');
        redirect('/admin/blog');
    }

    /** POST /admin/blog/toggle/{slug} */
    public function toggle(string $slug): void
    {
        $article = $this->blog->getBySlugAdmin($slug);
        if ($article) {
            $article['published']  = !$article['published'];
            $article['updated_at'] = date('Y-m-d');
            $this->blog->save($article);
        }
        redirect('/admin/blog');
    }

    // ── Private ──────────────────────────────────────────────────────────

    private function validateAndBuild(array $post, array $existing = []): ?array
    {
        $title   = trim($post['title']   ?? '');
        $content = trim($post['content'] ?? '');
        $preview = trim($post['preview'] ?? '');

        if (!$title || !$content || !$preview) return null;

        $slug = trim($post['slug'] ?? '');
        if (!$slug) $slug = Blog::generateSlug($title);

        $tags = array_values(array_filter(array_map('trim', explode(',', $post['tags'] ?? ''))));

        return [
            'id'               => $existing['id'] ?? Blog::generateId(),
            'slug'             => $slug,
            'title'            => $title,
            'meta_description' => trim($post['meta_description'] ?? $preview),
            'category'         => $post['category'] ?? 'technology',
            'tags'             => $tags,
            'published_at'     => $existing['published_at'] ?? date('Y-m-d'),
            'updated_at'       => date('Y-m-d'),
            'published'        => isset($post['published']),
            'preview'          => $preview,
            'content'          => $content,
        ];
    }
}
