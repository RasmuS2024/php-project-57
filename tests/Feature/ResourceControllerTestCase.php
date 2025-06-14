<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
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
        $response = $this->get(route($this->routePrefix . '.' . self::INDEX_ROUTE));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route($this->routePrefix . '.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = ['name' => 'New ' . class_basename($this->model)];
        $response = $this->post(route($this->routePrefix . '.store'), $data);
        $response->assertRedirect(route($this->routePrefix . '.' . self::INDEX_ROUTE));
        $this->assertDatabaseHas($this->model->getTable(), $data);
    }

    public function testEdit(): void
    {
        $response = $this->get(route($this->routePrefix . '.edit', $this->model));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = ['name' => 'Updated ' . class_basename($this->model)];
        $response = $this->put(route($this->routePrefix . '.update', $this->model), $data);
        $response->assertRedirect(route($this->routePrefix . '.' . self::INDEX_ROUTE));
        $this->assertDatabaseHas($this->model->getTable(), $data);
    }

    public function testDestroy(): void
    {
        $response = $this->delete(route($this->routePrefix . '.destroy', $this->model));
        $response->assertRedirect(route($this->routePrefix . '.' . self::INDEX_ROUTE));
        $this->assertDatabaseMissing($this->model->getTable(), ['id' => $this->model->id]);
    }
}
