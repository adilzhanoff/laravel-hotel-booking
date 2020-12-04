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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin
// Rooms
Route::get(
    '/admin/rooms', 'App\Http\Controllers\RoomController@index'
)->name('admin.rooms.index')->middleware('admin');
Route::post('admin/rooms', [
    'uses' => 'App\Http\Controllers\RoomController@store',
    'as' => 'admin.rooms.store'
])->middleware('admin');
Route::get('admin/rooms/create', [
    'uses' => 'App\Http\Controllers\RoomController@create',
    'as' => 'admin.rooms.create'
])->middleware('admin');
Route::get('admin/rooms/{room}', [
    'uses' => 'App\Http\Controllers\RoomController@show',
    'as' => 'admin.rooms.show'
])->middleware('admin');
Route::match(['put', 'patch'], 'admin/rooms/{room}', [
    'uses' => 'App\Http\Controllers\RoomController@update',
    'as' => 'admin.rooms.update'
])->middleware('admin');
Route::delete('admin/rooms/{room}', [
    'uses' => 'App\Http\Controllers\RoomController@destroy',
    'as' => 'admin.rooms.destroy'
]);
Route::get('admin/rooms/{room}/edit', [
    'uses' => 'App\Http\Controllers\RoomController@edit',
    'as' => 'admin.rooms.edit'
])->middleware('admin');
Route::get('admin/rooms/user/{user}', [
    'uses' => 'App\Http\Controllers\RoomController@roomsByUser', 
    'as' => 'admin.rooms.user'
])->middleware('admin');

// Categories
Route::get(
    '/admin/categories', 'App\Http\Controllers\CategoryController@index'
)->name('admin.categories.index')->middleware('admin');
Route::post('admin/categories', [
    'uses' => 'App\Http\Controllers\CategoryController@store',
    'as' => 'admin.categories.store'
])->middleware('admin');
Route::get('admin/categories/create', [
    'uses' => 'App\Http\Controllers\CategoryController@create',
    'as' => 'admin.categories.create'
])->middleware('admin');
Route::get('admin/categories/{category}', [
    'uses' => 'App\Http\Controllers\CategoryController@show',
    'as' => 'admin.categories.show'
])->middleware('admin');
Route::match(['put', 'patch'], 'admin/categories/{category}', [
    'uses' => 'App\Http\Controllers\CategoryController@update',
    'as' => 'admin.categories.update'
])->middleware('admin');
Route::delete('admin/categories/{category}', [
    'uses' => 'App\Http\Controllers\CategoryController@destroy',
    'as' => 'admin.categories.destroy'
]);
Route::get('admin/categories/{category}/edit', [
    'uses' => 'App\Http\Controllers\CategoryController@edit',
    'as' => 'admin.categories.edit'
])->middleware('admin');

// Views
Route::get('admin/views', [
    'uses' => 'App\Http\Controllers\ViewController@index',
    'as' => 'admin.views.index'
])->middleware('admin');
Route::post('admin/views', [
    'uses' => 'App\Http\Controllers\ViewController@store',
    'as' => 'admin.views.store'
])->middleware('admin');
Route::get('admin/views/create', [
    'uses' => 'App\Http\Controllers\ViewController@create',
    'as' => 'admin.views.create'
])->middleware('admin');
Route::get('admin/views/{view}', [
    'uses' => 'App\Http\Controllers\ViewController@show',
    'as' => 'admin.views.show'
])->middleware('admin');
Route::match(['put', 'patch'], 'admin/views/{view}', [
    'uses' => 'App\Http\Controllers\ViewController@update',
    'as' => 'admin.views.update'
])->middleware('admin');
Route::delete('views/{view}', [
    'uses' => 'App\Http\Controllers\ViewController@destroy',
    'as' => 'admin.views.destroy'
])->middleware('admin');
Route::get('admin/views/{view}/edit', [
    'uses' => 'App\Http\Controllers\ViewController@edit',
    'as' => 'admin.views.edit'
])->middleware('admin');

// Users
Route::get('admin/users', [
    'uses' => 'App\Http\Controllers\AdminUsersController@index',
    'as' => 'admin.users.index'
])->middleware('admin');
Route::get('admin/users/{user}', [
    'uses' => 'App\Http\Controllers\AdminUsersController@show',
    'as' => 'admin.users.show'
])->middleware('admin');
Route::match(['put', 'patch'], 'admin/users/{user}', [
    'uses' => 'App\Http\Controllers\AdminUsersController@update',
    'as' => 'admin.users.update'
])->middleware('admin');
Route::delete('admin/users/{user}', [
    'uses' => 'App\Http\Controllers\AdminUsersController@destroy',
    'as' => 'admin.users.destroy'
])->middleware('admin');
Route::get('admin/users/{user}/edit', [
    'uses' => 'App\Http\Controllers\AdminUsersController@edit',
    'as' => 'admin.users.edit'
])->middleware('admin');
Route::get('admin/users/role/{role}', [
    'uses' => 'App\Http\Controllers\AdminUsersController@usersByRole', 
    'as' => 'admin.users.role'
])->middleware('admin');

// User
Route::get(
    '/user', 'App\Http\Controllers\UserController@index'
)->name('user.index')->middleware('user');

Route::get(
    '/user/{room}', 'App\Http\Controllers\UserController@show'
)->name('user.show')->middleware('user');