<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'новая'],
            ['name' => 'завершена'],
            ['name' => 'выполняется'],
            ['name' => 'в архиве'],
        ];

        foreach ($statuses as $status) {
            TaskStatus::firstOrCreate($status);
        }
    }
}
