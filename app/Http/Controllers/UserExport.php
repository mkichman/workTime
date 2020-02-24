<?php


namespace App\Http\Controllers;

use App\Http\Timer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;


class UserExport implements FromCollection
{
    protected $startDate = null;
    protected $endDate = null;


    public function collection()
    {
        // todo walidacja daty

        $user = Auth::user();
        return   DB::table('timers')
            ->where('userId', '=', $user->id)
            ->whereBetween('startDate', [$this->startDate, $this->endDate])
            ->get();
    }

    public function setDate($data)
    {
        $this->startDate = $data['startDate'];
        $this->endDate = $data['endDate'];
    }

}