<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Http\Controllers\TaskStatusController;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TaskStatusController::class)]
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

    protected function controllerClass(): string
    {
        return \App\Http\Controllers\TaskStatusController::class;
    }

    public function testDestroyWithAssociatedTask(): void
    {
        /** @var TaskStatus $status */
        $status = $this->model;
        Task::factory()->create(['status_id' => $status->id]);

        $route = route("{$this->routePrefix}.destroy", $status);
        $response = $this->delete($route);

        $response->assertRedirect();
        $this->assertDatabaseHas($status->getTable(), ['id' => $status->id]);
    }
}
