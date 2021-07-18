<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check()){
            $user_id=Auth::id();
            $user=User::findOrFail($user_id);
            if($user->esVerificado()){
              return view('home');
            }else{
              return view('home.verification');
            }
        }
        return view('home');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getTokens()
    {
        if(Auth::check()){
            $user_id=Auth::id();
            $user=User::findOrFail($user_id);
            if($user->esVerificado()){

              return view('home.personal-tokens');
            }else{
              return view('home.verification');
            }
        }
        return view('home');
    }
}
