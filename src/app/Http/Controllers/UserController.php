<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(){
        //$date = date('Y-m-d H:i:s'); $date = new DateTime('now'); echo $date->format('Y年m月d日 H時i分s秒') . "\n";
        $date = Carbon::today()->format('Y年m月d日');
        $time = Carbon::now()->format('H:i');
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
        $weekdayIndex = Carbon::now()->format('w');
        $weekday = $weekdays[$weekdayIndex];

        return view('user_index',compact('date','time','weekday',));
    }
}
