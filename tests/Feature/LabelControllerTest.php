<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;

class LabelControllerTest extends ResourceControllerTestCase
{
    protected function modelClass(): string
    {
        return Label::class;
    }

    protected function routePrefix(): string
    {
        return 'labels';
    }

    public function testDestroyWithAssociatedTask(): void
    {
        /** @var Task $task */
        $task = Task::factory()->create();
        $task->labels()->attach($this->model);

        $destroyRoute = route(sprintf('%s.destroy', $this->routePrefix), $this->model);
        $indexRoute = route(sprintf('%s.index', $this->routePrefix));

        $response = $this->delete($destroyRoute);

        $response->assertRedirect($indexRoute);
        $this->assertDatabaseHas($this->model->getTable(), ['id' => $this->model->id]);
    }
}
