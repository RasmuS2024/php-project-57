<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();
        $this->label = Label::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = ['name' => 'New Label'];
        $response = $this->post(route('labels.store'), $data);
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $data);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('labels.edit', $this->label));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = ['name' => 'Updated Label'];
        $response = $this->put(route('labels.update', $this->label), $data);
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $data);
    }

    public function testDestroy(): void
    {
        $response = $this->delete(route('labels.destroy', $this->label));
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $this->label->id]);
    }

    public function testDestroyWithAssociatedTask(): void
    {
        /** @var Task $task */
        $task = Task::factory()->create();
        $task->labels()->attach($this->label);
        $response = $this->delete(route('labels.destroy', $this->label));
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);
    }
}
