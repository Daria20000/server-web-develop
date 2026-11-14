<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    // Отображение списка новостей
    public function index()
    {
        $articles = Article::latest()->get();

        return view('articles.index', [
            'articles' => $articles
        ]);
    }
}
