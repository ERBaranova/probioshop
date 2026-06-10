<?php

class BlogController extends BaseController
{
    private Blog $blog;

    public function __construct()
    {
        $this->blog = new Blog();
    }

    public function index(): void
    {
        $category = $_GET['category'] ?? '';
        $search   = trim($_GET['q'] ?? '');

        $articles   = $this->blog->getAll($category, $search);
        $categories = $this->blog->getCategories();
        $seo        = (new SeoHelper())->forBlog($category, $search);

        $this->render('pages/blog', [
            'seo'        => $seo,
            'articles'   => $articles,
            'categories' => $categories,
            'category'   => $category,
            'search'     => $search,
        ]);
    }

    public function show(string $slug): void
    {
        $article = $this->blog->getBySlug($slug);

        if (!$article) {
            http_response_code(404);
            $this->render('pages/404', ['seo' => (new SeoHelper())->for404()]);
            return;
        }

        $adjacent   = $this->blog->getAdjacentArticles($slug);
        $categories = $this->blog->getCategories();
        $seo        = (new SeoHelper())->forBlogArticle($article);

        $this->render('pages/blog_article', [
            'seo'        => $seo,
            'article'    => $article,
            'adjacent'   => $adjacent,
            'categories' => $categories,
        ]);
    }
}
