<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Todo;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TodosControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    /**
     * @test
     */
    public function a_user_should_see_all_todos_in_the_table()
    {
        $todos = factory(Todo::class, 25)->create();
        // $this->get('todos')
        // ->assertSee($todos[1]->text);
        $response = $this->json('GET', '/api/todos');
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                [
                  'id',
                  'text',
                  'due',
                  'done',
                  'completed'
                ]
            ]
        );
    }

    /**
     * @test
     */
    public function a_user_can_create_a_todo()
    {
        // $todoData = factory(Todo::class)->make()->toArray();
        $todos = factory(Todo::class, 25)->create();

        // $this->post('todos', $todos);

        $this->assertDatabaseHas('todos', [
            'completed' => '0'
        ]);

    }

    /**
     * @test
     */
    // public function a_user_can_view_a_todo()
    // {
    //     $todos = factory(Todo::class, 25)->create();
    //
    //     $this->get('todos/' . $todos[15]->id)
    //     ->assertSee($todos[15]->text);
    // }

    /**
     * @test
     */
    public function a_user_can_update_a_todo()
    {

        $todo = factory(Todo::class)->create();
        $response  = $this->json('GET', '/api/todos');
        $response->assertStatus(200);

        $todos     = $response->getData()[0];

        $update    = $this->json('PATCH', '/api/todos/'.$todos->id,['quantity' => ($todos->id+5)]);
        $update->assertStatus(200);
        $update->assertJson(['message' => "Todo Updated!"]);
    }

    /**
     * @test
     */
    public function a_user_can_delete_a_todo()
    {
      $todos = factory(Todo::class, 25)->create();
      // $this->get('todos')
      // ->assertSee($todos[1]->text);
      $response = $this->json('GET', '/api/todos');
      $response->assertStatus(200);

        $todo    = $response->getData()[0];

        $update   = $this->json('DELETE', '/api/todos/'.$todo->id);
        $update->assertStatus(200);
        $update->assertJson(['message' => "Todos Deleted!"]);
    }
}
