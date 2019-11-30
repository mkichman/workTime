<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
   protected $fillable = ['description', 'done', 'userId'] ;
   public $timestamps = false;
}