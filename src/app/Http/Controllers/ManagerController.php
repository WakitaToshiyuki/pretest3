<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use App\Models\Application;
use App\Models\ApplicationRest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class ManagerController extends Controller
{
    public function index(Request $request){
        if ($request->date) {
            $date = Carbon::parse($request->date);
        } else {
            $date = Carbon::today();
        }
        $nextDay = $date->copy()->addDay()->format('Y-m-d');
        $prevDay = $date->copy()->subDay()->format('Y-m-d');
        $works = Work::with('user')->whereDate('date', $date)->get();
        $totalrests = [];
        $totalworks = [];
        foreach($works as $work){
            if ($work->finish_time !== null) {
                $rests = Rest::where('work_id', $work->id)->get();
                $totalrest = 0;
                foreach ($rests as $rest) {
                    $rest_start = Carbon::parse($rest->start_time);
                    $rest_finish = Carbon::parse($rest->finish_time);
                    $rest_time = $rest_finish->diffInMinutes($rest_start);
                    $totalrest += $rest_time;
                }
                $totalrests[$work->id] = CarbonInterval::minutes($totalrest)->cascade()->format('%h:%I');
                $work_start = Carbon::parse($work->start_time);
                $work_finish = Carbon::parse($work->finish_time);
                $work_time = $work_finish->diffInMinutes($work_start);
                $totalworks[$work->id] = CarbonInterval::minutes($work_time - $totalrest)->cascade()->format('%h:%I');
            } else {
                $totalrests[$work->id] = null;
                $totalworks[$work->id] = null;
            }
        }
        return view('manager_index',compact('works','date','prevDay','nextDay','totalrests','totalworks',));
    }

    public function list(){
        $users = User::all();
        return view('manager_staff_list',compact('users',));
    }

    public function login(){
        return view('auth.manager_login');
    }
    public function check(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::guard('manager')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/attendance/list');
        }
        return back()->withErrors([
            'email' => 'ログイン情報が正しくありません。',
        ]);
    }

    public function destroy(Request $request){
        Auth::guard('manager')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function detail($work_id){
        $work = Work::findOrFail($work_id);
        $date = $work->date;
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
        if($application){
            $applicationRests = ApplicationRest::where('application_id', $application->id)->get();
            $applicationRestCount = $applicationRests->count();
            $applicationRestRows = [];
            for ($i = 0; $i<$applicationRestCount; $i++) {
                $applicationRest = $applicationRests[$i] ?? null;
                $applicationRestRows[] = [
                    'label' => $i === 0 ? '休憩' : '休憩' . ($i + 1),
                    'start_time' => Carbon::parse($applicationRest->update_start_time)->format('H:i'),
                    'finish_time' => $applicationRest ? Carbon::parse($applicationRest->update_finish_time)->format('H:i') : '',
                ];
            }
            return view('manager_detail',compact('work','application','applicationRests','restRows','applicationRestRows','date'));
        }else{
            return view('manager_detail',compact('work','application','restRows','date',));
        }
    }

    public function request_list(){
        $applications = Application::all();
        return view('manager_request',compact('applications',));
    }
}
