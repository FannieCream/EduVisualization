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

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return redirect('/');
});

Route:: post('/gdata', 'GraphController@GraphData');

Route:: get('/student', 'StudentController@index');
Route:: post('/sankeydata', 'StudentController@SankeyData');
Route:: post('/treemap', 'StudentController@matrix');
Route:: post('/plandata', 'StudentController@PlanData');

Route:: get('/battle', 'BattleController@index');
Route:: get('/knowledge', 'KnowledgeController@index');

