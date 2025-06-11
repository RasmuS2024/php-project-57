<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testIndexPage()
    {
        TaskStatus::factory()->count(5)->create();
        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200);
        $response->assertViewHas('taskStatuses');
    }

    public function testCreatePageAccess()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertForbidden();
        $response = $this->actingAs($this->user)
                         ->get(route('task_statuses.create'));
        $response->assertStatus(200);
    }

    public function testStoreStatus()
    {
        $data = ['name' => 'New Status'];
        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertForbidden();
        $response = $this->actingAs($this->user)
                         ->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testStoreValidation()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('task_statuses.store'), ['name' => '']);
        $response->assertSessionHasErrors('name');
    }

    public function testShowForbidden()
    {
        $status = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.show', $status));
        $response->assertForbidden();
        $response->assertSee('This action is unauthorized');
    }

    public function testEditPage()
    {
        $status = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.edit', $status));
        $response->assertForbidden();
        $response = $this->actingAs($this->user)
                         ->get(route('task_statuses.edit', $status));
        $response->assertStatus(200);
        $response->assertSee($status->name);
    }

    public function testUpdateStatus()
    {
        $status = TaskStatus::factory()->create();
        $data = ['name' => 'Updated Status'];
        $response = $this->patch(route('task_statuses.update', $status), $data);
        $response->assertForbidden();
        $response = $this->actingAs($this->user)
                         ->patch(route('task_statuses.update', $status), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroyStatus()
    {
        $status = TaskStatus::factory()->create();
        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertForbidden();
        $response = $this->actingAs($this->user)
                         ->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }

    public function testDestroyProtectedStatus()
    {
        $status = TaskStatus::factory()->create();
        Task::factory()->create(['status_id' => $status->id]);
        $response = $this->actingAs($this->user)
                         ->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }
}
