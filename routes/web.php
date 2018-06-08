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

Route::any('ListFlow', 'ListFlowController@listFlow');

Route::get('/', 'MenuController@getMenu');

Route::any('AddFlow', 'ListCatController@getAllCategory');

Route::any('ListTemplate','AddFlowController@addFlow');

Route::any('AddStep', 'AddStepController@addStep');

Route::any('SearchUser','SearchUserController@searchUser');

Route::any('AddFlowTemplate','AddFlowTemplateController@addFlowTemplate');

Route::any('AddCategory','AddCatController@addCat');

Route::any('SearchPosition','SearchUserController@searchPosition');

Route::any('FlowDetail','FlowDetailController@detail')->name('FlowDetail');

Route::any('LockFlow','LockFlowController@lockFlow');

Route::any('EditStep','EditStepController@editStep');

Route::any('GetSelectValidator','SearchUserController@getValidator');

// Validate data
Route::any('NameValidate','AddFlowController@validateName');

Route::any('DeadlineValidate','AddFlowController@validateDeadline');

Route::any('NumStepValidate','AddFlowController@validateNumberOfStep');

Route::any('AddStepTitleValidate','AddStepController@validateTitle');

Route::any('AddStepDeadlineValidate','AddStepController@validateDeadline');
