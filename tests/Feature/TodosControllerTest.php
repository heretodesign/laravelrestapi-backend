<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Todo;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->get('todos')
        ->assertSee($todos[0]->text); 
    }

    /**
     * @test
     */
    public function a_user_can_create_a_todo()
    {
        $todoData = factory(Todo::class)->make()->toArray();
        
        $this->post('todos', $todoData); 
        
        $this->assertDatabaseHas('todos',[
            'text' => $todoData['text']
        ]); 
    }

    /**
     * @test
     */
    public function a_user_can_view_a_todo()
    {
        $todos = factory(Todo::class, 25)->create();

        $this->get('todos/' . $todos[15]->id)
        ->assertSee($todos[15]->text); 
    }

    /**
     * @test
     */
    public function a_user_can_update_a_todo()
    {
        $todo = factory(Todo::class)->create(); 

        $todoData = factory(Todo::class)->make(); 
        
        $this->patch('todos/' . $todo->id, [
            'text' => $todoData['text']
        ]); 
        
        $this->assertDatabaseHas('todos',[
            'id' => $todo->id, 
            'text' => $todoData['text']
        ]); 
    }

    /**
     * @test
     */
    public function a_user_can_delete_a_todo()
    {
        $todos = factory(Todo::class, 25)->create();

        $this->delete('/todos/' . $todos[15]->id); 

        $this->assertDatabaseMissing('todos', [
            'text' => $todos[15]->text, 
        ]); 
    }
}
