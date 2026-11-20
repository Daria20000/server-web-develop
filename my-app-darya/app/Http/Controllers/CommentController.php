<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
    /**
     * Добавление комментария к новости.
     */
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:2|max:2000',
        ], [
            'content.required' => 'Введите текст комментария.',
            'content.min' => 'Комментарий должен содержать минимум 2 символа.',
            'content.max' => 'Комментарий не должен превышать 2000 символов.',
        ]);

        $article->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
        ]);

        Cache::forget('article_' . $article->id);

        return back()->with(
            'success',
            'Комментарий отправлен и ожидает модерации.'
        );
    }

    /**
     * Удаление комментария.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('manage-comments');

        $articleId = $comment->article_id;

        $comment->delete();

        Cache::forget('article_' . $articleId);

        return back()->with('success', 'Комментарий успешно удалён.');
    }

    public function moderation()
    {
        Gate::authorize('manage-comments');

        $comments = Comment::with(['user', 'article'])
            ->where('is_approved', false)
            ->latest()
            ->get();

        return view('comments.moderation', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        Gate::authorize('manage-comments');

        $comment->update([
            'is_approved' => true,
        ]);

        Cache::forget('article_' . $comment->article_id);

        return back()->with('success', 'Комментарий одобрен.');
    }

    public function reject(Comment $comment)
    {
        Gate::authorize('manage-comments');

        $articleId = $comment->article_id;

        $comment->delete();

        Cache::forget('article_' . $articleId);

        return back()->with('success', 'Комментарий отклонён и удалён.');
    }
}
