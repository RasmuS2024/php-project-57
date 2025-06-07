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
        
        // Создаем тестового пользователя
        $this->user = User::factory()->create();
    }

    // Тест для главной страницы (не требует авторизации)
    public function test_index_page()
    {
        TaskStatus::factory()->count(5)->create();
        $response = $this->get(route('task_statuses.index'));
        
        $response->assertStatus(200);
        $response->assertViewHas('taskStatuses');
    }

    // Тест страницы создания (требует авторизации)
    public function test_create_page_access()
    {
        // Без авторизации - должен быть запрет
        $response = $this->get(route('task_statuses.create'));
        $response->assertForbidden();

        // С авторизацией
        $response = $this->actingAs($this->user)
                         ->get(route('task_statuses.create'));
        
        $response->assertStatus(200);
    }

    // Тест создания статуса (требует авторизации)
    public function test_store_status()
    {
        $data = ['name' => 'New Status'];
        
        // Без авторизации
        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertForbidden();

        // С авторизацией
        $response = $this->actingAs($this->user)
                         ->post(route('task_statuses.store'), $data);
        
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $data);
    }

    // Тест валидации при создании
    public function test_store_validation()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('task_statuses.store'), ['name' => '']);
        
        $response->assertSessionHasErrors('name');
    }

    // Тест запрета просмотра (не требует авторизации)
    public function test_show_forbidden()
    {
        $status = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.show', $status));
        
        $response->assertForbidden();
        $response->assertSee('This action is unauthorized');
    }

    // Тест страницы редактирования (требует авторизации)
    public function test_edit_page()
    {
        $status = TaskStatus::factory()->create();
        
        // Без авторизации
        $response = $this->get(route('task_statuses.edit', $status));
        $response->assertForbidden();

        // С авторизацией
        $response = $this->actingAs($this->user)
                         ->get(route('task_statuses.edit', $status));
        
        $response->assertStatus(200);
        $response->assertSee($status->name);
    }

    // Тест обновления статуса (требует авторизации)
    public function test_update_status()
    {
        $status = TaskStatus::factory()->create();
        $data = ['name' => 'Updated Status'];
        
        // Без авторизации
        $response = $this->patch(route('task_statuses.update', $status), $data);
        $response->assertForbidden();

        // С авторизацией
        $response = $this->actingAs($this->user)
                         ->patch(route('task_statuses.update', $status), $data);
        
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $data);
    }

    // Тест удаления статуса (требует авторизации)
    public function test_destroy_status()
    {
        $status = TaskStatus::factory()->create();
        
        // Без авторизации
        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertForbidden();

        // С авторизацией
        $response = $this->actingAs($this->user)
                         ->delete(route('task_statuses.destroy', $status));
        
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }

    // Тест защиты статуса с задачами
public function test_destroy_protected_status()
{
    $status = TaskStatus::factory()->create();
    
    // Используем фабрику Task вместо hasTasks()
    Task::factory()->create(['status_id' => $status->id]);
    
    $response = $this->actingAs($this->user)
                     ->delete(route('task_statuses.destroy', $status));
    
    $response->assertRedirect();
    $response->assertSessionHas('error');
    $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
}
}