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

Route::get('/', function () {
    return view('welcome');
});

/**
 * 全タスク表示
 */
Route::get('/tasks', 'TaskController@index');

/**
 * 新タスク追加
 */
Route::post('/tasks', 'TaskController@store');

/**
 * 既存タスク削除
 */
Route::delete('/tasks/{task}', 'TaskController@destroy');
