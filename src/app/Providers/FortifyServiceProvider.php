<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //User Fortify
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::registerView(function(){
            return view('auth.user_register');
        });
        RateLimiter::for('login',function(Request $request){
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email.$request->ip());
        });
        Fortify::loginView(function(){
            return view('auth.user_login');
        });

        Fortify::authenticateUsing(function(Request $request){
            $user=User::where('email',$request->email)->first();
            if($user && Hash::check($request->password,$user->password)){
                return $user;
            }
            return null;
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        //Manager Fortify
    }
}
