<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    // Тесты для страницы списка статусов
    public function test_index_page_displays_statuses()
    {
        $statuses = TaskStatus::factory()->count(3)->create();

        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
        $response->assertViewIs('taskStatus.index');
        $response->assertSee($statuses->first()->name);
    }

    // Тесты для страницы создания статуса
    public function test_create_page_displays_form()
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertStatus(200);
        $response->assertViewIs('taskStatus.create');
        $response->assertSee('Создать статус');
    }

    // Тесты для сохранения статуса
    public function test_store_creates_new_status()
    {
        $data = ['name' => 'New Status'];

        $response = $this->post(route('task_statuses.store'), $data);

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success', 'Статус успешно создан');
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function test_store_requires_name()
    {
        $response = $this->post(route('task_statuses.store'), []);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('task_statuses', 0);
    }

    public function test_store_requires_unique_name()
    {
        TaskStatus::factory()->create(['name' => 'Existing']);
        
        $response = $this->post(route('task_statuses.store'), [
            'name' => 'Existing'
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('task_statuses', 1);
    }

    // Тесты для страницы редактирования
    public function test_edit_page_displays_form()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->get(route('task_statuses.edit', $status));

        $response->assertStatus(200);
        $response->assertViewIs('taskStatus.edit');
        $response->assertSee($status->name);
    }

    // Тесты для обновления статуса
    public function test_update_modifies_existing_status()
    {
        $status = TaskStatus::factory()->create();
        $data = ['name' => 'Updated Status'];

        $response = $this->put(route('task_statuses.update', $status), $data);

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success', 'Статус успешно обновлён');
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function test_update_requires_name()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->put(route('task_statuses.update', $status), [
            'name' => ''
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseHas('task_statuses', ['name' => $status->name]);
    }

    public function test_update_requires_unique_name()
    {
        $status1 = TaskStatus::factory()->create(['name' => 'First']);
        $status2 = TaskStatus::factory()->create(['name' => 'Second']);

        $response = $this->put(route('task_statuses.update', $status2), [
            'name' => 'First'
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseHas('task_statuses', [
            'id' => $status2->id,
            'name' => 'Second'
        ]);
    }

    // Тесты для удаления статуса
    public function test_destroy_deletes_status()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success', 'Статус успешно удалён');
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }

    public function test_destroy_fails_when_status_has_tasks()
    {
        $status = TaskStatus::factory()->create();
        Task::factory()->create(['status_id' => $status->id]);

        $response = $this->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Нельзя удалить статус с привязанными задачами');
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }

    public function test_destroy_handles_general_errors()
    {
        $status = TaskStatus::factory()->create();
        $this->mock(TaskStatus::class, function ($mock) use ($status) {
            $mock->shouldReceive('delete')->andThrow(new \Exception('Test error'));
        });

        $response = $this->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Произошла ошибка при удалении');
    }
}