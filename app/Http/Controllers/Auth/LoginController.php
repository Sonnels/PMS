<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function login(){
        $credentials = $this->validate(request(), [
            $this->username() => 'required|string|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($credentials)){
            if (auth()->user()->Estado == 'ACTIVO') {
                return redirect()->route('dashboard.index');
            }else{
                Auth::logout();
                return redirect('/')->with('flash','Su cuenta se encuentra INACTIVA, por favor COMUNIQUESE con el ADMINISTRADOR!');
            }
        }

        return back()
        ->withErrors([$this->username() => trans('auth.failed')])
        ->withInput(request([$this->username()]));


    }
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');


    }

    public function username(){
        return 'email';
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

}
