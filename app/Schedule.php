<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['name', 'description', 'startDate', 'endDate', 'userId', 'done'] ;

    public function find($id)
    {
        return $id;
    }
}
