<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TaskTestCase extends TestCase
{
    use RefreshDatabase;

    public function test_getting_tasks(): void
    {
        Task::all();
        $response = $this->getJson('/tasks');

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('tasks')->etc();
            $json->has('tasks.0', function (AssertableJson $json) {
                $json
                    ->whereType('id', 'integer')
                    ->whereType('assigned_by_id', 'integer')
                    ->whereType('assigned_to_id', 'integer')
                    ->whereType('title', 'string')
                    ->whereType('description', 'string')
                ;
            });
        });
    }

    public function test_getting_single_task(): void
    {
        $attributes = [
            'title' => 'Test item',
            'assigned_by_id' => 1,
            'assigned_to_id' => 2,
            'description' => 'Test description',
        ];

        $task = Task::create($attributes);

        $response = $this->getJson('/tasks/' . $task->id);

        $response->assertStatus(200);

        $responseItem = $response->json()['task'];

        $this->assertSame($task->id, $responseItem['id']);
        $this->assertSame($attributes['title'], $responseItem['title']);
        $this->assertSame('1', $responseItem['assigned_by_id']);
        $this->assertSame('2', $responseItem['assigned_to_id']);
        $this->assertSame($attributes['description'], $responseItem['description']);
    }

    public function test_creating_new_task_with_valid_data(): void
    {
        $response = $this->postJson('/tasks', [
            'title' => 'Test item',
            'assigned_by_id' => 1,
            'assigned_to_id' => 2,
            'description' => 'Test description',
        ]);

        $this->assertSame('New task', $response->json()['task']['name']);

        $this->assertDatabaseHas(Task::class, [
            'title' => 'Test item',
            'assigned_by_id' => 1,
            'assigned_to_id' => 2,
            'description' => "<p>Test <strong>item</strong> description</p>\n",
        ]);
    }

}
