<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;

class UserController extends Controller
{
    public function index(){
        return view('user_index');
    }
}
