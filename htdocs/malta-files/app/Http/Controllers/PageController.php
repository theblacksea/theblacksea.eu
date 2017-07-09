<?php

namespace App\Http\Controllers;

use App\Article;

class PageController extends Controller
{

    public function __construct()
    {
        $this->articleRepository = new Article();
    }

    public function getHome()
    {
        $articlesEn = $this->articleRepository->getAllArticles('en');
        $articlesTr = $this->articleRepository->getAllArticles('tr');
        return view('home', [
            'articles' => [
                'en' => $articlesEn,
                'tr' => $articlesTr
            ]
        ]);
    }

    public function getArticle($language, $slug)
    {
        $article = $this->articleRepository->getSingleArticle($language, $slug);
        return view('article', $article);
    }
}
