<?php

namespace App\Jobs;

use App\Mail\NewArticleNotification;
use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class VeryLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Article $article;

    /**
     * Создание нового задания.
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Выполнение фонового задания.
     */
    public function handle(): void
    {
        $moderators = User::whereHas('role', function ($query) {
            $query->where('name', 'moderator');
        })->whereNotNull('email')->get();

        foreach ($moderators as $moderator) {
            Mail::to($moderator->email)
                ->send(new NewArticleNotification($this->article));
        }
    }
}
