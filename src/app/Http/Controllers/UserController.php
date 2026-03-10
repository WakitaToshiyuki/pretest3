<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(){
        $date = Carbon::today();
        $time = Carbon::now()->format('H:i');
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
        $weekdayIndex = Carbon::now()->format('w');
        $weekday = $weekdays[$weekdayIndex];

        return view('user_index',compact('date','time','weekday',));
    }

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
        $user = auth('web')->user();
        $date = Carbon::today()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
        $weekdayIndex = Carbon::now()->format('w');
        $weekday = $weekdays[$weekdayIndex];
            
        if($request->has('start')){
            $name = 'work';
            $form =[
                'user_id'=>$user->id,
                'date'=>$date,
                'start_time'=>$time,
            ];
            Work::create($form);
            return view('user_index',compact('date','time','weekday','name',));
        }
        if($request->has('rest')){
            $work = Work::where('user_id', $user->id)->whereNull('finish_time')->firstOrFail();
            $name = 'rest';
            $form =[
                'work_id'=>$work->id,
                'start_time'=>$time,
            ];
            Rest::create($form);
            return view('user_index',compact('date','time','weekday','name',));
        }
        if($request->has('restart')){
            $name = 'work';
            $form =[
                'work_id'=>$user->id,
                'start_time'=>$request->post_number,
                'finish_time'=>$request->address,
            ];
            return view('user_index',compact('date','time','weekday','name',));
        }
        if($request->has('finish')){
            $name = 'finish';
            $form =[
                'user_id'=>$user->id,
                'date'=>$date,
                'start_time'=>$request->post_number,
                'finish_time'=>$request->address,
            ];
            dd($form);
            return view('user_index',compact('date','time','weekday','name',));
        }
    }
}
