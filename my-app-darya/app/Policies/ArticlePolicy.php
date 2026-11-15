<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Просмотр списка новостей и отдельной новости.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Article $article): bool
    {
        return true;
    }

    /**
     * Создание новости.
     */
    public function create(User $user): Response
    {
        return $user->isModerator()
            ? Response::allow()
            : Response::deny('Создавать новости могут только модераторы.');
    }

    /**
     * Редактирование новости.
     */
    public function update(User $user, Article $article): Response
    {
        return $user->isModerator()
            ? Response::allow()
            : Response::deny('Редактировать новости могут только модераторы.');
    }

    /**
     * Удаление новости.
     */
    public function delete(User $user, Article $article): Response
    {
        return $user->isModerator()
            ? Response::allow()
            : Response::deny('Удалять новости могут только модераторы.');
    }
}
