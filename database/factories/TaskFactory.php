<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status_id' => \App\Models\TaskStatus::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'assigned_to_id' => \App\Models\User::factory(),
        ];
    }
}
