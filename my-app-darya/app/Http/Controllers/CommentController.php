<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

        return back()->with('success', 'Комментарий успешно добавлен.');
    }

    /**
     * Удаление комментария.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('manage-comments');

        $comment->delete();

        return back()->with('success', 'Комментарий успешно удалён.');
    }
}
