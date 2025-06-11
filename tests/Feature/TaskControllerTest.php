<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $status;
    private $label;
    private $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->create();
        $this->label = Label::factory()->create();
        $this->task = Task::factory()->create(['created_by_id' => $this->user->id]);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
        $response->assertViewHas('tasks');
    }

    public function testIndexWithFilters(): void
    {
        $response = $this->get(route('tasks.index', [
            'filter' => ['status_id' => $this->status->id]
        ]));
        $response->assertOk();
        $response->assertViewHas('tasks');
    }

    public function testCreateForAuthenticatedUser(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testCreateForGuest(): void
    {
        $response = $this->get(route('tasks.create'));
        $response->assertRedirect(route('login'));
    }

    public function testStore(): void
    {
        $this->actingAs($this->user);
        $taskData = [
            'name' => 'New Task',
            'status_id' => $this->status->id,
            'labels' => [$this->label->id]
        ];
        $response = $this->post(route('tasks.store'), $taskData);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['name' => 'New Task']);
        $response->assertSessionHas('alert', [
            'type' => 'success',
            'message' => 'Задача успешно создана'
        ]);
    }

    public function testShow(): void
    {
        $response = $this->get(route('tasks.show', $this->task));
        $response->assertOk();
        $response->assertViewHas('task', $this->task);
    }

    public function testEditForCreator(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.edit', $this->task));
        $response->assertOk();
    }

    public function testEditForGuest(): void
    {
        $response = $this->get(route('tasks.edit', $this->task));
        $response->assertRedirect(route('login'));
    }

    public function testUpdate(): void
    {
        $this->actingAs($this->user);
        $updateData = [
            'name' => 'Updated Task',
            'status_id' => $this->status->id,
        ];
        $response = $this->put(route('tasks.update', $this->task), $updateData);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['name' => 'Updated Task']);
        $response->assertSessionHas('alert', [
            'type' => 'success',
            'message' => 'Задача успешно изменена'
        ]);
    }

    public function testDestroyByCreator(): void
    {
        $this->actingAs($this->user);
        $response = $this->delete(route('tasks.destroy', $this->task));
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
        $response->assertSessionHas('alert', [
            'type' => 'success',
            'message' => 'Задача успешно удалена'
        ]);
    }

    public function testDestroyByOtherUser(): void
    {
        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);
        $response = $this->delete(route('tasks.destroy', $this->task));
        $response->assertForbidden();
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
    }

    public function testDeleteLinkVisibilityForCreator()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.index'));
        $response->assertSee('Удалить');
    }

    public function testDeleteLinkNotVisibleForOtherUsers()
    {
        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);
        $response = $this->get(route('tasks.index'));
        $response->assertDontSee('Удалить');
    }

    public function testDeleteLinkNotVisibleForGuests()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertDontSee('Удалить');
    }
}
