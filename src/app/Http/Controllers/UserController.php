<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class UserController extends Controller
{
    public function index(){
        $user = auth('web')->user();
        $date = Carbon::today();
        $time = Carbon::now()->format('H:i');
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
        $weekdayIndex = Carbon::now()->format('w');
        $weekday = $weekdays[$weekdayIndex];
        $work = Work::where('user_id', $user->id)->whereDate('date', $date)->first();
        if (!$work) {
            return view('user_index', compact('date','time','weekday',));
        }
        if ($work && $work->finish_time === null) {
            $rest = Rest::where('work_id', $work->id)->whereNull('finish_time')->first();
            if ($rest) {
                $name = 'rest';
            }else{
                $name = 'work';
            }
            return view('user_index',compact('date','time','weekday','name',));
        }
        if ($work->finish_time !== null) {
            $name = 'finish';
            return view('user_index',compact('date','time','weekday','name',));
        }
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
            return redirect()->intended('/attendance');
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

    public function work(Request $request){
        $user = auth('web')->user();
        $date = Carbon::today();
        $time = Carbon::now()->format('H:i');
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
        $weekdayIndex = Carbon::now()->format('w');
        $weekday = $weekdays[$weekdayIndex];
            
        if($request->has('start')){
            $workCount = Work::where('user_id', $user->id)->where('date', $date)->exists();
            if($workCount){
                $error = '本日は出勤済みです。';
                return view('user_index',compact('date','time','weekday','error',));
            }
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
            $work = Work::where('user_id', $user->id)->whereNull('finish_time')->firstOrFail();
            $rest = Rest::where('work_id', $work->id)->whereNull('finish_time')->firstOrFail();
            $name = 'work';
            $form =[
                'work_id'=>$work->id,
                'start_time'=>$rest->start_time,
                'finish_time'=>$time,
            ];
            $rest->update($form);
            return view('user_index',compact('date','time','weekday','name',));
        }
        if($request->has('finish')){
            $work = Work::where('user_id', $user->id)->whereNull('finish_time')->firstOrFail();
            $name = 'finish';
            $form =[
                'user_id'=>$user->id,
                'date'=>$date,
                'start_time'=>$work->start_time,
                'finish_time'=>$time,
            ];
            $work->update($form);
            return view('user_index',compact('date','time','weekday','name',));
        }
    }

    public function list(Request $request){
        $user = auth('web')->user();
        if ($request->month) {
            $month = Carbon::parse($request->month);
        } else {
            $month = Carbon::today();
        }
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();
        $nextMonth = $month->copy()->addMonth()->format('Y-m');
        $prevMonth = $month->copy()->subMonth()->format('Y-m');
        $dates = [];
        $current = $start->copy();
        while ($current->lte($end)) {
            $dates[] = $current->copy();
            $work = Work::where('user_id', $user->id)->where('date', $current->toDateString())->first();
            $works[$current->toDateString()] = $work;
            if ($work) {
                $rests[$current->toDateString()] = Rest::where('work_id', $work->id)->get();
                $totalrest = 0;
                foreach ($rests[$current->toDateString()] as $rest) {
                    $rest_start = Carbon::parse($rest->start_time);
                    $rest_finish = Carbon::parse($rest->finish_time);
                    $rest_time = $rest_finish->diffInMinutes($rest_start);
                    $totalrest += $rest_time;
                };
                $totalrests[$current->toDateString()] = CarbonInterval::minutes($totalrest)->cascade()->format('%h:%I');
                if ($work->start_time && $work->finish_time){
                    $work_start = Carbon::parse($work->start_time);
                    $work_finish = Carbon::parse($work->finish_time);
                    $work_time = $work_finish->diffInMinutes($work_start);
                    $totalworks[$current->toDateString()] = CarbonInterval::minutes($work_time - $totalrest)->cascade()->format('%h:%I');
                }
            } else {
                $rests[$current->toDateString()] = collect();
                $totalrests[$current->toDateString()] = null;
                $totalworks[$current->toDateString()] = null;
            }
            $current->addDay();
        }
        return view('user_list',compact('month','dates','works','totalrests','totalworks','prevMonth','nextMonth',));
    }

    public function detail($date){
        $user = auth('web')->user();
        $work = Work::where('user_id', $user->id)->whereDate('date', $date)->first();
        $application = Application::where('work_id',$work->id)->first();
        $rests = Rest::where('work_id', $work->id)->get();
        $restCount = $rests->count()+1;
        $restRows = [];
        for ($i = 0; $i<$restCount; $i++) {
            $rest = $rests[$i] ?? null;
            $restRows[] = [
                'label' => $i === 0 ? '休憩' : '休憩' . ($i + 1),
                'start_time' => $rest ? Carbon::parse($rest->start_time)->format('H:i') : '',
                'finish_time' => $rest ? Carbon::parse($rest->finish_time)->format('H:i') : '',
            ];
        }
        return view('user_detail',compact('user','work','application','date','restRows'));
    }

    public function request($date,Request $request){
        $user = auth('web')->user();
        $work = Work::where('user_id', $user->id)->whereDate('date', $date)->first();
        $application = Application::where('work_id',$work->id)->first();
        $rests = Rest::where('work_id', $work->id)->get();
        $restCount = $rests->count()+1;
        $restRows = [];
        for ($i = 0; $i<$restCount; $i++) {
            $rest = $rests[$i] ?? null;
            $restRows[] = [
                'label' => $i === 0 ? '休憩' : '休憩' . ($i + 1),
                'start_time' => $rest ? Carbon::parse($rest->start_time)->format('H:i') : '',
                'finish_time' => $rest ? Carbon::parse($rest->finish_time)->format('H:i') : '',
            ];
        }
        return view('user_detail',compact('user','work','date','restRows'));
    }
}
