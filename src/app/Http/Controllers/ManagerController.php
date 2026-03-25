<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        return view('manager_index',compact('works','date','prevDay','nextDay',));
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
