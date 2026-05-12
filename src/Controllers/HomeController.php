<?php
class HomeController extends BaseController
{
    public function index(): void
    {
        $productModel = new Product();
        $all      = $productModel->all();
        // 4 товара с лучшим рейтингом на главной
        usort($all, fn($a, $b) => ($b['reviews_count'] ?? 0) <=> ($a['reviews_count'] ?? 0));
        $featured = array_slice($all, 0, 4);

        $this->render('pages/home', [
            'title'       => APP_NAME . ' — Пробиотические моющие средства',
            'featured'    => $featured,
            'allProducts' => $productModel->all(),
        ]);
    }
}

    public function technology(): void
    {
        $seo = (new SeoHelper())->forTechnology();
        $this->render('pages/technology', [
            'seo'   => $seo,
            'title' => $seo->getTitle(),
        ]);
    }
