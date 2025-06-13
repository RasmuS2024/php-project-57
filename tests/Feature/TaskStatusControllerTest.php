<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    private TaskStatus $taskStatus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskStatus = TaskStatus::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = ['name' => 'New Status'];
        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('task_statuses.edit', $this->taskStatus));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = ['name' => 'Updated Status'];
        $response = $this->put(route('task_statuses.update', $this->taskStatus), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroy(): void
    {
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $this->taskStatus->id]);
    }

    public function testDestroyWithAssociatedTask(): void
    {
        Task::factory()->create(['status_id' => $this->taskStatus->id]);
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);
    }
}
