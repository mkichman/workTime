<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    protected $fillable = ['scheduleId', 'todoId', 'userId'] ;
    public $timestamps = false;
}