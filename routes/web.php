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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/board/{board_id}', 'HomeController@index');
Route::get('/card/{card_id}/{card_title}', 'HomeController@index');
Route::get('/home', 'HomeController@home');

Route::get('/api/me', 'HomeController@me');
Route::get('/api/boards/{boord_id}', 'BoardController@show');
Route::post('/api/boards', 'BoardController@store');
Route::post('/api/boards/{board_id}/members', 'BoardController@saveMember');

Route::post('/api/teams', 'TeamController@store');

Route::post('/api/card-lists', 'CardListController@store');
Route::post('/api/card-lists/positions', 'CardListController@storePositions');

Route::get('/api/cards/{card_id}', 'CardController@show');
Route::get('/api/cards/{card_id}/activities', 'CardController@showActivities');
Route::get('/api/cards/{card_id}/attachments', 'CardController@showAttachments');
Route::put('/api/cards/{card_id}/title', 'CardController@updateTitle');
Route::put('/api/cards/{card_id}/description', 'CardController@updateDescription');
Route::post('/api/cards/{card_id}/comments', 'CardController@storeComment');
Route::post('/api/cards/{card_id}/attachments', 'CardController@storeAttachment');
Route::post('/api/cards/positions', 'CardController@storePositions');
Route::post('/api/cards', 'CardController@store');
