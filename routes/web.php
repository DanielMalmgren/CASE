<?php

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/',                                 'HomeController@index');
Route::get('/about',                            'HomeController@about');
//Route::get('/logout',                           'HomeController@logout');

//TrackController
Route::get('/tracks/create',                    'TrackController@create')->middleware('permission:manage tracks');
Route::post('/tracks',                          'TrackController@store')->middleware('permission:manage tracks');
Route::get('/tracks',                           'TrackController@index');
Route::get('/tracks/{track}',                   'TrackController@show');
Route::get('/tracks/{track}/edit',              'TrackController@edit')->middleware('permission:manage tracks');
Route::put('/tracks/{track}',                   'TrackController@update')->middleware('permission:manage tracks');
Route::get('/tracks/{track}/pdfdiploma',        'TrackController@pdfdiploma');
Route::post('/tracks/reorder',                  'TrackController@reorder')->middleware('permission:manage tracks');

//LessonController
Route::get('/lessons/create/{track}',           'LessonController@create')->middleware('permission:manage lessons');
Route::post('/lessons',                         'LessonController@store')->middleware('permission:manage lessons');
Route::get('/lessons/{lesson}/edit',            'LessonController@edit')->middleware('permission:manage lessons');
Route::put('/lessons/{lesson}',                 'LessonController@update')->middleware('permission:manage lessons');
Route::get('/lessons/{lesson}/editquestions',   'LessonController@editquestions')->middleware('permission:manage lessons');
Route::put('/lessons/{lesson}/vote',            'LessonController@vote');
Route::get('/lessons/{lesson}/finish',          'LessonController@finish');
Route::post('/lessons/reorder',                 'LessonController@reorder')->middleware('permission:manage lessons');
Route::get('/lessons/{lesson}/replicate',       'LessonController@replicate');
Route::get('/lessons/{lesson}/{page?}',         'LessonController@show');
Route::post('/lessons/replicateQuestions',      'LessonController@replicateQuestions');
Route::delete('/lessons/{lesson}',              'LessonController@destroy')->middleware('permission:manage lessons');

//TestController
Route::get('/test/{lesson}',                    'TestController@show');
Route::post('/test/{lesson}/number_of_questions', 'TestController@set_number_of_questions');
Route::post('/test/storeResponse',              'TestController@store');

//TestResultController
Route::get('/test/result/{test_session}',       'TestResultController@show');
Route::post('/test/{test_session}/pdfdiploma',  'TestResultController@pdfdiploma');
Route::post('/test/{test_session}/resultmail',  'TestResultController@resultmail')->middleware(['honey', 'honey-recaptcha']);

//QuestionController
Route::get('/test/question/create',             'QuestionController@create')->middleware('permission:manage lessons');
Route::post('/test/question',                   'QuestionController@store')->middleware('permission:manage lessons');
Route::get('/test/question/{question}',         'QuestionController@show');
Route::get('/test/question/{question}/edit',    'QuestionController@edit')->middleware('permission:manage lessons');
Route::put('/test/question/{question}',         'QuestionController@update')->middleware('permission:manage lessons');
Route::delete('/test/question/{question}',      'QuestionController@destroy')->middleware('permission:manage lessons');
Route::post('/test/question/reorder',           'QuestionController@reorder')->middleware('permission:manage lessons');

//FeedbackController
Route::get('/feedback',                         'FeedbackController@create');
Route::post('/feedback',                        'FeedbackController@post');

//UsersControler
Route::get('/users/create',                     'UsersController@create')->middleware('permission:manage users');
Route::get('/users/{user}',                     'UsersController@show');
Route::get('/users/{user}/edit',                'UsersController@edit')->middleware('permission:manage users');
Route::put('users/{user}',                      'UsersController@update')->middleware('permission:manage users');
Route::post('/users',                           'UsersController@store')->middleware('permission:manage users');
Route::get('/users',                            'UsersController@index')->middleware('permission:manage users');
//Route::get('/exportusers',                      'UsersController@export')->middleware('permission:manage users');
Route::delete('/user/{user}',                   'UsersController@destroy')->middleware('permission:manage users');
Route::get('/select2users',                     'UsersController@select2');

//FirstLoginController
Route::get('/firstlogin',                       'FirstLoginController@show');
Route::post('storefirstloginlanguage',          'FirstLoginController@storeLanguage');
Route::post('storegdpraccept',                  'FirstLoginController@storeGdprAccept');

//SettingsController
Route::get('/settings/{user?}',                 'SettingsController@edit');
Route::post('storesettings/{user}',             'SettingsController@store');
Route::post('storelanguage',                    'SettingsController@storeLanguage');

//WorkplaceController
Route::get('/workplace/create',                 'WorkplaceController@create')->middleware('permission:add workplaces');
Route::post('/workplace',                       'WorkplaceController@store')->middleware('permission:add workplaces');
Route::get('/workplace',                        'WorkplaceController@edit')->middleware('permission:edit workplaces');
Route::put('/workplace/{workplace}',            'WorkplaceController@update')->middleware('permission:edit workplaces');
Route::get('/workplaceajax/{workplace}',        'WorkplaceController@ajax')->middleware('permission:edit workplaces');
Route::delete('/workplace/{workplace}',         'WorkplaceController@destroy')->middleware('permission:add workplaces');

//SessionController
Route::get('/sessions',                         'SessionController@index')->middleware('permission:manage users');

//StatisticsController
Route::get('/statistics',                       'StatisticsController@index');
Route::get('/statistics/ajaxchart/{chartid}',   'StatisticsController@ajaxchart');

//AnnouncementsController
Route::resource('announcements',                'AnnouncementsController');

//SearchController
Route::get('/select2search',                    'SearchController@select2');

//PollController
Route::get('/poll',                             'PollController@index');
Route::get('/poll/create',                      'PollController@create');
Route::post('/poll',                            'PollController@store');
Route::get('/poll/{poll}',                      'PollController@show');
Route::get('/poll/{poll}/edit',                 'PollController@edit');
Route::put('/poll/{poll}',                      'PollController@update');
Route::get('/poll/{poll}/exportresponses',      'PollController@exportresponses');

//PollQuestionController
Route::get('/pollquestion/create/{poll}',       'PollQuestionController@create');
Route::post('/pollquestion',                    'PollQuestionController@store');
Route::get('/pollquestion/{question}',          'PollQuestionController@show');
Route::get('/pollquestion/{question}/edit',     'PollQuestionController@edit');
Route::put('/pollquestion/{question}',          'PollQuestionController@update');
Route::post('/pollquestion/reorder',            'PollQuestionController@reorder');

//PollResponseController
Route::post('/pollresponse',                    'PollResponseController@store');
