<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Jobs\VeryLongJob;
use App\Events\NewArticleEvent;
use App\Models\User;
use App\Notifications\NewArticleDatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Comment;

class ArticleController extends Controller
{
    // READ: список новостей с пагинацией


    public function index()
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5;

        // Кэшируем массив данных статей и общее количество
        $cached = Cache::remember(
            'articles_page_' . $page,
            3600,
            function () use ($page, $perPage) {
                return [
                    'items' => Article::latest()
                        ->forPage($page, $perPage)
                        ->get()
                        ->toArray(),

                    'total' => Article::count(),
                ];
            }
        );

        // Восстанавливаем модели из массива
        $items = Article::query()->hydrate($cached['items']);

        // Создаём объект пагинации
        $articles = new LengthAwarePaginator(
            $items,
            $cached['total'],
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );

        return view('articles.index', compact('articles'));
    }



    // READ: просмотр отдельной новости


    public function show($id)
    {
        // Кэшируем данные статьи и её комментариев
        $cached = Cache::rememberForever(
            'article_' . $id,
            function () use ($id) {
                $article = Article::with('comments.user')
                    ->findOrFail($id);

                return [
                    'article' => $article->getAttributes(),

                    'comments' => $article->comments->map(function ($comment) {
                        return [
                            'attributes' => $comment->getAttributes(),
                            'user' => $comment->user?->getAttributes(),
                        ];
                    })->all(),
                ];
            }
        );

        // Восстанавливаем модель статьи
        $article = (new Article)->newFromBuilder($cached['article']);

        // Восстанавливаем комментарии и их авторов
        $comments = collect($cached['comments'])->map(function ($item) {
            $comment = (new Comment)->newFromBuilder($item['attributes']);

            if ($item['user']) {
                $user = (new \App\Models\User)
                    ->newFromBuilder($item['user']);

                $comment->setRelation('user', $user);
            }

            return $comment;
        });

        $article->setRelation('comments', $comments);

        return view('articles.show', compact('article'));
    }



    // CREATE: отображение формы создания
    public function create()
    {
        Gate::authorize('create', Article::class);

        return view('articles.create');
    }

    // CREATE: сохранение новой новости

    public function store(Request $request)
    {
        Gate::authorize('create', Article::class);

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

        // Сохраняем статью в базе данных
        $article = Article::create($validated);

        // Очищаем кэш всех страниц списка статей
        $totalPages = (int) ceil(Article::count() / 5);

        for ($page = 1; $page <= $totalPages; $page++) {
            Cache::forget('articles_page_' . $page);
        }

        // Получаем всех пользователей с ролью reader
        $readers = User::whereHas('role', function ($query) {
            $query->where('name', 'reader');
        })->get();

        // Отправляем уведомления читателям
        Notification::send(
            $readers,
            new NewArticleDatabaseNotification($article)
        );

        NewArticleEvent::dispatch($article);

        // Добавляем задание отправки письма в очередь
        VeryLongJob::dispatch($article);

        return redirect()
            ->route('articles.index')
            ->with(
                'success',
                'Новость успешно создана! Уведомление поставлено в очередь на отправку.'
            );
    }


    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);

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

        Cache::flush();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Новость успешно обновлена!');
    }

    // DELETE: удаление новости
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();

        Cache::flush();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Новость успешно удалена!');
    }
}
