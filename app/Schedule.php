<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['name', 'description', 'startDate', 'endDate'] ;

    public function find($id)
    {
        return $id;
    }
}
