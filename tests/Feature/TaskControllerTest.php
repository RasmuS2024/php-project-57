<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use App\Http\Controllers\TaskController;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Providers\AppServiceProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

#[UsesClass(Label::class)]
#[UsesClass(Task::class)]
#[UsesClass(User::class)]
#[CoversClass(TaskController::class)]
#[UsesClass(AppServiceProvider::class)]
#[UsesClass(StoreTaskRequest::class)]
#[UsesClass(UpdateTaskRequest::class)]
class TaskControllerTest extends TestCase
{
    private User $user;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        /** @var Task $task */
        $task = Task::factory()->create(['created_by_id' => $this->user->id]);
        $this->task = $task;

        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $this->actingAs($this->user);

        $status = TaskStatus::factory()->create();
        $label = Label::factory()->create();

        $data = [
            'name' => 'Test Task',
            'description' => 'Test Description',
            'status_id' => $status->id,
            'labels' => [$label->id],
            'assigned_to_id' => null,
        ];

        $response = $this->post(route('tasks.store'), $data);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['name' => $data['name']]);
    }

    public function testShow(): void
    {
        $response = $this->get(route('tasks.show', $this->task));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.edit', $this->task));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $this->actingAs($this->user);

        $status = TaskStatus::factory()->create();
        $label = Label::factory()->create();

        $data = [
            'name' => 'Updated Task',
            'description' => 'Updated Description',
            'status_id' => $status->id,
            'labels' => [$label->id],
        ];

        $response = $this->put(route('tasks.update', $this->task), $data);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['name' => $data['name']]);
    }

    public function testDestroy(): void
    {
        $this->actingAs($this->user);
        $response = $this->delete(route('tasks.destroy', $this->task));
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }
}
