<?php

namespace Tests\Feature\Todo;

use App\Models\Todo;
use Carbon\Factory;
use Exception;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\CreatesApplication;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use CreatesApplication, DatabaseMigrations;

    private Generator $faker;

    public function setUp()
    : void {

        parent::setUp();
        $this->faker = Factory::create();
        Artisan::call('migrate:refresh');
    }

    public function __get($key) {

        if ($key === 'faker')
            return $this->faker;
        throw new Exception('Unknown Key Requested');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_todos_store()
    {
        $todo = [
            'task' => $this->faker->name
        ];

        $response = $this->post(route('todo.store'), $todo);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('todo', $todo);
    }

    public function test_cannot_api_todos_store()
    {
        $todo = [
            'task' => $this->faker->name
        ];

        $this->expectException(ValidationException::class);
        $this->post(route('todo.store'), $todo);
    }

    public function test_api_todos_show() {
        $todo = Todo::factory()->create();

        $response = $this->getJson(route('todos.show', $todo->id));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('id')
                 ->has('task')
        );
    }

    public function test_api_todos_update() {

        $todo = Todo::factory()->create();
        $data = [
            'task' => $this->faker->name,
        ];

        $response = $this->put(route('todos.update', $todo->id), $data);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('tasks', $data);
    }

    public function test_cannot_api_todos_update()
    {
        $todo = Todo::factory()->create();
        $data = [
            'task' => $this->faker->name,
        ];

        $this->expectException(ValidationException::class);
        $this->put(route('todos.update', $todo->id), $data);
    }

    public function test_api_todos_delete() {
        $todo = Todo::factory()->create();

        $response = $this->delete(route('todos.destroy', $todo->id));
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('tasks', ['id' => $todo->id]);
    }
}
