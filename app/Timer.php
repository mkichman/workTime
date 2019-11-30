<?php


namespace App\Http;


use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    public $timestamps = true;
    protected $fillable = ['startDate', 'startTime', 'endTime', 'endDate', 'userId', 'workTime'] ;


}