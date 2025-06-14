<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use App\Providers\AppServiceProvider;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\UsesClass;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
#[UsesClass(AppServiceProvider::class)]
#[UsesClass(Label::class)]
#[UsesClass(Task::class)]
#[UsesClass(User::class)]
abstract class ResourceControllerTestCase extends TestCase
{
    use RefreshDatabase;

    protected $model;
    protected $routePrefix;
    protected const INDEX_ROUTE = 'index';

    abstract protected function modelClass(): string;
    abstract protected function routePrefix(): string;
    abstract protected function controllerClass(): string;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = app($this->modelClass())->factory()->create();
        $this->routePrefix = $this->routePrefix();
    }

    public function testIndex(): void
    {
        $response = $this->get(route(sprintf('%s.%s', $this->routePrefix, self::INDEX_ROUTE)));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route(sprintf('%s.create', $this->routePrefix)));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = ['name' => sprintf('New %s', class_basename($this->model))];
        $response = $this->post(route(sprintf('%s.store', $this->routePrefix)), $data);
        $response->assertRedirect(route(sprintf('%s.%s', $this->routePrefix, self::INDEX_ROUTE)));
        $this->assertDatabaseHas($this->model->getTable(), $data);
    }

    public function testEdit(): void
    {
        $response = $this->get(route(sprintf('%s.edit', $this->routePrefix), $this->model));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = ['name' => sprintf('Updated %s', class_basename($this->model))];
        $response = $this->put(route(sprintf('%s.update', $this->routePrefix), $this->model), $data);
        $response->assertRedirect(route(sprintf('%s.%s', $this->routePrefix, self::INDEX_ROUTE)));
        $this->assertDatabaseHas($this->model->getTable(), $data);
    }

    public function testDestroy(): void
    {
        $response = $this->delete(route(sprintf('%s.destroy', $this->routePrefix), $this->model));
        $response->assertRedirect(route(sprintf('%s.%s', $this->routePrefix, self::INDEX_ROUTE)));
        $this->assertDatabaseMissing($this->model->getTable(), ['id' => $this->model->id]);
    }
}
