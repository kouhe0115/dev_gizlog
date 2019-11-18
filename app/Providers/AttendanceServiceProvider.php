<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\AttendanceService;

class AttendanceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Attendance',function($app){
            return new AttendanceService();
        });
    }
}
