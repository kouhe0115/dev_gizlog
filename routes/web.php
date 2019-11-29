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
    
    Route::resource('report', DailyReportController::class);
    
    Route::get('question/{id}/mypage', ['as' => 'question.mypage', 'uses' => 'QuestionController@myPage']);
    Route::post('question/confirm', ['as' => 'question.confirm', 'uses' => 'QuestionController@confirm']);
    Route::post('question/{id}/confirm', ['as' => 'confirm.update', 'uses' => 'QuestionController@confirm']);
    Route::post('question/{id}/comment', ['as' => 'question.comment', 'uses' => 'QuestionController@storeComment']);
    Route::resource('question', QuestionController::class);
    
    Route::get('attendance', 'AttendanceController@index')->name('attendance');
    Route::get('attendance/mypage', 'AttendanceController@mypage')->name('attendance.mypage');
    Route::post('attendance', 'AttendanceController@setStartTime')->name('attendance.setStartTime');
    Route::put('attendance/{id}', 'AttendanceController@setEndTime')->name('attendance.setEndTime');
    Route::get('attendance/absence', 'AttendanceController@showAbsence')->name('attendance.showAbsence');
    Route::post('attendance/absence', 'AttendanceController@setAbsence')->name('attendance.setAbsence');
    Route::get('attendance/modify', 'AttendanceController@modify')->name('attendance.modify');
    Route::post('attendance/modify', 'AttendanceController@createModify')->name('attendance.createModify');
});


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
    Auth::routes();
    
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
    
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    
    Route::get('attendance', 'AttendanceController@index')->name('attendance');
    Route::get('attendance/{id}/user/create', 'AttendanceController@create')->name('attendance.create');
    Route::get('attendance/{id}/user/edit/{date}', 'AttendanceController@edit')->name('attendance.edit');
    Route::put('attendance/{id}/user', 'AttendanceController@update')->name('attendance.update');
    Route::put('attendance/{id}/user/delete', 'AttendanceController@delete')->name('attendance.delete');
    Route::get('attendance/{id}/user', 'AttendanceController@user')->name('attendance.user');
    /*
     * ---------------------------------------------------------
     */
    
    Route::get('report', function () {
        abort(404);
    });
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
    
    Route::post('password/email',
        ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset',
        ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ResetPasswordController@reset']);
    Route::get('password/reset/{token}',
        ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    
    Route::post('/register', ['as' => 'register', 'uses' => 'Auth\AdminRegisterController@adminRegister']);
    Route::get('/register/', 'Auth\AdminRegisterController@showAdminRegistrationForm');
    
});

