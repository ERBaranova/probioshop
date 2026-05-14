<?php
class HomeController extends BaseController
{
    public function index(): void
    {
        $productModel = new Product();
        $all = $productModel->all();
        usort($all, fn($a, $b) => ($b['reviews_count'] ?? 0) <=> ($a['reviews_count'] ?? 0));
        $featured = array_slice($all, 0, 4);

        $seo = (new SeoHelper())->forHome();
        $this->render('pages/home', [
            'seo'         => $seo,
            'title'       => $seo->getTitle(),
            'featured'    => $featured,
            'allProducts' => $productModel->all(),
        ]);
    }

    public function technology(): void
    {
        $seo = (new SeoHelper())->forTechnology();
        $this->render('pages/technology', [
            'seo'   => $seo,
            'title' => $seo->getTitle(),
        ]);
    }
}
