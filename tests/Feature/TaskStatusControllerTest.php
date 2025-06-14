<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;

class TaskStatusControllerTest extends ResourceControllerTestCase
{
    protected function modelClass(): string
    {
        return TaskStatus::class;
    }

    protected function routePrefix(): string
    {
        return 'task_statuses';
    }

    public function testDestroyWithAssociatedTask(): void
    {
        Task::factory()->create(['status_id' => $this->model->id]);

        $route = route(sprintf('%s.destroy', $this->routePrefix), $this->model);
        $response = $this->delete($route);

        $response->assertRedirect();
        $this->assertDatabaseHas($this->model->getTable(), ['id' => $this->model->id]);
    }
}
