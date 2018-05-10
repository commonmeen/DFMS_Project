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
// Validate data
Route::any('NameValidate','AddFlowController@validateName');

Route::any('DeadlineValidate','AddFlowController@validateDeadline');

Route::any('NumStepValidate','AddFlowController@validateNumberOfStep');