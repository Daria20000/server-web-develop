<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class ModeratorSeeder extends Seeder
{
    public function run(): void
    {
        $moderatorRole = Role::where('name', 'moderator')->firstOrFail();
        $readerRole = Role::where('name', 'reader')->firstOrFail();

        // Назначаем существующим пользователям роль читателя
        User::whereNull('role_id')->get()->each(function ($user) use ($readerRole) {
            $user->role()->associate($readerRole);
            $user->save();
        });

        // Создаём пользователя-модератора
        $moderator = User::updateOrCreate(
            ['email' => 'moderator@example.com'],
            [
                'name' => 'Главный модератор',
                'password' => 'Moderator123!',
            ]
        );

        $moderator->role()->associate($moderatorRole);
        $moderator->save();
    }
}
