<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // READ: список новостей с пагинацией
    public function index()
    {
        $articles = Article::latest()->paginate(5);

        return view('articles.index', compact('articles'));
    }

    // READ: просмотр отдельной новости
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    // CREATE: отображение формы создания
    public function create()
    {
        return view('articles.create');
    }

    // CREATE: сохранение новой новости
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'content' => 'required|string',
            'image' => 'nullable|string|max:255',
        ], [
            'title.required' => 'Введите заголовок новости.',
            'title.max' => 'Заголовок не должен превышать 255 символов.',
            'description.required' => 'Введите краткое описание.',
            'description.max' => 'Описание не должно превышать 1000 символов.',
            'content.required' => 'Введите текст новости.',
            'image.max' => 'Путь к изображению слишком длинный.',
        ]);

        Article::create($validated);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Новость успешно создана!');
    }

    // UPDATE: отображение формы редактирования
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    // UPDATE: сохранение изменений
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'content' => 'required|string',
            'image' => 'nullable|string|max:255',
        ], [
            'title.required' => 'Введите заголовок новости.',
            'title.max' => 'Заголовок не должен превышать 255 символов.',
            'description.required' => 'Введите краткое описание.',
            'description.max' => 'Описание не должно превышать 1000 символов.',
            'content.required' => 'Введите текст новости.',
            'image.max' => 'Путь к изображению слишком длинный.',
        ]);

        $article->update($validated);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Новость успешно обновлена!');
    }

    // DELETE: удаление новости
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Новость успешно удалена!');
    }
}
