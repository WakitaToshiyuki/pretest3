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
        $date = Carbon::today()->format('Y年m月d日');
        $time = Carbon::now()->format('H:i');
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
        $weekdayIndex = Carbon::now()->format('w');
        $weekday = $weekdays[$weekdayIndex];

        return view('user_index',compact('date','time','weekday',));
    }

    // public function work(){
    //     $date = Carbon::today()->format('Y年m月d日');
    //     $time = Carbon::now()->format('H:i');
    //     $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
    //     $weekdayIndex = Carbon::now()->format('w');
    //     $weekday = $weekdays[$weekdayIndex];

    //     return view('work',compact('date','time','weekday',));
    // }
    // public function form(Request $request){
    //     if($request->has('rest')){
    //         return redirect('/rest');
    //     }
    //     if($request->has('finish')){
    //         return redirect('/finish');
    //     }
    // }
    // public function rest(){
    //     $date = Carbon::today()->format('Y年m月d日');
    //     $time = Carbon::now()->format('H:i');
    //     $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
    //     $weekdayIndex = Carbon::now()->format('w');
    //     $weekday = $weekdays[$weekdayIndex];

    //     return view('rest',compact('date','time','weekday',));
    // }
    // public function finish(){
    //     $date = Carbon::today()->format('Y年m月d日');
    //     $time = Carbon::now()->format('H:i');
    //     $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
    //     $weekdayIndex = Carbon::now()->format('w');
    //     $weekday = $weekdays[$weekdayIndex];

    //     return view('finish',compact('date','time','weekday',));
    // }



    public function login(){
        return view('auth.user_login');
    }
    public function check(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'ログイン情報が正しくありません。',
        ]);
    }
    public function destroy(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }


    public function test(Request $request){
        if($request->has('start')){
            $date = Carbon::today()->format('Y年m月d日');
            $time = Carbon::now()->format('H:i');
            $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
            $weekdayIndex = Carbon::now()->format('w');
            $weekday = $weekdays[$weekdayIndex];
            $name = 'work';
            return view('user_index',compact('date','time','weekday','name',));
        }
        if($request->has('rest')){
            $date = Carbon::today()->format('Y年m月d日');
            $time = Carbon::now()->format('H:i');
            $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
            $weekdayIndex = Carbon::now()->format('w');
            $weekday = $weekdays[$weekdayIndex];
            $name = 'rest';
            return view('user_index',compact('date','time','weekday','name',));
        }
        if($request->has('restart')){
            $date = Carbon::today()->format('Y年m月d日');
            $time = Carbon::now()->format('H:i');
            $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
            $weekdayIndex = Carbon::now()->format('w');
            $weekday = $weekdays[$weekdayIndex];
            $name = 'work';
            return view('user_index',compact('date','time','weekday','name',));
        }
        if($request->has('finish')){
            $date = Carbon::today()->format('Y年m月d日');
            $time = Carbon::now()->format('H:i');
            $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
            $weekdayIndex = Carbon::now()->format('w');
            $weekday = $weekdays[$weekdayIndex];
            $name = 'finish';
            return view('user_index',compact('date','time','weekday','name',));
        }
    }
}
