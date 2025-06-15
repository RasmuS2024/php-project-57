<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    public function run()
    {
        $labels = [
            [
                'name' => 'ошибка',
                'description' => 'Какая-то ошибка в коде или проблема с функциональностью',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'документация',
                'description' => 'Задача которая касается документации',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'дубликат',
                'description' => 'Повтор другой задачи',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'доработка',
                'description' => 'Новая фича, которую нужно запилить',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($labels as $label) {
            Label::firstOrCreate($label);
        }
    }
}
