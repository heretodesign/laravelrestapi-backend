<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/todos', 'TodosController@index');
Route::post('/todos', 'TodosController@store');

Route::get('/todos/completed', 'TodosController@completed');
Route::get('/todos/trash', 'TodosController@trash');
Route::get('/todos/pending', 'TodosController@pending');

Route::get('/todos/{todo}', 'TodosController@show');
Route::patch('/todos/{todo}', 'TodosController@update');
Route::delete('/todos/{todo}', 'TodosController@destroy');

Route::put('/todos/{todo}/complete', 'TodosController@markAsCompleted');
Route::put('/todos/{todo}/incomplete', 'TodosController@markIncomplete');

Route::put('/todos/{todo}/trash', 'TodosController@markAsTrash');
