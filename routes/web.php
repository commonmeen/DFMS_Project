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

Route::any('/', 'MenuController@getMenu');

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

Route::any('FileUpload','FileUploadController@upload');

Route::any('ListProcess','ListProcessController@listProcess');

Route::any('DataProcess','ProcessFormController@newProcessForm');

Route::any('ProcessDetail','ProcessDetailController@processDetail');

Route::any('CancelProcess','CancelProcessController@cancel');

Route::any('NewProcess','NewProcessController@newProcess');

Route::any('GetDocumentByFlow','GetFlowDocumentController@getDoc');

Route::any('EditFlow','EditFlowManageController@editFlow');

Route::any('ChangeStep','ChangeStepController@changeStep');

Route::any('ChangeStepSave','ChangeStepController@changeStepSave');

Route::any('ListVerify','ValidateListController@listProcessForValidate');

Route::any('CheckTypeValidate','CheckTypeValidateController@chkValidate');

Route::any('Approve','ApproveProcessController@approveProcess');

Route::any('Reject','RejectProcessController@rejectProcess');

Route::any('clear/session/{key}', 'ClearSessionController@test');

Route::get('Logout','LogoutController@logout');

Route::any('ChkPassword','ChkPasswordController@chkPassword');

Route::any('ChkOTP','ChkOTPController@chkOTP');

Route::any('SentOTP','SentOTPController@sentOTP');

Route::any('SaveDocTemplate','SaveDocTemplateController@saveTemplate');

Route::any('ListDocTemplate','ListDocTemplateController@listTemplate');

Route::any('TemplateDetail','TemplateDetailController@templateDetail');

Route::any('AddDocTemplate', function() {
    return view('AddDocTemplate');
});

// Validate data
Route::any('NameValidate','AddFlowController@validateName');

Route::any('NumStepValidate','AddFlowController@validateNumberOfStep');

Route::any('AddStepTitleValidate','AddStepController@validateTitle');

Route::any('AddStepDeadlineValidate','AddStepController@validateDeadline');