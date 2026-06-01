<?php

class BlogController extends BaseController
{
    private Blog $blog;

    public function __construct()
    {
        $this->blog = new Blog();
    }

    /**
     * GET /blog
     */
    public function index(): void
    {
        $category = $_GET['category'] ?? '';
        $search   = trim($_GET['q'] ?? '');

        $articles   = $this->blog->getAll($category, $search);
        $categories = $this->blog->getCategories();

        $this->render('pages/blog', [
            'title'      => 'Блог — ' . APP_NAME,
            'articles'   => $articles,
            'categories' => $categories,
            'category'   => $category,
            'search'     => $search,
        ]);
    }

    /**
     * GET /blog/{slug}
     */
    public function show(string $slug): void
    {
        $article = $this->blog->getBySlug($slug);

        if (!$article) {
            http_response_code(404);
            $this->render('pages/404', ['title' => 'Страница не найдена']);
            return;
        }

        $adjacent   = $this->blog->getAdjacentArticles($slug);
        $categories = $this->blog->getCategories();

        $this->render('pages/blog_article', [
            'title'       => $article['title'] . ' — ' . APP_NAME,
            'description' => $article['meta_description'] ?? $article['preview'],
            'article'     => $article,
            'adjacent'    => $adjacent,
            'categories'  => $categories,
        ]);
    }
}
