<?php

namespace Tests\Feature;

use App\Http\Controllers\LabelController;
use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use App\Providers\AppServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(LabelController::class)]
#[UsesClass(AppServiceProvider::class)]
#[UsesClass(Label::class)]
#[UsesClass(Task::class)]
#[UsesClass(User::class)]
class LabelControllerTest extends ResourceControllerTestCase
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
        return Label::class;
    }

    protected function routePrefix(): string
    {
        return 'labels';
    }

    protected function controllerClass(): string
    {
        return LabelController::class;
    }

    public function testDestroyWithAssociatedTask(): void
    {
        /** @var Task $task */
        $task = Task::factory()->create();
        $task->labels()->attach($this->model);

        $destroyRoute = route("{$this->routePrefix}.destroy", $this->model);
        $indexRoute = route("{$this->routePrefix}.index");

        $response = $this->delete($destroyRoute);

        $response->assertRedirect($indexRoute);
        $this->assertDatabaseHas($this->model->getTable(), ['id' => $this->model->id]);
    }
}
