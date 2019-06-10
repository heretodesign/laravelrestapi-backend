<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Todo::latest()->get();
       //return Todo::where('completed', 0)->first();
       //return Todo::where('completed', 1)->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = new Todo();
        $todo->text = request('text');
        $todo->due = request('due');
        $todo->done = request('done');
        $todo->completed = request('completed');
        $todo->completed = request('is_trash');
        $todo->save();

        return response()->json('Successfully added');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo, $id)
    {
        var_dump('lol');
        return Todo::where('completed', 0)->first();
        return $todo->toJson();

        // if (is_null($todo)) {
        //     return $this->sendError('Todo not found.');
        // }
        //return $this->sendResponse($todo->toArray(), 'Todo retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
      $request->validate([
         'text' => 'required|string',
         'due' => 'required|string',
         'done' => 'required|string',
         'completed' => 'required|boolean',
         'is_trash' => 'required|boolean',
      ]);

        $todo->update($request->all());
        return response()->json('Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json('Successfully updated', 204);
    }

    /**
     * Mark as complete the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsCompleted(Request $request, $id)
    {
      // search for the $todo row based on the id
      $todo = Todo::findOrFail($id);
      $todo->completed = true;
      $todo->update();

      return response()->json('Todo updated!');
    }

    /**
     * Mark as complete the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markIncomplete(Request $request, $id)
    {
      // search for the $todo row based on the id
      $todo = Todo::findOrFail($id);
      $todo->completed = false;
      $todo->update();

      return response()->json('Mark Incomplete updated!');
    }

    /**
     * Mark as complete the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsTrash(Request $request, $id)
    {
      // search for the $todo row based on the id
      $todo = Todo::findOrFail($id);
      $todo->is_trash = true;
      $todo->update();

      return response()->json('Marked As Trash updated!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function completed()
    {
      return Todo::where('completed', 1)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
      return Todo::where('is_trash', 1)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending()
    {
      return Todo::where('completed', 0)->get();
    }

}
