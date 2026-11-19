<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use App\Jobs\VeryLongJob;
use App\Events\NewArticleEvent;
use App\Notifications\NewArticleDatabaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleController extends Controller
{
    // READ: получение списка новостей с пагинацией
    public function index()
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5;

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

        $items = Article::query()->hydrate($cached['items']);

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

        return response()->json($articles, 200);
    }

    // READ: получение отдельной новости
    public function show($id)
    {
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

        $article = (new Article)->newFromBuilder($cached['article']);

        $comments = collect($cached['comments'])->map(function ($item) {
            $comment = (new Comment)->newFromBuilder($item['attributes']);

            if ($item['user']) {
                $user = (new User)->newFromBuilder($item['user']);
                $comment->setRelation('user', $user);
            }

            return $comment;
        });

        $article->setRelation('comments', $comments);

        return response()->json($article, 200);
    }

    // CREATE: создание новой новости
    public function store(Request $request)
    {
        Gate::authorize('create', Article::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'content' => 'required|string',
            'image' => 'nullable|string|max:255',
        ]);

        $article = Article::create($validated);

        // Очистка кэша списка статей
        $totalPages = (int) ceil(Article::count() / 5);

        for ($page = 1; $page <= $totalPages; $page++) {
            Cache::forget('articles_page_' . $page);
        }

        // Получение пользователей с ролью reader
        $readers = User::whereHas('role', function ($query) {
            $query->where('name', 'reader');
        })->get();

        // Отправка уведомлений читателям
        Notification::send(
            $readers,
            new NewArticleDatabaseNotification($article)
        );

        // Отправка события Pusher
        NewArticleEvent::dispatch($article);

        // Постановка задачи отправки email в очередь
        VeryLongJob::dispatch($article);

        return response()->json([
            'message' => 'Новость успешно создана! Уведомление поставлено в очередь на отправку.',
            'article' => $article,
        ], 201);
    }

    // UPDATE: обновление новости
    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'content' => 'required|string',
            'image' => 'nullable|string|max:255',
        ]);

        $article->update($validated);

        Cache::flush();

        return response()->json([
            'message' => 'Новость успешно обновлена!',
            'article' => $article,
        ], 200);
    }

    // DELETE: удаление новости
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();

        Cache::flush();

        return response()->json([
            'message' => 'Новость успешно удалена!',
        ], 200);
    }
}
