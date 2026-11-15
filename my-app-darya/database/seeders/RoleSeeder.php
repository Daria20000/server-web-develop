<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['name' => 'moderator'],
            ['description' => 'Модератор — полный доступ к управлению новостями и комментариями']
        );

        Role::updateOrCreate(
            ['name' => 'reader'],
            ['description' => 'Читатель — просмотр новостей и добавление комментариев']
        );
    }
}
