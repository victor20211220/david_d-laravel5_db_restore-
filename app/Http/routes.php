<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

// Resources
Route::resource('/contractors', 'Contractors');
Route::resource('/industries', 'IndustryController');
Route::resource('/premessages', 'preMessageController');
Route::resource('/premessagesGet', 'preMessageController@getPreMessagesJSON');
Route::resource('/messages', 'MessagesController');
Route::resource('/messages/review/{id}/', 'MessagesController@review');

// Create
Route::get('/industries/create/category', 'IndustryController@createCategory');
Route::post('industries/createCategory', 'IndustryController@storeCategory');

Route::post('leads', 'LeadController@store');

Route::get('/users/register', 'UsersController@register');
Route::post('/users/store', 'UsersController@store');

// Edit
Route::post('leads/review/{id}/', 'LeadController@review');
Route::get('/messages/edit/{id}/', 'MessagesController@edit');
Route::post('/messages/edit/submit/{id}', 'LeadController@review');
Route::post('/contractors/update/{id}', 'Contractors@update');

Route::get('industries/category/{id}/edit', 'IndustryController@editCategory');
Route::post('/industries/editcat/{id}/', 'IndustryController@editCategoryStore');

Route::post('/premessages/update/{id}', 'preMessageController@update');

// Delete
Route::get('/messages/delete/{id}/', 'MessagesController@destroy');
Route::get('/premessages/destroy/{id}/', 'preMessageController@destroy');
Route::get('/users/delete/{id}/', 'UsersController@destroy');
Route::get('/industries/delete/{id}/', 'IndustryController@destroyIndustry');
Route::get('/category/delete/{id}/', 'IndustryController@destroyCategory');
Route::get('/contractors/delete/{id}/', 'Contractors@delete');

// Others
Route::get('/', 'HomeController@index');
Route::get('/contractorsGet/{industry}/{location}', 'HomeController@findContractors');
Route::get('/users', 'UsersController@index');

Route::get('/settings', 'Settingscontroller@index');
Route::post('/settings/save/', 'Settingscontroller@save');
Route::get('/search/{string}/{column}', 'Contractors@search');

Route::get('/bulk', 'BulkSMSController@index');
Route::get('/bulk/history', 'BulkSMSController@history');
Route::post('/bulksms', 'BulkSMSController@store');

Route::get('/followup', 'FollowupController@index');

Route::get('/export/messages', 'ExportController@message');
Route::get('/export/contractors', 'ExportController@contractor');

Route::get('/followup/search/{time}/', 'FollowupController@search');
Route::get('/followup/{id}/show', 'FollowupController@show');
Route::post('/followup/show/{id}/', 'FollowupController@save');

Route::get('/yesterday', 'HomeController@findLeadsYesterday');

Route::get('/areas/lookup', 'AreasController@returnAreasFull');

Route::get('/export', 'ExportController@index');
Route::get('/export/full', 'ExportController@mysql');
Route::post('/export/operator', 'ExportController@exportOperator');
Route::post('/export/contractor', 'ExportController@exportContractor');

Route::get('/archive', 'ArchiveController@index');

Route::get('/freeleads', 'FreeController@index');
Route::get('/free/show/{id}/', 'FreeController@show');
Route::post('free/show/{id}/', 'FreeController@moveToReview');

Route::get('/stats', 'StatsController@index');
Route::get('/stats/search/{location}/{industry}/', 'StatsController@search');

Route::get('areas/fetch', 'HomeController@areasFetch');
Route::get('follow/notassisted/{id}', 'FollowupController@moveBack');