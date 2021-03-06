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

Route::any('/', 'MenuController@getMenu');

Route::any('Login', 'IndexController@checkAuth');

Route::any('AddCategory','AddCatController@addCat');

Route::any('AddDocument','AddDocumentController@addDoc');

Route::any('AddDocTemplate', 'AddDocTemplateController@addTemplate');

Route::any('AddFlow', 'ListCatController@getAllCategory');

Route::any('AddFlowTemplate','AddFlowTemplateController@addFlowTemplate');

Route::any('AddStep', 'AddStepController@addStep');

Route::any('Approve','ApproveProcessController@approveProcess');

Route::any('CancelProcess','CancelProcessController@cancel');

Route::any('ChangeTemplateStatus','ChangeTemplateStatusController@changeStatusTemplate');

Route::any('ChangeStep','ChangeStepController@changeStep');

Route::any('ChangeStepSave','ChangeStepController@changeStepSave');

Route::any('CheckTypeValidate','CheckTypeValidateController@chkValidate');

Route::any('ChkOTP','ChkOTPController@chkOTP');

Route::any('ChkPassword','ChkPasswordController@chkPassword');

Route::any('DataProcess','ProcessFormController@newProcessForm');

Route::any('DocumentDetail','DocumentDetailController@docDetail');

Route::any('DeleteDocument','DeleteDocumentController@deleteDocument');

Route::any('EditFlow','EditFlowManageController@editFlow');

Route::any('EditDocTemplate', 'EditDocTemplateController@editDocTemplate');

Route::any('EditDocument','EditDocumentController@editDoc');

Route::any('EditStep','EditStepController@editStep');

Route::any('FileUpload','FileUploadController@upload');

Route::any('FlowDetail','FlowDetailController@detail')->name('FlowDetail');

Route::any('GetDocumentByFlow','GetFlowDocumentController@getDoc');

Route::any('GetSelectValidator','SearchUserController@getValidator');

Route::any('GetTemplateForDocument','TemplateForAddDocController@templateAddDoc');

Route::any('ListDocTemplate','ListDocTemplateController@listTemplate');

Route::any('ListDocument','ListDocumentController@listDoc');

Route::any('ListFlow', 'ListFlowController@listFlow');

Route::any('ListProcess','ListProcessController@listProcess');

Route::any('ListTemplate','AddFlowController@addFlow');

Route::any('ListVerify','ValidateListController@listProcessForValidate');

Route::any('LockFlow','LockFlowController@lockFlow');

Route::any('LockTemplate','LockTemplateController@lockTemplate');

Route::get('Logout','LogoutController@logout');

Route::any('NewProcess','NewProcessController@newProcess');

Route::any('NotiRequest','NotificationRequestController@getNoti');

Route::any('Notifications',function(){
    return view('Notifications');
});

Route::any('ProcessDetail','ProcessDetailController@processDetail');

Route::any('ReadNoti','NotificationRequestController@readNoti');

Route::any('Reject','RejectProcessController@rejectProcess');

Route::any('SaveDocTemplate','SaveDocTemplateController@saveTemplate');

Route::any('SearchPosition','SearchUserController@searchPosition');

Route::any('SearchUser','SearchUserController@searchUser');

Route::any('SentOTP','SentOTPController@sentOTP');

Route::any('TemplateDetail','TemplateDetailController@templateDetail');

Route::any('clear/session/{key}', 'ClearSessionController@test');

// Validate data
Route::any('NameValidate','AddFlowController@validateName');

Route::any('NumStepValidate','AddFlowController@validateNumberOfStep');

Route::any('AddStepTitleValidate','AddStepController@validateTitle');

Route::any('AddStepDeadlineValidate','AddStepController@validateDeadline');