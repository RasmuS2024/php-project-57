<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Http\Controllers\TaskStatusController;
use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Providers\AppServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[UsesClass(User::class)]
#[CoversClass(TaskStatusController::class)]
#[UsesClass(AppServiceProvider::class)]
#[UsesClass(StoreTaskStatusRequest::class)]
#[UsesClass(UpdateTaskStatusRequest::class)]
class TaskStatusControllerTest extends ResourceControllerTestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

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
