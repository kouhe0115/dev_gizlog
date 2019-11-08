<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['prefix' => '/', 'user.', 'namespace' => 'User'], function () {
    Auth::routes();

    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return view('user.auth.login');
        }
    });

    Route::get('slack/login', 'Auth\AuthenticateController@callSlackApi');
    Route::get('callback', 'Auth\AuthenticateController@loginBySlackUserInfo');

    Route::post('/register', 'Auth\RegisterController@register');
    Route::get('/register/{query}', 'Auth\RegisterController@showRegistrationForm');


    Route::get('home', 'UserController@index')->name('home');

    Route::get('attendance', ['as' => 'attendance.index', 'uses' => 'AttendanceController@index']);
    Route::post('attendance/register', ['as' => 'attendance.register.start', 'uses' => 'AttendanceController@setStartTime']);
    Route::put('attendance/{id}/register', ['as' => 'attendance.register.end', 'uses' => 'AttendanceController@setEndTime']);
    Route::get('attendance/absence', ['as' => 'attendance.absence', 'uses' => 'AttendanceController@showAbsenceForm']);
    Route::post('attendance/absence', ['as' => 'attendance.absence.store', 'uses' => 'AttendanceController@registerAbsence']);
    Route::get('attendance/modify', ['as' => 'attendance.modify', 'uses' => 'AttendanceController@showModifyForm']);
    Route::post('attendance/modify', ['as' => 'attendance.modify.store', 'uses' => 'AttendanceController@storeModifyRequest']);
    Route::get('attendance/mypage', ['as' => 'attendance.mypage', 'uses' => 'AttendanceController@showMypage']);

    Route::resource('report', DailyReportController::class);
    
    Route::resource('question', QuestionController::class);
    Route::get('question/{question}/mypage', 'QuestionController@myPage')->name('question.mypage');
    Route::post('question/confirm', 'QuestionController@confirm')->name('question.confirm');
});


Route::group(['prefix' => 'admin', 'as' => 'admin.' ,'namespace' => 'Admin'], function() {
    Auth::routes();

    Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

    Route::resource('report', DailyReportController::class, ['only' => ['index', 'show']]);
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    Route::get('attendance', ['as' => 'attendance.index', 'uses' => 'AttendanceController@index']);
    Route::get('attendance/{id}/user', ['as' => 'attendance.user', 'uses' => 'AttendanceController@user']);
    Route::get('attendance/{id}/user/create', ['as' => 'attendance.user.create', 'uses' => 'AttendanceController@create']);
    Route::get('attendance/{id}/user/edit/{date}', ['as' => 'attendance.user.edit', 'uses' => 'AttendanceController@edit']);
    Route::post('attendance/{id}/user', ['as' => 'attendance.user.store', 'uses' => 'AttendanceController@store']);
    Route::put('attendance/{id}/user', ['as' => 'attendance.user.update', 'uses' => 'AttendanceController@update']);
    Route::get('report', ['as' => 'report.index', 'uses' => 'DailyReportController@index']);
    Route::get('report/{id}/show', ['as' => 'report.show', 'uses' => 'DailyReportController@show']);

    Route::get('question', function () {
        abort(404);
    });

    Route::get('user', function () {
        abort(404);
    });

    Route::get('adminuser', function () {
        abort(404);
    });

    Route::get('contact', function () {
        abort(404);
    });

    Route::post('password/email',['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset',['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ResetPasswordController@reset']);
    Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);

    Route::post('/register', ['as' => 'register', 'uses' => 'Auth\AdminRegisterController@adminRegister']);
    Route::get('/register/', 'Auth\AdminRegisterController@showAdminRegistrationForm');

});

