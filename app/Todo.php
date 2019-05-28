<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
  protected $fillable = ['text', 'due', 'done', 'completed'];
  protected $hidden = ['created_at', 'updated_at'];


  public function updateMe($attributes)
  {
      if (array_has($attributes, 'text')) {
          $this->start_date = array_get($attributes,'text');
      }

      if (array_has($attributes, 'due')) {
          $this->end_date = array_get($attributes,'due');
      }

      if (array_has($attributes, 'done')) {
          $this->list_of_dates = array_get($attributes,'done');
      }

      if (array_has($attributes, 'completed')) {
          $this->list_of_dates = array_get($attributes,'completed');
      }

      $this->save();
  }
}
