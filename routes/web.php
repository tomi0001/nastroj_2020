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
                    Route::get('/Mood/Edit', 'Mood\MoodController@edit')->name('mood.edit');
                    Route::get('/Mood/Delete', 'Mood\MoodController@delete')->name('mood.delete');
                    Route::get('/Mood/AddDescription', 'Mood\MoodController@AddDescription')->name('mood.addDescription');
                    Route::get('/Mood/ShowDescription', 'Mood\MoodController@ShowDescription')->name('mood.showDescription');
                    Route::get('/Mood/ActionShow', 'Mood\MoodController@ActionShow')->name('action.show');
                    Route::get('/Mood/EditDescription', 'Mood\MoodController@EditDescription')->name('Mood.editDescription');
                    Route::get('/Mood/EditAction', 'Mood\MoodController@EditAction')->name('Mood.editAction');
                    
                    
                    Route::get('/User/Setting', 'User\SettingController@Setting')->name('user.setting');
                    Route::get('/User/Settingas', 'User\SettingController@SettingActionAdd')->name('Setting.ActionAdd');
                    Route::get('/User/SettingaMood', 'User\SettingController@SettingchengeMood')->name('Setting.levelMoodChange');
                    Route::get('/User/SettingaChangeActionName', 'User\SettingController@SettingaChangeActionName')->name('user.changeActionName');
                    Route::get('/User/SettingaChangeActionName2', 'User\SettingController@SettingaChangeActionName2')->name('user.changeActionName2');
                    Route::get('/User/SettingaChangeActionDateName', 'User\SettingController@SettingaChangeActionDateName')->name('user.changeActionDateName');
                    Route::get('/User/SettingaChangeActionDateName2', 'User\SettingController@SettingaChangeActionDateName2')->name('user.changeActionDateName2');

                    Route::get("/Mood/SleepDelete",'Mood\MoodController@Sleepadd')->name("sleep.delete");
                    Route::get("/Mood/SleepAdd",'Mood\MoodController@Sleepadd')->name("Sleep.Add");
                    Route::get("/Mood/changeMinutes/{minutes}",'Mood\MoodController@changeMinutes')->name("change.minutes");
                    

                    
                    Route::get("/Search/main","Search\SearchController@main")->name("Search.main");
                    Route::get("/Search/mainAction","Search\SearchController@mainAction")->name("search.mainAction");
            /*
             * Routy dla userów z rolą partner
             */
            Route::group(
                ['middleware' => ['role:user']],
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


Route::post('/loginDrSubmit', 'Dr\User\UserLoginController@loginDr')->name('userDr.loginSubmit');
Route::get('/loginDr', 'Dr\User\UserLoginController@loginDrView')->name('userDr.login');


Auth::routes();









Route::get('/home', 'HomeController@index')->name('home');
