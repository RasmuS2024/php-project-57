<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\TaskStatus;
use App\Models\Task;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    // Тесты для index()
    public function test_index_page_returns_success(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
        $response->assertViewIs('taskStatus.index');
    }

    public function test_index_shows_paginated_statuses(): void
    {
        TaskStatus::factory()->count(20)->create();
        $response = $this->get(route('task_statuses.index'));
        $response->assertViewHas('taskStatuses');
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $response->viewData('taskStatuses'));
    }

    // Тесты для create()
    public function test_create_page_returns_success(): void
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertOk();
        $response->assertViewIs('taskStatus.create');
    }

    // Тесты для store()
    public function test_store_valid_status(): void
    {
        $data = ['name' => 'New Status'];
        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function test_store_invalid_status(): void
    {
        // Пустое имя
        $response = $this->post(route('task_statuses.store'), ['name' => '']);
        $response->assertSessionHasErrors('name');

        // Дубликат имени
        TaskStatus::factory()->create(['name' => 'Duplicate']);
        $response = $this->post(route('task_statuses.store'), ['name' => 'Duplicate']);
        $response->assertSessionHasErrors('name');
    }

    // Тесты для edit()
    public function test_edit_page_returns_success(): void
    {
        $status = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.edit', $status));
        $response->assertOk();
        $response->assertViewIs('taskStatus.edit');
        $response->assertViewHas('taskStatus', $status);
    }

    // Тесты для update()
    public function test_update_valid_status(): void
    {
        $status = TaskStatus::factory()->create(['name' => 'Old']);
        $data = ['name' => 'Updated Status'];
        $response = $this->patch(route('task_statuses.update', $status), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function test_update_invalid_status(): void
    {
        $status = TaskStatus::factory()->create(['name' => 'Original']);
        TaskStatus::factory()->create(['name' => 'Existing']);
        
        // Пустое имя
        $response = $this->patch(route('task_statuses.update', $status), ['name' => '']);
        $response->assertSessionHasErrors('name');
        
        // Дубликат имени
        $response = $this->patch(route('task_statuses.update', $status), ['name' => 'Existing']);
        $response->assertSessionHasErrors('name');
    }

    // Тесты для destroy()
    public function test_destroy_status_without_tasks(): void
    {
        $status = TaskStatus::factory()->create();
        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }

    public function test_destroy_status_with_linked_tasks(): void
    {
        $status = TaskStatus::factory()->create();
        Task::factory()->create(['status_id' => $status->id]);
        
        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }
}