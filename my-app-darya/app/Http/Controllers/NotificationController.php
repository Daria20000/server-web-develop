<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function open(string $id)
    {
        // Ищем уведомление только среди уведомлений текущего пользователя
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        // Получаем ID статьи из данных уведомления
        $articleId = $notification->data['article_id'];

        // Отмечаем уведомление как прочитанное
        $notification->markAsRead();

        // Переходим к статье
        return redirect()->route('articles.show', $articleId);
    }
}
