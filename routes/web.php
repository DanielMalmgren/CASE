<?php

Auth::routes();

Route::get('/',                                 'HomeController@index');
Route::get('/about',                            'HomeController@about');

//TrackController
Route::get('/tracks',                           'TrackController@index');
Route::get('/track/{track}',                    'TrackController@show');

//LessonController
Route::get('/lessons/{lesson}',                 'LessonController@show');
Route::get('/lessons/{lesson}/edit',            'LessonController@edit');
Route::put('/lessons/{lesson}',                 'LessonController@update');
Route::put('/lessons/{lesson}/vote',            'LessonController@vote');

//TestController
Route::get('/test/{lesson}',                    'TestController@show');
Route::post('/test/storeResponse',              'TestController@store');

//QuestionController
Route::get('/test/question/create',             'QuestionController@create');
Route::post('/test/question',                   'QuestionController@store');
Route::get('/test/question/{question}',         'QuestionController@show');
Route::get('/test/question/{question}/edit',    'QuestionController@edit');
Route::put('/test/question/{question}',         'QuestionController@update');
Route::delete('/test/question/{question}',      'QuestionController@destroy');

//TestResultController
Route::get('/test/result/{test_session}',       'TestResultController@show');

//UsersControler
Route::get('/userinfo/{user?}',                 'UsersController@show');
Route::get('/listusers',                        'UsersController@index')->middleware('permission:list users');
Route::get('/exportusers',                      'UsersController@export')->middleware('permission:list users');

//ActiveTimeController
Route::post('/activetime',                      'ActiveTimeController@store');
Route::get('/exportactivetime/{user?}',         'ActiveTimeController@export');

//FirstLoginController
Route::get('/firstlogin',                       'FirstLoginController@show');
Route::post('storefirstloginlanguage',          'FirstLoginController@storeLanguage');
Route::post('storegdpraccept',                  'FirstLoginController@storeGdprAccept');

//SettingsController
Route::get('/settings',                         'SettingsController@edit');
Route::post('storesettings',                    'SettingsController@store');
Route::post('storelanguage',                    'SettingsController@storeLanguage');

//WorkplaceSettingsController
Route::get('/wpsettings',                       'WorkplaceSettingsController@edit');
Route::post('storewpsettings',                  'WorkplaceSettingsController@store');
Route::get('/wpsettingsajax/{workplace}',       'WorkplaceSettingsController@ajax');

//AnnouncementsController
Route::resource('announcements',                'AnnouncementsController');
