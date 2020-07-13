<?php

use Illuminate\Support\Facades\Route;

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



Route::group(
    ['middleware' => ['auth']],
    function () {
    Route::get('/home', 'Main\MainController@index')->name('home');
    Route::get('/', 'Main\MainController@index')->name('mainmain');
    Route::get('/main/{year?}/{month?}/{day?}/{action?}', 'Main\MainController@index')->name('main');
    Route::get('/Mood/Add', 'Mood\MoodController@add')->name('Mood.Add');
    Route::get('/Mood/ActionAdd', 'Mood\MoodController@Actionadd')->name('Action.Add');
    Route::get('/User/Setting', 'User\SettingController@Setting')->name('user.setting');
    Route::get('/User/Settingas', 'User\SettingController@SettingActionAdd')->name('Setting.ActionAdd');
    Route::get('/User/SettingaMood', 'User\SettingController@SettingchengeMood')->name('Setting.levelMoodChange');
    Route::get("/Mood/SleepAdd",'Mood\MoodController@Sleepadd')->name("Sleep.Add");
        /*
         * Routy dla userów z rolą partner
         */
        Route::group(
            ['middleware' => ['role:partner']],
            function () {
            
            });
    }
    );


Route::get('/register', 'User\UserRegisterController@index')->name('user.index');
Route::post('/registerSubmit', 'User\UserRegisterController@store')->name('user.registerSubmit');
//Route::get('/login', 'User\UserLoginController@index')->name('user.login');
Route::post('/loginSubmit', 'User\UserLoginController@store')->name('user.loginSubmit');
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/logout', 'Auth\LoginController@logout')->name("logout");
Auth::routes();









Route::get('/home', 'HomeController@index')->name('home');
