<?php

namespace App\Console\Commands;

use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('app:send-daily-statistics')]
#[Description('Отправка ежедневной статистики использования сайта модераторам')]
class SendDailyStatistics extends Command
{
    public function handle(): int
    {
        // Начало и конец текущего дня
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        // Количество просмотров статей за сегодня
        $viewsCount = ArticleView::whereBetween('created_at', [
            $startOfDay,
            $endOfDay,
        ])->count();

        // Количество новых комментариев за сегодня
        $commentsCount = Comment::whereBetween('created_at', [
            $startOfDay,
            $endOfDay,
        ])->count();

        // Получаем всех модераторов
        $moderators = User::whereHas('role', function ($query) {
            $query->where('name', 'moderator');
        })->get();

        // Отправляем статистику каждому модератору
        foreach ($moderators as $moderator) {
            Mail::raw(
                "Ежедневная статистика сайта\n\n" .
                    "Дата: " . now()->format('d.m.Y') . "\n" .
                    "Количество просмотров новостей: {$viewsCount}\n" .
                    "Количество новых комментариев: {$commentsCount}\n",
                function ($message) use ($moderator) {
                    $message
                        ->to($moderator->email)
                        ->subject('Ежедневная статистика сайта');
                }
            );
        }

        $this->info("Статистика отправлена модераторам.");
        $this->info("Просмотры: {$viewsCount}");
        $this->info("Новые комментарии: {$commentsCount}");

        return self::SUCCESS;
    }
}
