<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Mail\UserCreated;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
/*
        User::updated(function($user){
            if($user->isDirty('email')){
              Mail::to($user->email)->send(new UserCreated($user));
            }
            if($user->verify_Token!=null && $user->isDirty('verify_Token')){
              Mail::to($user->email)->send(new UserCreated($user));
            }
        });
    */
    }
}
