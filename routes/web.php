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
                    Route::get('/Mood/addDeleteAction', 'Mood\MoodController@ddDeleteAction')->name('mood.addDeleteAction');
                    Route::get('/Mood/updateActionMoods', 'Mood\MoodController@updateActionMoods')->name('ajax.updateActionMoods');
                    Route::get("/Mood/ActionDayAdd","Mood\MoodController@addActionDay")->name("ActionDay.Add");
                    Route::get("/Mood/changeDay","Mood\MoodController@changeDay")->name("Action.changeDay");
                    
                    
                    Route::get("/Drugs/Add",'Drugs\DrugsController@add')->name("Drugs.Add");
                    Route::get("/Drugs/loadPortion",'Drugs\DrugsController@loadPortion')->name("Drugs.loadTypePortion");
                    Route::get("/Drugs/show",'Drugs\DrugsController@show')->name("Drugs.show");
                    Route::get("/Drugs/sumAverage","Drugs\DrugsController@sumAverage")->name("Drugs.sumAverage");
                    Route::get("/Drugs/sumAverage2","Drugs\DrugsController@sumAverage2")->name("Drugs.sumAverage2");
                    Route::get("/Drugs/showDescription","Drugs\DrugsController@showDescriptionsAction")->name("Drugs.showDescription");
                    Route::get("/Drugs/addDescription","Drugs\DrugsController@addDescriptionsAction")->name("Drugs.addDescriptions");
                    Route::get("/Drugs/deleteDrugs","Drugs\DrugsController@deleteDrugs")->name("Drugs.deleteDrugs");
                    Route::get("/Drugs/editDrugs","Drugs\DrugsController@EditDrugs")->name("Drugs.editDrugs");
                    Route::get("/Drugs/updateDrugs","Drugs\DrugsController@updateRegistration")->name("Drugs.updateDrugs");
                    Route::get("/Drugs/showUpdateDrugs","Drugs\DrugsController@updateShowRegistration")->name("Drugs.updateShowDrugs");
                    Route::get("/Drugs/closeForm","Drugs\DrugsController@closeForm")->name("Drugs.closeForm");
                    Route::get("/Drugs/calculateBenzo","Drugs\DrugsController@calculateBenzo")->name("Drugs.calculateBenzo");
                    
                    
                    
                    Route::get('/User/Setting', 'User\SettingController@Setting')->name('user.setting');
                    Route::get('/User/Settingas', 'User\SettingController@SettingActionAdd')->name('Setting.ActionAdd');
                    Route::get('/User/SettingaMood', 'User\SettingController@SettingchengeMood')->name('Setting.levelMoodChange');
                    Route::get('/User/SettingaChangeActionName', 'User\SettingController@SettingaChangeActionName')->name('user.changeActionName');
                    Route::get('/User/SettingaChangeActionName2', 'User\SettingController@SettingaChangeActionName2')->name('user.changeActionName2');
                    Route::get('/User/SettingaChangeActionDateName', 'User\SettingController@SettingaChangeActionDateName')->name('user.changeActionDateName');
                    Route::get('/User/SettingaChangeActionDateName2', 'User\SettingController@SettingaChangeActionDateName2')->name('user.changeActionDateName2');
                    Route::get('/User/SettingupdateHash', 'User\SettingController@SettingupdateHash')->name('setting.updateHash');
                    Route::get('/User/deleteActionPlans', 'User\SettingController@SettingdeleteActionPlans')->name('user.deleteActionPlans');
                    Route::get('/User/addGroup', 'User\SettingController@addGroupAction')->name('setting.addGroup');
                    Route::get('/User/addSubstances', 'User\SettingController@addSubstancesAction')->name('setting.addSubstances');
                    Route::get('/User/addProduct', 'User\SettingController@addProductAction')->name('setting.addProduct');
                    Route::get('/User/addPlaned', 'User\SettingController@addPlanedAction')->name('setting.addPlaned');
                    Route::get('/User/loadPlaned', 'User\SettingController@loadPlanedAction')->name('setting.loadPlaned');
                    Route::get('/User/loadPosition', 'User\SettingController@loadPosition')->name('setting.loadPosition');
                    Route::get('/User/updatePlaned', 'User\SettingController@updatePlaned')->name('setting.updatePlaned');
                    Route::get('/User/deletePlaned/{name}', 'User\SettingController@deletePlaned')->name('setting.deletePlaned');
                    Route::get('/User/editGroup', 'User\SettingController@editGroup')->name('setting.editGroup');
                    Route::get('/User/changeGroup', 'User\SettingController@changeGroup')->name('setting.changeGroup');
                    Route::get('/User/editSubstance', 'User\SettingController@editSubstance')->name('setting.editSubstances');
                    Route::get('/User/changeSubstance', 'User\SettingController@changeSubstance')->name('setting.changeSubstance');
                    Route::get('/User/editProduct', 'User\SettingController@editProduct')->name('setting.editProduct');
                    Route::get('/User/changeProduct', 'User\SettingController@changeProduct')->name('setting.changeProduct');
                    
                    
                    Route::get("/Mood/SleepDelete",'Mood\MoodController@SleepDelete')->name("sleep.delete");
                    Route::get("/Mood/SleepAdd",'Mood\MoodController@Sleepadd')->name("Sleep.Add");
                    Route::get("/Mood/SleepEdit",'Mood\MoodController@SleepEdit')->name("sleep.edit");
                    Route::get("/Mood/SleepEditAction",'Mood\MoodController@SleepEditAction')->name("Sleep.editAction");
                    
                    Route::get("/Mood/changeMinutes/{minutes}",'Mood\MoodController@changeMinutes')->name("change.minutes");
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    
                    Route::get("/Search/main","Search\SearchController@main")->name("Search.main");
                    Route::get("/Search/mainAction","Search\SearchController@mainAction")->name("search.mainAction");
                   
                    Route::get("/Search/SearchAIAction","Search\SearchController@searchAI")->name("Search.AI");
                    Route::get("/Search/SearchSumMood","Search\SearchController@searchSumMood")->name("Search.SumMood");
                    Route::get("/Search/searchDrugs","Search\SearchController@searchDrugs")->name("search.searchDrugs");
                    Route::get("/Search/selectDrugs","Search\SearchController@selectDrugs")->name("search.selectDrugs");
                    Route::get("/Search/sleepAction","Search\SearchController@sleepAction")->name("search.sleepAction");
                    Route::get("/Search/mainActionAllDay","Search\SearchController@mainActionAllDay")->name("search.mainActionAllDay");
                    Route::get("/Search/generationPDF","Search\SearchController@generationPDF")->name("search.generationPDF");
                    
                    
                
                    
                    //Route::get("/Search/sleepsSumMoods","Search\SearchController@sleepsSumMoods")->name("search.sleepsSumMoods");
                    //Route::get("/Search/difference","Search\SearchController@selectDifference")->name("search.difference");
                    
                    
                    
                    Route::get("/DrSearch/main","Dr\Search\SearchController@main")->name("DrSearch.main");
                    Route::get("/DrSearch/mainAction","Dr\Search\SearchController@mainAction")->name("Drsearch.mainAction");
                    Route::get("/DrSearch/sleepAction","Dr\Search\SearchController@sleepAction")->name("Drsearch.sleepAction");
                    Route::get("/DrSearch/SearchAIAction","Dr\Search\SearchController@searchAI")->name("DrSearch.AI");
                    Route::get("/DrSearch/SearchSumMood","Dr\Search\SearchController@searchSumMood")->name("DrSearch.SumMood");
                    Route::get("/DrSearch/searchDrugs","Dr\Search\SearchController@searchDrugs")->name("Drsearch.searchDrugs");
                    Route::get("/DrSearch/selectDrugs","Dr\Search\SearchController@selectDrugs")->name("Drsearch.selectDrugs");
                   
                    Route::get("/DrDrugs/show",'Dr\Drugs\DrugsController@show')->name("DrDrugs.show"); 
                    Route::get("/DrDrugs/sumAverage","Dr\Drugs\DrugsController@sumAverage")->name("DrDrugs.sumAverage");
                    Route::get("/DrDrugs/sumAverage2","Dr\Drugs\DrugsController@sumAverage2")->name("DrDrugs.sumAverage2");
                    Route::get("/DrDrugs/showDescription","Dr\Drugs\DrugsController@showDescriptionsAction")->name("DrDrugs.showDescription");
                    Route::get("/DrDrugs/calculateBenzo","Dr\Drugs\DrugsController@calculateBenzo")->name("DrDrugs.calculateBenzo");
                    Route::get('/DrMood/ShowDescription', 'Dr\Mood\MoodController@ShowDescription')->name('Drmood.showDescription');
                    Route::get('/DrMood/ActionShow', 'Dr\Mood\MoodController@ActionShow')->name('Draction.show');
                    
                    
                    Route::get("/sada",'Main\MainController@ss')->name("DrSearch.SumMoodss");
                    
                    Route::get('/Dr', 'Dr\Main\MainController@index')->name('mainmainDr');
                    Route::get('/Drmain/{year?}/{month?}/{day?}/{action?}', 'Dr\Main\MainController@index')->name('Drmain');
            /*
             * Routy dla userów z rolą partner
             */
            Route::group(
                ['middleware' => ['role:user']],
                function () {
                    
                });
    }
    );
Route::post("passwordResetConfirm2","User\SettingController@passwordConfirm2")->name("User.resetPasswordConfirm2");    
Route::get("passwordResetConfirm/{hash}","User\SettingController@passwordConfirm")->name("user.passwordConfirm");
Route::get("passwordReset","User\SettingController@passwordReset")->name("user.passwordReset");
Route::post("passwordResetSubmit","User\SettingController@passwordResetSubmit")->name("user.passwordResetSubmit");
Route::get('/register', 'User\UserRegisterController@index')->name('user.index');
Route::post('/registerSubmit', 'User\UserRegisterController@store')->name('user.registerSubmit');
//Route::get('/login', 'User\UserLoginController@index')->name('user.login');
Route::post('/loginSubmit', 'User\UserLoginController@store')->name('user.loginSubmit');
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/logout', 'Auth\LoginController@logout')->name("logout");
Route::post("/login/user",'Auth\LoginController@loginDr')->name("userDr");

Route::post('/loginDrSubmit', 'Dr\User\UserLoginController@loginDr')->name('userDr.loginSubmit');
Route::get('/loginDr', 'Dr\User\UserLoginController@loginDrView')->name('userDr.login');


Auth::routes();









Route::get('/home', 'HomeController@index')->name('home');
