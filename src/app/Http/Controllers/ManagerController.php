<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
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
}
