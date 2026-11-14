<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function index()
    {
        $json = file_get_contents(public_path('articles.json'));

        $articles = json_decode($json, true);

        return view('home', [
            'articles' => $articles
        ]);
    }

    public function galery($id)
    {
        $json = file_get_contents(public_path('articles.json'));

        $articles = json_decode($json, true);

        if (!isset($articles[$id])) {
            abort(404);
        }

        return view('galery', [
            'article' => $articles[$id]
        ]);
    }
}
